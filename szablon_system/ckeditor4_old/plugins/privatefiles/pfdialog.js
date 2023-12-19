( function(){

	var exampleDialog = function(editor){

		return {
			title : editor.lang.privateFiles,
			minWidth : 300,
			minHeight : 80,
			onOk: function(){
				var href = new String(this.getValueOf( 'tab1', 'input1' ));
				var name = new String(this.getValueOf( 'tab1', 'input2' ));			
				if(name.length == 0) {
					name = href;
				}
				if(name.length > 0 && href.length > 0) {
					editor.insertHtml('<a href=\x22'+href+'\x22>'+CKEDITOR.tools.htmlEncode(name)+'</a>');
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
							//hidden : 'true',
							//filebrowser : 'tab1:input1',
							onClick: function(){
								function addQueryString( url, params )
								{
									var queryString = [];
									if ( !params ) return url;
									else { for ( var i in params ) queryString.push( i + "=" + encodeURIComponent( params[ i ] ) ); }
									return url + ( ( url.indexOf( "?" ) != -1 ) ? "&" : "?" ) + queryString.join( "&" );
								}				

								if (editor.config.filebrowserPrivateFilesUrl)
								{			
									var params = {};
									params.CKEditor = editor.name;
									params.CKEditorFuncNum = editor._.filebrowserFn;
									var url = addQueryString(editor.config.filebrowserPrivateFilesUrl, params);
									var width = editor.config.filebrowserWindowWidth || '80%';
									var height = editor.config.filebrowserWindowHeight || '70%';
									editor.popup( url, width, height );
								}
							},
							label : editor.lang.common.browseServer,
						}
					]
				}
			]
		}
	}
	
	CKEDITOR.dialog.add('privatefiles', function(editor) {
		return exampleDialog(editor);
	});
		
})();
