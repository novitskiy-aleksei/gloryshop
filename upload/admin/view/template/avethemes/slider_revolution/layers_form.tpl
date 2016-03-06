<?php 
  echo $header; 
  echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
      			<a class="btn btn-primary btn-sm" href="<?php echo  $objurl->link('ave/slider_revolution/update', 'primary_id='.$primary_id.'&token=' . $objsession->data['token'], 'SSL');?>" data-size="modal-fw" data-type="iframe" data-title="<?php echo $text_preview;?>" title="<?php echo $text_preview;?>"><?php echo $text_main_slideshow;?></a>
      			<a class="btn btn-success btn-sm modalbox" href="<?php echo  $objurl->link('ave/slider_revolution/preview', 'primary_id='.$primary_id.'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL');?>" data-size="modal-fw" data-type="iframe" data-title="<?php echo $text_preview;?>" title="<?php echo $text_preview;?>"><?php echo $text_preview_slideshow;?></a>
      			<a class="btn btn-danger btn-sm" href="<?php echo $cancel; ?>"><?php echo $button_cancel; ?></a>
			</div>
			<h1><?php echo $heading_title;?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- End div#page-header -->

	<div id="page-content" class="container-fluid">
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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $slider_info['title'];?></h3>
				
			</div>
			<div class="panel-body">
                <div class="pull-right margin-bottom-10">
                     <button type="submit" form="slider_form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>  <?php echo $button_save; ?></button>
                     
		    		<a class="btn btn-sm btn-primary" href="<?php echo  $objurl->link('ave/slider_revolution/layer', 'primary_id='.$primary_id.'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL')?>"><i class="fa fa-plus"></i> <?php echo $text_create_new_group;?></a>
					<a href="" class="btn btn-sm btn-danger" data-toggle="clone"><i class="fa fa-file-text-o"></i> Clone Data</a>
				</div>
				<ul id="languagetabs" class="nav nav-tabs">
					<?php foreach ($languages as $language) {?>
					<li class="<?php echo $language['class']; ?>">
						<a href="<?php echo $language['href']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/> &nbsp;<?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
	    	 	<div>
					<p class="clearfix"><?php echo $text_drag_to_sort;?></p>
	    	 	</div>
	    		<div class="layers-group clearfix">
                
    <?php if(!empty($layers_group))  { ?>
        <?php foreach( $layers_group as $layer_group )  { ?>
            <div class="slider-item <?php echo ( $layer_group['layer_group_id'] == $layer_group_id ? 'active':'');?>" id="slider_<?php echo $layer_group['layer_group_id'];?>">
            <a class="image" href="<?php echo  $layer_group['edit'];?>" style="background:url('<?php echo $layer_group["image"];?>') center top no-repeat; height:100px;"></a>
            <a class="slider-clone" href="<?php echo $layer_group['clone'];?>"  title="<?php echo $text_clone_this;?>"><span><?php echo $text_copy;?></span></a>
            <a class="slider-delete" href="<?php echo $layer_group['delete'];?>" onclick="return confirm('<?php echo $text_confirm_delete;?>')"  title="<?php echo $text_delete;?>"><span><?php echo $text_delete;?></span></a>
                <div><?php echo $layer_group['title']; ?></div>
            </div>	
        <?php } ?>
    <?php } ?>
	    		</div>

	    		<!-- Form Edit Info Slider Layer -->
	    		<?php if( $layer_group_id )  { ?> 
	    		<h3><?php echo $text_edit_slider;?> <span><?php echo $slider_title;?></span></h3>
	    		<?php  } else { ?>
	    			<h3><?php echo $text_new_group;?></h3>
	    		<?php } ?>
				<form action="" method="post" id="slider_editor_form">
					<div id="slider-warning" class=""></div>
					<input type="hidden" id="primary_id" name="primary_id" value="<?php echo $primary_id;?>"/>
						<div class="table-responsive">
							 <table class="table table-bordered table-hover">
								<tr>
									<td> <?php echo $text_general;?> </td>
									<td>
                                     <div class="row">
                                        <div class="col-sm-4">
											<label><?php echo $text_title;?></label>
                                    <input class="form-control" type="text" name="slider_title" size="100" value="<?php echo $slider_title;?>">
                                    <input name="slider_language_id" type="hidden" value="<?php echo $lang; ?>"/>
                                        </div> 
                                        
                                        <div class="col-sm-4">
											<label><?php echo $text_status;?></label>
										<select class="form-control" name="slider_status">
											<?php foreach( $edisa as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $group_setting['slider_status'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?>
										</select>	
                                        </div>
                                        <div class="col-sm-4">
											<label><?php echo $text_delay;?></label>
                                            <input class="form-control" type="text" name="data-delay" value="<?php echo $group_setting['data-delay'];?>">
                                        </div>
                                      </div><!--//row --> 
                                    
								
                                    </td>
								</tr>
                                <tr>
									<td><?php echo $text_image;?></td>
									<td>
                                      <div class="row">
                                      <div class="col-sm-2">
											<label><?php echo $text_thumbnail;?></label>
                                            <div class="image">
                                                <a onclick="image_upload('data-thumb','thumb-img') " id="thumb-img" class="img-thumbnail">
                                                    <img src="<?php echo empty($data_thumb)?$placeholder:$data_thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                                                </a>
                                                <input type="hidden" name="data-thumb" id="data-thumb" value="<?php echo $group_setting['data-thumb'];?>"/>				
                                            </div>
                                        </div> 
                                        <div class="col-sm-2">
											<label><?php echo $text_kena;?></label>
                                            <select class="form-control" name="dataimg-kenburns">
											<?php foreach( $onoff as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $group_setting['dataimg-kenburns'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option><?php } ?>
										</select>	
                                        </div> 
                                        <div class="col-sm-2">
											<label><?php echo $text_bgposition;?></label>
                         <input class="form-control" type="text" name="dataimg-bgposition" value="<?php echo $group_setting['dataimg-bgposition'];?>">	
                                        </div>
                                        <div class="col-sm-2">
											<label><?php echo $text_bgposition_en;?></label>
                         <input class="form-control" type="text" name="dataimg-bgpositionend" value="<?php echo $group_setting['dataimg-bgpositionend'];?>">	
                                        </div>
                                        <div class="col-sm-2">
											<label><?php echo $text_bgfit;?></label>
                         <input class="form-control" type="text" name="dataimg-bgfit" value="<?php echo $group_setting['dataimg-bgfit'];?>">	
                                        </div>
                                         <div class="col-sm-2">
											<label><?php echo $text_bgfitend;?></label>
                         <input class="form-control" type="text" name="dataimg-bgfitend" value="<?php echo $group_setting['dataimg-bgfitend'];?>">	
                                        </div>
                                      </div><!--//row --> 
									</td>
								</tr>
                                
								<tr>
									<td><?php echo $text_effect;?></td>
									<td>
                                      <div class="row">
                                        <div class="col-sm-4">
											<label><?php echo $text_slot_amount;?></label>
                                            <input class="form-control" type="text" name="data-slotamount" value="<?php echo $group_setting['data-slotamount'];?>">
                                        </div> 
                                        <div class="col-sm-2">
											<label><?php echo $text_easing;?></label>
        <select class="form-control with-nav" name="dataimg-ease" id="dataimg-ease"> 
            <?php foreach ($easings as $easing){ ?>
                    <option value="<?php echo $easing['value'];?>" <?php if( $easing['value'] == $group_setting['dataimg-ease'] ){ ?> selected="selected" <?php } ?>><?php echo $easing['label'];?></option>
             <?php } ?>
        </select>
                                            </div>
                                        <div class="col-sm-2">
											<label><?php echo $text_transition;?></label>
										<select class="form-control with-nav" name="data-transition" id="data-transition">
											<?php foreach( $transtions as $transtion) { ?>
											<option value="<?php echo $transtion['value'];?>" <?php if( $transtion['value'] == $group_setting['data-transition'] ){ ?> selected="selected" <?php } ?>><?php echo $transtion['label']; ?></option>
											<?php } ?>
										</select>	
                                        </div>
                                        <div class="col-sm-2">
											<label><?php echo $textTransitionRotation;?></label>
                                           <input class="form-control" type="text" name="slider_rotation" value="<?php echo $group_setting['slider_rotation'];?>">
                                        </div>
                                        <div class="col-sm-2">
											<label><?php echo $textTransitionDuration;?></label>
                                            <input class="form-control" type="text" name="data-masterspeed" value="<?php echo $group_setting['data-masterspeed'];?>" >
                                        </div>
                                      </div><!--//row --> 
									</td>
								</tr>
								<tr>
									<td><?php echo $text_link_enable;?>  </td>
									<td> 
                                      <div class="row">
                                        <div class="col-sm-3">
											<label><?php echo $text_status;?></label>
										<select class="form-control" value="slider_enable_link">
											<?php foreach( $edisa as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $group_setting['slider_enable_link'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?>
										</select>	
                                        </div> 
                                        <div class="col-sm-9">
											<label><?php echo $text_link;?></label>
                                            <input class="form-control" type="text" name="data-link" value="<?php echo $group_setting['data-link'];?>">
                                        </div>
                                      </div><!--//row --> 
									</td>
								</tr>
								<tr>
									<td><?php echo $text_fullscreen_video;?></td>
									<td>
                                      <div class="row">
                                        <div class="col-sm-3">
											<label><?php echo $text_status;?></label>
											<select class="form-control" name="slider_usevideo">
												<?php foreach( $usevideo as $key => $value ) { ?>
												<option value="<?php echo $key;?>" <?php if( $key == $group_setting['slider_usevideo'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
												<?php } ?>
											</select>
                                        </div> 
                                        <div class="col-sm-6">
											<label><?php echo $text_video_id;?></label>
											<input class="form-control" type="text" name="slider_videoid" value="<?php echo $group_setting['slider_videoid'];?>">
                                        </div>
                                        <div class="col-sm-3">
											<label><?php echo $text_autoplay;?></label>
									<select class="form-control" name="slider_videoplay">
										<?php foreach( $yesno as $key => $value ) { ?>
										<option value="<?php echo $key;?>" <?php if( $key == $group_setting['slider_videoplay'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
										<?php } ?>
									</select>	
                                        </div>
                                      </div><!--//row --> 
                                      
                                        
									</td>
								</tr>
							
							</table>	
						</div>
					<input name="layer_group_id" type="hidden" id="layer_group_id" value="<?php echo $layer_group_id;?>" />	
					<input name="slider_image" id="slider-image" type="hidden" value="<?php echo $slider_image;?>">
				</form>
				<div class="clearfix"></div>

				<!-- Layers Editor -->
                
				<h3><?php echo $objlang->get("Layers Editor")?></h3> 
				<div class="layers-wrapper" id="slider-toolbar">
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"  id="slider_form">
	    		<?php if( $layer_group_id )  { ?> 


						<div class="slider-layers" >
						    <div class="slider-editor-wrap" style="width:<?php echo $sliderWidth;?>px;height:<?php echo $sliderHeight;?>px">	
						    	<div class="simage" id="simage"><img id="slider_image_src" src="<?php echo $slider_image_src;?>"></div>
							    <div class="slider-editor" id="slider-editor" style="width:<?php echo $sliderWidth;?>px;height:<?php echo $sliderHeight;?>px"></div>
							</div><!-- End div.slider-editor-wrap -->

                        
						<div class="editor-toolbar well well-sm">
                        	<div class="row">
							<div class="col-sm-7">
                            
                            <a class="btn btn-sm btn-warning" id="btn-update-slider"><i class="fa fa-level-down"></i> <?php echo $text_update_main_image;?></a>
							<a class="btn btn-sm btn-layer-create btn-primary" data-action="add-text"><i class="fa fa-font"></i> <?php echo $text_add_text;?></a>
							<a class="btn btn-sm btn-layer-create btn-primary" data-action="add-image"><i class="fa fa-picture-o"></i> <?php echo $text_add_image;?></a>
							<a class="btn btn-sm btn-layer-create btn-primary" data-action="add-video"><i class="fa fa-film"></i> <?php echo $text_add_video;?></a>
							<a class="btn btn-sm btn-delete btn-danger" data-action="delete-layer"><i class="fa fa-trash-o"></i> <?php echo $text_delete_layer;?></a>
                            </div>
							<div class="col-sm-5">
                            <a class="btn btn-sm btn-primary pull-right" id="btn-preview-slider"><?php echo $text_preview_slider;?></a>
							<a class="btn btn-sm btn-success pull-right" onclick="$('#slider_form').submit();"><?php echo $button_save; ?></a>
							</div>
                            </div>
						</div><!-- End div.editor-toolbar -->
                        
						<div id="dialog-video" class="modal-box modal fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            	<h4 class="modal-title">&nbsp;  </h4>
            </div>
            <div class="modal-body">
    			<div class="container-fluid">
                      <div class="table-responsive">
								<table class="table table-bordered table-hover">
									<tr>
										<td width="200"><?php echo $objlang->get("video_type")?></td>
										<td>
											<select class="form-control" name="layer_video_type" id="layer_video_type">
													<option value="youtube"><?php echo $text_youtube;?></option>
													<option value="vimeo"><?php echo $text_vimeo;?></option>
												</select>	
										</td>
									</tr>
									<tr>
										<td>Video ID</td>
										<td>
                                        <div class="form-group">
                                        <div class="input-group">
                                        <input name="layer_video_id" type="text" id="dialog_video_id" class="form-control">
                                    <div class="input-group-addon input-sm btn-primary blue-bg layer-find-video"><?php echo $text_find_video;?></div>
                                    <div class="input-group-addon input-sm btn-success green-bg layer-apply-video" id="apply_this_video" style="display:none;"><?php echo $text_use_video;?></div>
                                    </div><!--//input-group--> 
                               		 </div>
                                     <p>Example:<br>  Youtube: <b>VA770wpLX-Q</b> and vimeo: <b>9679622</b> </p>
										</td>
									</tr>
									<tr>
										<td colspan="2">
                                         <div class="row">
                                        <div class="col-sm-6">
											<label><?php echo $text_width;?></label>
											<input name="layer_video_width" type="text" value="300" class="form-control">
                                            </div>
                                        <div class="col-sm-6">
											<label><?php echo $text_height;?></label>
											<input name="layer_video_height" type="text" value="200" class="form-control">
                                            </div>
                                         </div>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="hidden" name="layer_video_thumb" id="layer_video_thumb">											
										</td>
									</tr>	
								</table></div><!--//table-responsive --> 
								
								<div id="video-preview" style="text-align:center;"></div>
                                </div><!--//container-fluid --> 
                                    </div><!--//modal-body --> 
        </div><!--//modal-content --> 
      </div><!--//modal-dialog --> 
</div><!--//modal-video --> 

							<div class="slider-foot">
                            	<div class="row">
								<div class="col-sm-5">
									<h4><?php echo $text_layer_collection;?></h4>
									<div class="layer-collection" id="layer-collection"></div>	
								</div>

								<div class="col-sm-7" id="layer-form">
									<h4><?php echo $text_edit_layer_data;?></h4>
									<input type="hidden" id="layer_id" name="layer_id"/>
									<input type="hidden" id="layer_content" name="layer_content"/>
									<input type="hidden" id="layer_type" name="layer_type"/>

									<table class="table table-bordered table-hover">
                                    <tr>
											<td><?php echo $text_position;?></td>
											<td>
                                            
                                         <div class="row">
                                        <div class="col-sm-4">
											<label><?php echo $text_left;?> (data-x)</label>
                                            <input class="form-control" size="3" type="text" name="data-x">
                                            </div>
                                        <div class="col-sm-4">
											<label><?php echo $text_top;?> (data-y)</label>
                                            <input class="form-control" size="3" type="text" name="data-y">
                                            </div>
                                             <div class="col-sm-4">
											<label><?php echo $text_parallaxLevels;?></label>
													<select class="form-control with-nav" name="class-parallax" id="class-parallax">
														 <?php foreach ($parallaxlevels as $level){ ?>
                                                                <option value="<?php echo $level['value'];?>"><?php echo $level['label'];?></option>
                                                           <?php } ?>
													</select>	
                                            </div>
                                            
                                         </div>
                                         
											</td>
										</tr>
										<tr>
											<td width="100"><?php echo $text_style_class;?></td>
											<td style="padding-bottom: 12px;">
												<div class="col-sm-6">
													<input class="form-control" type="text" name="class-layer" id="input-layer-class"/>
												</div>
												<div class="col-sm-6">
													<span class="buttons">
														<a class="btn btn-warning btn-sm" onclick="$('#input-layer-class').val('')"><?php echo $objlang->get("Clear");?></a> |
														<a class="btn btn-success btn-sm btn-typo" id="btn-insert-typo"><?php echo $objlang->get("Insert Typo")?></a>
													</span>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_text;?></td>
											<td>
												<textarea class="form-control" style="width:100%; height:80px;resize:none;" name="layer_caption" id="input-slider-caption" data-for="caption-layer" ></textarea>
												<br/>
												<?php echo $text_alow_html;?>
											</td>
										</tr>
										
										<tr>
											<td><?php echo $text_effect_in;?></td>
											<td>
                                            
                                         <div class="row">
                                        <div class="col-sm-4">
											<label><?php echo $text_speed;?></label>
                                            <input class="form-control" name="data-speed" type="text">
                                            <input class="form-control" type="hidden" name="data-start"> 
                                        </div> <div class="col-sm-4">
											<label><?php echo $text_easing;?> In</label>
													<select class="form-control with-nav" name="data-easing" id="data-easing">
														 <?php foreach ($easings as $easing){ ?>
                                                                <option value="<?php echo $easing['value'];?>"><?php echo $easing['label'];?></option>
                                                           <?php } ?>
													</select>	
                                            </div>
                                        <div class="col-sm-4">
											<label><?php echo $text_animation;?>  In</label>
												<select class="form-control with-nav" name="class-animation" id="class-animation">
                                                 		<?php foreach ($inanimations as $animation){ ?>
                                                                <option value="<?php echo $animation['value'];?>"><?php echo $animation['label'];?></option>
                                                           <?php } ?>
												</select>	
                                            </div>
                                     
                                         </div>
                                         
                                         <br/> 
                                         <div class="row">
                                           
                                        <div class="col-sm-12">
											<label><?php echo $text_customin;?></label>
                                        
												<textarea class="form-control" style="width:100%; height:80px;resize:none;" name="data-customin" id="input-data-customin" data-for="data-customin" ></textarea>
                                         </div>
                                         </div><!--//row --> 
											</td>
										</tr>
                                        
										<tr>
											<td><?php echo $text_effect_out;?></td>
											<td>
                                            
                                         <div class="row">
                                           
                                        <div class="col-sm-2">
											<label><?php echo $text_espeed;?></label>
                                            <input class="form-control" type="text" name="data-endspeed">
                                        </div>
                                        <div class="col-sm-2">
											<label><?php echo $text_end_time;?></label>
                                            <input class="form-control" type="text" name="data-end"> 
                                        </div> 
                                        <div class="col-sm-4">
											<label><?php echo $text_easing;?> Out</label>
                                            <select class="form-control with-nav" name="data-endeasing" id="data-endeasing"> 
													 	<?php foreach ($easings as $easing){ ?>
                                                                <option value="<?php echo $easing['value'];?>"><?php echo $easing['label'];?></option>
                                                         <?php } ?>
													</select>
                                            </div>
                                        <div class="col-sm-4">
											<label><?php echo $text_animation;?> Out</label>
													<select class="form-control with-nav" name="class-endanimation" id="class-endanimation"> 
														<?php foreach ($outanimations as $animation){ ?>
                                                                <option value="<?php echo $animation['value'];?>"><?php echo $animation['label'];?></option>
                                                           <?php } ?>
													</select>
                                            </div>
                                     
                                         </div>
                                         <br/> 
                                         <div class="row">
                                           
                                        <div class="col-sm-12">
											<label><?php echo $text_customout;?></label>
                                         <textarea class="form-control" style="width:100%; height:80px;resize:none;" name="data-customout" id="input-data-customout" data-for="data-customout" ></textarea>
                                         </div>
                                         </div><!--//row --> 
											</td>
										</tr>		
									</table>
                                    
									<div class="other-effect">
										<h5><?php echo $text_other_options;?></h5>
									<table class="table table-bordered table-hover">
											<tr>
												<td width="100"><?php echo $text_link_enable;?></td>
												<td>
                                         <div class="row">
                                           
                                        <div class="col-sm-3">
											<label><?php echo $text_status;?></label>
	    							 	<select name="link_enable" class="form-control">                                        
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <option value="1"><?php echo $text_enabled; ?></option>
	    								</select>	
                                        </div>
                                        <div class="col-sm-6">
											<label><?php echo $text_link;?></label>
                                            <input type="text" name="link_href" value="" class="form-control">
                                        </div> 
                                        <div class="col-sm-3">
											<label><?php echo $text_target;?></label>
                                           
	    							 	<select name="link_target" class="form-control">                                        
                            <option value="_self">_self</option>
                            <option value="_blank">_blank</option>
	    								</select>	
                                        </div>
                                       
                                         </div><!--//row --> 
                                         
                                         </td>
											</tr>
                                            <tr>
												<td width="100"></td>
												<td>
                                         <div class="row">
                                            
                                        <div class="col-sm-2">
											<label>H-offset</label>
                                            <input type="text" name="data-hoffset" value="" class="form-control">
                                        </div> 
                                        <div class="col-sm-2">
											<label>V-offset</label>
                                            <input type="text" name="data-voffset" value="" class="form-control">
                                        </div> 
                                        <div class="col-sm-2">
											<label>Split in</label>
                                            <input type="text" name="data-splitin" value="none" class="form-control">
                                        </div>
                                        <div class="col-sm-2">
											<label>Split out</label>
                                            <input type="text" name="data-splitout" value="none" class="form-control">
                                        </div> 
                                        
                                        <div class="col-sm-2">
											<label>Element Delay</label>
                                            <input type="text" name="data-elementdelay" value="0.1" class="form-control">
                                        </div> 
                                       
                                        <div class="col-sm-2">
											<label>End Element Delay</label>
                                            <input type="text" name="data-endelementdelay" value="0.1" class="form-control">
                                        </div> 
                                         </div><!--//row --> 
                                         
                                         </td>
											</tr>
                                            <tr>
												<td width="100"><?php echo $text_custom_css;?></td>
												<td>
                                         <div class="row">
                                           
                                        <div class="col-sm-12">
                                         <textarea class="form-control" style="width:100%; height:80px;resize:none;" name="style" id="input-data-style" data-for="style" ></textarea>
                                         </div>
                                         </div><!--//row --> 
                                         
                                         </td>
											</tr>
										</table>
									</div><!-- End div.other-effect -->
                                    
								</div><!-- End div.layer-form -->
							</div><!-- End row -->
							</div><!-- End div -->

		   				</div><!-- End div.slider-layers -->
                        <?php }else{ ?>
                <br>
                <div class="alert alert-info"><i class="fa fa-check-circle"></i> Please create new layer group!      <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
                <?php } ?>
					</form><!-- End form#slider_form -->

				</div><!-- End div.layers-wrapper -->
				
			</div><!-- End div.panel-body -->
		</div><!-- End div.panel-content -->

	</div><!-- End div#page-content -->

</div><!-- End div.content -->


 <!-- Modal Form-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo $text_preview_slideshow;?></h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $text_close; ?></button>
			</div>
		</div> 
	</div> 
</div>	

<script type="text/javascript"><!--
// clone data
$(document).delegate('a[data-toggle=\'clone\']', 'click', function(e) {
	e.preventDefault();
	var content = '';
	content += '<table class="table">';
	content += '	<tr>';
	content += '		<td><label class="control-label">Group:</label></td>';
	content += '		<td>';
	content += '			<select class="form-control" name="clone_group" id="clone_group">';
	content += '				<option value="0">Select group</option>';
	<?php foreach ($sliders as $group) { ?>content += '				<option value="<?php echo $group["primary_id"]; ?>"><?php echo $group["title"]; ?></option>';
<?php } ?>
	content += '			</select>';
	content += '		</td>';
	content += '	</tr>';
	content += '	<tr>';
	content += '		<td></td>';
	content += '		<td><button type="button" id="button-save" class="btn btn-primary"><i class="fa fa-save"></i></button> <button type="button" id="button-close" class="btn btn-danger"><i class="fa fa-close"></i></button></td>';
	content += '	</tr>';
	content += '</table>';

	var element = this;
	$(element).popover({
		title: 'Clone Data to Slider',
		html: true,
		placement: 'left',
		trigger: 'manual',
		content: function() {
			return content;
		}
	});

	var primary_id = <?php echo $primary_id; ?>;
	var lang = <?php echo $lang; ?>;
	
	$(element).popover('toggle');
	// Save
	$('#button-save').on('click', function() { 
		var clone_group = $("#clone_group option:selected").val();
		$.ajax({
			url: 'index.php?route=ave/slider_revolution/cloneLayerGroup&primary_id=' + primary_id + '&lang=' + lang + '&clonegroup=' + clone_group + '&token=' + getURLVar('token'),
			type: 'GET',
		}).done(function(data) { 
			location.reload(); 
		});
	});
	// Close
	$('#button-close').on('click', function() {
		$(element).popover('hide');
	});
});

// Sortable Slider
$(".layers-group").sortable({ accept:".slider-item",
	update:function() {   
		var ids = $( ".slider-item" );
		var group_setting = '';
		var j=1;
		$.each( ids, function(i,e){
			group_setting += 'layer_group_id['+$(e).attr('id').replace("slider_","")+']='+(j++)+"&";
		});
		$.ajax({
			url:'<?php echo str_replace("&amp;","&",$actionUpdatePostURL); ?>',
			data: group_setting,
			type:'POST'
		});
	} 
});

// Ajax Upload BackGround Image Slider
$("#btn-update-slider").click( function(){ 
			var field = 'slider-image';
			var preview = 'slider_image_src';
			var filemanager_path = 'index.php?route=ave/image_manager_plus/filemanager&token=' + getURLVar('token') + '&field=' + field + '&previewsrc=' + preview;
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
});

//--></script> 
<script type="text/javascript"><!--
$( document ).ready( function(){
	var JSONLIST = '<?php echo json_encode($layers); ?>';
	var $sliderEditor = $(document).revoSliderEditor(); 
	var SURLIMAGE = 'index.php?token=<?php echo $token; ?>';
	var SURL = '<?php echo HTTP_CATALOG ?>';
	$sliderEditor.process(SURL, SURLIMAGE, <?php echo $slider_info['configs']['delay']; ?> ); 
	$sliderEditor.createList(JSONLIST);
	Plus.init();
});
//--></script>
<?php echo $footer; ?>