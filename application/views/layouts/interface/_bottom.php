<div class="row-fluid">
    <div class="span12">

    </div>
</div>

<!-- popups --->
<div class="popup popup-login">
    <div class="popup-inner">
        <div class="popup-close">X</div>
        <h2>Вход</h2>

        <div class="alert">
            Введите email и пароль для входа
        </div>

        <form id="login-form" class="form-horizontal" action="/home/login">
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="mini-table-field">
                        <label class="control-label" for="email">Email</label>
                    </td>
                    <td>
                        <input type="email" id="email" name="Login[email]" placeholder="email" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="mini-table-field">
                        <label class="control-label" for="password">Пароль</label>
                    </td>
                    <td>
                        <input type="password" id="password" name="Login[password]" placeholder="пароль" value="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="checkbox pull-left">
                            <input id="remember_me" type="checkbox" name="Login[remember_me]" value="1">
                            Запомнить меня
                        </label>
                        <button type="submit" class="btn btn-primary pull-right">Войти</button>
                    </td>
                </tr>
            </table>
        </form>
        <a href="/registration" class="pull-right">Зарегистрироваться</a>
    </div>
</div>
<!-- popups --->
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/jquery.bxslider.min.js" type="text/javascript"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCAtXbJNP9aiECQEOM8nmiZYekelcCo2js&sensor=true" type="text/javascript"></script>
<script src="/js/script.js" type="text/javascript"></script>
</body>
</html>