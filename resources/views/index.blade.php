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
                } else {
                    html += '<th>Add to cart</th></tr>';
                }
                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>',
                        '<th><img src="/storage/images/' + product.image + '"/></td></th>',
                    ].join('');

                    if (window.location.hash === '#cart') {
                        html += '<td>';
                        html += '<form action="cart" method="post">';
                        html += '<input type="hidden" name="_token" value="' + csrf[1] +'">';
                        html += '<input name="id" value="' + product.id + '" type="hidden">';
                        html += '<button id="buttonId" name="remove" value="remove">Remove</button>';
                        html += '</form></td></tr><br>';

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
                    html += $('#form').load('/form');
                    $('#form').on('submit', function (e) {
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
                    '<input id="username" type="text" name="username" placeholder="Username">',
                    '<br><input id="password" type="password" name="password" placeholder="Password">',
                    '<br><button name="login" value="login">Login</button>',
                ].join('');
                $('#formLogin').on('submit', function (e) {
                    e.preventDefault();

                    let username = $('#username').val();
                    let password = $('#password').val();
                    $.ajax({
                        url: "login",
                        type: "POST",
                        data: {
                            "_token": csrf[1],
                            username: username,
                            password: password,
                        },
                        success: function (response) {
                            if(response) {
                                window.location.replace("#products");
                            } else {
                                htmlForm += $('#spanLogin').text('Invalid credentials');
                            }
                        },
                        error: function (response) {
                            let res = response.responseJSON.errors;
                            if (res.username) {
                                htmlForm += $('#spanLogin').text(res.username);
                            }
                            if (res.password) {
                                htmlForm += $('#spanLogin').text(res.password);
                            }
                        },
                    });
                });
                return htmlForm;
            }
            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();

                switch(window.location.hash) {
                    case '#products':
                        $('.products').show();
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
        <form id="form"></form>
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
</div>
</body>
</html>
