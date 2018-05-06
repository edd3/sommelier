<?php

use model\Image;
use sommelier\helper\Html;
use sommelier\base\App;

$this->title = 'Upload image';

?>
<h1><?= $this->title ?></h1>
<div class='img-upload-view'>
    <div class='jumbotron'>
        <form action='/image/upload/' enctype="multipart/form-data" method='post'>
            <div class="form-group">
                <label for="nameInput">Title</label>
                <input name='Image[name]' required class="form-control" id="nameInput" aria-describedby="nameHelp" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="imageInput">Image</label>
                <input name='uploadfile' required type="file" class="form-control-file" id="imageInput">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>