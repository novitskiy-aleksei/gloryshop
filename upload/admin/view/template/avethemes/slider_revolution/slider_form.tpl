<?php 
  echo $header; 
  echo $column_left; 
?>
<div id="content">

	<div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
		<div class="container-fluid">
			<div class="pull-right">
<a id="button-apply" onclick="applySlide();" class="btn btn-primary btn-sm"><span><i class="fa fa-save"></i> <?php echo $text_apply;?></span></a>
<a id="button-submit" onclick="$('#form-slider').submit();" class="btn btn-success btn-sm"><span><i class="fa fa-save"></i> <?php echo $button_save; ?></span></a>
<a href="<?php echo $cancel; ?>" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div id="page-content" class="container-fluid">
    	<div class="message"></div>
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <span class="hidden-xs"><?php echo $heading_title; ?></span></h3>
                <?php if( $primary_id ) { ?> 
										<div class="btn-group pull-right">
					<a class="btn btn-success btn-sm modalbox" data-size="modal-fw" data-type="iframe" data-title="<?php echo $text_preview;?>" title="<?php echo $text_preview;?>" href="<?php echo  $preview; ?>"><?php echo $text_preview;?></a>
					<a class="btn btn-primary btn-sm" href="<?php echo  $manager_layer;?>" id="preview-sliders"><?php echo $text_manager_layer; ?></a>
										</div>  
										<?php } ?>
			</div>
			<div class="panel-body">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-slider">						
						<div class="row">
                        <div class="col-sm-7">                            
        <div class="ds_accordion">
        <h3 class="ds_heading"><?php echo $text_general;?>
										</h3>
        <div class="ds_content">
							<table class="table">
                            <tbody>
								<tr>
									<td>ID: <?php echo $primary_id;?><input type="hidden" name="primary_id" value="<?php echo $primary_id; ?>"></td>
									<td><h4><?php echo $title;?></h4></td>   
								<tr>
									<td><?php echo $text_title;?></td>
									<td><input class="form-control" type="text" name="title" value="<?php echo $title;?>"/></td>
								</tr>
								<tr>
									<td><?php echo $text_delay;?></td>
									<td><input class="form-control" type="text" name="configs[delay]" value="<?php echo $configs['delay'];?>"/></td>
								</tr>
								<tr>
									<td><?php echo $text_fullwidth;?></td>
									<td>
										<select class="form-control" name="configs[fullwidth]">
										<?php foreach( $fullwidth as $key => $value ) { ?>
										<option value="<?php echo $key;?>" <?php if( isset($configs['fullwidth']) && ($key == $configs['fullwidth']) ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
										<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td><?php echo $text_slide_dimension;?></td>
									<td>
                                    <div class="row">
                                    <div class="col-sm-6">
										<label><?php echo $text_width;?></label>
										<input class="form-control" type="text" name="configs[startwidth]" value="<?php echo $configs['startwidth'];?>"/>
                                        </div>
                                    <div class="col-sm-6">
										<label><?php echo $text_height;?></label>
										<input class="form-control" type="text" name="configs[startheight]" value="<?php echo $configs['startheight'];?>"/>
                                        </div>
                                      </div>
									</td>
								</tr>
								<tr>
									<td><?php echo $text_touchenabled;?></td>
									<td>    
										<select class="form-control" name="configs[touchenabled]">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['touchenabled'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?>
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_onHoverStop;?></td>
									<td>
										<select class="form-control" name="configs[onHoverStop]">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['onHoverStop'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_shuffle;?></td>
									<td>
										<select class="form-control" name="configs[shuffle]">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['shuffle'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_image_cropping;?></td>
									<td>
										<select class="form-control" name="configs[image_cropping]">
										<?php foreach( $yesno as $key => $value ) { ?>
										<option value="<?php echo $key;?>" <?php if( $key == $configs['image_cropping'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
										<?php } ?> 
										</select>   
									</td>
								</tr>
                                <tr>
									<td><?php echo $text_add_css;?></td>
									<td>
										<input class="form-control" type="text" name="configs[custom_css]" value="<?php echo $configs['custom_css'];?>"/>
									</td>
								</tr>
                            </tbody>
							</table> 
</div>
</div>

       
        
</div><!-- //col--> 
<div class="col-sm-5"> <div class="alert alert-info margin-bottom-15"><?php echo $help_config_slideshow;?></div>
        <div class="ds_accordion">
        <h3 class="ds_heading"><?php echo $text_layout_style;?></h3>
        <div class="ds_content">
							<table class="table">
                            <tbody>
								<tr>
									<td><?php echo $text_shadow;?></td>
									<td>
										<select class="form-control" name="configs[shadow]">
											<?php foreach( $shadows as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['shadow'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_hideTimerBar;?></td>
									<td>
										<select class="form-control" name="configs[show_time_line]">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['show_time_line'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_timerBarPosition;?></td>
									<td>
										<select class="form-control" name="configs[time_line_position]">
											<?php foreach( $linepostions as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['time_line_position'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_background;?></td>
									<td>
                                    <input class="form-control colorpicker" type="text" name="configs[background_color]" value="<?php echo $configs['background_color'];?>"/>
                                    
                                    </td>
								</tr>
								<tr>
									<td><?php echo $text_margin;?></td>
									<td><input class="form-control" type="text" name="configs[margin]" value="<?php echo $configs['margin'];?>"/> Example: 5px 0; or 5px 10px 20px</td>
								</tr>
								<tr>
									<td><?php echo $text_padding;?></td>
									<td><input class="form-control" type="text" name="configs[padding]" value="<?php echo $configs['padding'];?>"/> Example: 5px 0; or 5px 10px 20px</td>
								</tr>
								<tr>
									<td><?php echo $text_show_background;?></td>
									<td>
										<select class="form-control" name="configs[background_image]">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['background_image'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_background_url;?></td>
									<td><input class="form-control" type="text" value="<?php echo $configs['background_url'];?>" name="configs[background_url]"/></td>
								</tr>
                            </tbody>
							</table> 
        </div>
		<h3 class="ds_heading"><?php echo $text_navigation_settings;?></h3>
        <div class="ds_content">
							<table class="table">
                            <tbody>
								<tr>
									<td><?php echo $text_navigationType;?></td>
									<td>
										<select class="form-control" name="configs[navigationType]">
											<?php foreach( $navigationTypes as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['navigationType'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											 <?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_navigationArrows;?></td>
									<td>
										<select class="form-control" name="configs[navigationArrows]">
											<?php foreach( $navigation_arrows as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['navigationArrows'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											 <?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_navigationStyle;?></td>
									<td>
										<select class="form-control" name="configs[navigationStyle]">
											<?php foreach( $navigationStyle as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['navigationStyle'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											 <?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_navigationStyle;?></td>
									<td><input class="form-control" type="text" value="<?php echo $configs['navOffsetHorizontal'];?>" name="configs[navOffsetHorizontal]"/></td>
								</tr>
								<tr>
									<td><?php echo $text_navigationOffset;?></td>
									<td><input class="form-control" type="text" value="<?php echo $configs['navOffsetVertical'];?>" name="configs[navOffsetVertical]"/></td>
								</tr>
								<tr>
									<td><?php echo $text_navigationShow;?></td>
									<td>
										<select class="form-control" name="configs[show_navigator]">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $configs['show_navigator'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											 <?php } ?> 
										</select>   
									</td>
								</tr>
								<tr>
									<td><?php echo $text_hideNavDelayOnMobile;?></td>
									<td><input class="form-control" type="text" value="<?php echo $configs['hideThumbs'];?>" name="configs[hideThumbs]"/></td>
								</tr>
                            </tbody>   
							</table> 
        </div>
		<h3 class="ds_heading"><?php echo $text_thumbnail;?></h3>
        <div class="ds_content">
							<table class="table">
                            <tbody>
								<tr>
									<td><?php echo $text_dimension;?></td>
									<td> 
                                    <div class="row">
                                   	 <div class="col-sm-6">
                                   	 <?php echo $text_width;?>
										<input class="form-control" type="text" value="<?php echo $configs['thumbWidth'];?>" name="configs[thumbWidth]"/>
                                        </div>
                                   		 <div class="col-sm-6">
                                        <?php echo $text_height;?>
										<input class="form-control" type="text" value="<?php echo $configs['thumbHeight'];?>" name="configs[thumbHeight]"/>
                                        </div>
                                     </div>
									</td>
								</tr>
								<tr>
									<td><?php echo $text_thumbAmount;?> </td>
									<td>
										<input class="form-control" type="text" value="<?php echo $configs['thumbAmount'];?>" name="configs[thumbAmount]"/>
									</td>
								</tr>
                            </tbody>
							</table> 
        </div>
		<h3 class="ds_heading"><?php echo $text_mobile_visibility;?></h3>
        <div class="ds_content">
							<table class="table">
                                <tbody>
                                    <tr>
                                        <td><?php echo $text_hideThumbsUnderResolution;?></td>
                                        <td><input class="form-control" type="text" value="<?php echo $configs['hide_screen_width'];?>" name="configs[hide_screen_width]"/></td>
                                    </tr>
                                </tbody>
							</table> 
						</div><!-- content-->
						</div><!-- ds_accordion-->
		</div><!-- //col--> 
		</div><!-- //row--> 
						</form><!-- End Form-Module -->
					
			</div>
		</div>
	</div>
</div>
 <script type="text/javascript">	
	function applySlide(){		
			$.ajax({
				url: 'index.php?route=ave/slider_revolution/apply&token=<?php echo $token;?>&primary_id=<?php echo $primary_id;?>',
				type: 'post',
				dataType: 'json',
				data: $('#form-slider input[type=\'text\'], #form-slider input[type=\'hidden\'], #form-slider input[type=\'radio\']:checked, #form-slider input[type=\'checkbox\']:checked, #form-slider select, #form-slider textarea'),
				beforeSend: function() {
					$('#button-apply').attr('disabled', true);
				},
				complete: function() {					
					$('#button-apply').attr('disabled', false);
				},
				success: function(json) {					
					if (json['error']) {
							$('.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
					} 	
					if (json['success']) {
						$('html, body').animate({scrollTop: 140}, 500); 						
						$('.message').html('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
						$('.success').fadeIn('slow');
					}					
					if (json['redirect']) {
						location = json['redirect'];
					}
				}
			});
	}
</script> 
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>