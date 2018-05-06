<div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
        <?php
        foreach ($arr as $k => $v) {

            ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?= $v['link'] ?>"
                   <?php
                   if (isset($v['onclick'])) {
                       echo 'onclick="' . $v['onclick'] . '"';
                   }

                   ?>
                   >
                       <?= ucfirst($v['title']) ?>
                </a>
            </li>
            <?php
        }

        ?>

    </ul>
</div>