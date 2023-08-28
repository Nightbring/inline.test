<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="shortcut icon" href="/favicon.png" type="image/png">
    <script src="/js/script.js"></script>
    <title><?= $title ?? 'Test' ?></title>
</head>
<body>
    <div class="container header-container">
        <div class="header">
            <div class="logo">
                <a href="/">
                    <img src="/images/logo.png" alt="ИНЛАЙН.test">
                </a>
            </div>
            <div class="nav-menu-container">
                <ul class="nav-menu">
                    <li class="nav-menu-elem<?= $_SERVER['REQUEST_URI'] == '/' ? ' active' : '' ?>">
                        <a href="/" class="nav-menu-link">ГЛАВНАЯ</a>
                    </li>
                    <li class="nav-menu-elem<?= $_SERVER['REQUEST_URI'] == '/update' ? ' active' : '' ?>">
                        <a href="/update" class="nav-menu-link">УПРАВЛЕНИЕ ДАННЫМИ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container main-container">
        <div class="main">
            <div class="section">