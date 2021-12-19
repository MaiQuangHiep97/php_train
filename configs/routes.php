<?php

$routes['default_controller'] = 'homecontroller';
//AuthController
$routes['admin/login'] = 'admin/authcontroller';
$routes['admin/postLogin'] = 'admin/authcontroller/login';
$routes['dashboard'] = 'admin/dashboardcontroller';
$routes['admin/logout'] = 'admin/authcontroller/logout';
$routes['admin/getChange'] = 'admin/authcontroller/getChange';
$routes['admin/postChange'] = 'admin/authcontroller/postChange';
//UserController
$routes['admin/user/list'] = 'admin/usercontroller';
$routes['admin/user/add'] = 'admin/usercontroller/add';
$routes['admin/user/store'] = 'admin/usercontroller/store';
$routes['admin/user/edit'] = 'admin/usercontroller/edit';
$routes['admin/user/update'] = 'admin/usercontroller/update';
$routes['admin/user/delete'] = 'admin/usercontroller/delete';
//AdminProductController
$routes['admin/product/list'] = 'admin/adminproductcontroller';
$routes['admin/product/add'] = 'admin/adminproductcontroller/add';
$routes['admin/product/store'] = 'admin/adminproductcontroller/store';
$routes['admin/product/edit'] = 'admin/adminproductcontroller/edit';
$routes['admin/product/update'] = 'admin/adminproductcontroller/update';
$routes['admin/product/delete'] = 'admin/adminproductcontroller/delete';
//AdminOrderController
$routes['admin/order/list'] = 'admin/adminordercontroller';
$routes['admin/order/detail'] = 'admin/adminordercontroller/show';
$routes['admin/order/status'] = 'admin/adminordercontroller/status';
