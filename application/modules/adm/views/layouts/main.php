<?php $bodyID = 'content';
require_once $this->module->basePath . '/views/layouts/interface/top.php'; ?>
    <div class="container-fluid">
        <div class="row-fluid head-block">
            <div class="span2 left-column">
                <a target="_blank" id="logo" href="<?php echo Yii::app()->homeUrl; ?>">
                    <img src="<?php echo Yii::app()->baseUrl.'/'.$this->logo() ?>">
                </a>
            </div>
            <div class="span10 right-column">
                <div class="row-fluid">
                    <div class="span12">
                        <?php require_once $this->module->basePath . '/views/layouts/interface/navbar.php'; ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <?php require_once $this->module->basePath . '/views/layouts/interface/breadcrumbs.php'; ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <?php require_once $this->module->basePath . '/views/layouts/interface/btn-group.php'; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid content-block">
            <div class="span2 left-column sidebar">
                <?php require_once $this->module->basePath . '/views/layouts/interface/main-menu.php'; ?>
            </div>
            <div class="span10 right-column">
                <div class="row-fluid parts-container">
                    <div class="span12">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once $this->module->basePath . '/views/layouts/interface/bottom.php'; ?>