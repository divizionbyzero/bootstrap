<?php $this->printTitle(); ?>
<form method="post" action="/adm/address/order/service_id/<?php echo $service_id ?>">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Заголовок</th>
            <th>Город</th>
            <th>Район</th>
            <th>Адрес</th>
            <th colspan="4">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($addresses)) {

            foreach ($addresses as $address) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $address->address_id; ?>]" value="<?php echo $address->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $address->title;?>
                    </td>
                    <td>
                        <?php echo $address->city;?>
                    </td>
                    <td>
                        <?php echo $address->area;?>
                    </td>
                    <td>
                        <?php echo $address->address;?>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-success" href="/adm/contact/index/service_id/<?php echo $service_id ?>/address_id/<?php echo $address->address_id ?>">
                            <i class="icon-list"></i>
                            Контакты
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-success" href="/adm/addresspicture/index/service_id/<?php echo $service_id ?>/address_id/<?php echo $address->address_id ?>">
                            <i class="icon-camera"></i>
                            Галерея
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/address/edit/service_id/<?php echo $service_id ?>/id/<?php echo $address->address_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить этот адрес?')" href="/adm/address/delete/service_id/<?php echo $service_id ?>/id/<?php echo $address->address_id ?>">
                            <i class="icon-trash"></i>
                            Удалить
                        </a>
                    </td>
                </tr>
            <?php
            }?>
            <tr>
                <td colspan="9">
                    <button type="submit" class="btn btn-primary pull-right">Сохранить сортировку</button>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td colspan="9">
                    <span class="label label-info">Извините, нет адрес в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>