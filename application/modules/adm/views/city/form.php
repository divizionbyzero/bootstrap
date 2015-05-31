<?php $this->printTitle(); ?>
<?php $this->printError($this->city); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/city/<?php echo $this->action->id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="name">Название</label>
            </td>
            <td>
                <input type="text" id="name" name="City[name]" placeholder="Название" value="<?php echo htmlspecialchars($this->city->name)?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>