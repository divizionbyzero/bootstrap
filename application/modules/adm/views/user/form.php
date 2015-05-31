<?php $this->printTitle(); ?>
<?php $this->printError($this->user); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/user/<?php echo $this->action->id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="FirstName">Имя</label>
            </td>
            <td>
                <input type="text" id="FirstName" name="AppUser[first_name]" placeholder="Имя" value="<?php echo $this->user->first_name?>">
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="LastName">Фамилия</label>
            </td>
            <td>
                <input type="text" id="LastName" name="AppUser[last_name]" placeholder="Фамилия" value="<?php echo $this->user->last_name?>">
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="nickname">Никнейм</label>
            </td>
            <td>
                <input type="text" id="nickname" name="AppUser[nickname]" placeholder="Никнейм" value="<?php echo $this->user->nickname?>">
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label">Фото</label>
            </td>
            <td>
                <input type="file" id="photo" name="AppUser[photo]" value="">
            </td>
        </tr>
        <?php if($this->user->photo){
            $this->ShowImage($this->user, 'photo', AppUser::thumb_dir);
        }?>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="Email">Email</label>
            </td>
            <td>
                <input autocomplete="off" type="text" id="Email" name="AppUser[email]" placeholder="Email" value="<?php echo $this->user->email?>">
            </td>
        </tr>
        <tr>
            <td>
                <label class="control-label" for="Password">Пароль</label>
            </td>
            <td>
                <input autocomplete="off" type="password" id="Password" name="AppUser[password]" placeholder="Пароль" value="">
            </td>
        </tr>
        <?php if(count($this->roles)){?>
            <tr>
                <td>
                    <label class="control-label">Роль</label>
                </td>
                <td>
                    <select name="AppUser[role]">
                        <?php foreach($this->roles as $role){
                            $attr = ($role->name == $this->user->role) ? 'selected=""' : '';
                            echo '<option '.$attr.' value="'.$role->name.'">'.$role->name.'</option>';
                        }?>
                    </select>
                </td>
            </tr>
        <?php }?>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>