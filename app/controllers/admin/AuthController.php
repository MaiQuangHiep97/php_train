<?php
class AuthController extends Controller
{
    public function index()
    {
        $this->render('admins/login');
    }
}
