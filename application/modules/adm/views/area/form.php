<?php $this->printTitle(); ?>
<?php $this->printError($this->area); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/area/<?php echo $this->action->id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="name">Город</label>
            </td>
            <td>
                <select name="Area[city_id]">
                    <option value="">пожалуйста, выберите</option>
                    <?php if(count($cities)){
                        foreach($cities as $city)
                        {
                            $attr = ($city->city_id == $this->area->city_id) ? 'selected="selected"' : '';
                            echo '<option '.$attr.' value="'.$city->city_id.'">'.$city->name.'</option>';
                        }
                    }?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="name">Название</label>
            </td>
            <td>
                <input type="text" id="name" name="Area[name]" placeholder="Название" value="<?php echo htmlspecialchars($this->area->name)?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>