<?php $this->printTitle(); ?>
<form method="post" action="/adm/contact/order/service_id/<?php echo $service_id ?>/address_id/<?php echo $address_id?>">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Тип</th>
            <th>Контакт</th>
            <th colspan="2">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($contacts)) {

            foreach ($contacts as $contact) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $contact->contact_id; ?>]" value="<?php echo $contact->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $contact->type;?>
                    </td>
                    <td>
                        <?php echo $contact->contact;?>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/contact/edit/service_id/<?php echo $service_id?>/address_id/<?php echo $address_id?>/id/<?php echo $contact->contact_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить этот контакт?')" href="/adm/contact/delete/service_id/<?php echo $service_id?>/address_id/<?php echo $address_id?>/id/<?php echo $contact->contact_id ?>">
                            <i class="icon-trash"></i>
                            Удалить
                        </a>
                    </td>
                </tr>
            <?php
            }?>
            <tr>
                <td colspan="5">
                    <button type="submit" class="btn btn-primary pull-right">Сохранить сортировку</button>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td colspan="5">
                    <span class="label label-info">Извините, нет контактов в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>