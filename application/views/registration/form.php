<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1>Регистрация</h1>
        </div>
    </div>
    <div class="row-fluid">
        <?php if($success){?>
            <div class="alert alert-success">
                Поздравляем, вы успешно зарегестрировались. Теперь вы можете войти на сайт используя свой email и пароль!
            </div>
        <?php }else{?>
            <?php $this->printError($this->user); ?>
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="/registration/<?php echo ($this->action->id == 'edit') ? 'edit/id/'.$this->user->id_user : 'run';?>">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td class="mini-table-field">
                            <label class="control-label" for="FirstName">Имя</label>
                        </td>
                        <td>
                            <input class="input-xxlarge" type="text" id="FirstName" name="AppUser[first_name]" placeholder="Имя" value="<?php echo $this->user->first_name?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="mini-table-field">
                            <label class="control-label" for="LastName">Фамилия</label>
                        </td>
                        <td>
                            <input class="input-xxlarge" type="text" id="LastName" name="AppUser[last_name]" placeholder="Фамилия" value="<?php echo $this->user->last_name?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="mini-table-field">
                            <label class="control-label" for="nickname">Никнейм</label>
                        </td>
                        <td>
                            <input class="input-xxlarge" type="text" id="nickname" name="AppUser[nickname]" placeholder="Никнейм" value="<?php echo $this->user->nickname?>">
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
                            <input class="input-xxlarge" autocomplete="off" type="text" id="Email" name="AppUser[email]" placeholder="Email" value="<?php echo $this->user->email?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label" for="Password">Пароль</label>
                        </td>
                        <td>
                            <input class="input-xxlarge" autocomplete="off" type="password" id="Password" name="AppUser[password]" placeholder="Пароль" value="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-large btn-block btn-primary pull-right">
                                <?php echo ($this->action->id == 'edit') ? 'Сохранить' : 'Зарегистрироваться';?>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php }?>
    </div>
</div>