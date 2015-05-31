<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1><?php echo $service->title; ?></h1>
        </div>
    </div>
    <div class="row-fluid">

        <div class="span2">
            <h4>Организация: </h4>
            <address>
                <strong><?php echo $organization->name; ?></strong><br>
                <?php echo $organization->title; ?><br>

            </address>

            <address>
                <strong>Контакты</strong><br>
                <abbr title="Телефон">Т:</abbr> <?php echo $organization->phone; ?> <br/>
                <abbr title="Email">E:</abbr> <a href="mailto: <?php echo $organization->email; ?>"><?php echo $organization->email; ?></a>
            </address>
        </div>

        <div class="span10">
            <div class="list-item">
                <h2>Описание услуги: </h2>
                <div class="text">
                    <?php echo $service->description; ?>
                </div>
                <div class="info">
                    <p class="lead pull-right">Цена: <?php echo $service->cost; ?> руб.</p>
                </div>
            </div>
        </div>

    </div>
    <?php if(count($service->addresses)){?>
    <div class="row-fluid addresses">
        <div class="span12">
            <h2>Адреса</h2>

            <?php foreach($service->addresses as $address){?>
                <div class="row-fluid address-item">
                    <div class="span12">
                        <div class="row-fluid">
                            <div class="span2">
                                <?php if(count($address->contacts)){?>
                                    <h4>Контакты: </h4>

                                    <address>
                                        <?php foreach($address->contacts as $contact){
                                            echo '<abbr title="'.$contact->type.'">'.mb_substr($contact->type, 0, 1, 'UTF-8').': </abbr>'.$contact->contact.' <br/>';
                                        }?>

                                    </address>
                                <?php }?>
                            </div>
                            <div class="span10">
                                <div class="pull-left pic">
                                    <img src="/<?php echo Address::thumb_dir.'/'.$address->file_name ?>" class="img-polaroid">
                                </div>
                                <div class="pull-left address">
                                    <h3><?php echo $address->title ?></h3>
                                    <p>
                                        <small><?php echo $address->city?></small><br/>
                                        <small><?php echo $address->area?></small><br/>
                                        <small><?php echo $address->address?></small><br/>
                                    </p>
                                </div>
                                <div id="map_canvas_<?php echo $address->address_id ?>" class="item-map pull-right" lat="<?php echo $address->map_lat?>" lng="<?php echo $address->map_lng?>"></div>
                            </div>
                        </div>
                        <?php if(count($address->pictures)){?>
                            <div class="row-fluid gallery">
                                <div class="offset2 span10">
                                    <ul class="bxslider">
                                        <?php foreach($address->pictures as $picture){?>
                                            <li><img src="/<?php echo AddressPicture::file_dir.'/'.$picture->file_name ?>" title="<?php echo $picture->title ?>" /></li>
                                        <?}?>
                                    </ul>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>

            <?php }?>
        </div>
    </div>
    <?php }?>
</div>