<?php
class Controller
{
    public $db;
    public function model($model)
    {
        if (file_exists(_DIR_ROOT.'/app/models/'.$model.'.php')) {
            require_once _DIR_ROOT.'/app/models/'.$model.'.php';
            if (class_exists($model)) {
                $model = new $model();
                return $model;
            }
        } else {
            echo "lỗi";
        }
    }
    public function render($view, $data=[])
    {
        extract($data);
        if (file_exists(_DIR_ROOT.'/app/views/'.$view.'.php')) {
            require_once _DIR_ROOT.'/app/views/'.$view.'.php';
        }
    }
    public function auth()
    {
        if (isset($_SESSION['is_login'])&&isset($_SESSION['user_login'])&&$_SESSION['user_login']['type']=='admin') {
            return true;
        }
        return false;
    }
    public function authCustomer()
    {
        if (isset($_SESSION['is_login'])&&isset($_SESSION['customer_login'])&&$_SESSION['customer_login']['type']=='user') {
            return true;
        }
        return false;
    }
    public function handleFile($file_name, $upload_dir)
    {
        $upload_file = $upload_dir.$file_name;
        $type = pathinfo($file_name, PATHINFO_EXTENSION);
        if (file_exists($upload_file)) {
            $file_name = pathinfo($file_name, PATHINFO_FILENAME);
            $new_file_name = $file_name.'-Copy.';
            $new_upload_file = $upload_dir.$new_file_name.$type;
            $k = 1;
            while (file_exists($new_upload_file)) {
                $new_file_name = $file_name."-Copy({$k}).";
                $k++;
                $new_upload_file = $upload_dir.$new_file_name.$type;
            }
            $file_name = $new_file_name.$type;
        }
        return $file_name;
    }
    public function pagination($total_page, $page)
    {
        if ($total_page>5) {
            if ($page<6) {
                for ($i=1; $i < 6; $i++) {
                    $page_array[]=$i;
                }
                $page_array[]='...';
                $page_array[]=$total_page;
            } else {
                $end_limit = $total_page-5;
                if ($page>$end_limit) {
                    $page_array[]=1;
                    $page_array[]='...';
                    for ($i=$end_limit; $i <= $total_page; $i++) {
                        $page_array[]=$i;
                    }
                } else {
                    $page_array[]=1;
                    $page_array[]='...';
                    for ($i=$page-1; $i <=$page+1 ; $i++) {
                        $page_array[]=$i;
                    }
                    $page_array[]='...';
                    $page_array[]=$total_page;
                }
            }
        } else {
            for ($i=1; $i <=$total_page; $i++) {
                $page_array[]=$i;
            }
        }
        $page_link='';
        $prev_link='';
        $next_link='';
        for ($i=0; $i < count($page_array); $i++) {
            if ($page==$page_array[$i]) {
                $page_link.='<li>
                <a href="?page='.$page_array[$i].'" class="page-link active disabled" num-page="'.$page_array[$i].'">'.$page_array[$i].'</a>
                </li>';
                $prev_id = $page_array[$i]-1;
                if ($prev_id<=0) {
                    $prev_link.='<li>
                    <a href="" class="page-link disabled">Prev</a>
                    </li>';
                } else {
                    $prev_link.='<li>
                    <a href="?page='.$prev_id.'" class="page-link" num-page="'.$prev_id.'">Prev</a>
                    </li>';
                }
                $next_id = $page_array[$i]+1;
                if ($next_id>=$total_page) {
                    $next_link.='<li>
                    <a href="" class="page-link disabled">Next</a>
                    </li>';
                } else {
                    $next_link.='<li>
                    <a href="?page='.$next_id.'" class="page-link" num-page="'.$next_id.'">Next</a>
                    </li>';
                }
            } else {
                if ($page_array[$i]=='...') {
                    $page_link.='<li>
                    <a href="" class="page-link disabled">...</a>
                    </li>';
                } else {
                    $page_link.='<li>
                    <a href="?page='.$page_array[$i].'" class="page-link" num-page="'.$page_array[$i].'">'.$page_array[$i].'</a>
                    </li>';
                }
            }
        }
        
                                        
        return $prev_link.$page_link.$next_link;
    }
}
