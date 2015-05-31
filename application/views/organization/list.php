<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1>Организации</h1>
        </div>
    </div>
    <div class="row-fluid">

        <div class="offset1 span10 offset1 list-items">

            <?php if(count($organizations)){
                foreach($organizations as $organization){?>

                    <div class="list-item">
                        <h2><?php echo $organization->name ?></h2>
                        <p>Телефон: <?php echo $organization->phone ?></p>
                        <p>Email: <?php echo $organization->email ?></p>
                        <div class="text">
                            <?php echo AppHelper::trim_text($organization->description, 60); ?>
                        </div>
                        <div class="info">
                            <a class="btn btn-info pull-right" href="/organization/show/organization_id/<?php echo $organization->organization_id ?>">подробнее</a>
                        </div>
                    </div>

                <?php }
            }?>

        </div>
    </div>
</div>