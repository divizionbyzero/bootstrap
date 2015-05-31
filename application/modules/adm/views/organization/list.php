<?php $this->printTitle(); ?>
<form method="post" action="/adm/organization/order">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Заголовок</th>
            <th>Телефон</th>
            <th>Email</th>
            <th colspan="2">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($organizations)) {

            foreach ($organizations as $organization) {?>
                <tr>
                    <td class="mini-table-field">
                        <input type="text" class="input-mini sort-order-box" name="SortOrder[<?php echo $organization->organization_id; ?>]" value="<?php echo $organization->sort_order;?>"/>
                    </td>
                    <td>
                        <?php echo $organization->name;?>
                    </td>
                    <td>
                        <?php echo $organization->title;?>
                    </td>
                    <td>
                        <?php echo $organization->phone;?>
                    </td>
                    <td>
                        <?php echo $organization->email;?>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-warning" href="/adm/organization/edit/id/<?php echo $organization->organization_id ?>">
                            <i class="icon-pencil"></i>
                            Редактировать
                        </a>
                    </td>
                    <td class="mini-table-field">
                        <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить эту организацию?')" href="/adm/organization/delete/id/<?php echo $organization->organization_id ?>">
                            <i class="icon-trash"></i>
                            Удалить
                        </a>
                    </td>
                </tr>
                <?php
            }?>
            <tr>
                <td colspan="7">
                    <button type="submit" class="btn btn-primary pull-right">Сохранить сортировку</button>
                </td>
            </tr>
        <?php }else{?>
            <tr>
                <td colspan="7">
                    <span class="label label-info">Извините, нет организаций в базе данных</span>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</form>