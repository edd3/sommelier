<?php

use model\Image;
use sommelier\helper\Html;
use sommelier\base\App;

$this->title = 'Images';

?>
<h1><?= $this->title ?></h1>
<div class='img-index'>
    <?php
    foreach ($images as $k => $image) {

        ?>
        <div class='row img-row'>
            <div class='col'>
                <?= Html::a($image->show(), '/image/view/' . $image->url) ?>
            </div>
            <div class='col'>
                <h2>
                    <?= Html::a($image->name, '/image/view/' . $image->url) ?>
                </h2>
                <?= App::$formatter->toDateTime($image->date) ?>
                <Br>
                <?= $image->user()->username ?>
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
            echo Html::a($i, '/image/page/' . $i);
            if ($page == $i) {
                echo '</b>';
            }
        }

        ?>
    </div>
</div>