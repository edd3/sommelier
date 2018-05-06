<?php

use model\Image;
use sommelier\helper\Html;
use sommelier\base\App;

$this->title = $image->name;
$imageUser = $image->user();

?>
<h1><?= $this->title ?></h1>
<div class='img-view'>
    <div class="img-view-holder">
        <div class="jumbotron">
            <img src="/images/<?= $image->file ?>" class="rounded" alt="<?= $image->name ?>">
            <p class="lead">
                Uploaded by: <?= Html::a($imageUser->username, '/user/view/' . $imageUser->username) ?><br>
                Upload date: <?= App::$formatter->toDateTime($image->date) ?>
            </p>
        </div>
    </div>
    <div class='img-view-comments-holder'>
        <div class="jumbotron">
            <h2>Comments <?= $image->countComments() ?>/10</h2>
            <?php
            if ($comments) {
                foreach ($comments as $k => $comment) {
                    $commentUser = $comment->user();

                    ?>
                    <div class='row comment-row'>
                        <div class='col'>
                            <?= Html::a($commentUser->username, '/user/view/' . $commentUser->username) ?>
                            <br>
                            <?= App::$formatter->toDateTime($comment->date) ?>
                        </div>
                        <div class='col'>
                            <?= $comment->comment ?>
                        </div>
                    </div>
                    <?php
                }
            }
            $disabled = '';
            if ($image->countComments() > 9) {
                $disabled = 'disabled';
            }

            ?>
            <div class='row'>
                <form action='/image/addComment/<?= $image->url ?>' method='post'>
                    <?= $disabled ? '<b>This form is disabled. Max 10 comments are allowed per image.</b>' : null ?>
                    <div class="form-group">
                        <label for="commentTextarea">Comment</label>
                        <textarea <?= $disabled ?> name='Comment[comment]' required class="form-control" id="commentTextarea" rows="3"></textarea>
                    </div>
                    <button type="submit" <?= $disabled ?> class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>