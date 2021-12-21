<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        aux = document.cookie.split(';')[0];
        csrf = aux.split('=');
        $(document).ready(function () {
            function renderList(products) {
                html = [
                    '<tr>',
                    '<th>Title</th>',
                    '<th>Description</th>',
                    '<th>Price</th>',
                    '<th>Image</th>',
                ].join('');
                if (window.location.hash === '#cart') {
                    html += '<th>Remove from cart</th></tr>';
                } else if(window.location.hash === '#products') {
                    html += '<th>Edit product</th>';
                    html += '<th>Delete products</th></tr>';
                } else {
                    html += '<th>Add to cart</th></tr>';
                }
                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<td><img src="/storage/images/' + product.image + '"/></td>',
                    ].join('');

                    if (window.location.hash === '#cart') {
                        html += '<td>';
                        html += '<form id="formR" action="cart_destroy" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf[1] +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button name="remove" value="remove">Remove</button>';
                        html += '</form></td></tr><br>';
                    } else if (window.location.hash === '#products') {
                        html += '<td><a href="#product/' + product.id + '">Edit</a></td>';
                        html += '<td>';
                        html += '<form action="products" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf[1] +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button name="delete" value="delete">Delete</button>';
                        html += '</form></td></tr>';
                    } else {
                        html += '<td>';
                        html += '<form action="/" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf[1] +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button name="add" value="add">Add</button>';
                        html += '</form></td></tr>';
                    }
                });
                if (window.location.hash === '#cart') {
                    htmlFrom = [
                        '<input type="hidden" name="_token" value="' + csrf[1] +'">',
                        '<input id="name" type="text" name="name" placeholder="Name" class="width"><br>',
                        '<input id="email" type="text" name="email" placeholder="Email" class="width"><br>',
                        '<textarea id="comments" name="comments" cols="40" rows="10" placeholder="Comments"></textarea>',
                        '<br><div style="text-align: center;">',
                        '<button type="submit" id="button" name="checkout" value="checkout">Checkout</button></div>'
                    ].join('');
                    $('.cart .formCart').html(htmlFrom);
                    $('#formCart').on('submit', function (e) {
                        e.stopImmediatePropagation();
                        e.preventDefault();
                        let name = $('#name').val();
                        let email = $('#email').val();
                        let comments = $('#comments').val();

                        $.ajax({
                            url: "cart",
                            type: "POST",
                            data: {
                                "_token": csrf[1],
                                name: name,
                                email: email,
                                comments: comments,
                            },
                            success: function () {
                                window.location.replace("#");
                            },
                            error: function (response) {
                                let res = response.responseJSON.errors;
                                if (res.name) {
                                    html += $('#span').text(res.name);
                                }
                                if (res.email) {
                                    html += $('#span').text(res.email);
                                }
                            },
                        });
                    });

                }
                return html;
            }
            function createLogin() {
                htmlForm = [
                    '<input type="hidden" name="_token" value="' + csrf[1] +'">',
                    '<input id="email" type="text" name="email" placeholder="Email">',
                    '<br><input id="password" type="password" name="password" placeholder="Password">',
                    '<br><button type="submit" name="login" value="login">Login</button>',
                ].join('');
                $('#formLogin').on('submit', function (e) {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                    let email = $('#email').val();
                    let password = $('#password').val();
                    $.ajax({
                        url: "login",
                        type: "POST",
                        data: {
                            "_token": csrf[1],
                            email: email,
                            password: password,
                        },
                        success: function (response) {
                            if(response === 'logged_in') {
                                window.location.replace("#products");
                            }
                        },
                        error: function (response) {
                            let res = response.responseJSON.errors;
                            if (res.email) {
                                htmlForm += $('#spanLogin').text(res.email);
                            } else  if (res.password) {
                                htmlForm += $('#spanLogin').text(res.password);
                            } else {
                                htmlForm += $('#spanLogin').text('Invalid credentials');
                            }
                        },
                    });
                });
                return htmlForm;
            }
            function createProductForm(title, description, price) {
                if (! title && ! description && ! price) {
                    title = price = description = '';
                }
                htmlForm = [
                    '<input class="width" type="hidden" name="_token" value="' + csrf[1] +'"><br>',
                    '<input class="width" id="title" type="text" name="title" placeholder="Title" value="' + title + '"><br>',
                    '<input class="width" id="description" type="text" name="description" placeholder="Description", value="' + description + '"><br>',
                    '<input class="width" id="price" type="number" step="0.01" name="price" placeholder="Price" value="' + price + '"><br>',
                    '<input type="file" name="file" id="image">',
                    '<button name="save" value="save">Save</button>',
                ].join('');

                $('#formProduct').on('submit', function (e) {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                    let formData = new FormData();
                    formData.append('_token', csrf[1]);
                    formData.append('title', $('#title').val());
                    formData.append('description', $('#description').val());
                    formData.append('price', $('#price').val());
                    formData.append('file', $('#image')[0].files[0]);
                    let url = window.location.hash.split('#')[1];
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function () {
                            window.location.replace("#products");
                        },
                        error: function (response) {
                            let res = response.responseJSON.errors;
                            if (res.title) {
                                htmlForm += $('#spanErrorProduct').text(res.title);
                            }
                            if (res.description) {
                                htmlForm += $('#spanErrorProduct').text(res.description);
                            }
                            if (res.price) {
                                htmlForm += $('#spanErrorProduct').text(res.price);
                            }
                            if (res.file) {
                                htmlForm += $('#spanErrorProduct').text(res.file);
                            }
                        }
                    });
                });
                return htmlForm;
            }

            function renderListOrders(orders) {
                html = [
                    '<tr>',
                    '<th>Date</th>',
                    '<th>Customer name</th>',
                    '<th>Customer email</th>',
                    '<th>Total</th>',
                    '<th>Details</th>',
                    '</tr>',
                ].join('');
                $.each(orders, function (key, order) {
                    html += [
                        '<tr>',
                        '<td>' + order.date + '</td>',
                        '<td>' + order.name + '</td>',
                        '<td>' + order.email + '</td>',
                        '<td>' + order.sum + '</td>',
                        '<td><a href="#order/' + order.id + '">See details</td></tr>',
                    ].join('');
                });
                return html;
            }
            function renderProductsInOrder(products){
                html = [
                    '<tr>',
                    '<th>Title</th>',
                    '<th>Description</th>',
                    '<th>Price</th>',
                    '<th>Image</th>',
                    '</tr>'
                ].join('');
                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<td><img src="/storage/images/' + product.image + '"/></td>',
                        '</tr>',
                    ].join('');
                });
                return html;
            }
            function renderListOrderDetails(order) {
                html = [
                    '<li>Date: ' + order.date +'</li>',
                    '<li>Name: ' + order.name +'</li>',
                    '<li>Email: ' + order.email +'</li>',
                ].join('');
                return html;
            }
            function createLogout() {
                html = [
                    // '<form action="logout" method="post">',
                    '<input class="width" type="hidden" name="_token" value="' + csrf[1] +'"><br>',
                    '<button type="submit" name="logout" value="logout">Logout</button>',
                    // '</form>'
                ].join('');
                $('#formLogout').on('submit', function (e) {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                    $.ajax({
                        url: 'logout',
                        type: "POST",
                        data: {
                            "_token": csrf[1]
                        },
                        success: function (response) {
                            window.location.replace("#")
                        }
                    });
                });
                return html;
            }
            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();
                switch(window.location.hash) {
                    case '#orders':
                        $('.orders').show();
                        $.ajax('orders', {
                            dataType: 'json',
                            success: function (response) {
                                $('.orders .list').html(renderListOrders(response));
                            },
                            error: function () {
                                window.location.replace('#');
                            }
                        });
                        break;
                    case '#product':
                        $.ajax('product', {
                            success: function () {
                                    $('.product').show();
                                    $('.product .formProduct').html(createProductForm());
                            },
                            error: function () {
                                window.location.replace('#');
                            }
                        });
                        break;
                    case '#products':
                        $.ajax('product', {
                            success: function () {
                                $('.products').show();
                                $.ajax('products', {
                                    dataType: 'json',
                                    success: function (response) {
                                        $('.products .list').html(renderList(response));
                                        $('.products .formLogout').html(createLogout());
                                    }
                                });
                            },
                            error: function () {
                                window.location.replace('#');
                            }
                        });
                        break;
                    case '#login':
                        $('.login').show();
                        $.ajax('login', {
                            success: function () {
                                $('.login .formLogin').html(createLogin());
                            }
                        });
                        break;
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response));
                            }
                        });
                        break;
                    default:
                        if (window.location.hash.split('/')[0] === '#product') {
                            $.ajax('product', {
                                success: function () {
                                    $('.product').show();
                                    $.ajax('/product/' + window.location.hash.split('/')[1] + '/edit', {
                                        dataType: 'json',
                                        success: function (response) {
                                            $('.product .formProduct').html(createProductForm(response.title, response.description, response.price, response.image));
                                        }
                                    });
                                },
                                error: function () {
                                    window.location.replace('#');
                                }
                            });

                            break;
                        }
                        if (window.location.hash.split('/')[0] === '#order') {
                            $.ajax('product', {
                                success: function () {
                                    $('.order').show();
                                    $.ajax('order/' + window.location.hash.split('/')[1], {
                                        success: function (response) {
                                            $('.order .table').html(renderProductsInOrder(response.products));
                                            $('.order .list').html(renderListOrderDetails(response.order));
                                        }
                                    });
                                },
                                error: function () {
                                    window.location.replace('#');
                                }
                            });

                            break;
                        }
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response));
                            }
                        });
                        break;
                }
            }
            window.onhashchange();
        });
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index">
    <h1>List of products</h1>
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>
    <br>
    <!-- A link to go to the cart by changing the hash -->
    <div style="text-align: center;">
        <a href="#cart" class="button">Go to cart</a>
    </div>
    <a href="#login" class="button" style="position: absolute; bottom: 0pt; right: 0pt;">Login</a>
</div>
<!-- The cart page -->
<div class="page cart">
    <h1>Cart</h1>
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>
    <br>
    <!-- A link to go to the index by changing the hash -->
    <div style="text-align: center;">
        <form class="formCart" id="formCart"></form>
        <span class="error" id="span"></span>
        <a href="#" class="button">Go to index</a>
    </div>
    <a href="#login" class="button" style="position: absolute; bottom: 0pt; right: 0pt;">Login</a>
</div>
<!-- The login page -->
<div class="page login">
    <h1>Login</h1>
    <div style="text-align: center;">
        <form class="formLogin" method="post" id="formLogin"></form>
        <span class="error" id="spanLogin"></span>
    </div>
</div>
<!-- The products page -->
<div class="page products">
    <h1>Products</h1>
    <table class="list"></table>
    <br>
    <div style="text-align: center;">
        <a href="#product">Add</a>
    </div>
    <a href="#orders" class="button" style="position: absolute; bottom: 0pt; right: 0pt;">Orders</a>
    <form id="formLogout" style="position: absolute; bottom: 0pt;" class="formLogout"></form>
</div>
<!-- The product page -->
<div class="page product">
    <h1>Add/Edit product</h1>
    <div style="text-align: center;">
        <form class="formProduct" method="post" id="formProduct" enctype="multipart/form-data"></form>
        <span class="error" id="spanErrorProduct"></span>
    </div>
    <a href="#orders" class="button" style="position: absolute; bottom: 0pt; right: 0pt;">Orders</a>
    <form id="formLogout" style="position: absolute; bottom: 0pt;" class="formLogout"></form>
</div>
<!-- The orders page -->
<div class="page orders">
    <h1>Orders</h1>
    <table class="list"></table>
    <form id="formLogout" style="position: absolute; bottom: 0pt;" class="formLogout"></form>
</div>
<!-- The order page -->
<div class="page order">
    <h1>Order</h1>
    <table class="table"></table>
    <ul class="list"></ul>
    <form id="formLogout" style="position: absolute; bottom: 0pt;" class="formLogout"></form>
</div>
</body>
</html>
