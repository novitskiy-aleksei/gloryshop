<?php global $ave;  global $config; echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">        
        <button type="submit" form="form-author" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i></button>
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
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
     
  <?php if(!$config->get('ave_confirm_installed')){?>  
   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php }else{?>    
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-author" name="form-author" class="form-horizontal">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_general" data-toggle="tab"><?php echo $text_general;?> </a></li>
        <li><a href="#tab_social" data-toggle="tab"><?php echo $text_socials;?> </a></li>
      
      </ul>
                 <div class="tab-content">
      <div id="tab_general" class="tab-pane active">
      <input type="hidden" name="author_id" value="<?php echo $author_id;?>" />
                  
              <div class="form-group">
              <label class="col-sm-3"><?php echo $entry_author; ?></label>
                <div class="col-sm-9">
                <input id="author" type="text" name="author" value="<?php echo $author; ?>" class="form-control" />
                <?php if ($error_author) { ?>
                <span class="text-danger"><?php echo $error_author; ?></span>
                <?php } ?>
                  </div>
                  </div><!--//form-group --> 
           <div class="form-group">
              <label class="col-sm-3"><?php echo $entry_keyword; ?></label>
                <div class="col-sm-9"><input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>"  class="form-control" />
              <?php if ($error_keyword) { ?>
               <br><span class="text-danger"><?php echo $error_keyword; ?></span>
                <?php } ?>
                  </div>
                  </div><!--//form-group -->        
              
              <div class="form-group">
              <label class="col-sm-3"><?php echo $entry_image; ?></label>
                <div class="col-sm-9"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" /></a>
                  </div>
                  </div><!--//form-group --> 
                  
              <div class="form-group">
              <label class="col-sm-3"><?php echo $entry_competence; ?></label>
                <div class="col-sm-9"><input id="competence" type="text" name="competence" value="<?php echo $competence; ?>" class="form-control" />
                <?php if ($error_competence) { ?>
                <span class="text-danger"><?php echo $error_competence; ?></span>
                <?php } ?>
                  </div>
                  </div><!--//form-group --> 
         
              <div class="form-group">
              <label class="col-sm-3"><?php echo $entry_description; ?></label>
                <div class="col-sm-9"><textarea class="form-control" name="author_description" id="author_description"/><?php echo $author_description; ?></textarea>
                <?php if ($error_description) { ?>
                  <span class="text-danger"><?php echo $error_description; ?></span>
                  <?php } ?>
                  </div>
                  </div><!--//form-group --> 
              <div class="form-group">
              <label class="col-sm-3"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-9">
                <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                  </div>
                  </div><!--//form-group --> 
              
          </div>
          
      <div id="tab_social" class="tab-pane fade">
       <table id="social"  class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="left" style="width:300px;"><?php echo $column_icon; ?></td>
              <td class="left" style="width:250px;"><?php echo $text_title; ?></td>
              <td class="left" style="width:400px;"><?php echo $text_link; ?></td>
              <td class="left"><?php echo $text_new_tab; ?></td>
              <td class="right"> </td>
            </tr>
          </thead>
          <?php $social_row = 0; ?>
          <?php 
          if(!empty($socials)){
          foreach ($socials as $social) { ?>
          <tbody id="social-row<?php echo $social_row; ?>">
            <tr>
              <td class="left" style="width:200px;">
              <a class="icon-preview">
    <i class="<?php echo $social['social']; ?>" id="social_icon_thumb<?php echo $social_row; ?>"></i>
   <input type="hidden" name="socials[<?php echo $social_row; ?>][social]" value="<?php echo $social['social'];?>" id="social_icon<?php echo $social_row; ?>" /></a>
    
    
 
                
              </td> 
              <td class="left" style="width:250px;"><input type="text" name="socials[<?php echo $social_row; ?>][title]" class="form-control title<?php echo $social_row; ?>" value="<?php echo $social['title']; ?>" style="width:98%;"/>              
                <?php if (isset($error_title[$social_row])) { ?><br/> 
                <span class="text-danger"><?php echo $error_title[$social_row]; ?></span>
                <?php } ?>
                </td>  
              <td class="left" style="width:400px;"><input type="text" name="socials[<?php echo $social_row; ?>][href]" class="form-control title<?php echo $social_row; ?>" value="<?php echo $social['href']; ?>" style="width:98%;"/>              
                <?php if (isset($error_link[$social_row])) { ?><br/> 
                <span class="text-danger"><?php echo $error_link[$social_row]; ?></span>
                <?php } ?>
                </td>      
              <td class="left"><select name="socials[<?php echo $social_row; ?>][target]" class="form-control">                  
                  <option value="_blank" <?php if ($social['target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                  <option value="_self" <?php if ($social['target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>                  
                </select></td>       
              <td class="right"><a onclick="$('#social-row<?php echo $social_row; ?>').remove();" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i> <?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $social_row++; ?>
          <?php } ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="right"><a onclick="addSocial();" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> <?php echo $button_add; ?></a></td>
            </tr>
          </tfoot>
        </table>
          </div>
          </div>
      </form>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('#author_description').summernote({
	height: 300
});
//--></script> 
<script type="text/javascript"><!--
var social_row = <?php echo $social_row; ?>;

function addSocial() {	
	html  = '<tbody id="social-row' + social_row + '">';
	html += '<tr>';
	html += '<td class="left" style="width:200px;">';	
	
    html += '<a class="icon-preview">';
    html += '<i class="fa fa-rocket" id="social_icon_thumb' + social_row + '"></i>';
    html += '<input type="hidden" name="socials[' + social_row + '][social]" value="fa fa-facebook" id="social_icon' + social_row + '" /></a> ';
	
	
	html += '</td>';
	html += '    <td class="left" style="width:250px;"><input type="text" name="socials[' + social_row + '][title]" class="form-control title' + social_row + '" value="" style="width:98%;"/></td>';
	html += '    <td class="left" style="width:400px;"><input type="text" name="socials[' + social_row + '][href]" class="form-control title' + social_row + '" value="" style="width:98%;"/></td>';
	html += '    <td class="left"><select name="socials[' + social_row + '][target]" class="form-control">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><a onclick="$(\'#social-row' + social_row + '\').remove();" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i> <?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#social tfoot').before(html);
	Plus.initNav('#social-row'+social_row);
	social_row++;
}
//--></script> 

<?php }?>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>