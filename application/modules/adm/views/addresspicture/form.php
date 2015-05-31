<?php $this->printTitle(); ?>
<?php $this->printError($this->picture); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/addresspicture/<?php echo $this->action->id?>/service_id/<?php echo $service_id ?>/address_id/<?php echo $address_id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="title">Заголовок</label>
            </td>
            <td>
                <input type="text" id="title" name="AddressPicture[title]" placeholder="Заголовок" value="<?php echo $this->picture->title?>">
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label">Изображение</label>
            </td>
            <td>
                <input type="file" id="file_name" name="AddressPicture[file_name]" value="">
            </td>
        </tr>
        <?php if($this->picture->file_name){
            $this->ShowImage($this->picture, 'file_name', AddressPicture::thumb_dir);
        }?>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>