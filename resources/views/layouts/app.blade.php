<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            Тестовые задачи ООО СибЭлКом-Логистик:
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ $task == 1 ? 'active' : '' }}" href="/?task=1">Задача 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $task == 2 ? 'active' : '' }}" href="/?task=2">Задача 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $task == 3 ? 'active' : '' }}" href="/?task=3">Задача 3</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
@yield('js')
<!-- Подключение Bootstrap JS и необходимых библиотек -->
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
