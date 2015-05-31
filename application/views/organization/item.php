<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1><?php echo $organization->name; ?></h1>
        </div>
    </div>
    <div class="row-fluid">

        <div class="span2">
            <h4>Контакты: </h4>

            <address>
                <abbr title="Телефон">Т:</abbr> <?php echo $organization->phone; ?> <br/>
                <abbr title="Email">E:</abbr> <a href="mailto: <?php echo $organization->email; ?>"><?php echo $organization->email; ?></a>
            </address>
        </div>

        <div class="span10">
            <div class="list-item">
                <h2>Описание организации: </h2>

                <div class="text">
                    <?php echo $organization->description; ?>
                </div>
            </div>
        </div>

    </div>

    <?php if(count($services)){?>
        <div class="row-fluid addresses">
            <div class="offset2 span10">
                <h2>Услуги</h2>

                <ul class="nav nav-pills nav-stacked">
                    <?php foreach($services as $service){?>
                        <li><a href="/service/show/service_id/<?php echo $service->service_id?>"><?php echo $service->service_type.': '.$service->title.' - '.$service->cost.' руб.' ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php }?>

</div>