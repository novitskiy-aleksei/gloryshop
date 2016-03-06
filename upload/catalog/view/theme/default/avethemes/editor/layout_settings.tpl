<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>
  <a data-group="general_group" data-action="layout_assign" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_general_layout;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
        
		<ul class="nav nav-tabs nav-justified margin-bottom-5">
                    <li class="active"><a href="#layout-general" data-toggle="tab" data-tooltip="bottom" title="<?php echo $help_general_layout;?>" onclick="MCP.initSlimScroll('.design_content');"><?php echo $text_general_layout;?></a></li>
                    <li><a href="#layout-different" data-toggle="tab" data-tooltip="bottom" title="<?php echo $help_different_layout;?>" onclick="MCP.initSlimScroll('.design_content');"><?php echo $text_different_layout;?></a></li>
        </ul>
        
  <div class="container-fluid">
          <div class="tab-content">
             <!--DESKTOP -->    
            <div class="tab-pane active in" id="layout-general">
		<ul class="nav nav-tabs nav-justified margin-bottom-5">
                    <li class="active"><a href="#tab-desktop" data-toggle="tab" onclick="MCP.initSlimScroll('.design_content');"><i class="fa fa-desktop"></i> <?php echo $text_desktop;?></a></li>
                    <li><a href="#tab-tablet" data-toggle="tab" onclick="MCP.initSlimScroll('.design_content');"><i class="fa fa-tablet"></i> <?php echo $text_tablet;?></a></li>
        </ul>
  
                  
          <div class="tab-content">
          
             <!--DESKTOP -->    
            <div class="tab-pane active in" id="tab-desktop"> 

			<h4><a><?php echo $text_column_ratio_setting;?></a></h4>
    <!-- PRE_HEADER --> 
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_after_header;?></span></div></div></div>
    
        
    <!-- TOP_LEFT+TOP_RIGHT --> 
    <div class="row" id="desktop_range_top_position_0" data-text-content="<?php echo $text_top_right;?>" data-text-left="<?php echo $text_top_left;?>" data-text-right="<?php echo $text_top_right;?>">
            <div class="slide_label with-tooltip"></div>
            <div class="col_label with-tooltip"></div>
    </div>
        <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
    
     <div class="row colslider" id="desktop_range_top_position_slider_0">
              <div id="desktop_range_top_position_left_0" class="col-md-<?php echo $top_left;?>">
                   <div class="dashed"><span><?php echo $text_top_left;?></span><b class="value"><?php echo $top_left;?>/12</b>
                      <input type="hidden" name="theme_setting[top_left]" value="<?php echo $top_left;?>" readonly="true">
                      
                  </div>
              </div>
              <div id="desktop_range_top_position_right_0" class="col-md-<?php echo $top_right;?>">
                    <div class="dashed"><span class="col_label"><?php echo $text_top_right;?></span><b class="value"><?php echo $top_right;?>/12</b>
                      <input type="hidden" name="theme_setting[top_right]" value="<?php echo $top_right;?>" readonly="true">
                      
                    </div>
              </div>
    </div>
      
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_top;?></span></div></div></div>
    
      
     <!-- MAIN_COLUMN -->
    <div class="row" id="desktop_range_0" data-text-content="<?php echo $text_main_content;?>" data-text-left="<?php echo $text_column_left;?>" data-text-right="<?php echo $text_column_right;?>">
        <div class="slide_left with-tooltip"></div>
        <div class="slide_right with-tooltip"></div>
    </div>
      <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
      
    <div class="row colslider" data-id="#layout_scheme0" id="desktop_range_slider_0">
        <div id="desktop_range_left_0" class="col-md-<?php echo $desktop_left;?>">
          <div class="dashed"> <span><?php echo $text_column_left;?></span><br/><b class="value"><?php echo $desktop_left;?>/12</b>
            <input type="hidden" name="theme_setting[desktop_left]" value="<?php echo $desktop_left;?>" class="cval" readonly="true"/>
            <input type="hidden" value="l" class="sort"/>
          </div>
        </div>
        <!-- column_left-->
        <div id="desktop_range_content_0" class="col-md-<?php echo $desktop_content;?>">
          <div class="dashed"><span><?php echo $text_content_top;?></span></div>
          <div class="dashed"> <span><?php echo $text_main_content;?></span><br/><b class="value"><?php echo $desktop_content;?>/12</b>
            <input type="hidden" name="theme_setting[desktop_content]" value="<?php echo $desktop_content;?>" class="cval" readonly="true"/>
            <input type="hidden" value="c" class="sort"/>
          </div>
          <div class="dashed"><span><?php echo $text_content_bottom;?></span></div>
        </div>
        <!-- main_content-->
        <div id="desktop_range_right_0" class="col-md-<?php echo $desktop_right;?>">
          <div class="dashed"> <span><?php echo $text_column_right;?></span><br/><b class="value"><?php echo $desktop_right;?>/12</b>
            <input type="hidden" name="theme_setting[desktop_right]" value="<?php echo $desktop_right;?>" class="cval" readonly="true"/>
            <input type="hidden" value="r" class="sort"/>
          </div>
        </div>
        <!-- column_right--> 
      </div>
      
    
     <!-- EXTRA_BOTTOM -->
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_bottom;?></span></div></div></div>
     
    
     <!-- BOTTOM_LEFT_RIGHT -->
    
    <div class="row" id="desktop_range_bottom_position_0" data-text-left="<?php echo $text_bottom_left;?>" data-text-content="<?php echo $text_bottom_right;?>" data-text-right="<?php echo $text_bottom_right;?>">
            <div class="slide_label with-tooltip"></div>
            <div class="col_label with-tooltip"></div>
    </div>
    <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
        
        <div class="row colslider" id="desktop_range_bottom_position_slider_0">
              <div id="desktop_range_bottom_position_left_0" class="col-md-<?php echo $bottom_left;?>">
                   <div class="dashed">
                   <span><?php echo $text_bottom_left;?></span>
                   <b class="value"><?php echo $bottom_left;?>/12</b>
                      <input type="hidden" name="theme_setting[bottom_left]" value="<?php echo $bottom_left;?>" readonly="true">
                  </div>
              </div>
              <div id="desktop_range_bottom_position_right_0" class="col-md-<?php echo $bottom_right;?>">
                    <div class="dashed">
                    <span class="col_label"><?php echo $text_bottom_right;?></span><b class="value"><?php echo $bottom_right;?>/12</b>
                      <input type="hidden" name="theme_setting[bottom_right]" value="<?php echo $bottom_right;?>" readonly="true">
                    </div>
              </div>
    </div>
    
    
     <!-- PRE_FOOTER -->
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_footer;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_footer;?></span></div></div></div>
    <script type="text/javascript">
    	MCP.renderDesktopLayout('desktop_range_','0','custom');
	</script>
                </div><!-- tab-pane--> 
                
                
             <!--TABLET -->    
            <div class="tab-pane in" id="tab-tablet">
            
             <div class="form-group">
                    <label class="col-sm-8 control-label" for="input-name1"><?php echo $text_side_column;?></label>
             </div>
             <div class="form-group">
                    <div class="col-sm-12">
                    
                     <select name="theme_setting[default_tablet_layout]" id="default_tablet_layout" class="tr_change with-nav form-control" onChange="MCP.changeTwoColumn('tab_range_','0',this.value);MCP.changeTwoColumn('range_layout_tablet_top_','0','left');MCP.changeTwoColumn('range_layout_tablet_bottom_','0','left');MCP.changeTwoColumn('range_layout_tablet_extra_top_','0','left');MCP.changeTwoColumn('range_layout_tablet_extra_bottom_','0','left');">
                          <option value="left" <?php if ($default_tablet_layout=='left'){ ?>selected="selected" <?php } ?>><?php echo $text_column_left;?></option>
                          <option value="right" <?php if ($default_tablet_layout=='right'){ ?>selected="selected" <?php } ?>  ><?php echo $text_column_right;?></option>
                          </select></div>
                  </div><!--//form-group -->   
       
			<h4><a><?php echo $text_column_ratio_setting;?></a></h4>
     <!-- PRE_HEADER -->           
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_after_header;?></span></div></div></div>
    
    
     <!-- TOP_LEFT_RIGHT -->   
    <div class="row colslider" id="range_layout_tablet_top_0" data-text-content="<?php echo $text_top_right;?>" data-text-left="<?php echo $text_top_left;?>" data-text-right="<?php echo $text_top_right;?>">
            <div class="slide_label with-tooltip"></div>
            <div class="col_label with-tooltip"></div>
    </div>
    <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
    
        <div class="row colslider" id="range_layout_tablet_top_slider_0">
              <div id="range_layout_tablet_top_left_0" class="col-md-<?php echo $layout_tablet_top_left;?>">
                   <div class="dashed"><span><?php echo $text_top_left;?></span><b class="value"><?php echo $layout_tablet_top_left;?>/12</b>
                      <input type="hidden" name="theme_setting[layout_tablet_top_left]" value="<?php echo $layout_tablet_top_left;?>" readonly="true">
                      
                  </div>
              </div>
              <div id="range_layout_tablet_top_right_0" class="col-md-<?php echo $layout_tablet_top_right;?>">
                    <div class="dashed"><span class="col_label"><?php echo $text_top_right;?></span><b class="value"><?php echo $layout_tablet_top_right;?>/12</b>
                      <input type="hidden" name="theme_setting[layout_tablet_top_right]" value="<?php echo $layout_tablet_top_right;?>" readonly="true">
                      
                    </div>
              </div>
    </div>
    
     <!-- EXTRA_TOP-->   
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_top;?></span></div></div></div>
    
     <!-- MAIN COLUMN-->   
             <div class="row" id="tab_range_0" data-text-content="<?php echo $text_main_content;?>" data-text-left="<?php echo $text_column_left;?>" data-text-right="<?php echo $text_column_right;?>"><div class="slide_label with-tooltip"></div></div>
    <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
                        <!--mark -->
                        <div id="tab_range_slider_0" class="row colslider">
                          <div id="tab_range_left_0" class="col-md-<?php echo $tablet_rest;?>">
                            <div class="dashed"> <span class="col_label"></span> <b class="value"><?php echo $tablet_rest;?>/12</b>
                              <input type="hidden" name="theme_setting[tablet_rest]" value="<?php echo $tablet_rest;?>" readonly="true">
                             
                            </div>
                          </div>
                          <div id="tab_range_right_0" class="col-md-<?php echo $tablet_content;?>">
                            <div class="dashed"><span><?php echo $text_content_top;?></span></div>
                            <div class="dashed"><span class="main_label"><?php echo $text_main_content;?></span> <b class="value"><?php echo $tablet_content;?>/12</b>
                              <input type="hidden" name="theme_setting[tablet_content]" value="<?php echo $tablet_content;?>" readonly="true">
                              
                            </div>
                            <div class="dashed"><span><?php echo $text_content_bottom;?></span></div>
                          </div>
                        </div>
     
     
    
     <!-- EXTRA_BOTTOM-->           
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_bottom;?></span></div></div></div>
       
     <!-- BOTTOM_LEFT_RIGHT-->     
    <div class="row" id="range_layout_tablet_bottom_0" data-text-content="<?php echo $text_bottom_right;?>" data-text-left="<?php echo $text_bottom_left;?>" data-text-right="<?php echo $text_bottom_right;?>">
            <div class="slide_label with-tooltip"></div>
            <div class="col_label with-tooltip"></div>
        </div>
    <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
    <div class="row colslider" id="range_layout_tablet_bottom_slider_0">
              <div id="range_layout_tablet_bottom_left_0" class="col-md-<?php echo $layout_tablet_bottom_left;?>">
                   <div class="dashed"><span><?php echo $text_bottom_left;?></span><b class="value"><?php echo $layout_tablet_bottom_left;?>/12</b>
                      <input type="hidden" name="theme_setting[layout_tablet_bottom_left]" value="<?php echo $layout_tablet_bottom_left;?>" readonly="true">
                      
                  </div>
              </div>
              <div id="range_layout_tablet_bottom_right_0" class="col-md-<?php echo $layout_tablet_bottom_right;?>">
                    <div class="dashed"><span class="col_label"><?php echo $text_bottom_right;?></span><b class="value"><?php echo $layout_tablet_bottom_right;?>/12</b>
                      <input type="hidden" name="theme_setting[layout_tablet_bottom_right]" value="<?php echo $layout_tablet_bottom_right;?>" readonly="true">
                      
                    </div>
              </div>
    </div>
    
     <!-- PRE_FOOTER-->   
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_footer;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_footer;?></span></div></div></div>
     
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
            <?php echo $help_extra_position_ratio;?><button type="button" class="close" data-dismiss="alert">×</button>
   			 </div>
            </div><!--tab panel-->
</div><!--tab-content --> 


            </div><!--layout-general-->
            
        
        
        
        
        
        
        
        
            
            
  <!-- LAYOUT-DIFFERENRT-->       
 <div class="tab-pane" id="layout-different">
 
            
  <div class="layout_setting">
  			<div class="form-group">
                    <label class="col-sm-12 control-label"> <?php echo $entry_layout;?></label>
<div class="col-sm-12">
<select name="change_different_layouts" id="change_different_layouts" class="form-control with-nav tr_change" onchange="MCP.activeObj('layout_different',this.options[this.selectedIndex].value);">
              <?php foreach($layouts as $layout){?>
              <option value="layout_id<?php echo $layout['layout_id'];?>" <?php echo ($layout['layout_id']==$session_layout_id)?'selected="selected"':'';?>><?php echo $layout['name'];?> </option>
              <?php } ?> 
              </select>
                     </div>
              </div><!-- form-group--> 
              
                    <?php foreach ($layouts as $layout){ ?>
                <div class="layout_different clearfix otp-layout_id<?php echo $layout['layout_id'];?>" style="display:none;">
                <h4><a><?php echo $layout['name'];?></a></h4>
                <ul class="nav nav-tabs nav-justified margin-bottom-5">
                    <li class="active"><a href="#tab-desktop<?php echo $layout['layout_id'];?>" data-toggle="tab"><i class="fa fa-desktop"></i> <?php echo $text_desktop;?></a></li>
                    <li><a href="#tab-tablet<?php echo $layout['layout_id'];?>" data-toggle="tab"><i class="fa fa-tablet"></i> <?php echo $text_tablet;?></a></li>
                </ul>
     
              
                <div class="tab-content">
            <div class="tab-pane active in" id="tab-desktop<?php echo $layout['layout_id'];?>">
            
                  <div class="form-group">
                      <label class="col-sm-6 control-label layout-<?php echo $layout['layout_id'];?>"><?php echo $text_column_position;?></label>
                      </div>
                  <div class="form-group">
                       <div class="col-sm-12">
					   <?php $desktop_layout=(!empty($theme_setting['desktop'][$layout['layout_id']]))?$theme_setting['desktop'][$layout['layout_id']]:'default';?>
                      
                        <select class="form-control data_set with-nav" data-set="column_position" data-trigger="<?php if($desktop_layout!='default'){?>change<?php } ?>" data-selected="<?php echo $desktop_layout;?>" name="theme_setting[desktop][<?php echo $layout['layout_id'];?>]" id="layout_scheme<?php echo $layout['layout_id'];?>" onChange="MCP.renderDesktopLayout('desktop_range_','<?php echo $layout['layout_id'];?>',this.value);"></select>
                     </div>
              </div><!-- form-group--> 
            
                        
                        
 			<div class="range_row desktop_range_row_<?php echo $layout['layout_id'];?>" style="display:none;">
            
			<h4><a><?php echo $text_column_ratio_setting;?></a></h4>
            
				<?php if(isset($theme_setting['layout_desktop_left'][$layout['layout_id']])&&isset($theme_setting['layout_desktop_content'][$layout['layout_id']])&&isset($theme_setting['layout_desktop_right'][$layout['layout_id']])){
                     $desktop_left_value=$theme_setting['layout_desktop_left'][$layout['layout_id']];
                     $desktop_content_value=$theme_setting['layout_desktop_content'][$layout['layout_id']];
                     $desktop_right_value=$theme_setting['layout_desktop_right'][$layout['layout_id']];                
                }else{
                     $desktop_left_value=$desktop_left;
                     $desktop_content_value=$desktop_content;
                     $desktop_right_value=$desktop_right; 
                }
                if(isset($theme_setting['different_desktop_top_left'][$layout['layout_id']])&&isset($theme_setting['different_desktop_top_right'][$layout['layout_id']])){
                     $different_desktop_top_left_value=$theme_setting['different_desktop_top_left'][$layout['layout_id']];
                     $different_desktop_top_right_value=$theme_setting['different_desktop_top_right'][$layout['layout_id']];         
                }else{
                     $different_desktop_top_left_value=$top_left;
                     $different_desktop_top_right_value=$top_right;
                }
                ?>
                <?php   
                if(isset($theme_setting['different_desktop_bottom_left'][$layout['layout_id']])&&isset($theme_setting['different_desktop_bottom_right'][$layout['layout_id']])){
                     $different_desktop_bottom_left_value=$theme_setting['different_desktop_bottom_left'][$layout['layout_id']];
                     $different_desktop_bottom_right_value=$theme_setting['different_desktop_bottom_right'][$layout['layout_id']];         
                }else{
                     $different_desktop_bottom_left_value=$bottom_left;
                     $different_desktop_bottom_right_value=$bottom_right;
                } 
                if(isset($theme_setting['different_desktop_extra_top_left'][$layout['layout_id']])&&isset($theme_setting['different_desktop_extra_top_right'][$layout['layout_id']])){
                     $different_desktop_extra_top_left_value=$theme_setting['different_desktop_extra_top_left'][$layout['layout_id']];
                     $different_desktop_extra_top_right_value=$theme_setting['different_desktop_extra_top_right'][$layout['layout_id']];         
                }else{
                     $different_desktop_extra_top_left_value=$extra_top_left;
                     $different_desktop_extra_top_right_value=$extra_top_right;
                }
                
                if(isset($theme_setting['different_desktop_extra_bottom_left'][$layout['layout_id']])&&isset($theme_setting['different_desktop_extra_bottom_right'][$layout['layout_id']])){
                     $different_desktop_extra_bottom_left_value=$theme_setting['different_desktop_extra_bottom_left'][$layout['layout_id']];
                     $different_desktop_extra_bottom_right_value=$theme_setting['different_desktop_extra_bottom_right'][$layout['layout_id']];         
                }else{
                     $different_desktop_extra_bottom_left_value=$extra_bottom_left;
                     $different_desktop_extra_bottom_right_value=$extra_bottom_right;
                }
                ?>
                    
    <!-- PRE_HEADER --> 
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_after_header;?></span></div></div></div>
                   
                      
                <!-- TOP_LEFT_RIGHT-->  
                
                    <div class="row" id="desktop_range_top_position_<?php echo $layout['layout_id'];?>" data-text-content="<?php echo $text_top_right;?>" data-text-left="<?php echo $text_top_left;?>" data-text-right="<?php echo $text_top_right;?>">
                            <div class="slide_label with-tooltip"></div>
                            <div class="col_label with-tooltip"></div>
                     </div>
                     <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
                        
                        <div class="row colslider" id="desktop_range_top_position_slider_<?php echo $layout['layout_id'];?>">
                              <div id="desktop_range_top_position_left_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_desktop_top_left_value;?>">

                                   <div class="dashed"><span><?php echo $text_top_left;?></span><b class="value"><?php echo $different_desktop_top_left_value;?>/12</b>
                                      <input type="hidden" name="theme_setting[different_desktop_top_left][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_desktop_top_left_value;?>" readonly="true">
                                      
                                  </div>
                              </div>
                              <div id="desktop_range_top_position_right_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_desktop_top_right_value;?>">
                                    <div class="dashed"><span class="col_label"><?php echo $text_top_right;?></span><b class="value"><?php echo $different_desktop_top_right_value;?>/12</b>
                                      <input type="hidden" name="theme_setting[different_desktop_top_right][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_desktop_top_right_value;?>" readonly="true">
                                      
                                    </div>
                              </div>
                    </div>
             
                    
                <!-- EXTRA_TOP--> 
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_top;?></span></div></div></div>
                
                
                <!-- MAIN COLUMN--> 
                      <div class="row" id="desktop_range_<?php echo $layout['layout_id'];?>" data-text-content="<?php echo $text_main_content;?>" data-text-left="<?php echo $text_column_left;?>" data-text-right="<?php echo $text_column_right;?>">
                        <div class="slide_left with-tooltip"></div>
                        <div class="slide_right with-tooltip"></div>
                      </div>
                     <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
                        
                        <div class="row colslider" data-id="#layout_scheme<?php echo $layout['layout_id'];?>" id="desktop_range_slider_<?php echo $layout['layout_id'];?>">
                          <div id="desktop_range_left_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $desktop_left_value;?>">
                            <div class="dashed"> <span><?php echo $text_column_left;?></span><br/><b class="value"><?php echo $desktop_left_value;?>/12</b>
                              <input type="hidden" name="theme_setting[layout_desktop_left][<?php echo $layout['layout_id'];?>]" value="<?php echo $desktop_left_value;?>" readonly="true" class="cval">
                              <input type="hidden" value="l" class="sort">
                            </div>
                          </div>
                          <div id="desktop_range_content_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $desktop_content_value;?>">
                            <div class="dashed"> <span><?php echo $text_main_content;?></span><br/><b class="value"><?php echo $desktop_content_value;?>/12</b>
                              <input type="hidden" name="theme_setting[layout_desktop_content][<?php echo $layout['layout_id'];?>]" value="<?php echo $desktop_content_value;?>" readonly="true" class="cval">
                              <input type="hidden" value="c" class="sort">
                            </div>
                          </div>
                          <div id="desktop_range_right_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $desktop_right_value;?>">
                            <div class="dashed"> <span><?php echo $text_column_right;?></span><br/><b class="value"><?php echo $desktop_right_value;?>/12</b>
                              <input type="hidden" name="theme_setting[layout_desktop_right][<?php echo $layout['layout_id'];?>]" value="<?php echo $desktop_right_value;?>" readonly="true" class="cval">
                              <input type="hidden" value="r" class="sort">
                            </div>
                          </div>
                        </div>
                        
           
               
                    
        
                <!-- EXTRA_BOTTOM-->             
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_bottom;?></span></div></div></div>
           
     <!-- BOTTOM_LEFT_RIGHT-->        
                    <div class="row" id="desktop_range_bottom_position_<?php echo $layout['layout_id'];?>" data-text-left="<?php echo $text_bottom_left;?>" data-text-content="<?php echo $text_bottom_right;?>" data-text-right="<?php echo $text_bottom_right;?>">
                            <div class="slide_label with-tooltip"></div>
                            <div class="col_label with-tooltip"></div>
                        </div>
                        <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
                        
                        <div class="row colslider" id="desktop_range_bottom_position_slider_<?php echo $layout['layout_id'];?>">
                              <div id="desktop_range_bottom_position_left_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_desktop_bottom_left_value;?>">
                                   <div class="dashed"><span><?php echo $text_bottom_left;?></span> <b class="value"><?php echo $different_desktop_bottom_left_value;?>/12</b>
                                      <input type="hidden" name="theme_setting[different_desktop_bottom_left][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_desktop_bottom_left_value;?>" readonly="true">
                                      
                                  </div>
                              </div>
                              <div id="desktop_range_bottom_position_right_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_desktop_bottom_right_value;?>">
                                    <div class="dashed"><span class="col_label"><?php echo $text_bottom_right;?></span><b class="value"><?php echo $different_desktop_bottom_right_value;?>/12</b>
                           <input type="hidden" name="theme_setting[different_desktop_bottom_right][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_desktop_bottom_right_value;?>" readonly="true">
                                      
                                    </div>
                              </div>
                    </div><!-- colslider--> 
                    
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_footer;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_footer;?></span></div></div></div>
                    
             </div><!-- range_row-->               
            </div><!-- //tab-desktop--> 
            
            
          
          
          
          
          
          
            
            
            
            
            
            <div class="tab-pane in" id="tab-tablet<?php echo $layout['layout_id'];?>">
              
            				<div class="form-group">
                    <label class="col-sm-8 control-label"> <?php echo $text_tablet_side_column;?></label>
                    </div>
            				<div class="form-group">
                    <div class="col-sm-12">
					<?php $tablet_layout=(!empty($theme_setting['tablet'][$layout['layout_id']]))?$theme_setting['tablet'][$layout['layout_id']]:'default';?>
                    
<select name="theme_setting[tablet][<?php echo $layout['layout_id'];?>]" id="theme_setting_tablet_<?php echo $layout['layout_id'];?>" class="<?php if($tablet_layout!='default'){?>tr_change<?php } ?> with-nav form-control" onChange="MCP.changeTwoColumn('tab_range_','<?php echo $layout['layout_id'];?>',this.value); MCP.changeTwoColumn('range_layout_tablet_top_','<?php echo $layout['layout_id'];?>','left'); MCP.changeTwoColumn('range_layout_tablet_bottom_','<?php echo $layout['layout_id'];?>','left'); MCP.changeTwoColumn('range_tablet_extra_top_','<?php echo $layout['layout_id'];?>','left'); MCP.changeTwoColumn('range_tablet_extra_bottom_','<?php echo $layout['layout_id'];?>','left');">
                          <option value="default" <?php echo ($tablet_layout=='default')?'selected="selected"':'';?>><?php echo $text_inherit_general;?></option>
                          <option value="left" <?php echo ($tablet_layout=='left')?'selected="selected"':'';?>><?php echo $text_column_left;?></option>
                          <option value="right" <?php echo ($tablet_layout=='right')?'selected="selected"':'';?>><?php echo $text_column_right;?></option></select>
                     </div>
              </div><!-- form-group--> 
              
              
              <div class="range_row tab_range_row_<?php echo $layout['layout_id'];?>" style="display:none;">
              
			<h4><a><?php echo $text_column_ratio_setting;?></a></h4>
                    <?php 
                if(isset($theme_setting['layout_tablet_rest'][$layout['layout_id']])&&isset($theme_setting['layout_tablet_content'][$layout['layout_id']])){
                     $tablet_content_value=$theme_setting['layout_tablet_content'][$layout['layout_id']];  
                     $tablet_rest_value=$theme_setting['layout_tablet_rest'][$layout['layout_id']];         
                }else{
                     $tablet_content_value=$tablet_content;
                     $tablet_rest_value=$tablet_rest;
                }
               
                if(isset($theme_setting['different_tablet_top_left'][$layout['layout_id']])&&isset($theme_setting['different_tablet_top_right'][$layout['layout_id']])){
                     $different_tablet_top_left_value=$theme_setting['different_tablet_top_left'][$layout['layout_id']];
                     $different_tablet_top_right_value=$theme_setting['different_tablet_top_right'][$layout['layout_id']];         
                }else{
                     $different_tablet_top_left_value=$layout_tablet_top_left;
                     $different_tablet_top_right_value=$layout_tablet_top_right;
                }
                if(isset($theme_setting['different_tablet_bottom_left'][$layout['layout_id']])&&isset($theme_setting['different_tablet_bottom_right'][$layout['layout_id']])){
                     $different_tablet_bottom_left_value=$theme_setting['different_tablet_bottom_left'][$layout['layout_id']];
                     $different_tablet_bottom_right_value=$theme_setting['different_tablet_bottom_right'][$layout['layout_id']];         
                }else{
                     $different_tablet_bottom_left_value=$layout_tablet_bottom_left;
                     $different_tablet_bottom_right_value=$layout_tablet_bottom_right;
                }
                
                if(isset($theme_setting['different_tablet_extra_top_left'][$layout['layout_id']])&&isset($theme_setting['different_tablet_extra_top_right'][$layout['layout_id']])){
                     $different_tablet_extra_top_left_value=$theme_setting['different_tablet_extra_top_left'][$layout['layout_id']];
                     $different_tablet_extra_top_right_value=$theme_setting['different_tablet_extra_top_right'][$layout['layout_id']];         
                }else{
                     $different_tablet_extra_top_left_value=$layout_tablet_extra_top_left;
                     $different_tablet_extra_top_right_value=$layout_tablet_extra_top_right;
                }
                
                if(isset($theme_setting['different_tablet_extra_bottom_left'][$layout['layout_id']])&&isset($theme_setting['different_tablet_extra_bottom_right'][$layout['layout_id']])){
                     $different_tablet_extra_bottom_left_value=$theme_setting['different_tablet_extra_bottom_left'][$layout['layout_id']];
                     $different_tablet_extra_bottom_right_value=$theme_setting['different_tablet_extra_bottom_right'][$layout['layout_id']];         
                }else{
                     $different_tablet_extra_bottom_left_value=$layout_tablet_extra_bottom_left;
                     $different_tablet_extra_bottom_right_value=$layout_tablet_extra_bottom_right;
                }
                
                ?>
                
     <!--PRE_HEADER-->
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_header;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_after_header;?></span></div></div></div>
    
    
 
     <!--TOP_LEFT_RIGHT-->
    <div class="row colslider" id="range_layout_tablet_top_<?php echo $layout['layout_id'];?>" data-text-content="<?php echo $text_top_right;?>" data-text-left="<?php echo $text_top_left;?>" data-text-right="<?php echo $text_top_right;?>">
            <div class="slide_label with-tooltip"></div>
            <div class="col_label with-tooltip"></div>
        </div>
        <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
    
        <div class="row colslider" id="range_layout_tablet_top_slider_<?php echo $layout['layout_id'];?>">
              <div id="range_layout_tablet_top_left_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_tablet_top_left_value;?>">
                   <div class="dashed"><span><?php echo $text_top_left;?></span><b class="value"><?php echo $different_tablet_top_left_value;?>/12</b>
                      <input type="hidden" name="theme_setting[different_tablet_top_left][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_tablet_top_left_value;?>" readonly="true">
                      
                  </div>
              </div>
              <div id="range_layout_tablet_top_right_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_tablet_top_right_value;?>">
                    <div class="dashed"><span class="col_label"><?php echo $text_top_right;?></span><b class="value"><?php echo $different_tablet_top_right_value;?>/12</b>
                      <input type="hidden" name="theme_setting[different_tablet_top_right][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_tablet_top_right_value;?>" readonly="true">
                      
                    </div>
              </div>
    </div>
   
     <!--EXTRA_TOP-->   
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_top;?></span></div></div></div>
    
     <!--MAIN_COLUMN-->   
    <div class="row" id="tab_range_<?php echo $layout['layout_id'];?>" data-text-content="<?php echo $text_main_content;?>" data-text-left="<?php echo $text_column_left;?>" data-text-right="<?php echo $text_column_right;?>"><div class="slide_label with-tooltip"></div>
                        </div>
                        <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
                        
                        <div class="row colslider" id="tab_range_slider_<?php echo $layout['layout_id'];?>">
                          <div id="tab_range_left_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $tablet_rest_value;?>">
                            <div class="dashed"> <span class="col_label main_label"><?php echo $text_content_top;?></span><b class="value"><?php echo $tablet_rest_value;?>/12</b>
                              <input type="hidden" name="theme_setting[layout_tablet_rest][<?php echo $layout['layout_id'];?>]" 
                              value="<?php echo $tablet_rest_value;?>" readonly="true">
                              
                            </div>
                          </div>
                          <div id="tab_range_right_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $tablet_content_value;?>">
                            <div class="dashed"><span><?php echo $text_content_top;?></span></div>
                            <div class="dashed"><span class="main_label"><?php echo $text_main_content;?></span><b class="value"><?php echo $tablet_content_value;?>/12</b>
                              <input type="hidden" name="theme_setting[layout_tablet_content][<?php echo $layout['layout_id'];?>]" value="<?php echo $tablet_content_value;?>" readonly="true">
                            </div>
                            <div class="dashed"><span><?php echo $text_content_bottom;?></span></div>
                          </div>
                        </div>

 
    
     <!-- EXTRA_BOTTOM--> 
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_extra_bottom;?></span></div></div></div>
    
     <!-- BOTTOM_LEFT_RIGHT-->    
    <div class="row colslider" id="range_layout_tablet_bottom_<?php echo $layout['layout_id'];?>" data-text-content="<?php echo $text_bottom_right;?>" data-text-left="<?php echo $text_bottom_left;?>" data-text-right="<?php echo $text_bottom_right;?>">
            <div class="slide_label with-tooltip"></div>
            <div class="col_label with-tooltip"></div>
        </div>
        <div class="row with_ruler"><?php echo $text_grid_ruler;?></div>
    
        <div class="row colslider" id="range_layout_tablet_bottom_slider_<?php echo $layout['layout_id'];?>">
              <div id="range_layout_tablet_bottom_left_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_tablet_bottom_left_value;?>">
                   <div class="dashed"><span><?php echo $text_bottom_left;?></span><b class="value"><?php echo $different_tablet_bottom_left_value;?>/12</b>
                      <input type="hidden" name="theme_setting[different_tablet_bottom_left][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_tablet_bottom_left_value;?>" readonly="true">
                      
                  </div>
              </div>
              <div id="range_layout_tablet_bottom_right_<?php echo $layout['layout_id'];?>" class="col-md-<?php echo $different_tablet_bottom_right_value;?>">
                    <div class="dashed">
                    <span class="col_label"><?php echo $text_bottom_right;?></span>
                    <b class="value"><?php echo $different_tablet_bottom_right_value;?>/12</b>
<input type="hidden" name="theme_setting[different_tablet_bottom_right][<?php echo $layout['layout_id'];?>]" value="<?php echo $different_tablet_bottom_right_value;?>" readonly="true">
					</div>
              </div>
    </div>      
     
     <!-- PRE_FOOTER-->                    
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_pre_footer;?></span></div></div></div>
    <div class="row colslider"><div class="col-md-12"><div class="dashed no_resize"><span><?php echo $text_footer;?></span></div></div></div>
    
                 </div><!--//range_row--> 
            </div><!-- //tab-tablet--> 
            
            </div><!--//tab-content --> 
                </div><!-- ds_content--> 
                    <?php } ?>
</div><!-- //layout_setting--> 
 </div><!--layout-different-->
</div><!--tab-content --> 

<script type="text/javascript">
MCP.handleThumbview();
</script>
</div><!-- //container-fluid--> 