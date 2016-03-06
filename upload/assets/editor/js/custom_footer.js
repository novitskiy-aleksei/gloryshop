/**
 * Re-define COnsoleLog
 */
if(typeof(console)=='undefined' || console==null) { console={}; console.log=function(){}}


var LG_DataRow = function () {
    this.index   =  0;
    this.clss   = '';
}

var LG_DataCol = function () {
    this.index = 0;
    this.clss   = '';
    this.inrow = 0;
    this.col_lg = 4;
    this.col_md = 4;
    this.col_sm = 6;
    this.col_xs = 12; 
	     
}
var LG_DataWidget = function () {
    this.wtype = '';
    this.wkey ='';
    this.name = '';
         
}

var CustomLayout = function () {	
		/*
		 * default configuration
		 */
		var config = {
			gutter	   :   30,
			coldwith   :   60,
			defaultcol :   3,
			col 	   :   12,
			confirmdel :   'Are you sure to delete?'
		};

		/**
		 * store wrapper layout editor.
		 */
		var $layout_element = null;

		var $screenmode = 'large-screen';
		
		var $colkey = 'col_lg';

		/** 
		 * caculate total layout width based on column's width and gutter + number of columns 
		 */
		var layoutwidth = config.coldwith*config.col + ((config.col-1)*config.gutter);
	 	
	
    return {
			
	  	/**
	  	 * add new column element and append it before suggest column.
	  	 * 
	  	 * return Object col: jquery object of that column
	  	 */	
	  	 addColumn:function( scol, row ){
	  		$( ".lg-col", $layout_element ).removeClass( "active" );	
	  		var col = $( '<div class="active lg-col drop-col">\n\
							<span class="label label-info">1</span>\n\
                            <div class="inner clearfix"><div class="tool-delete tool-icon btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></div>\n\
                            <div class="tool-addrow tool-icon btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Add row"><i class="fa fa-plus"></i></div>\n\
                            <div class="tool-addwidget tool-icon btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Add Widget"><i class="fa fa-puzzle-piece"></i></div>\n\
                            <div class="tool-content"></div></div></div>' );
	  		col.width( config.coldwith*3+2*config.gutter 	);
	  		col.insertBefore( scol );
	  		col.data( "colcfg", new LG_DataCol() );

	  		CustomLayout.bindingColEventS( col , row );	
	  		return col;
	  	},

	  	/* binding events for column */
	  	bindingColEventS:function ( col, row ){
	  		var maxWidth = layoutwidth; 
	  		col.resizable({
			    stop: function(event, ui) {
				 	setTimeout( function(){
				 		var cnum =  Math.floor(config.col*col.width()/row.width())+1;
				 		maxWidth = row.width();
				 		if( cnum > 12 ){
				 			cnum = 12;
				 		}
						CustomLayout.updateColsWidth(col,cnum);
						CustomLayout.recalculateCols();
						 
					 }, 200 );	
		 	
			    },
			     handles: 'e',
			     //maxWidth:maxWidth+config.gutter,
			     minWidth:config.coldwith
			}); 
	  		col.click( function(event) {
  				$( ".drop-col", $layout_element ).removeClass( "active" );	
	  			col.addClass( 'active' );
	  		     event.stopPropagation();
	  		} );
			$( ".tool-delete" ,col).click( function(){
				if( confirm(config.confirmdel) ){
					col.remove();  
		 			CustomLayout.recalculateAllColsWidth(row);
					CustomLayout.initTooltip();
		 		}
			} );
			$( ".tool-addwidget", col ).click( function(){
				CustomLayout.showWigetsList( col );
			} );

			// bind sortable event to re-sort widgets inside.
			$( ".tool-content", col ).sortable({
				connectWith: ".drop-col .tool-content",
				 placeholder: "ui-state-highlight-widget",
				 over:function(event, ui ){   ui.item.width(ui.placeholder.width() ) }
			}); 

			$( '.tool-addrow', col ).click( function(){
				CustomLayout.addRow( col.children( '.inner' ), true ); 
			} );
			 $(".btn-remove",col).click( function(){
	            	 $(this).parent().parent().remove();
					 CustomLayout.initTooltip();
	        });
	
	  	},
		showWigetsList:function ( col ){
 			$("#modallistmodules").modal('show');
 			$(".ds_content .module-block").unbind( 'click');
 			$(".ds_content .module-block").bind( 'click', function(){
 				var mod = $(this).clone();
 				$(".tool-content",col).append( mod );
 				$("#modallistmodules").modal('hide');
				CustomLayout.handleEdit(col);
				CustomLayout.handleDelete(col);
				CustomLayout.initTooltip();
 			} );
 		},
 		handleDelete: function(col){
			 $(".btn-remove",col).click( function(){
				if( confirm(config.confirmdel) ){
	            	 $(this).parent().parent().remove();
					 CustomLayout.initTooltip();
				}
	        });	
		},
 		handleEdit: function(col){
			 $(".btn-edit",col).click( function(){
				$('#modal-editmodule').remove();
				var data_href = $(this).attr('data-href');
				var button = '<button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
				var html  = '<iframe id="ifmeditmodule" src="'+data_href+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe>';
				var content ='<div class="modal-dialog"><div class="modal-content"><div class="modal-header">'+button+'</div><div class="modal-body">'+html+'</div></div></div>';
				$('body').append('<div id="modal-editmodule" class="modal">' + content + '</div>');
			
				var iframe = $('#ifmeditmodule');
				iframe.load( function(){
					$('#modal-editmodule').modal('show');
					var current_url = document.getElementById("ifmeditmodule").contentWindow.location.href;
					iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
					iframe.contents().find('#content').css({ padding: '10px 0 0 0',margin: '0 0 0 0'});
					if (current_url.indexOf('extension/module') > -1) {
						$('#modal-editmodule').modal('hide');               
					}
				});
			});
			
		},
		editWidget:function( widget ){
 			$('#modal-editmodule').remove();
 			var button = '<button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
 			var html  = '<iframe id="ifmeditmodule" src="'+$(widget).data('href')+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe>';
 			var content ='<div class="modal-dialog modal-fw"><div class="modal-content"><div class="modal-header">Module Manager '+button+'</div><div class="modal-body">'+html+'</div></div></div>';
 			$('body').append('<div id="modal-editmodule" class="modal">' + content + '</div>');
 		
 			 var iframe = $('#ifmeditmodule');
 			iframe.load( function(){
		 		$('#modal-editmodule').modal('show');
            	var current_url = document.getElementById("ifmeditmodule").contentWindow.location.href;
                iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
                iframe.contents().find('#content').css({ padding: '10px 0 0 0',margin: '0 0 0 0'});
				if (current_url.indexOf('extension/module') > -1) {
					$('#modal-editmodule').modal('hide');               
				}
 			});
 		},
 		deleteWidget:function( widget ){
 			if( confirm("Are you sure to delete?") ){
 				$(widget).parent().parent().remove();
 			}
 			
 		},
 		getWidgetKey: function(){
 			var d = new Date();
			 return d.getTime();
 		},
	  	createModuleWidget:function( col, widget ){  
	  		if( $("#modallistmodules [data-code=\'"+widget.module+"\']") ){
	  			var mod = $("#modallistmodules [data-code=\'"+widget.module+"\']").clone();
	  			
	  			$(".btn-edit",mod).click( function(){
	  				CustomLayout.editWidget( this );
	  			} );
 
            
	            $(".btn-remove",mod).click( function(){
	            	 CustomLayout.deleteWidget( this );
					 CustomLayout.initTooltip();
	            });
	  			$('.tool-content',col).append( mod );
	  		}
	  	},

	  	/* recaculate all column width */
	  	 recalculateAllColsWidth:function( row ){
			 console.log('recalculateAllColsWidth');
			var childnum = $(row).children('.inner').children( ".drop-col" ).length;
			var dcol = Math.floor( 12/childnum );
			var a = 12%childnum;
			if(childnum>=4){
				$(row).addClass('maxcol');
			}else{
				$(row).removeClass('maxcol');
			}
			var screenmod = $('#screen-mod').attr('class');		  
			CustomLayout.removeEachClassPrefix(row,screenmod);
			
				$(row).children('.inner').children( ".drop-col" ).each( function(i, col ) {
					if( a > 0 && (i == childnum-1) ){
						dcol = dcol+a;
					}
					CustomLayout.updateAllColsWidth( this, dcol, screenmod );
				});
		 
		},
		 updateAllColsWidth:function(col, dcol, screenmod){  
			$(col).addClass(screenmod+dcol).css('width','');  
			$(col).find('span.label').html(dcol);
 			var data =  $(col).data('colcfg');
			data[$colkey] = dcol;
			$(col).data('colcfg',data );
		},
	  	/* recaculate column width */
	  	 recalculateColsWidth:function( row ){
			var childnum = $(row).children('.inner').children( ".drop-col" ).length;
			var dcol = Math.floor( 12/childnum );
			var a = 12%childnum;
			if(childnum>=4){
				$(row).addClass('maxcol');
			}else{
				$(row).removeClass('maxcol');
			}
				$(row).children('.inner').children( ".drop-col" ).each( function(i, col ) {
					if( a > 0 && (i == childnum-1) ){
						dcol = dcol+a;
					}
					CustomLayout.updateColsWidth( this, dcol );
				});
		 
		},
		 updateColsWidth:function(col, dcol ){  
			var screenmod = $('#screen-mod').attr('class');					
	     	//$(col).css( {'width':dcol/config.col*100 +'%'} );  
			CustomLayout.removeClassPrefix(col,screenmod);
			$(col).addClass(screenmod+dcol).css('width','');  
			$(col).find('span.label').html(dcol);
 			var data =  $(col).data('colcfg');
			data[$colkey] = dcol;
			$(col).data('colcfg',data );
		},
	  	/**
	  	 * add new row element and append it before suggest row.
	  	 * 
	  	 * return Object col: jquery object of that column
	  	 */	
	  	 addRow:function( srow, sub ){

	  		var row = $( '<div class="drop-row lg-row"><div class="tool-tool"><div class="tool-sortable btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Sort"><i class="fa fa-arrows"></i></div></div><div class="inner clearfix"></div></div>' );
	  		var edit = $('<div class="tool-edit btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-cog"></i></div>');
	  		//var copy = $('<div class="tool-copy  btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-copy"></i></div>');
	  		var del = $('<div class="tool-delete  btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></div>');
	  		
	  		$(row).children(".tool-tool").append(del).append(edit);	//.append(copy)
	  		
	  		CustomLayout.bindingRowEvents( row , srow, sub );
	  		
			//row.insertBefore( srow );
			if( sub !=null && sub== true ){
				srow.append( row );	
				srow.addClass('hd-widgets-func');
				CustomLayout.addSuggestColumn( row );
				row.addClass( 'active' );
			}else {
				$layout_element.children('.inner').append( row );	
				CustomLayout.addSuggestColumn( row );
				$layout_element.children('.inner').children( ".drop-row").removeClass( "active" );	
				row.addClass( 'active' );
			}
		
		
			row.data( "rowcfg", new LG_DataRow() );

			return row;
	  	},

	  	/* clone data from orginal for new 
	  	 cloneData:function(data, target ){
			for( var k in target ){   
			 	target[k] = data[k];
			}
	  		return target;
	  	},*/

  		/* ROW PROCESS: add and create a setting form */	
	  	bindingRowEvents:function ( row , srow ){
	  		$(".tool-tool .tool-delete", row).click( function(){
	  			if( confirm(config.confirmdel) ){
	  				if( row.parent().children('.drop-row').length<= 1 ){
	  					row.parent().removeClass('hd-widgets-func');
	  				}
	  				row.remove();
		 			CustomLayout.recalculateColsWidth( row );
					CustomLayout.initTooltip();
	  			}
	  		} );
/*
	  		$(".tool-copy", row).click( function( event ){
	  			CustomLayout.cloneLayoutInRow( row, srow );
	  		} );*/ 
			// set default values or element'data 
	  		$( ".tool-edit", row ).click( function(event){ 
	  			$(".form-control", "#row-builder").val('');
	  			var cfg = row.data("rowcfg") ; 

	  			$('input, textarea, select', '#row-builder').each(function() {
	  				$(this).val('');
	  				
	  				var k = $(this).attr('name');
	  				$("[name="+k+"]", "#row-builder").attr( "value", cfg[k] ); 
	  				$("[name="+k+"]", "#row-builder").val( cfg[k] ); 

	  				if( k.indexOf('color') != -1 ){
	  					if( cfg[k] ){ 
	  						$("[name="+k+"]", "#row-builder").css({'background-color':cfg[k]}); 
	  					}else{
	  						$("[name="+k+"]", "#row-builder").css({'background-color':'#FFFFFF'}); 	
	  					}
	  				}	

	  				if( k.indexOf('image') != -1 ){
	  					var a = $("[name="+k+"]", "#row-builder").val();
	  					if( a ){
	  						var parent = $("[name="+k+"]", "#row-builder").parent();
	  						$('img', parent).attr( 'src', $("[name="+k+"]", "#row-builder").data('base')+a );
	  					}else {  
	  						var parent = $("[name="+k+"]", "#row-builder").parent();
	  						$('img', parent).attr( 'src', $('img', parent).attr('data-placeholder') );
	  					}
	  				}
	  			}); 
	   
	  			var pos = $( row ).offset(); 
	  			var l = pos.left;
	  			var ll = $(this).offset().left;
  				$( "#row-builder" ).modal( 'show' );

  				$(".drop-row.active").removeClass( 'active' );
  				$(row).addClass( 'active' );
				 event.stopPropagation();
	  		} );
			
	  		row.delegate( ".add-col", "click", function(){ 
	  			CustomLayout.addColumn( $(this), row );
	  		 	CustomLayout.recalculateAllColsWidth( row ); 
				CustomLayout.customFooterDraggable();
	  		} );	
	  		 
	  		// bind sortable for this to sort columns on current row and other rows.	
		 	$( row ).children('.inner').sortable({
				connectWith: ".drop-row > .inner", 
				placeholder: "ui-state-highlightcol",
	 			update:function( event, ui ){  
	 			
	 			},
	 			
	 			remove:function(){  
	 			 	var trow = $(this).parent();
 			   		 CustomLayout.recalculateColsWidth( trow );
	 			},
	 			start:function( event, ui ){
	 		 		$( '.ui-state-highlightcol', row ).width( $(ui.item).width() );
	 			},
	 			receive: function( event, ui ) {
	 			   	 var trow = $(this).parent();
 			   		 CustomLayout.recalculateColsWidth( trow );
	 			},
	 			cancel: ".tool-sortable, .add-col"
			});	 
		 	 		
	  	},
		/*
		 cloneLayoutInRow:function( row, sub, incol ){
			
			var cr = CustomLayout.addRow( sub==true?incol.children( '.inner' ):$(".add-row",$layout_element), sub );
			cr.data( 'rowcfg', CustomLayout.cloneData(row.data( 'rowcfg'),new LG_DataRow()) );
		 
			$(row).children('.inner').children( ".lg-col" ).each( function(){	
				var cc = CustomLayout.addColumn( $(cr).children('.inner').children(".drop-row.active .add-col"), cr );
				 
  				 $(this).children('.inner').children('.tool-content').children( '.add-mod' ).each( function(){   
  				 	var rwd   = CustomLayout.cloneData( $(this).data('wgcfg'), new LG_DataWidget() );  
		  			rwd.wkey  = CustomLayout.getWidgetKey();
  				 	CustomLayout.cloneFormData( cwkey, $(this).data('wgcfg').wkey );	

  				} );
  		 		var rcd = $(this).data('colcfg'); 
  				cc.data( 'colcfg', CustomLayout.cloneData(rcd,new LG_DataCol()) );
  				
  				$(cc).css( {'width':(rcd.col_lg/config.col*100)+'%'} );  
  				if( $(this).children('.inner').children( '.drop-row' ).length > 0 ){  

	  				$(this).children('.inner').children( '.drop-row' ).each( function(){   
	  					CustomLayout.cloneLayoutInRow( $(this), true, cc );
	  				});
  				}

			} );
	 	},*/ 

  		/**
	  	 * add suggest row using to click to this for adding new real row
	  	 */
	  	 addSuggestRow:function(){
	  		var srow = $('.add-row');
	  		srow.click( function(){
	  			CustomLayout.addRow(this); 				
	  		});
	  	},

	  	/**
	  	 * add suggest column using to click to this for adding new real row
	  	 */
	  	 addSuggestColumn:function( row ){
	  		var scol = $(  '<div class="add-col btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Add Column"><i class="fa fa-sign-in"></i></div>' );
	  		$(row).children(".inner").append( scol );	
	  	 
	  	},


	  	/**
	  	 * binding some delegate events
	  	 */
	  	 bindDelegateEvents:function(){
 			$( ".popover" ).each( function(){
 				var pop = this;
 				$( '.popover-title',this ).click( function(){
 					$(pop).hide();	
 				});
 			});
 			$(".button-alignments button").click( function (){
 				$screenmode = $(this).data('option');
 				$(".button-alignments button").removeClass('active');
 				$(this).addClass( 'active' );
 				var screensize = $(this).data('size');
 				$("#screen-mod").attr('class',screensize);
 				CustomLayout.updateColWidthByScreen();

 			} );
	  	},

	  	 updateColWidthByScreen:function(){
	  	
	  		switch( $screenmode ){
	  			case 'medium-screen':
	  				$colkey = 'col_md';
	  				break;
	  			case 'tablet-screen':
	  				$colkey = 'col_sm';
	  				break;
	  			case 'mobile-screen':
	  				$colkey = 'col_xs';
	  				break;
	  			default: 
	  				$colkey = 'col_lg';	
	  		}

	  		$(".drop-row",$layout_element).each( function(){
	 			var _row = $(this);
	 			$( '.drop-col', _row ).each( function(){
	 				var rcd = $(this).data('colcfg');  
						var screenmod = $('#screen-mod').attr('class');		
						CustomLayout.removeClassPrefix(this,screenmod);
						$(this).addClass(screenmod+rcd[$colkey]).css('width','');  
						$(this).find('span.label').html(rcd[$colkey]);
			
	 				//$(this).css( {'width':rcd[$colkey]/config.col*100+'%'} );  
	 			});
		 	});		
	  	},
	 	
	 	/**
	 	 * add event triggers to operator in form of selected column and selected row 
	 	 */
	 	 triggerFormsEvent:function(){
	 		/* ROW SETTING HANDLER */
	 		$("#row-builder form").submit( function(){ 
	 			if( $(".drop-row.active") ){
	 				var cfg = $(".drop-row.active").data( 'rowcfg' );
	 				for( var k in cfg ){
	 					if( k == 'bgimage' ){
	 						var a = $('[name="bgimage"]').attr('value');
	 						if( a != "" ){
	 							cfg[k] = a;
	 						}else {
	 							cfg[k] = $("[name="+k+"]", "#row-builder").val(  ); 
	 						}
	 					}else {
	  						cfg[k] = $("[name="+k+"]", "#row-builder").val(  ); 
	  					}
	  				}
	 				//console.log( $("#row-builder form").serialize() );
	  				$(".drop-row.active").data('rowcfg' ,cfg);
	 			}  

	 			$( "#row-builder" ).modal('hide');

	 			return false;
	 		} );

	 	},
	 	/**
	 	 * build layout having rows, columns and widgets.
	 	 */
	 	 renderLayoutInRow:function( rows, widgetids, sub, incol ){
					var screenmod = $('#screen-mod').attr('class');
	 		$(rows).each( function() {
	  			// add row here
	  			var row = CustomLayout.addRow( sub==true?incol.children( '.inner' ):$(".add-row",$layout_element), sub );
	  			$( this.cols ).each( function(){ 

	  				var col = CustomLayout.addColumn( $(row).children('.inner').children(".drop-row.active .add-col"), row, sub );

	  				$( this.widgets ).each( function(){   
	  				 	CustomLayout.createModuleWidget( col, this );
	  				} );
	  				
	  				this.widgets = null;
	  				col.data( 'colcfg', this );
					//add by Y
					var screenmod = $('#screen-mod').attr('class');		
					CustomLayout.removeClassPrefix(col,screenmod);
					$(col).addClass(screenmod+this.col_lg).css('width','');  
					$(col).find('span.label').html(this.col_lg);
	  			   // $(col).css( {'width':(this.col_lg/config.col*100)+'%'} );  
  					if( this.rows.length > 0 ){
	  					 CustomLayout.renderLayoutInRow( this.rows, widgetids, true, col ); 
	  				}
	  				this.rows = null;
	  			} );

	  			this.cols = null;
	  			row.data( 'rowcfg', this );
  			} );
  			return true;
	 	},

	 	/**
	 	 *
	 	 *
	 	 */
	 	 buildLayoutByJson:function( json ) {
			//console.log(json);  
	 		var widgetids = new Array(); 
	 		if( json ) {
		  		var rows = $.parseJSON( json  );
	  			CustomLayout.renderLayoutInRow( rows , widgetids, false );
		  	}	 
		  	$layout_element.fadeIn( 600 );	
		   	
		   	$($layout_element).children(".inner" ).sortable({
				connectWith: ".footer-builder",
				placeholder: "ui-state-highlight",
				handle:'.tool-sortable' 
			});	

		   	$($layout_element).children(".inner" ).sortable({
				connectWith: ".footer-builder",
				placeholder: "ui-state-highlight",
				handle:'.tool-sortable',
				cancel:'.tool-icon, .tool-content' 
			});	
	 	},
		initTooltip:function(){
			$('.tooltip').remove();
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		},
		recalculateCols:function (){
				$(".drop-row" ).each( function(index, elem ) {
					var childnum = $(elem).children('.inner').children( ".drop-col" ).length;
					if(childnum>=4){
						$(elem).addClass('maxcol');
					}else{
						$(elem).removeClass('maxcol');
					}
				});
		},
		removeClassPrefix:function (elem,prefix) {
			if(elem.length){
				elem.each(function(i, el) {
					var classes = el.className.split(" ").filter(function(c) {
						return c.lastIndexOf(prefix, 0) !== 0;
					});
					el.className = $.trim(classes.join(" "));
				});
				return this;
			}
		},
		removeEachClassPrefix:function (elem,prefix) {
			if(elem.length){
				elem.find('.lg-col').each(function(i, el) {
					var classes = el.className.split(" ").filter(function(c) {
						return c.lastIndexOf(prefix, 0) !== 0;
					});
					el.className = $.trim(classes.join(" "));
				});
				return this;
			}
		},
		customFooterDraggable:function () {		
			//console.log('customFooterDraggable');	
					$(".drag_area .module-block").draggable({
						appendTo: document.body,
						helper: "clone",
						cursor: "move",
						zIndex: 9999,
						cancel: '.btn-remove, .btn-edit',
						stop: function( event, ui ) {},
						distance: 2,
						cursorAt: {
							left: 10,
							top: 10
						}
					});
					 $(".tool-content").droppable({
						activeClass: "activeDroppable",
						hoverClass: "hoverDroppable",
						tolerance: "pointer",
						forceHelperSize: false,
						forcePlaceholderSize: false,
						accept: ".module-block",
						cancel: '.btn-remove, .btn-edit',
						drop: function(event, ui) {
							var html = $(ui.draggable).clone();
							$(".footer-builder").find(ui.draggable).remove();
							
							$(this).append(html);
							$(".ui-sortable-helper").css({'position':'relative','left':'auto','top':'auto','width':'auto','height':'auto'});
					
						}
					}).disableSelection();
		},
		getLayoutData:function ( container ){
					var output = new Array();	
					$( container ).children('.inner ').children(".drop-row").each( function(){
				 
						var _row = $(this);
						var data = _row.data('rowcfg');
						data.cols = new Array();
						$(_row).children('.inner').children( '.drop-col' ).each( function(){
							var _col = $(this).data('colcfg');
							_col.widgets = new Array();
		
							$(this).children('.inner').children('.tool-content ').children( '.add-mod' ).each( function() {  
								var wd = new Object();
								wd.name = $(this).data('name');
								wd.module = $(this).data('code');
								wd.tyle = $(this).data('type');
								_col.widgets.push( wd );
							} ); 
							_col.rows = new Array();
							if( $(this).children('.inner').children( '.drop-row' ).length > 0 ){
								_col.rows = CustomLayout.getLayoutData( this );
							}
							data.cols.push( _col );
						} );
						output.push( data );  
					} );
					return output;	
		},
		
		/**
		 * add event triggers to operator in form of selected column and selected row 
		 */
		triggerSaveForm:function (){
			$( "#formcustomfooter" ).submit( function(){
				
				$(".footer-builder-wrapper").each( function(){
					var output = CustomLayout.getLayoutData($(this).find(".footer-builder") );
					var j = JSON.stringify(output );  
					$(".hidden-content-layout",this).html( j );
				});
				//console.log('saveform');
				return true; 
			});
		},
        init: function (layout_element) {
			$layout_element = $(layout_element);
			/**
			 *  preload widgets using for layout edtior and add some elements as suggest row to click add to new row.
			 */				
	  		$layout_element.append('<div class="inner"></div>');
	  		//$layout_element.width( layoutwidth );
	  		CustomLayout.addSuggestRow();
			var datajson = $(".hidden-content-layout").val();
			CustomLayout.buildLayoutByJson(datajson);
			/* add some global delegate events */
			CustomLayout.bindDelegateEvents();
			/* add event triggers to operator in form of selected column and selected row */
			CustomLayout.triggerFormsEvent();
			CustomLayout.initTooltip();
			CustomLayout.recalculateCols();
			CustomLayout.customFooterDraggable();
			CustomLayout.triggerSaveForm();
        }

    };//return
}();