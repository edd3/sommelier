<?php

use model\User;
use sommelier\helper\Html;
use sommelier\base\App;

$this->title = 'Users';

?>
<h1><?= $this->title ?></h1>
<div class='img-index'>
    <?php
    foreach ($users as $k => $user) {

        ?>
        <div class='row img-row'>
            <div class='col'>
                <?= Html::a($user->username, '/user/view/' . $user->username) ?>
            </div>
            <div class='col'>
                Uploaded images: <?= $user->cnt ?>
            </div>
        </div>
        <?php
    }

    ?>
    <div class='row pagination'>
        <?php
        for ($i = 1; $i <= $maxPages; $i++) {
            if ($page == $i) {
                echo '<b>';
            }
            echo Html::a($i, '/user/page/' . $i);
            if ($page == $i) {
                echo '</b>';
            }
        }

        ?>
    </div>
</div>