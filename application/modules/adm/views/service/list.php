<?php $this->printTitle(); ?>
<form method="post" action="/adm/service/order">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Организация</th>
            <th>Тип услуги</th>
            <th>Заголовок</th>
            <th>Стоимость</th>
            <th colspan="3">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($services)) {

            foreach ($services as $service) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $service->service_id; ?>]" value="<?php echo $service->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $service->organization;?>
                    </td>
                    <td>
                        <?php echo $service->service_type;?>
                    </td>
                    <td>
                        <?php echo $service->title;?>
                    </td>
                    <td>
                        <?php echo $service->cost;?> руб.
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-success" href="/adm/address/index/service_id/<?php echo $service->service_id ?>">
                            <i class="icon-list"></i>
                            Адреса
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/service/edit/id/<?php echo $service->service_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить эту услугу?')" href="/adm/service/delete/id/<?php echo $service->service_id ?>">
                            <i class="icon-trash"></i>
                            Удалить
                        </a>
                    </td>
                </tr>
            <?php
            }?>
            <tr>
                <td colspan="8">
                    <button type="submit" class="btn btn-primary pull-right">Сохранить сортировку</button>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td colspan="8">
                    <span class="label label-info">Извините, нет услуг в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>