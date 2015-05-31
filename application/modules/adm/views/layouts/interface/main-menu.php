<ul id="main-menu">
    <?php if ($this->menu()) {
        foreach ($this->menu() as $header => $menu) {
            ?>
            <li class="header"><?php echo $header;?></li>
            <?php if (count($menu)) {
                foreach ($menu as $item) {
                    ?>
                    <li <?php echo ($item['active'] == $this->active()) ? 'class="active"' : ''; ?> >
                        <a href="<?php echo $item['url']; ?>">
                            <?php echo $item['icon'] ? '<i class="' . $item['icon'] . '"></i>' : '';?>
                            <?php echo $item['title'];?>
                        </a>
                    </li>
                <?php
                }
            }?>
        <?php
        }
    }?>
</ul>
