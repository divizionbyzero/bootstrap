<?php $this->printTitle(); ?>
<?php $this->printError($this->service); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/service/<?php echo $this->action->id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="title">Организация</label>
            </td>
            <td>
                <select name="Service[organization_id]">
                    <option value="">Пожалуйста выберите</option>
                    <?php if(count($organizations)){
                        foreach($organizations as $organization)
                        {
                            $attr = ($organization->organization_id == $this->service->organization_id) ? 'selected=""' : '';
                            echo '<option '.$attr.' value="'.$organization->organization_id.'">'.htmlspecialchars($organization->name).'</option>';
                        }
                    }?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="title">Тип услуги</label>
            </td>
            <td>
                <select name="Service[service_type_id]">
                    <option value="">Пожалуйста выберите</option>
                    <?php if(count($service_types)){
                        foreach($service_types as $service_type)
                        {
                            $attr = ($service_type->service_type_id == $this->service->service_type_id) ? 'selected=""' : '';
                            echo '<option '.$attr.' value="'.$service_type->service_type_id.'">'.htmlspecialchars($service_type->name).'</option>';
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
                <input type="text" id="title" name="Service[title]" placeholder="Заголовок" value="<?php echo htmlspecialchars($this->service->title)?>" />
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="description">Описание</label>
            </td>
            <td>
                <textarea id="description" name="Service[description]" rows="3"><?php echo htmlspecialchars($this->service->description)?></textarea>
                <script type="text/javascript">
                    CKEDITOR.replace('Service[description]');
                </script>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="cost">Стоимость</label>
            </td>
            <td>
                <div class="input-prepend">
                    <span class="add-on">руб.</span>
                    <input type="text" class="input-mini" id="cost" name="Service[cost]" placeholder="cost" value="<?php echo htmlspecialchars($this->service->cost)?>">
                </div>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="rating">Рейтинг</label>
            </td>
            <td>
                <div class="input-append">
                    <input type="text" class="input-mini" id="rating" name="Service[rating]" placeholder="rating" value="<?php echo htmlspecialchars($this->service->rating)?>">
                    <span class="add-on">.00</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>