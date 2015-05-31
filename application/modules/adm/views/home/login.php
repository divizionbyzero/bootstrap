<?php
    $bodyID='login-page';
    require_once $this->module->basePath . '/views/layouts/interface/top.php';
?>

    <div class="container">
        <div class="row logo-container">
            <img src="<?php echo Yii::app()->baseUrl.'/'.$this->logo();?>" class="img-polaroid">
            <h5><?php echo Yii::app()->name ?>: панель администратора</h5>
        </div>
        <div class="row form-container">
            <form class="form-signin" method="POST" action="/adm">
                <h3 class="form-signin-heading">Авторизация</h3>
                <?php $this->printError($login_form); ?>
                <div class="control-group">
                    <div class="controls">
                        <input type="text" class="input-block-level" name="LoginForm[email]" placeholder="email" value="<?php echo $login_form->email ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="password" class="input-block-level" placeholder="password" name="LoginForm[password]" value="<?php echo $login_form->password ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" name="LoginForm[remember_me]" value="1" <?php echo $login_form->remember_me ? 'checked=""' : ''; ?>>
                            Запомнить меня
                        </label>
                        <button class="btn btn-large btn-primary" type="submit">Войти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require_once $this->module->basePath . '/views/layouts/interface/bottom.php'; ?>