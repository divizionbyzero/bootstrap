<?php $this->printTitle(); ?>
<form method="post" action="/adm/servicetype/order">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th colspan="2">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($service_types)) {

            foreach ($service_types as $service_type) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $service_type->service_type_id; ?>]" value="<?php echo $service_type->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $service_type->name;?>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/servicetype/edit/id/<?php echo $service_type->service_type_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить этот тип услуги?')" href="/adm/servicetype/delete/id/<?php echo $service_type->service_type_id ?>">
                            <i class="icon-trash"></i>
                            Удалить
                        </a>
                    </td>
                </tr>
            <?php
            }?>
            <tr>
                <td colspan="4">
                    <button type="submit" class="btn btn-primary pull-right">Сохранить сортировку</button>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td colspan="4">
                    <span class="label label-info">Извините, нет типов услуг в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>