<?php
if ($this->buttons()) {
    ?>
    <div class="btn-group pull-right">
        <?php foreach ($this->buttons() as $name => $link) {
            echo '<a class="btn" href="'.$link.'">'.$name.'</a>';
        }?>
    </div>
<?php } ?>
