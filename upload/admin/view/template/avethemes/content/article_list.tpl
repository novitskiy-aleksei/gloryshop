<?php global $config; echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">   
      <a onclick="location = '<?php echo $insert; ?>'" class="btn btn-success btn-sm"><span><i class="fa fa-plus"></i> <?php echo $button_add; ?></span></a>
       <a onclick="$('#form').attr('action', '<?php echo $copy; ?>').submit();" class="btn btn-default btn-sm"><i class="fa fa-copy"></i> <?php echo $button_copy; ?></a>
      <a onclick="$('#form').submit();" class="btn btn-danger btn-sm"><span><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></span></a>
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
    
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="row">
      <div class="col-sm-3 col-md-3 col-xs-12">
      <div class="heading-bar"><?php echo $button_filter;?></div>
      
        <div class="well clearfix">
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""><?php echo $column_name; ?></label>
                <div class="col-sm-12">
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" class="form-control"/>
                </div>
              </div><!-- form-group-->
              
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""><?php echo $column_category; ?></label>
                <div class="col-sm-12">
                
              <select name="filter_content_category"  onchange="filter()" class="form-control">
              <option value=""></option>
              <?php foreach ($categories as $category){?>
                <?php if ($category['type']=='category'){?>
                    <?php if ($category['content_id']==$filter_content_category){?>
                      <option value="<?php echo $category['content_id'];?>" selected="selected"><?php echo $category['name'];?> <?php echo $category['total'];?></option>
                    <?php } else{?>
                      <option value="<?php echo $category['content_id'];?>"><?php echo $category['name'];?> <?php echo $category['total'];?></option> 
                    <?php }?>
                <?php }?>
              <?php }?>
              </select>
                </div>
              </div><!-- form-group-->
           
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""><?php echo $column_service; ?></label>
                <div class="col-sm-12">
                
              <select name="filter_service_group"  onchange="filter()" class="form-control">
              <option value=""></option>
              		<?php foreach ($services as $service){?>
                    <?php if ($service['service_id']==$filter_service_group){?>
                      <option value="<?php echo $service['service_id'];?>" selected="selected"><?php echo $service['name'];?> <?php echo $service['total'];?></option>
                    <?php } else{?>
                      <option value="<?php echo $service['service_id'];?>"><?php echo $service['name'];?> <?php echo $service['total'];?></option> 
                    <?php }?>
              <?php }?>
              </select>
                </div>
              </div><!-- form-group-->
           
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""><?php echo $column_author; ?></label>
                <div class="col-sm-12">
                <select name="filter_author" class="form-control" onchange="filter()">
                <option value=""></option>
                <?php foreach ($authors as $author){?>
                <?php if ($author['author_id']==$filter_author){?>
                <option value="<?php echo $author['author_id'];?>" selected="selected"><?php echo $author['author'];?></option>
                <?php } else{?>
                <option value="<?php echo $author['author_id'];?>"><?php echo $author['author'];?></option>
                <?php }?>
                <?php }?>
              </select>
                
                </div>
              </div><!-- form-group-->
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""><?php echo $column_status; ?></label>
                <div class="col-sm-12">
                <select name="filter_status" class="form-control" onchange="filter()">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
                </div>
              </div><!-- form-group-->
                
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""><?php echo $column_date_added; ?></label>
                <div class="col-sm-12">
                <input type="text" name="filter_date" value="<?php echo $filter_date;?>"  class="date form-control" onchange="filter()" onclick="this.value = '';"/>
                </div>
              </div><!-- form-group-->
              
            
             <div class="form-group">
                <label class="col-sm-7 control-label" for=""></label>
                <div class="col-sm-12">
                <a onclick="filter();" class="btn btn-primary btn-sm pull-right"><span><i class="fa fa-search"></i> <?php echo $button_filter; ?></span></a>
                </div>
              </div><!-- form-group-->
              
            
        </div>
      </div><!-- //col--> 
      <div class="col-md-9 col-sm-9 col-xs-12">
      	<div style="overflow:hidden">
         <div class="table-responsive" >
            <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td width="1"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'pd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
                <td class="left hidden-sm hidden-xs"><?php echo $column_category; ?></td>
              <td class="left hidden-xs"><?php if ($sort == 'p.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
                 <td class="left hidden-sm hidden-xs"><?php if ($sort == 'p.sort_order') { ?>
                <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_order; ?>"><?php echo $column_sort; ?></a>
                <?php } ?></td>
                <td class="left hidden-sm hidden-xs" width="1"><?php if($sort=='p.date_added'){?>
                <a href="<?php echo $sort_date;?>" class="<?php echo strtolower($order);?>"><?php echo $column_date_added; ?></a>
                <?php }else{?>
                <a href="<?php echo $sort_date;?>">Date Added</a>
                <?php }?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
         
            <?php if ($articles) { ?>
            <?php foreach ($articles as $article) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($article['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" />
                <?php } ?></td>
              <td><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" style="padding: 1px; margin:3px 0; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><?php echo $article['name']; ?>
              <br/><span class="help"><?php echo $article['type']; ?></span>
              </td>
              
                <td class="left hidden-sm hidden-xs" style="padding:5px;"><div class="filterbox"><?php foreach ($categories as $category){?>
                <?php if (in_array($category['content_id'], $article['category'])){?>
                <?php echo $category['name'];?><br>
                <?php }?> <?php }?></div>
				</td>
                
                
              <td class="left hidden-xs"><?php echo $article['status']; ?></td>
              <td class="left hidden-sm hidden-xs"><?php echo $article['sort_order']; ?></td>
              <td class="left hidden-sm hidden-xs"><?php echo $article['date'];?></td>
              <td class="right">
              <div class="buttons">
              <?php foreach ($article['action'] as $action) { ?>
                 <a href="<?php echo $action['href']; ?>" class="btn btn-primary btn-sm" target="<?php echo $action['target']; ?>"><?php echo $action['text']; ?></a> 
                <?php } ?>
                </div>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
</div>
</div>
 </div><!-- //col--> 
 </div><!-- //row--> 
    </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div><!--row --> 
      </div><!--panel-body --> 
    </div><!--panel --> 
    <?php } ?>
  </div><!--container-fluid --> 
</div><!--#content -->
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=ave/article&token=<?php echo $token; ?>';	
	var filter_name = $('input[name=\'filter_name\']').attr('value');	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}	
	/*filter_content_category*/
	var filter_content_category = $('select[name=\'filter_content_category\']').attr('value');
	if (filter_content_category) {url += '&filter_content_category=' + encodeURIComponent(filter_content_category);	}
	/*filter_service_group*/
	var filter_service_group = $('select[name=\'filter_service_group\']').attr('value');
	if (filter_service_group) {url += '&filter_service_group=' + encodeURIComponent(filter_service_group);	}
	/*author*/
	var filter_author = $('select[name=\'filter_author\']').attr('value');
	if (filter_author) {url += '&filter_author=' + encodeURIComponent(filter_author);}	
	/*date*/
	var filter_date = $('input[name=\'filter_date\']').attr('value');
	if (filter_date) {url += '&filter_date=' + encodeURIComponent(filter_date);}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/article/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['article_id']
					}
				}));
			}
		});
	}, 
	select: function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
						
		return false;
	}
});
//--></script> 
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>