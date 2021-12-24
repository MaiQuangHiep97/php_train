<?php

$routes['default_controller'] = 'homecontroller';
//DashboardController
$routes['dashboard'] = 'admin/dashboardcontroller';
$routes['dashboard/status'] = 'admin/dashboardcontroller/status';
//AuthController
$routes['admin/login'] = 'admin/authcontroller';
$routes['admin/postLogin'] = 'admin/authcontroller/login';
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
//CustomerController
$routes['customer/login'] = 'customer/customercontroller';
$routes['customer/postLogin'] = 'customer/customercontroller/login';
$routes['customer/logout'] = 'customer/customercontroller/logout';
$routes['customer/register'] = 'customer/customercontroller/getregister';
$routes['customer/postRegister'] = 'customer/customercontroller/postregister';
$routes['customer/change'] = 'customer/customerController/getChange';
$routes['customer/postChange'] = 'customer/customerController/postChange';
$routes['customer/info'] = 'customer/customercontroller/info';
$routes['customer/postInfo'] = 'customer/customercontroller/postInfo';
//HomeController
$routes['.+-(\d+)'] = 'homecontroller/getProduct/$1';
$routes['product/detail'] = 'customer/productcontroller';
$routes['search'] = 'homecontroller/search';
//CartController
$routes['cart/add'] = 'customer/cartcontroller/add';
$routes['cart/show'] = 'customer/cartcontroller';
$routes['cart/update'] = 'customer/cartcontroller/update';
$routes['cart/delete'] = 'customer/cartcontroller/delete';
$routes['cart/destroy'] = 'customer/cartcontroller/destroy';
//OrderController
$routes['checkout'] = 'customer/ordercontroller';
$routes['post-checkout'] = 'customer/ordercontroller/postCheckout';
$routes['order/done'] = 'customer/ordercontroller/done';
