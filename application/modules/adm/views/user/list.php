<?php $this->printTitle(); ?>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Email</th>
        <th>Роль</th>
        <th colspan="2">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (count($users)) {
        $i = 1;
        foreach ($users as $user) {?>
            <tr>
                <td class="mini-table-field">
                    <?php echo $i;?>
                </td>
                <td>
                    <?php echo $user->first_name;?>
                </td>
                <td>
                    <?php echo $user->last_name;?>
                </td>
                <td>
                    <?php echo $user->email;?>
                </td>
                <td>
                    <?php echo $user->role;?>
                </td>
                <td class="mini-table-field">
                    <a class="btn-mini btn-warning" href="/adm/user/edit/id/<?php echo $user->id_user ?>">
                        <i class="icon-pencil"></i>
                        Редактировать
                    </a>
                </td>
                <td class="mini-table-field">
                    <a class="btn-mini btn-danger" onClick="return confirm('Вы действительно хотите удалить этого пользователя?')" href="/adm/user/delete/id/<?php echo $user->id_user ?>">
                        <i class="icon-trash"></i>
                        Удалить
                    </a>
                </td>
            </tr>
            <?php
            $i++;
        }
    }else{?>
        <tr>
            <td colspan="7">
                <span class="label label-info">Извините, нет пользователей в базе данных</span>
            </td>
        </tr>
    <?php }?>
    </tbody>
</table>