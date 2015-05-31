<?php $this->printTitle(); ?>
<form method="post" action="/adm/city/order">
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
        if (count($cities)) {

            foreach ($cities as $city) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $city->city_id; ?>]" value="<?php echo $city->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $city->name;?>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/city/edit/id/<?php echo $city->city_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить этот город?')" href="/adm/city/delete/id/<?php echo $city->city_id ?>">
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
                    <span class="label label-info">Извините, нет городов в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>