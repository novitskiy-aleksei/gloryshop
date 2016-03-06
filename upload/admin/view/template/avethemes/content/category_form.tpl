<?php global $ave;?>

      <div class="message"></div>
      <div class="clearfix">
      
      
         <div id="products-toolbar" class="clearfix" style="margin-top: 10px; margin-bottom:20px;">
         		<h2 style="float:left; text-transform:uppercase;"><?php echo $title;?> <?php echo isset($category_description[$language_id]) ?': '. $category_description[$language_id]['name'] : ''; ?></h2>
                 <?php if($view){?>
                 <a class="btn btn-sm btn-primary pull-right" style="margin-left:15px;" href="<?php echo $view;?>" target="_blank"><i class="fa fa-eye"></i></a>
                 <?php } ?>
                  <?php if($filter){?>
                 <a class="btn btn-sm btn-primary pull-right" style="margin-left:15px;" href="<?php echo $filter;?>" target="_blank"><i class="fa fa-search"></i></a>
                 <?php } ?>
                 <a class="btn btn-sm btn-success pull-right" onclick="applyForm();"><i class="fa fa-save"></i> Save</a>
          </div>
                 
      <form method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
     
      	<input type="hidden" name="content_id" value="<?php echo $content_id;?>" />
      	<input type="hidden" name="color" value="" />
        <div class="row">
          <!--Data Form  --> 
          <div class="col-md-8 col-sm-7">
          <h3><?php echo $text_general;?></h3>
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_content_type; ?></label>
                <div class="col-sm-8">
              <select name="type" id="content_type" class="tr_change with-nav form-control" onchange="Plus.activeObj('content_type',this.options[this.selectedIndex].value);">
              <?php if ($ave->validate()!==false) { ?>
                  <option value="category" <?php echo ($type=='category')?'selected="selected"':''; ?>><?php echo $text_category;?></option>
                  <option value="faq" <?php echo ($type=='faq')?'selected="selected"':''; ?>><?php echo $text_faqs;?></option>
             	<?php } ?>
                  <option value="link" <?php echo ($type=='link')?'selected="selected"':''; ?>><?php echo $text_custom_link;?></option>
                  <option value="content" <?php echo ($type=='content')?'selected="selected"':''; ?>><?php echo $text_custom_content;?></option>
                </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""></label>
                <div class="col-sm-8"> 
                  <div class="alert alert-info content_type otp-category" style="display:none;"><?php echo $help_category;?></div>
                  <div class="alert alert-info content_type otp-link" style="display:none;"><?php echo $help_custom_link;?></div>
                  <div class="alert alert-info content_type otp-content" style="display:none;"><?php echo $help_custom_content;?></div>
                  <div class="alert alert-info content_type otp-faq" style="display:none;"><?php echo $help_faq;?></div>
                                  </div>
              </div><!-- form-group--> 
              <div class="form-group content_type otp-content">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_custom_size; ?></label>
                <div class="col-sm-8">
              <select name="content_size" class="form-control">
                  <option value="col-1"  <?php if ($content_size=='col-1') { ?>selected="selected" <?php } ?>>220px</option>
                  <option value="col-2"  <?php if ($content_size=='col-2') { ?>selected="selected" <?php } ?>>440px</option>
                  <option value="col-3"  <?php if ($content_size=='col-3') { ?>selected="selected" <?php } ?>>660px</option>
                  <option value="col-4"  <?php if ($content_size=='col-4') { ?>selected="selected" <?php } ?>>880px</option>
                  <option value="col-full"  <?php if ($content_size=='col-full') { ?>selected="selected" <?php } ?>><?php echo $text_full_width;?></option>
                </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group content_type otp-category">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_item_display; ?></label>
                <div class="col-sm-8">
              <select name="item_display" class="form-control">
                      <option value="blog" <?php echo ($item_display=='blog')?'selected="selected"':''; ?>><?php echo $text_content;?></option>
                      <option value="gallery" <?php echo ($item_display=='gallery')?'selected="selected"':''; ?>><?php echo $text_gallery;?></option>
                      <option value="project" <?php echo ($item_display=='project')?'selected="selected"':''; ?>><?php echo $text_project;?></option>
                    </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group content_type otp-category otp-link otp-faq">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_parent; ?></label>
                <div class="col-sm-8">
              <select name="parent_id" id="parent_id" class="tr_change form-control" onchange="Plus.activeObj('parent_id',this.options[this.selectedIndex].value);Plus.deactiveObj('parent_disable',this.options[this.selectedIndex].value);">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                      <?php if ($category['type']!=='content') { ?>
                          <?php if ($category['content_id'] == $parent_id) { ?>
                          <option value="<?php echo $category['content_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $category['content_id']; ?>"><?php echo $category['name']; ?></option>
                          <?php } ?>
                      <?php } ?>                      
                  <?php } ?>
                </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for="">
                
                 <p class="content_type otp-category"><?php echo $entry_name; ?></p>
                 <p class="content_type otp-link" style="display:none"><?php echo $entry_link; ?></p>
                 <p class="content_type otp-content" style="display:none"><?php echo $entry_content; ?></p>
                 <p class="content_type otp-faq" style="display:none"><?php echo $text_faqs_group_title; ?></p>
                
                </label>
                <div class="col-sm-8">
            <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input id="title" type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" class="form-control"/>
                  </div>
                  <?php if (isset($error_name[$language['language_id']])) { ?><br/> 
                  <span class="text-danger"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?>
            <?php } ?>
                                  </div>
              </div><!-- form-group-->               
              
              <div class="form-group content_type otp-link">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_custom_link; ?></label>
                <div class="col-sm-8">
              
              <input type="text" name="link" id="link" style="width:95%" value="<?php echo $link; ?>" class="form-control"/><br> 
              <?php echo $help_entry_custom_link;?>             
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group content_type otp-link">
                <label class="col-sm-4 control-label" for=""><span ><?php echo $entry_target; ?></span></label>
                <div class="col-sm-8">
              <span><select name="target" class="form-control">
                  <option value="_self" <?php if ($target=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                  <option value="_blank" <?php if ($target=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                </select>
                </span>
                                  </div>
              </div><!-- form-group--> 
              <div class="form-group content_type otp-category otp-faq">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_keyword; ?></label>
                <div class="col-sm-8">
              
              <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" class="form-control"/>
              <?php if ($error_keyword) { ?>
               <br><span class="text-danger"><?php echo $error_keyword; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group content_type otp-category otp-faq">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_meta_description; ?></label>
                <div class="col-sm-8">
                  <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#meta_desc_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
     			 </ul>
      
                 <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div id="meta_desc_language<?php echo $language['language_id']; ?>" class="tab-pane fade">
             <textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                  </div>
            <?php } ?>
            </div><!-- tab-content--> 
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group content_type otp-category ">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-8">
                <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#meta_kw_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
     			 </ul>
                 <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div id="meta_kw_language<?php echo $language['language_id']; ?>" class="tab-pane fade">
             <textarea name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                  </div>
            <?php } ?>
            </div><!-- tab-content--> 
                                  </div>
              </div><!-- form-group--> 
             
          <div class="content_type otp-category otp-content clearfix otp-faq">
          	<label class="content_type otp-category otp-faq"><?php echo $text_description;?> </label>
          	<label class="content_type otp-content"><?php echo $text_custom_content_description;?> </label>
           
                <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#desc_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
     			 </ul>
                 <div class="tab-content">
              <?php foreach ($languages as $language) { ?>
              <div id="desc_language<?php echo $language['language_id']; ?>"class="tab-pane fade">
                <textarea class="form-control summernote" name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
                </div>
              <?php } ?>
              </div><!--tab-content --> 
                  
             </div><!--clearfix -->   
              
          </div>
          
          
          
        <div class="col-md-4 col-sm-5">
            <h3>Data</h3>
        	<div class="well">
        	<div class="form content_type otp-category otp-link otp-faq">
              <div class="form-group parent_id otp-0">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_top; ?></label>
                <div class="col-sm-8">
              <input type="checkbox" name="top" value="1" <?php if ($top) { ?>checked="checked"<?php } ?> />
                                  </div>
              </div><!-- form-group--> 
            </div><!-- form-->   
            <div class="form content_type otp-category otp-link">
              <div class="form-group parent_id otp-0">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_nav_display; ?></label>
                <div class="col-sm-8">
              <select name="display" id="category_display" class="tr_change form-control" onchange="Plus.activeObj('category_display',this.options[this.selectedIndex].value);">
                  <option value="multi_level" <?php echo ($display=='multi_level')?'selected="selected"':''; ?>><?php echo $text_multi_level;?></option>
                  <option value="mega" <?php echo ($display=='mega')?'selected="selected"':''; ?>><?php echo $text_mega;?></option>
                </select>
                                  </div>
              </div><!-- form-group-->
             </div><!-- form-->   
              
              <div class="form-group parent_id otp-0 category_display otp-mega">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_column; ?></label>
                <div class="col-sm-8">
              <select name="column" class="form-control">
                  <option value="1"  <?php if ($column=='1') { ?>selected="selected" <?php } ?>>1</option>
                  <option value="2"  <?php if ($column=='2') { ?>selected="selected" <?php } ?>>2</option>
                  <option value="3"  <?php if ($column=='3') { ?>selected="selected" <?php } ?>>3</option>
                  <option value="4"  <?php if ($column=='4') { ?>selected="selected" <?php } ?>>4</option>
                </select>
                                  </div>
              </div><!-- form-group-->
              
              
              <div class="form-group parent_id otp-0 category_display otp-mega">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_nav_thumb; ?></label>
                <div class="col-sm-8">
              <select name="nav_thumb" class="form-control">
                  <option value="1" <?php if ($nav_thumb=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                  <option value="0" <?php if ($nav_thumb=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                </select>
                                  </div>
              </div><!-- form-group-->
              <div class="form-group content_type otp-category otp-link otp-faq">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_image; ?></label>
                <div class="col-sm-8">
                <a onclick="image_upload('input_image','thumb_image');" id="thumb_image" class="img-thumbnail">
                <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                </a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input_image" />
                  
                  </div>
              </div><!-- form-group-->
              <div class="form-group content_type otp-category otp-link otp-faq">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_icon; ?></label>
                <div class="col-sm-8">
             <a class="icon-preview">
                    <i class="<?php echo $icon;?>" id="icon_thumb"></i>
                     <input type="hidden" name="icon" value="<?php echo $icon;?>" id="icon" /></a> 
                                  </div>
              </div><!-- form-group-->
              
             
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-8">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" class="form-control"/>
                                  </div>
              </div><!-- form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_status; ?></label>
                <div class="col-sm-8">
              <select name="status" class="form-control">
                  <option value="1" <?php if ($status=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                  <option value="0" <?php if ($status=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                </select>
                                  </div>
              </div><!-- form-group-->
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $text_layout; ?></label>
                <div class="col-sm-8">
                 <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="category_layout[0][layout_id]" class="form-control">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($stores as $store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $store['name']; ?></td>
                <td class="left"><select name="category_layout[<?php echo $store['store_id']; ?>][layout_id]" class="form-control">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
            </div><!--table-responsive --> 
            
                                  </div>
              </div><!-- form-group-->
              
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_store; ?></label>
                <div class="col-sm-8">
                <div class="well well-sm" style="min-height:200px;overflow: auto;">
                            <div class="checkbox">
                        <label>
                            <input type="checkbox" name="category_store[]" value="0"  <?php if (in_array(0, $category_store)) { ?>checked="checked"<?php } ?> />
                            <?php echo $text_default; ?>
                            </label>
                            </div>
                          <?php foreach ($stores as $store) { ?>
                            <div class="checkbox">
                        <label>
                            <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" <?php if (in_array($store['store_id'], $category_store)) { ?>checked="checked" <?php } ?> /> <?php echo $store['name']; ?></label>
                            </div>
                          <?php } ?>
                        </div><!--well --> 
                                  </div>
              </div><!-- form-group-->
            </div><!--//well -->
          </div><!-- //col--> 
          </div><!-- row -->
          <div class="clearfix content_type otp-faq" style="margin-top:20px;" style="display:none;">
          <h3><?php echo $text_faqs;?></h3>
         <div class="table-responsive">
          <table class="table table-bordered table-hover" id="faqs">    
            <thead>
              <tr>
                <td class="left"><?php echo $text_question_answer;?></td>
               	<td class="right" width="60">
                 
               </td>
              </tr>
          
            </thead>
            
            <?php $faq_row = 0;?>
            <?php
             foreach($content_faqs as $content_faq){?>
            <tbody class="faq-row" id="faq-row<?php echo $faq_row;?>">
              <tr>               
                <td class="left">
                
                 <a style="margin-bottom:30px;" class="icon-preview">
                    <i class="<?php echo $content_faq['color'];?>" id="faq_bg<?php echo $faq_row; ?>"></i>
                     <input type="hidden" name="content_faq[<?php echo $faq_row; ?>][color]" id="faq_bg<?php echo $faq_row; ?>" value="<?php echo $content_faq['color'];?>"></a>
                     
                
                <?php foreach($languages as $language){?>
                 <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="content_faq[<?php echo $faq_row;?>][description][<?php echo $language['language_id'];?>][question]" value="<?php echo isset($content_faq['description'][$language['language_id']]) ? $content_faq['description'][$language['language_id']]['question'] : '';?>" class="form-control"/>
                  </div>
                  <?php }?>
                  <br/>      
                  
                <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>            
     <li><a href="#faq_language_<?php echo $faq_row;?>_<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> </a></li>
            <?php } ?>
     			 </ul>
                 <div class="tab-content">
           <?php foreach ($languages as $language) { ?>
            <div id="faq_language_<?php echo $faq_row;?>_<?php echo $language['language_id']; ?>" class="tab-pane fade">
                 <textarea class="to_editor summernote" id="faq_desc_<?php echo $faq_row;?>_<?php echo $language['language_id'];?>" name="content_faq[<?php echo $faq_row;?>][description][<?php echo $language['language_id'];?>][answer]" style="width:90%" rows="10"><?php echo isset($content_faq['description'][$language['language_id']]) ? $content_faq['description'][$language['language_id']]['answer'] : '';?></textarea>
                 </div>
                  <?php } ?>
                  </div>
<script type="text/javascript"><!--
$('#faq_desc_<?php echo $faq_row;?>_<?php echo $language['language_id'];?>').summernote({
	height: 250
});
//--></script> 
                 </td>
                 
                <td class="right vtop">
               <input type="hidden" readonly="readonly" name="content_faq[<?php echo $faq_row;?>][sort_order]" class="faq_sort" value="<?php echo $content_faq['sort_order'];?>" id="sort_order<?php echo $faq_row;?>"/>
               
                     
                     <a onclick="$('#faq-row<?php echo $faq_row;?>').remove();" class="btn btn-primary btn-xs"><?php echo $button_remove;?></a></td>
              </tr>
            </tbody>
            <?php $faq_row++;?>
            <?php }?>
            <tfoot>
              <tr>
              
                <td></td>
               <td class="right"><a onclick="addFAQ();" class="btn btn-primary btn-xs"><?php echo $button_add;?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        </div><!-- //clearfix--> 
      </form>
      
  <script type="text/javascript"><!--
var faq_row = parseInt(<?php echo $faq_row;?>)+1;
function addFAQ() {
	
	html  = '<tbody class="faq-row" id="faq-row' + faq_row + '">';
    html += '  <tr>';
	html += '<td class="left">';		  
	html += '<a style="margin-bottom:30px;" class="icon-preview"><i class="fa fa-life-ring" id="faq_bg' + faq_row + '"></i>';
	html += '<input type="hidden" name="content_faq[' + faq_row + '][color]" id="faq_bg' + faq_row + '" value="fa fa-life-ring"></a>';
	
		<?php foreach($languages as $language){?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
	
	html += '<input type="text" name="content_faq['+faq_row + '][description][<?php echo $language['language_id'];?>][question]" value="Question?" class="form-control"/>';
	html += '</div><br/>';
                  <?php }?>                          
	html += '<ul class="nav nav-tabs" id="faq_num' + faq_row + '">';
            <?php foreach ($languages as $language) { ?>
	html += '<li><a href="#faq_language_' + faq_row + '_<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> </a></li>';
            <?php } ?>
	html += '</ul><div class="tab-content">';
           <?php foreach ($languages as $language) { ?>
	html += '<div id="faq_language_' + faq_row + '_<?php echo $language['language_id']; ?>" class="tab-pane fade">';
	html += '<tex'+'tarea class="to_editor summernote" name="content_faq[' + faq_row + '][description][<?php echo $language['language_id'];?>][answer]" id="faq_desc_' + faq_row + '_<?php echo $language['language_id'];?>" style="width:90%" rows="10">Answer</tex'+'tarea>';
	html += '</div>';
          <?php } ?>
	html += '</div>';
	html += '</td>'; 
	html += '<td class="right vtop">';
	html += '<input readonly="readonly" type="hidden" name="content_faq[' + faq_row + '][sort_order]" class="faq_sort" value="' + faq_row + '" id="sort_order' + faq_row + '"/>';
	html += '<a onclick="$(\'#faq-row' + faq_row + '\').remove();" class="btn btn-primary btn-xs"><?php echo $button_remove;?></a></td>';
    html += '</tr>';	
    html += '</tbody>';
	$('#faqs tfoot').before(html);
	$('#faq-row'+faq_row+' .tr_change').trigger('change');
	Plus.initNav('#faq-row'+faq_row);
	$('#faq_num' + faq_row + ' li:first-child a').tab('show');
	<?php foreach ($languages as $language) { ?>
		$('#faq_desc_' + faq_row + '_<?php echo $language['language_id'];?>').summernote({height: 250});
	<?php } ?>
	faq_row++;
	$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');
}
//--></script> 
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#description<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
<?php } ?>
//--></script> 
    </div>