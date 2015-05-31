<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1>Услуги</h1>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <?php if(count($service_types)){ ?>
                <ul class="nav nav-list left-menu">
                    <?php foreach($service_types as $service_type){ ?>
                        <li <?php echo ($this->active()==$service_type->service_type_id) ? 'class="active"' : '';?>><a href="/service/index/service_id/<?php echo $service_type->service_type_id ?>"><?php echo $service_type->name ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>


        <div class="span10 list-items">

            <?php if(count($services)){
                foreach($services as $service){?>

                <div class="list-item">
                    <h2><?php echo $service->title ?></h2>
                    <h3><?php echo $service->organization ?></h3>
                    <h4><?php echo $service->service_type ?></h4>
                    <div class="text">
                        <?php echo AppHelper::trim_text($service->description, 60); ?>
                    </div>
                    <div class="info">
                        <p class="lead pull-left"><?php echo $service->cost; ?> руб.</p>
                        <a class="btn btn-info pull-right" href="/service/show/service_id/<?php echo $service->service_id ?>">подробнее</a>
                    </div>
                </div>

            <?php }
            }?>

        </div>
    </div>
</div>