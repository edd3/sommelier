<?php

use sommelier\base\App;
use sommelier\helper\Html;

$menuArr [] = [
    'title' => 'home',
    'link' => '/'
];

$menuArr[] = [
    'title' => 'images',
    'link' => '/image'
];

if (App::$identity->isLogged()) {
    $menuArr [] = [
        'title' => 'Upload image',
        'link' => '/image/upload'
    ];
}

$menuArr [] = [
    'title' => 'users',
    'link' => '/user'
];

$menuArr[] = [
    'title' => 'contact',
    'link' => '/contact'
];

if (App::$identity->isLogged()) {
    $menuArr[] = [
        'title' => 'logout',
        'link' => '#',
        'onclick' => 'logout()'
    ];
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $this->title ?> | Sommelier MVC</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="/style.css">
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="/">Sommelier MVC</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?= Html::createMenu($menuArr) ?>
        </nav>

        <main role="main" class="container">
            <?= $content ?>
        </main>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="/scripts.js"></script>
    </body>

</html>



