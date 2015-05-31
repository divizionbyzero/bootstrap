<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1>Результаты поиска</h1>
        </div>
    </div>
    <div class="row-fluid">

        <div class="offset1 span10 offset1 list-items">

            <?php if(count($res)){
                foreach($res as $result){?>

                    <div class="list-item">
                        <h2><?php echo $result['title'] ?></h2>
                        <h4><?php echo $result['organization_name'] ?></h4>
                        <div class="text">
                            <?php echo AppHelper::trim_text($result['description'], 60); ?>
                        </div>
                        <div class="info">
                            <a class="btn btn-info pull-right" href="<?php echo $result['url']?>">подробнее</a>
                        </div>
                    </div>

                <?php }
            }else{?>
                <h4>Нет результов поиска</h4>
            <?php } ?>

        </div>
    </div>
</div>