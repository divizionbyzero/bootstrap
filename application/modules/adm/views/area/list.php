<?php $this->printTitle(); ?>
<form method="post" action="/adm/area/order">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Город</th>
            <th>Название</th>
            <th colspan="2">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($areas)) {

            foreach ($areas as $area) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $area->area_id; ?>]" value="<?php echo $area->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $area->city;?>
                    </td>
                    <td>
                        <?php echo $area->name;?>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/area/edit/id/<?php echo $area->area_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить этот район?')" href="/adm/area/delete/id/<?php echo $area->area_id ?>">
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
                    <span class="label label-info">Извините, нет районов в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>