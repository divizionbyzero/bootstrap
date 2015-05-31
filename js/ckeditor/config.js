/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbar = 'Full';
    config.contentsCss = '/js/ckeditor/page.css'
    config.filebrowserBrowseUrl='/js/ckfinder/ckfinder.html';
    config.filebrowserUploadUrl='/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
};

CKEDITOR.config.toolbar_Full =
    [
        { name: 'basicstyles',	items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'styles',		items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'colors',		items : [ 'TextColor','BGColor' ] },
        { name: 'paragraph',	items : ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
        { name: 'links',		items : [ 'Link','Unlink','Image' ] }
    ];

CKEDITOR.config.toolbar_Basic =
    [
        { name: 'basicstyles',	items : [ 'Bold','Italic','Underline'] },
        { name: 'colors',		items : [ 'TextColor'] },
        { name: 'links',		items : [ 'Link','Unlink'] },
        { name: 'paragraph', items : [ 'NumberedList','BulletedList'] }
    ];

CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;