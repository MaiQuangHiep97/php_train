<?php
class Paginator
{
    public static function pagination($total_page, $page)
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
    public static function pagi($fields, $limit)
    {
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $total_rows = count($fields);
        $total_page = ceil($total_rows/$limit);
        $start = ($page-1)*$limit;
        $button_pagination = static::pagination($total_page, $page);
        $data=[
            'total'=>$total_rows,
            'start'=>$start,
            'button_pagination' => $button_pagination
        ];
        return $data;
    }
}
