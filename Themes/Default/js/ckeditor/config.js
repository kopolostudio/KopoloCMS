/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.language = 'ru';
	config.uiColor = '#F1F1F1';
	config.toolbar = 'KopoloDefaultToolbar';
	
	config.toolbar_KopoloDefaultToolbar =
	[
		['Undo','Redo'],
		['Cut','Copy','Paste','PasteFromWord'], 
		['Bold','Italic','Underline','Strike', '-', 'Format','FontSize','TextColor'],
		['NumberedList','BulletedList'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Image','Table'],
		['Source'],
		['Maximize']
	];
	
	config.toolbar_KopoloExtendedToolbar =
	[
		['Undo','Redo'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'Templates', 'Preview'], 
		['Find','Replace','-','SelectAll','RemoveFormat'],
		['Source'],
		['Link','Unlink','Anchor'],
		['Image','Flash','Table','HorizontalRule','SpecialChar'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['FontSize','Format','Font','Styles'],
		['TextColor','BGColor'], 
		['Maximize']
	];
	
};
