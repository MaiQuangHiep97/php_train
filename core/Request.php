<?php
class Request
{
    private $__rules = [];
    private $__messages = [];
    private $__errors = [];
    public $db;
    /*
     * 1. Method
     * 2. Body
     * */

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost()
    {
        if ($this->getMethod()=='post') {
            return true;
        }

        return false;
    }

    public function isGet()
    {
        if ($this->getMethod()=='get') {
            return true;
        }

        return false;
    }

    public function getFields()
    {
        $dataFields = [];

        if ($this->isGet()) {
            //Xử lý lấy dữ liệu với phương thức get
            if (!empty($_GET)) {
                foreach ($_GET as $key=>$value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }


        if ($this->isPost()) {
            //Xử lý lấy dữ liệu với phương thức post
            if (!empty($_POST)) {
                foreach ($_POST as $key=>$value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        return $dataFields;
    }
}
