/*!
    * Start Bootstrap - SB Admin v7.0.4 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
// 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");
jQuery.validator.addMethod("customEmail", function (value, element) {
    return this.optional(element) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
}, "Please enter valid email address!");
jQuery.validator.addMethod("customPhone", function (value, element) {
    return this.optional(element) || /^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/.test(value);
}, "Please enter valid phone!");
$.validator.addMethod("alphanumeric", function (value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");
var $loginForm = $('#login-form');
if ($loginForm.length) {
    $loginForm.validate({
        rules: {
            email: {
                required: true,
                customEmail: true
            },
            password: {
                required: true
            },
        },
        messages: {
            email: {
                required: 'Please enter email!',
                email: 'Please enter valid email!'
            },
            password: {
                required: 'Please enter password!'
            },
        },
    });
}
var $changeForm = $('#change-form');
if ($changeForm.length) {
    $changeForm.validate({
        rules: {
            password: {
                required: true
            },
            passwordConfirm: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            password: {
                required: 'Please enter password!'
            },
            passwordConfirm: {
                required: 'Please enter password confirm!',
                equalTo: 'Please enter same password!'
            },
        },
    });
}
var $addForm = $('#add-form');
if ($addForm.length) {
    $addForm.validate({
        rules: {
            username: {
                required: true,
                // alphanumeric: true
            },
            email: {
                required: true,
                customEmail: true
            },
            password: {
                required: true
            },

            phone: {
                required: true,
                customPhone: true
            }
        },
        messages: {
            username: {
                required: 'Please enter username!'
            },
            email: {
                required: 'Please enter email!',
                email: 'Please enter valid email!'
            },
            password: {
                required: 'Please enter password!'
            },
            phone: {
                required: 'Please enter phone!',
                customPhone: "Please enter valid phone!"
            }
        },
    });
}