<?php global $ave;  global $config; echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">        
      <button type="submit" form="form-content_category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></span></button>
      <a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
        </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
     
        <?php if($rstatus){?>
      <form action="<?php echo $import_module; ?>" method="post" enctype="multipart/form-data" id="import">
      		<input type="hidden" value="<?php echo $redirect;?>" name="redirect" />
                          <div>
        <table class="table table-bordered table-hover">
                 <tbody>
                    <tr>
                    <td><input type="file" name="import" /></td>  
                    <td>
    <a href="<?php echo $export_module;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Export this module data"><span><i class="fa fa-download"></i></span></a>
    <a onclick="$('#import').submit();" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> <span>Import Backup data</span></a>
                    </td>   
                    </tr>
                    </tbody>
                    </table>
</div>
      </form>
        <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-content_category" class="form-horizontal">
        <div class="row">
           <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-8">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>  
               <div class="form-group">
                <label class="col-sm-4 control-label" for="input-name"><?php echo $entry_custom_title; ?></label>
                <div class="col-sm-8">
                 <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="custom_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($custom_title[$language['language_id']]) ? $custom_title[$language['language_id']] : ''; ?>" class="form-control custom_title"/>
          </div>
          <?php } ?>
                </div>
              </div>  <!--//form-group--> 
          
         
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-8">
              <select name="status" id="input-status" class="form-control">
                <option value="1" <?php if ($status=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($status=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-type"><?php echo $entry_type; ?></label>
            <div class="col-sm-8">
             <select name="type" id="input-type" class="form-control tr_change with-nav" onchange="Plus.activeObj('type_display',this.options[this.selectedIndex].value);">
                <option value="catalog" <?php if ($type=='catalog') { ?>selected="selected"<?php } ?>><?php echo $text_catalog_category; ?></option>
                <option value="content" <?php if ($type=='content') { ?>selected="selected"<?php } ?>><?php echo $text_content_category; ?></option>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-count"><?php echo $entry_count; ?></label>
            <div class="col-sm-8">
              <select name="count" id="input-count" class="form-control">
                <option value="0" <?php if ($count==0) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                <option value="1" <?php if ($count==1) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
              </select>
            </div>
          </div>
          <div class="form-group hide">
            <label class="col-sm-4 control-label" for="input-mobile_visible"><?php echo $text_mobile_visible; ?></label>
            <div class="col-sm-8">
              <select name="mobile_visible" id="input-mobile_visible" class="form-control">
                <option value="" <?php if ($mobile_visible=='') { ?>selected="selected"<?php } ?>><?php echo $text_visible; ?></option>
                <option value="hidden-xs" <?php if ($mobile_visible=='hidden-xs') { ?>selected="selected"<?php } ?>><?php echo $text_hidden; ?></option>
              </select>
            </div>
          </div>
          
          <div class="form-group hide">
            <label class="col-sm-4 control-label" for="input-show_thumb"><?php echo $entry_show_thumb; ?></label>
            <div class="col-sm-8">
              <select name="show_thumb" id="input-show_thumb" class="form-control">
                <option value="1" <?php if ($show_thumb=='1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                <option value="0" <?php if ($show_thumb=='0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
              </select>
            </div>
          </div>
          <div class="form-group hide">
            <label class="col-sm-4 control-label" for="input-desc_limit"><?php echo $entry_desc_limit; ?></label>
            <div class="col-sm-8">
              <input name="desc_limit" id="input-desc_limit" class="form-control" value="<?php echo $desc_limit;?>"/>
            </div>
          </div>
          
          <div class="form-group hide">
            <label class="col-sm-4 control-label" for="input-show_thumb"><?php echo $entry_show_icon; ?></label>
            <div class="col-sm-8">
              <select name="show_icon" id="input-show_icon" class="form-control">
                <option value="1" <?php if ($show_icon=='1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                <option value="0" <?php if ($show_icon=='0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
              </select>
            </div>
          </div>
              </div>  <!--//col--> 
           <div class="col-sm-6">
            
           <div class="form-group">
            <div class="col-sm-4" for=""><?php echo $entry_display; ?></div>
            <div class="col-sm-8">             
            <select name="display" id="item_display" class="form-control tr_change with-nav" onchange="Plus.activeObj('item_display',this.options[this.selectedIndex].value);">
    <?php foreach ($elements as $elem) { ?>
    <option value="<?php echo $elem['value'];?>"  <?php echo ($elem['value']==$display)?'selected="selected"':'';?>><?php echo $elem['label'];?></option> 
   <?php } ?>
            </select>  
            </div>
          </div>
          <div class="form-group">
          <div class="col-sm-4" for=""></div>
            <div class="col-sm-8">
           
            <div style="max-width:600px;">
  <?php foreach ($elements as $elem) { ?>
            <img src="../assets/editor/img/mockup/<?php echo $elem['value'];?>.png" class="img-responsive item_display otp-<?php echo $elem['value'];?>" style="display:none;"/>
   <?php } ?>
            </div>
            </div>
          </div>     
          
              </div>  <!--//col--> 
              </div>  <!--//row--> 
              <div class="clearfix">
                   <div class="clearfix type_display otp-catalog" id="tab-catalog">
              <h2><?php echo $text_catalog_data;?></h2>
      <div class="table-responsive">
         <table id="page" class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="250"><?php echo $text_shown_as_parent; ?></td>
              <td width="1"><?php echo $text_thumb; ?><?php echo $entry_click_to_edit;?></td>
              <td width="1"><?php echo $text_icon; ?></td>
              <td width="1"><?php echo $text_column; ?></td>
              <td width="1"><?php echo $text_sort_order; ?></td>
            </tr>
          </thead>
                  <tbody>
           <?php foreach($catalog_categories as $category){?>
                    <tr>
                    <td> <input type="checkbox" name="catalog_data[<?php echo $category['category_id']; ?>][is_parent]" value="1" <?php if(isset($catalog_data[$category['category_id']]['is_parent'])){?>checked="checked"<?php } ?>/>
                      <input type="hidden" name="catalog_data[<?php echo $category['category_id']; ?>][category_id]" value="<?php echo $category['category_id']; ?>"/><?php echo $category['name']; ?>
                      </td>
                     
                         <td>
                    <a class="btn-quickedit img-thumbnail" href="<?php echo $category['edit'];?>">
                    <img src="<?php echo $category['image']; ?>"/>
                    </a>
                        </td> <td> <a class="icon-preview" style="display:block; max-width:100px;">
              <?php if(isset($catalog_data[$category['category_id']])){?>
                    <i class="<?php echo $catalog_data[$category['category_id']]['icon']; ?> fa-2x" id="icon_thumb<?php echo $category['category_id']; ?>"></i>
              <input type="hidden" name="catalog_data[<?php echo $category['category_id']; ?>][icon]" value="<?php echo $catalog_data[$category['category_id']]['icon']; ?>" id="icon<?php echo $category['category_id']; ?>"/>
              <?php }else{ ?>
                    <i class=" fa-2x" id="icon_thumb<?php echo $category['category_id']; ?>"></i>
             <input type="hidden" name="catalog_data[<?php echo $category['category_id']; ?>][icon]" value="" id="icon<?php echo $category['category_id']; ?>"/>
              <?php } ?>
                                 </a> 
                        </td>       
                    <td width="1"> 
                    <?php $vcolumn = isset($catalog_data[$category['category_id']]['vcolumn'])?$catalog_data[$category['category_id']]['vcolumn']:'1';?>
                      <select name="catalog_data[<?php echo $category['category_id']; ?>][vcolumn]" class="form-control" style="width:60px;">
                      <option value="2" <?php echo ($vcolumn==2)?'selected="selected"':''; ?>>2</option>
                      <option value="1" <?php echo ($vcolumn==1)?'selected="selected"':''; ?>>1</option>
                      </select>
                      </td>         
                    <td width="1"> 
                    <?php $vsort_order = !empty($catalog_data[$category['category_id']]['vsort_order'])?$catalog_data[$category['category_id']]['vsort_order']:'999';?>
                      <input type="text" name="catalog_data[<?php echo $category['category_id']; ?>][vsort_order]" value="<?php echo $vsort_order; ?>" class="form-control" style="width:50px;"/>
                      </td>
                    </tr>
          <?php } ?>
                  </tbody> 
        </table>
        </div>
            
          </div><!--//tab-catalog --> 
            <div class="clearfix type_display otp-content" id="tab-content">
              <h2><?php echo $text_content_data;?></h2>
           <div class="table-responsive">
         <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="250"><?php echo $text_shown_as_parent; ?></td>
              <td width="1"><?php echo $text_thumb; ?><?php echo $entry_click_to_edit;?></td>
              <td width="1"><?php echo $text_icon; ?></td>
              <td width="1"><?php echo $text_column; ?></td>
              <td width="1"><?php echo $text_sort_order; ?></td>
            </tr>
          </thead>
                  <tbody>
                   <tr>
                    <td colspan="5"> 
  <?php if(!$config->get('ave_confirm_installed')){?>  
   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>  </td>
                    </tr>
	<?php }else{?>    
           <?php if(!empty($content_categories)){?>
           <?php foreach($content_categories as $category){?>
                    <tr>
                    <td> <input type="checkbox" name="content_data[<?php echo $category['content_id']; ?>][is_parent]" value="1" <?php if(isset($content_data[$category['content_id']]['is_parent'])){?>checked="checked"<?php } ?>/>
                      <input type="hidden" name="content_data[<?php echo $category['content_id']; ?>][content_id]" value="<?php echo $category['content_id']; ?>"/><?php echo $category['name']; ?>
                      </td>
                     
                         <td>
                    <span class="img-thumbnail">
                    <img src="<?php echo $category['image']; ?>"/>
                    </span>
                        </td> <td> <div class="icon-preview" style="display:block; max-width:100px;">
                    <i class="<?php echo $category['icon']; ?> fa-2x"></i>
                                 </div> 
                        </td>       
                    <td width="1"> 
                    <?php $vcolumn = isset($content_data[$category['content_id']]['vcolumn'])?$content_data[$category['content_id']]['vcolumn']:'1';?>
                      <select name="content_data[<?php echo $category['content_id']; ?>][vcolumn]" class="form-control" style="width:60px;">
                      <option value="2" <?php echo ($vcolumn==2)?'selected="selected"':''; ?>>2</option>
                      <option value="1" <?php echo ($vcolumn==1)?'selected="selected"':''; ?>>1</option>
                      </select>
                      </td>         
                    <td width="1"> 
                    <?php $vsort_order = !empty($content_data[$category['content_id']]['vsort_order'])?$content_data[$category['content_id']]['vsort_order']:'999';?>
                      <input type="text" name="content_data[<?php echo $category['content_id']; ?>][vsort_order]" value="<?php echo $vsort_order; ?>" class="form-control" style="width:50px;"/>
                      </td>
                    </tr>
          <?php } ?>
          <?php } ?>
    
<?php }?>
                  </tbody> 
        </table>
        </div>
            </div><!--//tab-content -->
            </div><!--//clearfix --> 
        </form>
      </div>
    </div>
  </div></div>
<script type="text/javascript">

$(document).ready(function() {
		$(document).on('click', '.btn-quickedit', function(event) {
				event.preventDefault();
				var iframe = $('#modal-iframe');
				iframe.addClass('loading');
				var data_href = $(this).attr('href');
				$('#modal-iframe').attr('src',data_href);
					$('#module-modal').modal('show');
				iframe.removeClass('loading');
				$('#modal-iframe').on('load', function(event) {
					event.preventDefault();		
					var iframe = $('#modal-iframe');
					iframe.addClass('loading');
					var current_url = document.getElementById("modal-iframe").contentWindow.location.href;
		
					iframe.contents().find('[href]').on('click', function(event) {
						iframe.addClass('loading');
					});
		
					iframe.contents().find('form').on('submit', function(event) {
						iframe.addClass('loading');
						setTimeout(function() {
							$('#module-modal').modal('hide'); 
						}, 1500);
					});
						iframe.addClass('loading');
						iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
						iframe.contents().find('#content').css({ padding: '10px 0 0 0',margin: '0 0 0 0'});
						iframe.removeClass('loading');
				});
		});
});
	$(document).ready(function() {
		$('#tab_custom_category a').click( function(){
			localStorage.setItem("tab_custom_category", $(this).attr("href") );
		} );
		if( localStorage.getItem("tab_custom_category") !="undefined" ){
			$('#tab_custom_category a').each( function(){ 
				if( $(this).attr("href") ==  localStorage.getItem("tab_custom_category") ){
					$(this).click();
					return ;
				}
			} );
			
		}
		Plus.init();
	});
</script>
<div id="module-modal" class="modal-box modal fade hide_module_option">
        <div class="modal-dialog modal-fw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            	<h4 class="modal-title">&nbsp;  </h4>
            </div>
            <div class="modal-body modal-iframe">
                <iframe id="modal-iframe" class="modal-iframe loading" frameborder="0" allowtransparency="true" seamless></iframe>
            </div>
        </div>
      </div>
</div><!--//module-modal --> 
<?php echo $footer; ?>