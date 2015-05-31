<?php $this->printTitle(); ?>
<?php $this->printError($this->contact); ?>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="/adm/contact/<?php echo $this->action->id?>/service_id/<?php echo $service_id?>/address_id/<?php echo $address_id?><?php echo $url_attributes?>">
    <table class="table table-striped table-bordered">
        <tr>
            <td class="mini-table-field">
                <label class="control-label">Тип контакта</label>
            </td>
            <td>
                <select name="Contact[contact_type_id]">
                    <option value="">пожалуйста, выберите</option>
                    <?php if(count($contact_types)){
                        foreach($contact_types as $contact_type)
                        {
                            $attr = ($contact_type->contact_type_id == $this->contact->contact_type_id) ? 'selected="selected"' : '';
                            echo '<option '.$attr.' value="'.$contact_type->contact_type_id.'">'.$contact_type->name.'</option>';
                        }
                    }?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="mini-table-field">
                <label class="control-label" for="contact">Контакт</label>
            </td>
            <td>
                <input type="text" id="contact" name="Contact[contact]" placeholder="Контакт" value="<?php echo htmlspecialchars($this->contact->contact)?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
            </td>
        </tr>
    </table>
</form>