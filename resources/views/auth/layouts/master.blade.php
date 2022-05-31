<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>


    <link rel="stylesheet" href="css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/starter-template.css" rel="stylesheet">
    <link rel="stylesheet" href="js/app.js">

</head>
<body>
<nav class="navbar navbar-default navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">
            Вернуться на сайт
        </a>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @admin
                <li><a href="{{ route('categories.index') }}">Категории</a></li>
                <li><a href="{{ route('products.index') }}">Товары</a>
                </li>
                <li><a href="{{ route('orders') }}">Заказы</a></li>
                @endadmin
            </ul>

            @guest
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Зарегистрироваться</a>
                    </li>
                </ul>
            @endguest

            @auth
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}">Выйти</a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>


<div class="container">
    <div class="starter-template">
        @yield('content')
    </div>
</div>
</body>
</html>
