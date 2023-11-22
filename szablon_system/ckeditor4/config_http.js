/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar_Http =
		[
			['Bold','Italic','Underline','Strike','Subscript','Superscript'],
			['NumberedList','BulletedList','Blockquote'],
			['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			['Maximize']
		];
	config.toolbar = 'Http';
	config.contentsCss = '/_szablon/iqcms.css';
	config.entities_latin = false;
	config.disableNativeSpellChecker = false;
	config.forcePasteAsPlainText = true;
};
