<?php if ($this->breadcrumbs()) { ?>
    <ul class="breadcrumb">
        <?php foreach ($this->breadcrumbs() as $title => $url) {
            echo $url ? '<li><a href="' . $url . '">' . $title . '</a> <span class="divider">/</span></li>' : '<li class="active">' . $title . '</li>';
        }?>
    </ul>
<?php } ?>