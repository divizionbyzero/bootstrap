<?php $this->printTitle(); ?>
<?php $this->printError($this->address); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/address/<?php echo $this->action->id?>/service_id/<?php echo $service_id?><?php echo $url_attributes?>">
    <input type="hidden" id="lat" name="Address[map_lat]" value="<?php echo $this->address->map_lat; ?>">
    <input type="hidden" id="lng" name="Address[map_lng]" value="<?php echo $this->address->map_lng; ?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="name">Город</label>
            </td>
            <td>
                <select id="city_list" name="Address[city_id]">
                    <option value="">пожалуйста, выберите</option>
                    <?php if(count($cities)){
                        foreach($cities as $city)
                        {
                            $attr = ($city->city_id == $this->address->city_id) ? 'selected="selected"' : '';
                            echo '<option '.$attr.' value="'.$city->city_id.'">'.$city->name.'</option>';
                        }
                    }?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="name">Район</label>
            </td>
            <td>
                <select id="area_list" name="Address[area_id]">
                    <option value="">пожалуйста, выберите</option>
                    <?php if(count($areas)){
                        foreach($areas as $area)
                        {
                            $attr = ($area->area_id == $this->address->area_id) ? 'selected="selected"' : '';
                            echo '<option '.$attr.' value="'.$area->area_id.'">'.$area->name.'</option>';
                        }
                    }?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="title">Заголовок</label>
            </td>
            <td>
                <input type="text" id="title" name="Address[title]" placeholder="Заголовок" value="<?php echo htmlspecialchars($this->address->title)?>" />
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="address">Адрес</label>
            </td>
            <td>
                <textarea id="address" name="Address[address]" rows="3"><?php echo htmlspecialchars($this->address->address)?></textarea>
                <script type="text/javascript">
                    CKEDITOR.replace('Address[address]');
                </script>
            </td>
        </tr>
        <tr>
            <td>
                <label class="control-label">Карта</label>
            </td>
            <td>
                <div id="map_canvas" style="width:460px; height:460px"></div>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label">Изображение</label>
            </td>
            <td>
                <input type="file" id="file_name" name="Address[file_name]" value="">
            </td>
        </tr>
        <?php if($this->address->file_name){
            $this->ShowImage($this->address, 'file_name', Address::thumb_dir);
        }?>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>