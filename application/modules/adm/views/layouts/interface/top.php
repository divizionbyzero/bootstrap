<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo Yii::app()->baseUrl ?>/img/favicon.ico" type="image/x-icon">

    <link href="<?php echo Yii::app()->baseUrl ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl ?>/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl ?>/css/admin.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl ?>/js/ckeditor/ckeditor.js"></script>

    <title><?php echo $this->title().' - '.Yii::app()->name; ?></title>

</head>
<body <?php echo $bodyID ? 'id="'.$bodyID.'"' : '';?>>