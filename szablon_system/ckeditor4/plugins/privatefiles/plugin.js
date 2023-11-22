(function()
{
	pluginName = 'privatefiles';

	var privatefilesDialog = function(editor)
	{
		return {
			title : editor.lang.privateFiles,
			minWidth : 300,
			minHeight : 80,
			onOk: function(){
				var href = new String(this.getValueOf( 'tab1', 'input1' ));		
				var name;

				if ( this._.selectedElement )
				{
					name = this._.selectedElement.getHtml();
				}
				else
				{
					name = new String(this.getValueOf( 'tab1', 'input2' ));
					name = CKEDITOR.tools.htmlEncode(name);
				}
				if (name.length == 0) {
					name = href;
				}
				if (name.length > 0 && href.length > 0) {
					editor.insertHtml('<a href=\x22'+href+'\x22>' + name + '</a>');
					return true;
				}
				return false;
			},
			onLoad: function(){},
			onShow: function(){
				var selection = new String(editor.getSelection().getNative());
				if(selection.length > 0) {
					this.setValueOf( 'tab1', 'input2', selection );
				}
				var element= this.getParentEditor().getSelection().getSelectedElement();
				if (element.is( 'a' ) && element.hasAttribute( 'href' ) )
					this.setValueOf( 'tab1', 'input1', element.getAttribute( 'href' ) );
			},
			onHide: function(){},
			onCancel: function(){},
			resizable: 'none',
			contents : [
				{
					id : 'tab1',
					label : 'First Tab',
					title : 'First Tab',
					elements :
					[
						{
							id : 'input2',
							type : 'text',
							label : editor.lang.common.name,
						},
						{
							id : 'input1',
							type : 'text',
							label : editor.lang.common.url,
						},
						{
							type : 'button',
							id : 'browse',
							label : editor.lang.common.browseServer,
							filebrowser :
							{
								action : 'Browse',
								url : editor.config.filebrowserPrivateFilesUrl,
								target : 'tab1:input1'
							}
						}
					]
				}
			]
		}
	}
	
	CKEDITOR.dialog.add(pluginName, function(editor) {
		return privatefilesDialog(editor);
	});

	CKEDITOR.plugins.add(pluginName,
	{
		init:function(editor)
		{
			/*editor.addCommand(pluginName, privateFilesCommand);*/
			//CKEDITOR.dialog.add(pluginName, this.path + 'pfdialog.js');
			editor.addCommand(pluginName, new CKEDITOR.dialogCommand(pluginName));

			editor.ui.addButton('PrivateFiles',
			{
				label: editor.lang.privateFiles,
				icon: this.path + 'lock.png',
				command: pluginName
			});
/*
			if ( editor.addMenuItems )
			{
				editor.addMenuItems(
				{
					privatefiles :
					{
						label : editor.lang.privateFiles,
						command : 'privatefiles',
						group : 'link'
					}
				});
			}

			// If the "contextmenu" plugin is loaded, register the listeners.
			if ( editor.contextMenu )
			{
				editor.contextMenu.addListener( function( element, selection )
				{
					if ( !element )
						return null;

					if ( !( element = CKEDITOR.plugins.link.getSelectedLink( editor ) ) )
						return null;

					isPrivate = (element.getAttribute('href').indexOf('/_private/') == 0);

					return isPrivate ? { privatefiles : CKEDITOR.TRISTATE_OFF } : { privatefiles : CKEDITOR.TRISTATE_OFF };
				});
			}
*/
		}
	});

})();
