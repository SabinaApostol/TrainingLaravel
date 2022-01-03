<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">
        function translate (data) {
            return data
        }
        loggedIn = false
        aux = document.cookie.split(';');
        for (val in aux) {
            aux2 = aux[val].split('=');
            if (aux2[0] === 'csrf') {
                csrf = aux2[1];
            }
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });
        $(document).ready(function () {
            $('#formCart').on('submit', function (e) {
                e.preventDefault();
                let name = $('#name').val();
                let email = $('#email').val();
                let comments = $('#comments').val();

                $.ajax({
                    url: 'cart',
                    type: 'POST',
                    data: {
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
                            $('.cart .span_name').html(res.name);
                        }
                        if (res.email) {
                            $('.cart .span_email').html(res.email);
                        }
                    },
                });
            });
            $('#formProduct').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                formData.append('price', $('#price').val());
                formData.append('file', $('#image')[0].files[0]);
                let url = window.location.hash.split('#')[1];
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        window.location.replace("#products");
                    },
                    error: function (response) {
                        let res = response.responseJSON.errors;
                        if (res.title) {
                            $('.product .span_title').html(res.title);
                        }
                        if (res.description) {
                            $('.product .span_description').html(res.description);
                        }
                        if (res.price) {
                            $('.product .span_price').html(res.price);
                        }
                        if (res.file) {
                            $('.product .span_file').html(res.file[0]);
                        }
                    }
                });
            });
            $('#formLogin').on('submit', function (e) {
                e.preventDefault();
                let email = $('#email').val();
                let password = $('#password').val();
                $.ajax({
                    url: 'login',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                    },
                    success: function (response) {
                        window.location.replace("#products");
                    },
                    error: function (response) {
                        let res = response.responseJSON.errors;
                        if (res.email) {
                            $('.login .span_email').html(res.email);
                        } else  if (res.password) {
                            $('.login .span_password').html(res.password);
                        } else {
                            $('.login .span_login').text('Invalid credentials');
                        }
                    },
                });
            });
            $('#formLogout').on('submit', function (e) {
                e.preventDefault();
                loggedIn = false
                $.ajax({
                    url: 'logout',
                    type: 'POST',
                    success: function () {
                        window.location.replace("#")
                    }
                });
            });
            function renderList(products, page) {
                html = [
                    '<tr>',
                    '<th>' + translate('Title') + '</th>',
                    '<th>' + translate('Description') + '</th>',
                    '<th>' + translate('Price') + '</th>',
                    '<th>' + translate('Image') + '</th>',
                ].join('');
                if (page === 'cart') {
                    html += '<th>' + translate('Remove from cart') + '</th></tr>';
                } else if (window.location.hash === '#products') {
                    html += '<th>' + translate('Edit product') + '</th>';
                    html += '<th>' + translate('Delete products') + '</th></tr>';
                } else {
                    html += '<th>' + translate('Add to cart') + '</th></tr>';
                }
                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<td><img src="/storage/images/' + product.image + '"/></td>',
                    ].join('');
                    if (page === 'cart') {
                        html += '<td>';
                        html += '<form action="cart_destroy" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button name="remove" value="remove">' + translate('Remove') + '</button>';
                        html += '</form></td></tr><br>';
                    } else if (page === 'products') {
                        html += '<td><a href="#product/' + product.id + '">' + translate('Edit') + '</a></td>';
                        html += '<td>';
                        html += '<form action="products" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button name="delete" value="delete">' + translate('Delete') + '</button>';
                        html += '</form></td></tr>';
                    } else {
                        html += '<td>';
                        html += '<form action="/" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button name="add" value="add">' + translate('Add') + '</button>';
                        html += '</form></td></tr>';
                    }
                });
                if (page === 'cart') {
                    htmlFrom = [
                        '<input id="name" type="text" name="name" placeholder="' + translate('Name') + '" class="width"><br><span style="color: red" class="span_name"></span><br>',
                        '<input id="email" type="text" name="email" placeholder="' + translate('Email') + '" class="width"><br><span style="color: red" class="span_email"></span><br>',
                        '<textarea id="comments" name="comments" cols="40" rows="10" placeholder="' + translate('Comments') + '"></textarea>',
                        '<br><div style="text-align: center;">',
                        '<button type="submit" id="button" name="checkout" value="checkout">' + translate('Checkout') + '</button></div>'
                    ].join('');
                    $('.cart .formCart').html(htmlFrom);
                }
                return html;
            }
            function createLogin() {
                htmlForm = [
                    '<input id="email" type="text" name="email" placeholder="' + translate('Email') + '"><br>',
                    '<span style="color: red" class="span_email"></span><br>',
                    '<input id="password" type="password" name="password" placeholder="' + translate('Password') + '"><br>',
                    '<span style="color: red" class="span_password"></span><br>',
                    '<button type="submit" name="login" value="login">' + translate('Login') + '</button><br>',
                    '<span style="color: red" class="span_login"></span><br>',
                ].join('');
                return htmlForm;
            }
            function createProductForm(title, description, price) {
                if (! title && ! description && ! price) {
                    title = price = description = '';
                }
                htmlForm = [
                    '<input class="width" id="title" type="text" name="title" placeholder="' + translate('Title') + '" value="' + title + '"><br>',
                    '<span style="color: red" class="span_title"></span><br>',
                    '<input class="width" id="description" type="text" name="description" placeholder="' + translate('Description') + '", value="' + description + '"><br>',
                    '<span style="color: red" class="span_description"></span><br>',
                    '<input class="width" id="price" type="number" step="0.01" name="price" placeholder="' + translate('Price') + '" value="' + price + '"><br>',
                    '<span style="color: red" class="span_price"></span><br>',
                    '<input type="file" name="file" id="image">',
                    '<span style="color: red" class="span_file"></span><br>',
                    '<button name="save" value="save">' + translate('Save') + '</button>',
                ].join('');
                return htmlForm;
            }
            function renderListOrders(orders) {
                html = [
                    '<tr>',
                    '<th>' + translate('Date') + '</th>',
                    '<th>' + translate('Customer name') + '</th>',
                    '<th>' + translate('Customer email') + '</th>',
                    '<th>' + translate('Total') + '</th>',
                    '<th>' + translate('Details') + '</th>',
                    '</tr>',
                ].join('');
                $.each(orders, function (key, order) {
                    html += [
                        '<tr>',
                        '<td>' + order.date + '</td>',
                        '<td>' + order.name + '</td>',
                        '<td>' + order.email + '</td>',
                        '<td>' + order.sum + '</td>',
                        '<td><a href="#order/' + order.id + '">' + translate('See details') + '</td></tr>',
                    ].join('');
                });
                return html;
            }
            function renderProductsInOrder(products) {
                html = [
                    '<tr>',
                    '<th>' + translate('Title') + '</th>',
                    '<th>' + translate('Description') + '</th>',
                    '<th>' + translate('Price') + '</th>',
                    '<th>' + translate('Image') + '</th>',
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
                    '<li>' + translate('Date:') +  + order.date +'</li>',
                    '<li>' + translate('Name:') +  order.name +'</li>',
                    '<li>' + translate('Email:') +  order.email +'</li>',
                ].join('');
                return html;
            }
            function createLogout() {
                html = [
                    '<button type="submit" name="logout" value="logout">' + translate('Logout') + '</button>',
                ].join('');
                return html;
            }
            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                $('.page').hide();
                switch(window.location.hash) {
                    case '#orders':
                        $.ajax('orders', {
                            dataType: 'json',
                            success: function (response) {
                                $('.orders .list').html(renderListOrders(response));
                                $('.orders').show();
                            },
                            error: function () {
                                window.location.replace('#');
                            }
                        });
                        break;
                    case '#product':
                        $.ajax('product', {
                            success: function () {
                                $('.product .formProduct').html(createProductForm());
                                $('.product').show();
                            },
                            error: function () {
                                window.location.replace('#');
                            }
                        });
                        break;
                    case '#products':
                        $.ajax('products', {
                            dataType: 'json',
                            success: function (response) {
                                $('.products .list').html(renderList(response, 'products'));
                                $('.products .formLogout').html(createLogout());
                                $('.products').show();
                            },
                            error: function () {
                                window.location.replace('#');
                            }
                        });
                        break;
                    case '#login':
                         if (! loggedIn) {
                            $('.login').show();
                            $('.login .formLogin').html(createLogin());
                            loggedIn = true;
                         } else {
                             window.location.replace('#products');
                         }
                        break;
                    case '#cart':
                        $.ajax('cart', {
                            dataType: 'json',
                            success: function (response) {
                                $('.cart .list').html(renderList(response, 'cart'));
                                $('.cart').show();
                            }
                        });
                        break;
                    default:
                        if (window.location.hash.split('/')[0] === '#product') {
                            $.ajax('/product/' + window.location.hash.split('/')[1] + '/edit', {
                                dataType: 'json',
                                success: function (response) {
                                    $('.product .formProduct').html(createProductForm(response.title, response.description, response.price, response.image));
                                    $('.product').show();
                                },
                                error: function () {
                                    window.location.replace('#');
                                }
                            });
                            break;
                        }
                        if (window.location.hash.split('/')[0] === '#order') {
                            $.ajax('order/' + window.location.hash.split('/')[1], {
                                success: function (response) {
                                    $('.order .table').html(renderProductsInOrder(response.products));
                                    $('.order .list').html(renderListOrderDetails(response.order));
                                    $('.order').show();
                                },
                                error: function () {
                                    window.location.replace('#');
                                }
                            });
                            break;
                        }
                        $.ajax('/', {
                            dataType: 'json',
                            success: function (response) {
                                $('.index .list').html(renderList(response));
                                $('.index').show();
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
