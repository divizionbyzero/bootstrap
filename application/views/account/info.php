<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1>Ваш Аккаунт</h1>
        </div>
    </div>
    <div class="row-fluid">
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="mini-table-field">
                        <label class="control-label" for="FirstName">Имя</label>
                    </td>
                    <td>
                        <?php echo $this->user->first_name?>
                    </td>
                </tr>
                <tr>
                    <td class="mini-table-field">
                        <label class="control-label">Фамилия</label>
                    </td>
                    <td>
                        <?php echo $this->user->last_name?>
                    </td>
                </tr>
                <tr>
                    <td class="mini-table-field">
                        <label class="control-label">Никнейм</label>
                    </td>
                    <td>
                        <?php echo $this->user->nickname?>
                    </td>
                </tr>
                <?php if($this->user->photo){
                    $this->ShowImage($this->user, 'photo', AppUser::thumb_dir);
                }?>
                <tr>
                    <td class="mini-table-field">
                        <label class="control-label">Email</label>
                    </td>
                    <td>
                        <?php echo $this->user->email?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a class="btn btn-large btn-block btn-primary pull-right" href="/registration/edit/id/<?php echo $this->user->id_user ?>">Редактировать</a>
                    </td>
                </tr>
            </table>
    </div>
</div>