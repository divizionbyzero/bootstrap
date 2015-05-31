<?php

function CheckAuthentication()
{
    /*if(Yii::app()->user->IsGuest()) return false;
    return true;*/
    return true;
}

$config['LicenseName'] = '';
$config['LicenseKey'] = '';






$baseUrl = '/public/uploads/page/';


$baseDir = resolveUrl($baseUrl);




$config['Thumbnails'] = Array(
		'url' => $baseUrl . 'ck/thumb',
		'directory' => $baseDir . 'ck/thumb',
		'enabled' => true,
		'directAccess' => false,
		'maxWidth' => 100,
		'maxHeight' => 100,
		'bmpSupported' => false,
		'quality' => 80);


$config['Images'] = Array(
		'maxWidth' => 1600,
		'maxHeight' => 1200,
		'quality' => 80);


$config['RoleSessionVar'] = 'CKFinder_UserRole';



$config['AccessControl'][] = Array(
		'role' => '*',
		'resourceType' => '*',
		'folder' => '/',

		'folderView' => true,
		'folderCreate' => true,
		'folderRename' => true,
		'folderDelete' => true,

		'fileView' => true,
		'fileUpload' => true,
		'fileRename' => true,
		'fileDelete' => true);




$config['DefaultResourceTypes'] = '';

$config['ResourceType'][] = Array(
		'name' => 'Files',
        'url' => $baseUrl . 'ck/files',
		'directory' => $baseDir . 'ck/files',
		'maxSize' => 0,
		'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
		'deniedExtensions' => '');

$config['ResourceType'][] = Array(
		'name' => 'Images',
		'url' => $baseUrl . 'ck/images',
		'directory' => $baseDir . 'ck/images',
		'maxSize' => "16M",
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,avi,iso,mp3',
		'deniedExtensions' => '');

$config['ResourceType'][] = Array(
		'name' => 'Flash',
		'url' => $baseUrl . 'ck/flash',
		'directory' => $baseDir . 'ck/flash',
		'maxSize' => 0,
		'allowedExtensions' => 'swf,flv',
		'deniedExtensions' => '');


$config['CheckDoubleExtension'] = true;


$config['FilesystemEncoding'] = 'UTF-8';


$config['SecureImageUploads'] = true;


$config['CheckSizeAfterScaling'] = true;


$config['HtmlExtensions'] = array('html', 'htm', 'xml', 'js');


$config['HideFolders'] = Array(".svn", "CVS");


$config['HideFiles'] = Array(".*");


$config['ChmodFiles'] = 0777 ;


$config['ChmodFolders'] = 0755 ;


$config['ForceAscii'] = false;


include_once "plugins/imageresize/plugin.php";
include_once "plugins/fileeditor/plugin.php";

$config['plugin_imageresize']['smallThumb'] = '90x90';
$config['plugin_imageresize']['mediumThumb'] = '120x120';
$config['plugin_imageresize']['largeThumb'] = '180x180';
