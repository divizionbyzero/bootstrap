<?php
class BackendController extends CController
{
    private $state = array(
        'title' => '',
        'active' => '',
        'breadcrumbs' => array(),
        'buttons' => array()
    );

    private $config = array();

    public function init()
    {
        $this->active($this->id);
        $this->config = require(Yii::getPathOfAlias('application.config.back-end') . '.php');
        parent::init();
    }

    public function active($active_flag = null)
    {
        if ($active_flag) {
            $this->state['active'] = $active_flag;
        }

        return $this->state['active'] ? $this->state['active'] : false;
    }

    public function menu()
    {
        return $this->config['menu'] ? $this->config['menu'] : false;
    }

    public function breadcrumbs($breadcrumbs = null)
    {
        if ($breadcrumbs && is_array($breadcrumbs)) {
            foreach ($breadcrumbs as $title => $url) {
                $this->state['breadcrumbs'][$title] = $url;
            }
        }
        return $this->state['breadcrumbs'] ? $this->state['breadcrumbs'] : false;
    }

    public function title($title = null)
    {
        if ($title) {
            $this->state['title'] = $title;
        }
        return $this->state['title'] ? $this->state['title'] : false;
    }

    public function buttons($buttons = null)
    {
        if ($buttons && is_array($buttons)) {
            foreach ($buttons as $title => $url) {
                $this->state['buttons'][$title] = $url;
            }
        }
        return $this->state['buttons'] ? $this->state['buttons'] : false;
    }

    public function logo()
    {
        return $this->config['logo'] ? $this->config['logo'] : false;
    }

    public function printError($model)
    {
        if ($model instanceof CModel) {
            if (count($errors = $model->getErrors())) {
                echo '<div class="alert alert-error">';
                foreach ($errors as $field => $error) {
                    echo $error[0] . '<br/>';
                }
                echo '</div>';
            }
        }
    }

    public function printTitle()
    {
        echo $this->title() ? '<div class="alert alert-info">' . $this->title() . '</div>' : '';
    }

    public function ShowImage($model, $fileName, $path)
    {
        if ($model->$fileName) {
            echo '<tr>
                <td>
                    <label class="control-label" for="Note">Существующий файл</label>
                </td>
                <td>
                    <img style="max-height: 200px; max-width: 200px;" src="' . Yii::app()->baseUrl . '/' . $path . '/' . $model->$fileName . '" class="img-polaroid">
                </td>
            </tr>';
        }
    }

    public function checkCompare($model_name, $condition, $params, $message_name)
    {
        if (!$model_name::model()->exists($condition, $params))
            throw new CHttpException(404, 'запрошенный(я) ' . $message_name . ' не найден(а)');
    }
}