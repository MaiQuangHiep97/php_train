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
$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
});
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
var $editForm = $('#edit-form');
if ($editForm.length) {
    $editForm.validate({
        rules: {
            username: {
                required: true,
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
            phone: {
                required: 'Please enter phone!',
                customPhone: "Please enter valid phone!"
            }
        },
    });
}
var $addProductForm = $('#addProduct');
if ($addProductForm.length) {
    $addProductForm.validate({
        rules: {
            product_name: {
                required: true
            },
            product_desc: {
                required: true
            },
            product_detail: {
                required: true
            },
            product_price: {
                required: true,
                customPhone: true
            },
            product_cat: {
                required: true
            },
            product_thumb: {
                required: true,
                extension: "png|jpeg|jpg",
                filesize: 1048576,
            },
            product_images: {
                required: true,
            },
        },
        messages: {
            product_name: {
                required: 'Please enter product name!'
            },
            product_desc: {
                required: 'Please enter description!',
            },
            product_detail: {
                required: 'Please enter product detail!'
            },
            product_price: {
                required: 'Please enter product price!',
                customPhone: "Please enter valid price!"
            },
            product_cat: {
                required: 'Please select category!'
            },
            product_thumb: {
                required: 'Please select thumbnail!',
                extension: 'File must be JPEG or PNG'
            },
            product_images: {
                required: 'Please select country!'
            },
        },
        // highlight: function (element) {
        //     $(element).closest('.form-group').addClass('has-error');
        // },
        // unhighlight: function (element) {
        //     $(element).closest('.form-group').removeClass('has-error');
        // },
    
        // errorPlacement: function (error, element) {
        //     if (element.parent('.input-group').length) {
        //         error.insertAfter(element.parent());
        //     } else {
        //         error.insertAfter(element);
        //     }
        // }

    });
}



