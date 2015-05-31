<?php require_once Yii::app()->basePath . '/views/layouts/interface/_top.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12 header">
            <div class="navbar navbar-fixed-top navbar-inverse top-menu">
                <div class="navbar-inner">
                    <a class="brand" href="/"><?php echo Yii::app()->name; ?></a>
                    <ul class="nav">
                        <li <?if(Yii::app()->controller->id == 'home'){?>class="active"<?}?>><a href="/">На главную</a></li>
                        <li <?if(Yii::app()->controller->id == 'service'){?>class="active"<?}?>><a href="/service">Услуги</a></li>
                        <li <?if(Yii::app()->controller->id == 'organization'){?>class="active"<?}?>><a href="/organization">Организации</a></li>
                        
                    </ul>

                    <form class="navbar-search pull-right" method="post" action="/search">
                        <input type="text" name="SearchWord" value="" class="search-query" placeholder="Поиск">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid main-content">
        <?php echo $content; ?>
    </div>
</div>
<?php require_once Yii::app()->basePath . '/views/layouts/interface/_bottom.php'; ?>