<?php global $ave;  global $config;?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
    <div class="container-fluid">
    
      <div class="pull-left">   
     <?php echo $shortcut_group;?>
      </div>
    </div>
        <div class="container-fluid">
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
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                <div class="row">
                	<div class="col-md-3 col-sm-12 col-xs-12">
                        <div id="left-pane">
                            <div id="left-pane-toolbar" style="height: 40px; width: 100%; padding-right: 6px;">
                            
                                <button onclick="onCollapseTree(); return false;" type="button" style="float: left;" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_collapse; ?>"><i class="fa fa-angle-double-up"></i></button>
                                <button onclick="onExpandTree(); return false;" type="button" style="float: left; margin-left: 6px;" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_expand; ?>"><i class="fa fa-angle-double-down"></i></button>
                                
                 <a class="btn btn-sm btn-default pull-right" id="add_cate_btn" data-toggle="tooltip" data-original-title="Add Category" style="margin-left:15px;" onclick="addNewCategory();"><i class="fa fa-plus"></i></a>
                                <button id="btnCategoryEdit" onclick="onCategoryDelete(); return false;" type="button" style="float: right;"  data-toggle="tooltip" class="btn btn-sm btn-danger" title="<?php echo $button_category_delete; ?>"><i class="fa fa-trash"></i></button>
                            </div>
                            <div id="jstree"></div>
                        </div><!--//left-pane --> 
                    </div>
                	<div class="col-md-9 col-sm-12 col-xs-12">
                        <div id="products-list" style="overflow:hidden;">
                            <div id="category-form"></div>
                        </div><!--//products-list --> 
                     </div>
                   <!--//row --> 
                </div>
            </div>
        </div>
    </div>
	<?php } ?>
</div>
<script type="text/javascript"><!--
$(function () {

    $('#jstree')
            .jstree({
                'core' : {
                    'check_callback' : function(operation, node, node_parent, node_position, more) {
                        if (operation === 'move_node') {
                            return false;
                        }
                    },
                    'multiple' : false,
                    'data' : {
                        'url' : 'index.php?route=ave/category/tree&token=<?php echo $token; ?>',
                        'data' : function (node) {
                            return { 'id' : node.id, 'operation' : 'get_node' };
                        }
                    }},
                'plugins' : ['wholerow']
            }
    )
            .on('refresh.jstree', function () {
                $('#jstree').jstree("rename_node", "0", "<?php echo $text_home; ?>");
                if (window.open_node) {
                    window.open_node = false;
                    var selectedNode = $('#jstree').jstree(true).get_selected(false);
                    if (selectedNode.length == 1)
                        $('#jstree').jstree("open_node", selectedNode);
                }
            })
            .on('ready.jstree', function () {
                $('#jstree').jstree("open_node", "0");
                $('#jstree').jstree("rename_node", "0", "<?php echo $text_home; ?>");
                $('#jstree').jstree("select_node", "0");
            })
            .on("changed.jstree", function (e, data) {

                var obj = null;
                var root = true;
                if (data.node !== undefined) {
                    obj = data.node.data;
                    root = data.node.id == "0";
                }
                checkUIState(obj, data.selected.length, root);
                if (obj != null && data.selected.length == 1) {
					$('#add_cate_btn').attr('data-original-title','Add child category to '+data.node.text);		
                   getCategoryForm();
                }
            }) ;

    var selectedNode = $('#jstree').jstree(true).get_selected(false);
    checkUIState(null, selectedNode.length, true);

});

function addNewCategory(){
  	getCategoryForm(1);
}
function onExpandTree() {
    $('#jstree').jstree("open_all");
}

function onCollapseTree() {
    $('#jstree').jstree("close_all");
}

function onCategoryEdit() {
    var selectedNode= $('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length == 1) {
        doCategoryEdit(selectedNode);
    }
}

function setButtonState(selector, state) {
    if (state) {
        $(selector).removeClass('disabled').addClass('active');
    }
    else {
        $(selector).removeClass('active').addClass('disabled');
    }
}
function checkUIState(data, selectedCount, root) {
    if (root) {
        setButtonState('#btnCategoryEdit', false);
        return;
    }
    var status = 0;
    if (data != null)
        status = parseInt(data.status);
    setButtonState('#btnCategoryEdit', selectedCount == 1);
}

function applyForm(){
	$('.summernote').each(function () {
    	var $textArea = $(this);
            $textArea.val($(this).code());
       
	});
	$.ajax({
			url: 'index.php?route=ave/category/apply&token=<?php echo $token;?>',
			type: 'post',
			dataType: 'json',
			data: $('#form-category input[type=\'text\'], #form-category input[type=\'hidden\'], #form-category input[type=\'radio\']:checked, #form-category input[type=\'checkbox\']:checked, #form-category select, #form-category textarea'),
			beforeSend: function() {
			},
			complete: function() {					
			},
			success: function(json) {	
				$('#jstree').jstree("refresh");				
				if (json['error']) {
						$('.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				} 
				if (json['success']) {	
					$('.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
	var selectedNodes = $('#jstree').jstree(true).get_selected(false);
	var node = (selectedNodes.length == 1) ? node = selectedNodes[0] : 0;		
					
				}
			}
	});
}

function onCategoryDelete(){
	if(confirm('Delete/Uninstall cannot be undone! Are you sure want to delete this selected category and sub category?') ){
		var selectedNodes = $('#jstree').jstree(true).get_selected(false);
		var node = (selectedNodes.length == 1) ? node = selectedNodes[0] : 0;
		$.ajax({
			url: 'index.php?route=ave/category/delete&token=<?php echo $token;?>&content_id='+node,
			dataType: 'json',		
			success: function(json) {				
				if (json['error']) {
						$('.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				} 
				if (json['success']) {	
					$('.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					$('#jstree').jstree("refresh");				
					
				}
			}
		});
	}
}
function getCategoryForm(is_new){
	var selectedNodes = $('#jstree').jstree(true).get_selected(false);
	var node = (selectedNodes.length == 1) ? node = selectedNodes[0] : 0;
	var form_url = 'index.php?route=ave/category/form&token=<?php echo $token;?>';
	if (is_new==1) {
		form_url += '&parent_id=' + node;
	}else{
		form_url += '&content_id=' + node;
	}
	/**/
	$.ajax({
		url: form_url,
		dataType: 'html',		
		success: function(html) {
			$('#category-form').html(html);
			// Override summernotes image manager
			$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');
			$('.nav-tabs').each(function () {
				$(this).find('a:first').tab('show');
			   
			});
			$('.tr_change').trigger('change');	
			$('.tr_click').trigger('click');
			Plus.init();
		}
	}); 
}
//--></script>

<?php echo $footer; ?>