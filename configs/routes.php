<?php

$routes['default_controller'] = 'homecontroller';
//DashboardController
$routes['dashboard'] = 'admin/dashboardcontroller';
$routes['dashboard/status'] = 'admin/dashboardcontroller/status';
//AuthController
$routes['admin-login'] = 'admin/authcontroller';
$routes['admin-postLogin'] = 'admin/authcontroller/login';
$routes['admin-logout'] = 'admin/authcontroller/logout';
$routes['admin-getChange'] = 'admin/authcontroller/getChange';
$routes['admin-postChange'] = 'admin/authcontroller/postChange';
//UserController
$routes['admin-list-([a-zA-Z_-]+).html'] = 'admin/usercontroller/getList/$1';
$routes['admin-user-add'] = 'admin/usercontroller/add';
$routes['admin-user-store'] = 'admin/usercontroller/store';
$routes['admin-user-edit-([0-9]+).html'] = 'admin/usercontroller/edit/$1';
$routes['admin-user-update'] = 'admin/usercontroller/update';
$routes['admin-user-delete'] = 'admin/usercontroller/delete';
//AdminCategoriController
$routes['admin-cat-list'] = 'admin/adminproductcatcontroller';
$routes['admin-cat-store'] = 'admin/adminproductcatcontroller/store';
$routes['admin-cat-edit'] = 'admin/adminproductcatcontroller/edit';
$routes['admin-cat-update'] = 'admin/adminproductcatcontroller/update';
$routes['admin-cat-delete'] = 'admin/adminproductcatcontroller/delete';
//AdminProductController
$routes['admin-product-list'] = 'admin/adminproductcontroller';
$routes['admin-product-add'] = 'admin/adminproductcontroller/add';
$routes['admin-product-store'] = 'admin/adminproductcontroller/store';
$routes['admin-product-edit-([0-9]+).html'] = 'admin/adminproductcontroller/edit/$1';
$routes['admin-product-update-([0-9]+).html'] = 'admin/adminproductcontroller/update/$1';
$routes['admin-product-delete-([0-9]+).html'] = 'admin/adminproductcontroller/delete/$1';
//AdminOrderController
$routes['admin-order-list'] = 'admin/adminordercontroller';
$routes['admin-order-detail-([0-9]+).html'] = 'admin/adminordercontroller/show/$1';
$routes['admin-order-edit-([0-9]+).html'] = 'admin/adminordercontroller/edit/$1';
$routes['admin-order-add-([0-9]+).html'] = 'admin/adminordercontroller/addProduct/$1';
$routes['admin-order-key'] = 'admin/adminordercontroller/key';
$routes['admin-order-storeProduct'] = 'admin/adminordercontroller/storeProduct';
$routes['admin-order-status'] = 'admin/adminordercontroller/status';
$routes['admin-order-updateQty'] = 'admin/adminordercontroller/updateQty';
$routes['admin-order-updateInfo'] = 'admin/adminordercontroller/updateInfo';
//AdminAddOrderController
$routes['admin-order-addOrder'] = 'admin/adminaddordercontroller/add';
$routes['admin-order-storeOrder'] = 'admin/adminaddordercontroller/store';
//CustomerController
$routes['customer-login'] = 'customer/customercontroller';
$routes['customer-postLogin'] = 'customer/customercontroller/login';
$routes['customer-logout'] = 'customer/customercontroller/logout';
$routes['customer-register'] = 'customer/customercontroller/getregister';
$routes['customer-postRegister'] = 'customer/customercontroller/postregister';
$routes['customer-change'] = 'customer/customerController/getChange';
$routes['customer-postChange'] = 'customer/customerController/postChange';
$routes['customer-info'] = 'customer/customercontroller/info';
$routes['customer-postInfo'] = 'customer/customercontroller/postInfo';
//HomeController
$routes['category-([a-zA-Z_-]+).html'] = 'homecontroller/getProduct/$1';
$routes['product-detail'] = 'customer/productcontroller';
$routes['search'] = 'homecontroller/search';
//CartController
$routes['cart-add'] = 'customer/cartcontroller/add';
$routes['cart-show'] = 'customer/cartcontroller';
$routes['cart-update'] = 'customer/cartcontroller/update';
$routes['cart-delete'] = 'customer/cartcontroller/delete';
$routes['cart-destroy'] = 'customer/cartcontroller/destroy';
//OrderController
$routes['checkout'] = 'customer/ordercontroller';
$routes['post-checkout'] = 'customer/ordercontroller/postCheckout';
$routes['order-done'] = 'customer/ordercontroller/done';
