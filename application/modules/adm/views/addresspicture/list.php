<?php $this->printTitle(); ?>
<form method="post" action="/adm/addresspicture/order/service_id/<?php echo $service_id ?>/address_id/<?php echo $address_id ?>">
    <?php if (count($pictures)) { ?>
        <div class="row-fluid pic-gallery">
            <ul class="thumbnails">
                <? foreach ($pictures as $picture) { ?>
                    <li class="span2">
                        <div class="thumbnail">
                            <img src="/<?php echo AddressPicture::thumb_dir . '/' . $picture->file_name ?>" alt="<?php echo $picture->title ?>">
                            <h3><?php echo $picture->title ?></h3>
                            <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $picture->picture_id; ?>]" value="<?php echo $picture->sort_order; ?>"/>
                            <div class="btn-group">
                                <a class="btn btn-mini btn-warning" href="/adm/addresspicture/edit/service_id/<?php echo $service_id ?>/address_id/<?php echo $address_id ?>/id/<?php echo $picture->picture_id ?>">
                                    <i class="icon-pencil"></i>
                                    Редактировать
                                </a>
                                <a class="btn btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить это изображение?')" href="/adm/addresspicture/delete/service_id/<?php echo $service_id ?>/address_id/<?php echo $address_id ?>/id/<?php echo $picture->picture_id ?>">
                                    <i class="icon-trash"></i>
                                    Удалить
                                </a>
                            </div>
                        </div>
                    </li>
                <?php
                }?>
            </ul>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <button type="submit" class="btn btn-primary pull-right">Сохранить сортировку</button>
            </div>
        </div>
    <?php } else { ?>
        <div class="row-fluid">
            <div class="span12">
                <div class="span12"><span class="label label-info">Извините, нет контактов в базе данных</span></div>
            </div>
        </div>
    <?php }?>
</form>