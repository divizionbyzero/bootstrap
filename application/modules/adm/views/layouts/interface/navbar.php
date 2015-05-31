<div class="navbar navbar-static-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a href="<?php echo Yii::app()->homeUrl ?>" target="_blank" class="brand"><?php echo Yii::app()->name ?></a>
            <!--<ul class="nav pull-left">
                <li class="divider-vertical"></li>
                <li>
                    <form class="navbar-search">
                        <input type="text" class="search-query" placeholder="Search">
                        <button style="margin-top: 0px;" type="submit" class="btn">Go</button>
                    </form>
                </li>
            </ul>-->
            <ul class="nav pull-right">
                <li class="divider-vertical"></li>
                <li><a target="_blank" href="<?php echo Yii::app()->homeUrl; ?>">Перейти на сайт</a></li>
                <li class="divider-vertical"></li>
                <li><a href="/adm/home/logout"><i class="icon-off" style="margin-right: 5px;"></i>Выйти</a></li>
            </ul>
        </div>
    </div>
</div>
