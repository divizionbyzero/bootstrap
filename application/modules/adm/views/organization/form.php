<?php $this->printTitle(); ?>
<?php $this->printError($this->organization); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/organization/<?php echo $this->action->id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="name">Название</label>
            </td>
            <td>
                <input type="text" id="name" name="Organization[name]" placeholder="Название" value="<?php echo htmlspecialchars($this->organization->name)?>" />
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="title">Заголовок</label>
            </td>
            <td>
                <input type="text" id="title" name="Organization[title]" placeholder="Заголовок" value="<?php echo htmlspecialchars($this->organization->title)?>">
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="description">Описание</label>
            </td>
            <td>
                <textarea id="description" name="Organization[description]" rows="3"><?php echo htmlspecialchars($this->organization->description)?></textarea>
                <script type="text/javascript">
                    CKEDITOR.replace('Organization[description]');
                </script>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="phone">Телефон</label>
            </td>
            <td>
                <input autocomplete="off" type="text" id="phone" name="Organization[phone]" placeholder="Телефон" value="<?php echo htmlspecialchars($this->organization->phone)?>">
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="email">Email</label>
            </td>
            <td>
                <input autocomplete="off" type="email" id="email" name="Organization[email]" placeholder="Email" value="<?php echo htmlspecialchars($this->organization->email)?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>