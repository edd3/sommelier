<?php

use model\Image;
use sommelier\helper\Html;
use sommelier\base\App;

$this->title = 'Main page';

?>
<div class='home-index'>
    <div class='row img-holder'>
        <?php
        $images = (new Image())->select()->filter('active')->limit(10)->orderBy('id desc')->q();
        foreach ($images as $k => $image) {

            ?>
            <div class='col'>
                <?= Html::a($image->show(), '/image/view/' . $image->url) ?>
            </div>
            <?php
        }

        ?>
    </div>        <?php
    if (!App::$identity->isLogged()) {

        ?>
        <div class="row">
            <div class="col">
                <div class="jumbotron">
                    <h2>Register</h2>
                    <form action='/site/register' method='post'>
                        <?php
                        if (isset($_SESSION['error']['form']['Register'])) {
                            echo $_SESSION['error']['form']['Register'];
                            unset($_SESSION['error']['form']['Register']);
                        }

                        ?>
                        <div class="form-group">
                            <label for="registerUsername">Username</label>
                            <input name='User[username]' required class="form-control" id="registerUsername" aria-describedby="usernameHelp" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="registerEmail">Email address</label>
                            <input name='User[email]' required type="email" class="form-control" id="registerEmail" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Password</label>
                            <input name='User[password]' required type="password" class="form-control" id="registerPassword" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col">
                <div class="jumbotron">
                    <h2>Login</h2>
                    <form action='/site/login' method='post'>
                        <?php
                        if (isset($_SESSION['error']['form']['Login'])) {
                            echo $_SESSION['error']['form']['Login'];
                            unset($_SESSION['error']['form']['Login']);
                        }

                        ?>
                        <div class="form-group">
                            <label for="loginEmail">Email address</label>
                            <input name='User[email]' required type="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input name='User[password]' required type="password" class="form-control" id="loginPassword" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    ?>
</div>