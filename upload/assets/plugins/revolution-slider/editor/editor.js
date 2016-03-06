/**
 * Slider Editor
 *
 * @copyright Commercial License By PavoThemes.Com 
 * @email pavothemes@gmail.com
 * @visit http://www.pavothemes.com
 */

(function( $ ) {
 
	$.fn.revoSliderEditor = function( initvar ) {

 		/**
 		 * Variables.
 		 */
 		this.data = null; 
 		this.currentLayer = null;
 	 	this.stoolbar = $( "#slider-toolbar .editor-toolbar" );
		this.seditor  = $( "#slider-toolbar .slider-editor" );
		this.ilayers  = $( "#slider-toolbar .layer-collection" );
		this.lform    = $("#layer-form");
		this.siteURL  = null;
		this.adminURL = null;
		this.countItem = 0;
		this.delayTime = 9000;
		this.state = false;
		/**
		 * Create List Layers By JSON Data.
		 */
		this.createList = function( JSLIST  ){

 			 var list  = jQuery.parseJSON( JSLIST );
 			 var $this = this;
			 var $stoolbar = $( "#slider-toolbar .editor-toolbar" );	
			 var layer = '';
			 if( list ) {
	 			 $.each( list, function(i, jslayer ){
	 			 	var type = list[i]['layer_type']?'add-'+list[i]['layer_type']:'add-text';

			 		layer = $this.createLayer( type, list[i] , list[i]['layer_id'] );

			 		$this.countItem++;
	 			 });
 			}
 		}

 		/**
 		 * Crete A Layer By Type with Default data or specified data.
 		 */
 		this.createLayer = function( type, data, slayerID ){
			var $this=this;
 			var layer = $('<div class="draggable-item tp-caption"><div class="caption-layer"></div></div>');
	 		layer.attr('id','slayerID'+ slayerID ); 
	 		var ilayer = $('<div class="layer-index"></div>').attr("id","i-"+layer.attr("id"));
	 		ilayer.append('<div class="slider-wrap"><div class="t-start">0ms</div><div class="t-end">'+$this.delayTime+'ms</div><div class="slider-timing" id="islider'+slayerID+'"></div></div><div class="clearfix"></div>');
	 		ilayer.append('<span class="i-no">'+($(".draggable-item",$this.seditor).length+1)+'</span>');
	 		ilayer.append('<span class="layer-index-caption"></span>');
	 		ilayer.append('<div class="input-time"><input type="text" id="input-islider'+slayerID+'" name="layer_time['+slayerID+']" size="3" value="400"/></div>');
	 		ilayer.append('<span class="status">show</span>');

	 		switch( type ){
	 			case 'add-text':  
	 				$this.addLayerText( layer , ilayer,  "Html Caption Here " + slayerID );
	 				break;
	 			case 'add-video': 
	 				$this.addLayerVideo( layer , ilayer, "Here is Video "+ slayerID  );
	 				break;
	 			case 'add-image': 
	 				$this.addLayerImage(layer , ilayer,  "Image Title Here " + slayerID );
	 				break;	
	 			
	 		}
	 	 
 	
	 		$("#layer_id").val( slayerID );
	 		
	 		// create slider timing 
	 		$('#islider'+slayerID).slider( { max:$this.delayTime,
	 										 value:(400*$this.countItem),	
	 										 slide:function(event, ui ){
	 										 	$('#input-islider'+slayerID).val( ui.value );	
	 										 }
	 									} ); 
	 		$('#input-islider'+slayerID).val( 400*$this.countItem );	
 			// auto set current active.
 			
	 		$this.setCurrentLayerActive( layer );	
	 		//auto bind the drag and drap for this 
	 		$(layer).draggable({ containment: "#slider-toolbar .slider-editor",
	 							 drag:function(){
	 							 	$this.setCurrentLayerActive( layer );
	 							 	$this.updatePosition( layer.css('left'), layer.css("top") );
	 							 },
	 							 create:function(){
	 							 	$this.createDefaultLayerData( layer, data );
	 							 }
	 		});

	 	
			// bind current layer be actived when this selected. 	    
	 	    layer.click( function() { 
	 			$this.setCurrentLayerActive( layer );	 
	 		});
	 		$("#i-"+layer.attr("id") ).click( function(){
	 		  if( $this.currentLayer != null ){
	 		  	$this.storeCurrentLayerData();
	 		  }
	 		  $this.setCurrentLayerActive(layer); 
	 		} );


	 		/// insert typo

	 		
	 		return layer;
 		};

 		
 		/**
 		 * Process All First Handler.
  		 */
		this.process = function( siteURL , adminURL, delayTime ) {
		
			this.siteURL =  siteURL;
			this.adminURL = adminURL;
			this.delayTime = delayTime;
			var $this=this;

			$( ".btn-layer-create", $this.stoolbar ).click( function(){  
				 
				var layer = $this.createLayer( $(this).attr("data-action"), null, ++$this.countItem );
				if( $(this).attr("data-action") == 'add-image'){

					$this.showDialogImage(  'img-'+layer.attr('id') );
				}
				if( $(this).attr("data-action") == 'add-video'){
					$this.showDialogVideo();
				}
		 		return false;
			} );
			
			$(".btn-delete").click( function(){
				$this.deleteCurrentLayer();
			} );
			
			/////////// FORM SETTING ///////////
			// auto save when any change of element form.
			$('input, select ,textarea', '#slider_form').change( function(){  
				if( $(this).attr('name') =='data-y' || $(this).attr('name') == 'data-x') {  
					$this.currentLayer.css( { top:$('[name="data-y"]','#slider_form').val()+"px",			
					 						  left:$('[name="data-x"]','#slider_form').val()+"px"				
					 						});	
				}
				$this.state=true;
				$this.storeCurrentLayerData();  
				
			});
			// auto fill text for name or any.
			$('#input-slider-caption', '#slider_form').keypress( function(){  
				 
				 	
				 setTimeout(function ()
				 { 
				    $(".caption-layer",$this.currentLayer).html( $('#input-slider-caption', '#slider_form').val()  );
				 	$('.layer-index-caption',"#i-"+$this.currentLayer.attr("id") ).text( $(".caption-layer",$this.currentLayer).text() );	
				 }, 6);
				$this.state = true;
			});

	
			/**** GLOBAL PROCESS ****/
		    $(".draggable-item", this.seditor).draggable({ containment: "#slider-toolbar .slider-editor" });
		    $(".layer-collection").sortable({ accept:"div",
		    								  update:function() {   
		    								  		var j = 1;
		    								  		$(".layer-index",$this.ilayers).each( function(i, e){ 
		    								  			$(".i-no",e).html( (j++) ) ;
		    								  		//	$("#"+e.replace("i-","").css('z-index',j));
		    								  		});		
		     							      } 
		    });
		  	$this.ilayers.delegate('.status','click', function(){
		     	$(this).toggleClass('in-active');  
		     	$('#'+($(this).parent('.layer-index').attr("id").replace("i-","") ) ).toggleClass("in-active");	
		    } );
			
	 		$this.seditor.delegate('.btn-typo','click', function(){				
				$this.insertTypo(); 
		    });
	 		// change image 

 			$this.seditor.delegate('.btn-change-img','click', function(){
	     		$this.showDialogImage(  'img-'+$this.currentLayer.attr('id') );	
		    } );
		    $this.seditor.delegate('.btn-change-video','click', function(){
	     		$this.showDialogVideo	(   );	
		    } );

		    $("#dialog-video .layer-find-video").click( function (){
		    	if( $("#dialog_video_id").val() ){
		    		$this.videoDialogProcess( $("#dialog_video_id").val() );	
		    	}
		    	else {  
					$("#video-preview").html('<div class="error">Could not find any thing</div>');
				}
		    	
			});
			$("#apply_this_video").click( function(){   
 				$("#video-"+ $this.currentLayer.attr('id') ).html('<img  width="'+$('[name="layer_video_width"]','#slider_form').val()+'"  height="'+$('[name="layer_video_height"]','#slider_form').val()+'" src="'+$("#layer_video_thumb").val()+'"/>') 	;
 				$("#dialog-video").modal('hide');
 				 
 				$this.storeCurrentLayerData();
 			} );


			// BUTTON CLICK
 			$(".btn-typo").on('click', function(){ 
 				$this.insertTypo();
 			});

 			$("#btn-preview-slider").on('click', function(){
 				$this.preview();
 			});


 			/** SUBMIT FORM **/
 		 	this.submitForm();
		};

		this.submitForm = function(){
			var $this = this;
			$("#slider_form").submit( function(){
					 var data =[];
					 var i = 0;
					 var group_setting = 'id='+$("#layer_group_id").val()+"&"+$("#slider_editor_form").serialize()+"&";

					 var times = '';
					 $( "#slider-toolbar .slider-editor .draggable-item" ).each( function(){
			 			var param = '';
			 			$.each( $(this).data("data-form"), function(_,e ) {
								if( $(this).attr('name').indexOf('layer_time') ==-1 ){
									if( e.name == 'layer_caption'){
										 e.value = e.value.replace(/\&/,'_ASM_');
										 e.value = e.value.replace(/\'/,'_apos_');
									}  
 									param += 'layers['+i+']['+e.name+']='+e.value+'&';
								}
			 			}  );
			 			group_setting += 	param+"&";
					 	i++
					 } );
					 $(".input-time input", $("#slider_form") ).each( function(i,e){
					 	group_setting +=$(e).attr('name')+"="+$(e).val()+"&";
					 	 
					 } ); 

					 $.ajax( {url:$("#slider_form").attr('action'),  dataType:"JSON",type: "POST", 'data':group_setting}  ).done( function(output){
				 		  if( output.error == 1 ){
				 		  	$("#slider-warning").html('<div class="warning">'+output.message+'</div>');
				 		  }else {
				  	  	 location.reload();
				 		  }
					 } );
					return false; 
			}  );
		};

 		this.getFormsData=function(){

 			 var data =[];
			 var i = 0;
			 var group_setting = 'id='+$("#layer_group_id").val()+"&"+$("#slider_editor_form").serialize()+"&";
			 var times = '';
			 var objects = new Object();
			 objects.layers = new Object();
			 $( "#slider-toolbar .slider-editor .draggable-item" ).each( function(){
			 	var iobject = new Object();
	 			$.each( $(this).data("data-form"), function(_,e ) {
					if( $(this).attr('name').indexOf('layer_time') ==-1 ){
						iobject[e.name] = e.value;
					}
	 			}  );  

	 			iobject.data_start = $( "#input-islider"+iobject.layer_id ).val();

	 			objects.layers[i] = iobject; i++;
			 } );

		 	objects.group_setting = new Object();
		 	objects.primary_id = $('[name="primary_id"]',"#slider_editor_form").val();
		 	objects.title = $('[name="slider_title"]',"#slider_editor_form").val();
		 	objects.status = $('[name="slider_status"]',"#slider_editor_form").val();
		 	objects.image = $('[name="slider_image"]',"#slider_editor_form").val();
		 	$.each( $("#slider_editor_form").serializeArray(), function(_,e ) {
		 		objects.group_setting[e.name] = e.value;
		 	});	

		 	//	objects.group_setting
			objects.times = new Object();

		 	return ( JSON.stringify(objects) );
 		}

		this.preview=function(){
			var group_setting = this.getFormsData();
			$('#modal-preview').remove();					
			$.ajax({
				url: 'index.php?route=ave/slider_revolution/previewLayer&token=' + getURLVar('token'),
				type: "POST",
				data: { slider_preview_data: group_setting },
				dataType: 'html',
				success: function(data) {
					html  = '<div id="modal-preview" class="modal-box modal fade">';
					html += '  <div class="modal-dialog modal-fw">';
					html += '    <div class="modal-content">';
					html += '      <div class="modal-header">'; 
					html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
					html += '        <h4 class="modal-title">Preview Manager</h4>';
					html += '      </div>';
					html += '      <div class="modal-body modal-html">'+data+'</div>';	
					html += '    </div';
					html += '  </div>';
					html += '</div>';	
					$('body').append(html);	
					$('#modal-preview').modal('show');
				}
			});
		};

		// 2. Fix Bug Cho Nay
		this.insertTypo=function(){
			var $this = this;
			var field = 'input-layer-class'; 
			var layer_id = 'slayerID' + $('#layer_id').val();
			var class_layer = $("#"+field).val();

			$('#modal-typo').remove();
			$.ajax({
				url: 'index.php?route=ave/slider_revolution/typo&token=' + getURLVar('token'),
				dataType: 'html',
				success: function(html_data) {
					html  = '<div id="modal-typo" class="modal-box modal fade">';
					html += '  <div class="modal-dialog modal-fw">';
					html += '    <div class="modal-content">';
					html += '      <div class="modal-header">'; 
					html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
					html += '        <h4 class="modal-title">Typography</h4>';
					html += '      </div>';
					html += '      <div class="modal-body modal-html">'+html_data+'</div>';	
					html += '    </div';
					html += '  </div>';
					html += '</div>';	
					$('body').append(html);
					$('#modal-typo').modal('show');
				}
			});
								
					$(document).on('click', '.tp-typo',function() {	
						var new_class = $(this).attr("data-class");
						if(class_layer.length){
							$('#'+layer_id).removeClass(class_layer);
						}
						if(new_class.length){
							//console.log(new_class);
							$('#'+layer_id).addClass(new_class);
						}
						$('#'+field).val(new_class);
						if( $("#"+field).val()) { 
							$this.currentLayer.removeClass(class_layer).addClass(new_class);	
							$this.storeCurrentLayerData(); 
						}
						$('#modal-typo').modal('hide');
					});

			return false;
 		}

 		/**
 		 *
 		 */
 		this.showDialogVideo=function(){
			$("#dialog-video").modal('show');
			this.videoDialogProcess('');
		}	
 		this.videoDialogProcess=function( videoID ){
 			var $this = this;
 			 
			var error = false;
			 
			if( videoID !="" ) {
 				
 				if( $("#layer_video_type").val() == 'vimeo') {
					$.getJSON('http://www.vimeo.com/api/v2/video/' + videoID + '.json?callback=?', {format: "json"}, function(data) {
					
						$this.showVideoPreview( data[0].title, data[0].description, data[0].thumbnail_large );
					});
				}else {
					$.getJSON('http://gdata.youtube.com/feeds/api/videos/'+videoID+'?v=2&alt=jsonc',function(data,status,xhr){ 
				 		$this.showVideoPreview( data.data.title, data.data.description, data.data.thumbnail.hqDefault )
					});
				}
			}
 		};

 		this.showVideoPreview=function( title, description, image ){
			
		 	if( title ){
		 		var html = '';
				html += '<div class="video-title">'+title+'</div>';	
			 	html += '<img src="'+image+'">';
			 	html += '<div class="video-description">'+description+'</div>';	
			 	$("#layer_video_thumb").val(image);	
		 		$("#video-preview").html( html );
		 		$("#apply_this_video").show();
		 	}else {
		 		$("#video-preview").html('<div class="error">Could not find any thing</div>');
		 	}
 		}
 		/**
 		 * Set Current Layer is Actived And Show Form Setting For It.
 		 */
 		this.setCurrentLayerActive = function ( layer ){
			$(".draggable-item", this.seditor).removeClass("layer-active");
	 		$( layer ).addClass("layer-active");
	 	 	
	 	 	$(".layer-index",this.layers).removeClass("layer-active");
	 	 	$("#i-"+layer.attr("id") ).addClass("layer-active");

	 	 	this.currentLayer = layer;

	 	 	this.showLayerForm( layer );	
		};	 	

		/**
		 * Add Layer Having Type Text
		 */
		this.addLayerText=function( layer, ilayer , caption ){  
			layer.addClass('layer-text');
			$(".caption-layer",layer ).html( caption ).after('<a class="btn-typo" title="Change Typography">Change Typography</a>');
			this.seditor.append( layer );
			$("#layer_type").val('text');
			this.ilayers.append( ilayer );
			$(".layer-index-caption", ilayer).html( caption );
		};

		/**
		 * Add Layer Having Type Video: Support YouTuBe And Vimeo.
		 */
		this.addLayerVideo = function( layer, ilayer , caption ){
			layer.addClass('layer-content');
			$(".caption-layer",layer ).html( caption );
			this.seditor.append( layer );

			this.ilayers.append( ilayer ); $(".layer-index-caption", ilayer).html( caption );
			
			$("#layer_type").val('video');
			layer.append('<div class="layer_video" id="'+'video-'+layer.attr('id')+'"><div class="content-sample"></div></div><div class="btn-change-video">Chang Video</div>');

		};

		/**
		 * Add Layer Having Type Image.
		 */
		this.addLayerImage=function( layer, ilayer , caption ){
			layer.addClass('layer-content');
			$(".caption-layer",layer ).html( caption );
			layer.append('<div class="layer_image" id="'+'img-'+layer.attr('id')+'"><div class="content-sample"></div></div><div class="btn-change-img">Chang Image</div>');

			this.seditor.append( layer );
			this.ilayers.append( ilayer ); $(".layer-index-caption", ilayer).html( caption );
			
			$("#layer_type").val('image');
			$("#layer_content").val('');
			// show input form
		
		};

	
		this.showDialogImage=function(thumb ){
			var $this = this;
			var field = 'layer_content';
			var filemanager_path = 'index.php?route=ave/image_manager_plus/filemanager&token=' + getURLVar('token') + '&field=' + field + '&previewsrc=' + thumb;
			$('#modal-image-editor').remove();
			var fhtml  = '<div id="modal-image-editor" class="modal-box modal fade">';
			fhtml += '  <div class="modal-dialog modal-lg">';
			fhtml += '    <div class="modal-content">';
			fhtml += '      <div class="modal-header">'; 
			fhtml += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			fhtml += '        <h4 class="modal-title">Filemanager</h4>';
			fhtml += '      </div>';
			fhtml += '      <div class="modal-body modal-iframe"><iframe id="modal-iframe" frameborder="0" src="'+filemanager_path+'"></iframe></div>';	
			fhtml += '    </div';
			fhtml += '  </div>';
			fhtml += '</div>';	
			$('body').append(fhtml);
			$('#modal-image-editor').modal('show');
			 $(document).on('hidden.bs.modal', function(event) {				 				 
					if ($('#' + field).attr('value')) {	
						$this.storeCurrentLayerData();
					}
			 });
		}
		/**
		 * Delete Current Layer: Remove HTML and Data. Hidden Form When Delete All Layers.
		 */
		this.deleteCurrentLayer=function(){
			var $this = this;

			if( $this.currentLayer ){
				$( "#i-"+$this.currentLayer.attr("id") ).remove();
				$this.currentLayer.remove();	
				$this.currentLayer.data( "data-form", null );
				$this.currentLayer = null;
		//		if( $(".draggable-item",$this.seditor).length <= 0 ) {
					$this.lform.hide();
					$('#dialog').remove();
					$('#dialog-video').modal('hide');
		//		}
			}else {
				alert( "Please click  one to delete" );
			}
		};

		/**
		 * Set Default Value For Data Element Form Of Layer With Default Setting Or Sepecified Data.
		 */
		this.createDefaultLayerData = function( layer, data ){
	 		var $this = this;	
	 		if( data !=null && data ) { 
		 		$.each( data , function(key, valu){	
		 			if( key!= 'layer_layer_group_id') {  
		 			 	if( key=='layer_caption'){
		 			 		valu = valu.replace( /_ASM_/,'&');
		 			 		valu = valu.replace( /_apos_/,'\'');
		 			 	}
	 					$('[name="'+key+'"]','#slider_form').val(  valu );
	 				}
	 				
	 				if( key =='data-y') {  
						$this.currentLayer.css('top', valu+'px');	
					}
					if( key == 'data-x'){
						$this.currentLayer.css('left', valu+'px');		
					}
			 	} ); 

		 		if(  data['layer_type'] == 'image'){
					var thumb = 'img-'+$this.currentLayer.attr('id');
					var src = $this.siteURL+"image/"+data['layer_content'];
					$('#' + thumb).replaceWith('<img src="' + src + '" alt="" id="' + thumb + '" />');
					// this.siteURL 	
				}
				if(  data['layer_type'] == 'video'){
					var thumb = 'video-'+$this.currentLayer.attr('id');
					var src = data['layer_video_thumb'];
					$(".content-sample",$this.currentLayer).html('<img height="'+data['layer_video_height']+'" width="'+data['layer_video_width']+'" src="'+src+'"/>');
					// this.siteURL 	
				}
				if(  data['layer_type'] == 'text'){
					 $this.currentLayer.addClass(  data['class-layer'] );
				}
				data['layer_caption'] = data['layer_caption'].replace(/_ASM_/,'&');
				data['layer_caption'] = data['layer_caption'].replace(/_apos_/,'\'');
			 
				 $(".caption-layer",$this.currentLayer).html( data['layer_caption'] );
				  $(".layer-index-caption", '#i-slayerID'+data['layer_id']).text( $(".caption-layer",$this.currentLayer).text()  );

				 $('[name="layer_time['+data['layer_id']+']"]','#slider_form').val(data['data-start'] );
	 			 $("#islider"+data['layer_id']).slider('value', data['data-start'] );

			 	//$this.currentLayer = layer;
	 		}else {

				$('[name="layer_caption"]','#slider_form').val($(".caption-layer",layer).html() );
				$('[name="class-layer"]','#slider_form').val('');
				$('[name="data-x"]','#slider_form').val(0);
				$('[name="data-y"]','#slider_form').val(0);
				$('[name="data-speed"]','#slider_form').val(350);
				$('[name="data-end"]','#slider_form').val(0);
				$('[name="data-endspeed"]','#slider_form').val(300);
				//$('[name="class-endanimation"]','#slider_form').val('');
				//$('[name="data-endeasing"]','#slider_form').val('');
				$('[name="style"]','#slider_form').val('');
				$('[name="data-customin"]','#slider_form').val('');
				$('[name="data-customout"]','#slider_form').val('');
				$('[name="layer_content"]','#slider_form').val('no_image.png');
		 	}
		 	this.storeCurrentLayerData();
		  
		};

		/**
		 * Update Position In Element Form Of Current When Draping.
		 */
		this.updatePosition = function( left, top ){
			 $('[name="data-y"]','#slider_form').val( parseInt(top) );
			 $('[name="data-x"]','#slider_form').val( parseInt(left) );

			this.storeCurrentLayerData();
		};

		/**
		 * Show Layer Form When A Layer Is Actived.
		 */
		this.showLayerForm = function( layer ){
		 	 // restore data form for
		 	 var $currentLayer = this.currentLayer;

			 if( $currentLayer.data("data-form") ){ 
			 	$.each( $currentLayer.data("data-form"), function(_, kv) {
			 		if( $(this).attr('name').indexOf('layer_time') ==-1 ){
						$('[name="'+kv.name+'"]','#slider_form').val( kv.value );

					}
				} ); 
			 }
			 $("#layer-form").show();
			//$('.chosen-select').chosen({height:"120px",width:"100%"});	
		};

		/**
		 * Set Current Layer Data.
		 */
	 	this.storeCurrentLayerData=function(){

	 		 this.state = false; 
	 		 this.currentLayer.data( "data-form", $('#slider_form').serializeArray() );
	 	};

		//THIS IS VERY IMPORTANT TO KEEP AT THE END
		return this;
	};
 
})( jQuery );
/***/
