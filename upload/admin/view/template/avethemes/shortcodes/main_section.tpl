<?php global $ave;
global $config; echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
<style>
html {
    overflow-x: hidden;
}
.form-horizontal .nav {
	margin-bottom:20px;
}
.form-horizontal .nav > li.active > a{
    color: #ffffff;
    background: #f56b6b;
    border-color: #f24545;
}
.form-horizontal .nav > li > a{
    color: #eeeeee;
    background: #1e91cf;
}
.icon-left{ display:inline-block; margin-right:10px;}
.icon-right{float:right;}
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">        
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
   <div class="message"></div>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>  
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="hidden-xs"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></span></h3>
        <div class="pull-right text-right">
        
         
         <button onclick="applySection();" class="btn btn-success btn-sm"><span><i class="fa fa-save"></i> <?php echo $button_apply; ?></span></button>
         
      <button type="submit" form="form-section" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></span></button>
      <button onclick="location = '<?php echo $cancel; ?>';" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></button>
      
                    </div>
      </div>
      <div class="panel-body">
    <div class="row">
     <div class="col-md-9 col-sm-12 col-xs-12 pull-right">
     
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-section" class="form-horizontal">
        <input type="hidden" name="element" value="<?php echo $element;?>"/>
        <div class="row">
        <div class="col-sm-6">
        
          
          <div class="form-group">
          
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
            <label class="col-sm-4 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-8">
              <select name="status" id="input-status" class="form-control">
                <option value="1" <?php if ($status=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($status=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
          
            <div class="col-sm-12">
                <?php echo (!empty($element))?$entry_section:$text_please_select;?></div>
              <div class="col-sm-12">
            <div class="clearfix">
              <div class="input-group">
              <a class="input-group-addon input-sm" onclick="Plus.navSelect('prev','#template_display')"><i class="fa fa-chevron-left"></i></a>
               
 <select id="template_display" multiple="multiple" class="form-control" onchange="location = this.value;" style="height:300px;">
              <?php foreach ($elements as $elem) { ?>
    <option value="<?php echo $elem['value'];?>"  <?php echo ($elem['key']==$element)?'selected="selected"':'';?>><?php echo $elem['label'];?></option> 
              <?php } ?>
            </select>
            <a class="input-group-addon input-sm" onclick="Plus.navSelect('next','#template_display')"><i class="fa fa-chevron-right"></i></a>
              </div> <!--input-group --> 
              </div>  <!-- //clear--> 
              
         <a href="<?php echo $add;?>" class="btn btn-success btn-sm btn-block"><i class="fa fa-plus"></i> <?php echo $text_add_module; ?></a>
              </div>
          </div>    <!--//form-group --> 
        
          <div class="form-group">
                <div class="col-sm-12">
                <div style="max-width:600px;text-align:center; position:relative;">
              <?php foreach ($elements as $elem) {
              if(!empty($elem['key'])){
               ?>
                <img src="../assets/editor/img/mockup/<?php echo $elem['key'];?>.png" data-key="<?php echo $elem['key'];?>" class="<?php echo ($elem['key']==$element)?'show':'hide';?>" style="margin: 0 auto;max-width:100%;"/>
              <?php } ?>
              <?php } ?>
              </div>
              </div>  
          </div>    <!--//form-group --> 
        
              </div><!-- //col--> 
              
        <div class="col-sm-6">
        
          <div class="well">
          <h5><?php echo $text_section_data;?></h5>
          <small><?php echo $help_section_data;?></small>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-type"><?php echo $entry_section_icon; ?></label>
            <div class="col-sm-8">
             <a class="icon-preview">
         <i class="<?php echo $icon;?>" id="main_icon_thumb"></i>
         <input type="hidden" name="icon" value="<?php echo $icon;?>" id="main_icon" /></a> 
              <i class="fa fa-trash-o clear-ico"></i>
            </div>
          </div> <!--//form-group--> 
 
      <div class="form-group">
                <label class="col-sm-4 control-label" for="input-name"><?php echo $entry_section_title; ?></label>
                <div class="col-sm-8">
                 <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" class="form-control title"/>
          </div>
          <?php } ?>
                </div>
              </div>  <!--//form-group-->
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-classes"><?php echo $text_heading_align; ?></label>
            <div class="col-sm-8">
            <select name="heading_align" id="heading_align" class="form-control">
    <option><?php echo $text_inherit;?></option> 
    <option value="centered" <?php echo ($heading_align=='centered')?'selected="selected"':'';?>><?php echo $text_centered;?></option> 
            </select>
            </div>
          </div> <!--//form-group--> 
          
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-classes"><?php echo $text_paralax_class; ?></label>
            <div class="col-sm-8">
            <select name="paralax_class" id="paralax_class" class="form-control">
    <option value=""><?php echo $text_none;?></option>  
    <option value="bg_gray" <?php echo ($paralax_class=='bg_gray')?'selected="selected"':'';?>>Grey Bg </option> 
    <option value="ave_parallax1" <?php echo ($paralax_class=='ave_parallax1')?'selected="selected"':'';?>>Paralax level 1</option> 
    <option value="ave_parallax2" <?php echo ($paralax_class=='ave_parallax2')?'selected="selected"':'';?>>Paralax level 2</option> 
    <option value="ave_parallax3" <?php echo ($paralax_class=='ave_parallax3')?'selected="selected"':'';?>>Paralax level 3</option> 
    <option value="ave_parallax4" <?php echo ($paralax_class=='ave_parallax4')?'selected="selected"':'';?>>Paralax level 4</option> 
    <option value="ave_parallax5" <?php echo ($paralax_class=='ave_parallax5')?'selected="selected"':'';?>>Paralax level 5</option> 
    <option value="ave_parallax6" <?php echo ($paralax_class=='ave_parallax6')?'selected="selected"':'';?>>Paralax level 6</option> 
    <option value="ave_parallax7" <?php echo ($paralax_class=='ave_parallax7')?'selected="selected"':'';?>>Paralax level 7</option> 
    <option value="ave_parallax8" <?php echo ($paralax_class=='ave_parallax8')?'selected="selected"':'';?>>Paralax level 8</option> 
    <option value="ave_parallax9" <?php echo ($paralax_class=='ave_parallax9')?'selected="selected"':'';?>>Paralax level 9</option> 
            </select>
            </div>
          </div> <!--//form-group--> 
             <div class="form-group">
            <label class="col-sm-4 control-label" for="input-classes"><?php echo $entry_background_mode; ?></label>
            <div class="col-sm-8">
 <select name="bgmode" id="bgmode" class="form-control" onchange="Plus.activeObj('bgmode',this.options[this.selectedIndex].value);">  
    <option value="" <?php echo ($bgmode=='')?'selected="selected"':'';?>><?php echo $text_light;?></option> 
    <option value="white_section" <?php echo ($bgmode=='white_section')?'selected="selected"':'';?>><?php echo $text_dark;?></option> 
    <option value="bg_gray" <?php echo ($bgmode=='bg_gray')?'selected="selected"':'';?>>Grey Bg</option> 
            </select>
 
            </div>
          </div> <!--//form-group--> 
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-image"><?php echo $entry_section_bgcolor; ?></label>
            <div class="col-sm-8">
            <input class="form-control colorpicker" type="text" name="bgcolor" placeholder="<?php echo $entry_bgcolor;?>" value="<?php echo (!empty($bgcolor))?$bgcolor:'';?>">
            
            </div>
          </div> <!--//form-group--> 
 
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-image"><?php echo $entry_section_background; ?></label>
            <div class="col-sm-8">
            <a data-toggle="image-upload" onclick="image_upload('main_image','main_thumb');" id="main_thumb" class="img-thumbnail">
            <img src="<?php echo (!empty($bgimage))?'../image/'.$bgimage:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($bgimage))?'../image/'.$bgimage:$placeholder;?>" id="main_image_thumb"/></a>
            <input type="hidden" name="bgimage" value="<?php echo $bgimage;?>" id="main_image"/>
            
            </div>
          </div> <!--//form-group-->     
          
          </div><!-- //well--> 
          </div><!--//col --> 
          
          </div><!--//row --> 
           
          <div class="clearfix">
          <?php echo $module_content;?>
          </div><!--//row --> 
    </form>
          </div><!--//col --> 
     <div class="col-md-3 col-sm-12 col-xs-12 pull-left">
        <div class="block_relative">
          <div id="module_list">
          <div class="heading-bar"><?php echo $text_installed_modules;?></div>
          <div class="module_accordion ds_accordion">
          <div class="form-group">
              <div class="ds_content" style="display:block !important">
                  <?php foreach ($module_data as $module) { ?>
                  <div class="module-block <?php echo ($module['module_id']==$module_id)?'active':'';?>" <?php echo ($module['thumb'])?'data-thumb="'.$module['thumb'].'"':''; ?>>
                    <a style="display:block;float: left;width: 80%;text-align:left;" class="btn btn-sm btn-edit" href="<?php echo $module['href'];?>"><i class="fa fa-edit"></i> <?php echo $module['name'];?> </a> 
                    <a style="float:right;text-align:right;"onclick="confirm('<?php echo $text_confirm;?>') ? location.href='<?php echo $module['delete'];?>' : false;" data-toggle="tooltip" title="<?php echo $text_delete;?>" class="btn btn-sm btn-edit"><i class="fa fa-trash-o"></i></a>     
                    </div>
                  <?php } ?>
              
              </div>    <!--//ds_content --> 
          </div>    <!--//form-group --> 
          </div>    <!--//module_accordion--> 
          </div>    <!--//module_list--> 
          </div>    <!--//block_relative--> 
        
          
          </div><!--//col --> 
        </div><!-- //row--> 
        
  	</div><!-- panel-body--> 
    </div><!-- panel---> 
  </div>
  
<script type="text/javascript"><!--
function cloneSection(clone_row){
		section_row = parseInt($('#add_section').attr('data-section'));
	var clone_html = $('<div>').append($('#section-tab'+clone_row).clone()).remove().html();	
		clone_html = clone_html.replace("section-tab"+clone_row,"section-tab"+section_row);	
		clone_html = clone_html.replace("<?php echo $text_section; ?> #"+parseInt(clone_row+1),"<?php echo $text_section; ?> #"+parseInt(section_row+1));
		
		$.ajax({
		url: 'index.php?route=module/ave_shortcodes/cloneSection&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data:  'clone_html=' + clone_html +'&clone_row=' + clone_row +  '&section_row=' + section_row,
		success: function(json) {
			if (json['success']) {
				$('#section-tab.tab-content').append(json['clone_html']);
			
				$('#section_nav > li:last-child').before('<li><a href="#section-tab' + section_row + '" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(' + section_row + ')" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_section; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
				$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
				$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
				section_row++;
				$('#add_section').attr('data-section',parseInt(section_row));						
				
			}else{
				addSection();	
			}
		}
	});
	
}
function removeSection(section_row){
	$('a[href=\'#section-tab' + section_row + '\']').parent().remove();
	$('#section-tab' + section_row + '').remove();
	$('#section_nav a:first').tab('show');
}
function applySection(){
	$('.summernote').each(function () {
    	var $textArea = $(this);
            $textArea.val($(this).code());
       
	});
		$.ajax({
			url: 'index.php?route=module/ave_shortcodes/apply&token=<?php echo $token;?>&module_id=<?php echo $module_id;?>',
			type: 'post',
			dataType: 'json',
			data: $('#form-section input[type=\'text\'], #form-section input[type=\'hidden\'], #form-section input[type=\'radio\']:checked, #form-section input[type=\'checkbox\']:checked, #form-section select, #form-section textarea'),
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
//--></script> 
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
		
	});
</script>
  </div>

<?php echo $footer; ?>