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
    public function getCurrentPageURL()
    {
        $pageURL = 'http';
        if (!empty($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 'on') {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
}
