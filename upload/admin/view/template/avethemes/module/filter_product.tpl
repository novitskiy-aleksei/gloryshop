<?php global $ave;  global $config; echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">        
      <button type="submit" form="form-filter_product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></span></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-filter_product" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="ave_product_filter_status" id="input-status" class="form-control">
                <?php if ($ave_product_filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
           <ul class="nav nav-tabs">
               <li class="active"><a href="#tab-manufacturer" data-toggle="tab"><?php echo $text_manufacturer?></a></li>
               <li><a href="#tab-options" data-toggle="tab"><?php echo $text_options?></a></li>
               <li><a href="#tab-attributes" data-toggle="tab"><?php echo $text_attributes?></a></li>
               <li><a href="#tab-more" data-toggle="tab"><?php echo $text_more?></a></li>
           </ul>
   
          <div class="tab-content">
   <div class="tab-pane active in" id="tab-manufacturer">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
			<tr>
				<td><?php echo $text_manufacturer?></td>
				<td>
					<?php foreach($display_options as $display_option) { ?>
                <label for="display_manufacturer<?php echo $display_option['value']?>">
                    <input type="radio" name="ave_product_filter_setting[display_manufacturer]" id="display_manufacturer<?php echo $display_option['value']?>" value="<?php echo $display_option['value']?>" <?php if(isset($setting['display_manufacturer']) && $display_option['value']==$setting['display_manufacturer']) echo 'checked="checked"';?> /><?php echo $display_option['name']?>
					</label><?php }?></td>
			</tr>
         </table>
         </div>
         </div>
   <div class="tab-pane fade" id="tab-options">  
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
			<?php foreach($options as $option){?>
			<tr>
				<td><?php echo $option['name']?></td>
				<td>
					<?php foreach($display_options as $display_option) { ?>
                <label for="display_option_<?php echo $display_option['value']?>_<?php echo $option['option_id'];?>">
                <input type="radio" name="ave_product_filter_setting[display_option_<?php echo $option['option_id']?>]"  id="display_option_<?php echo $display_option['value']?>_<?php echo $option['option_id'];?>"  value="<?php echo $display_option['value']?>"
						<?php if(isset($setting['display_option_' . $option['option_id']]) && $display_option['value']==$setting['display_option_' . $option['option_id']]) echo '  checked="checked"';?>/><?php echo $display_option['name']?></label>
					<?php }?> </td>
			</tr>
			<?php }?>
          </table> 
          </div>
   </div>
   <div class="tab-pane fade" id="tab-attributes">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
			<?php foreach($attributes as $attribute){?>
			<tr>
				<td><?php echo $attribute['name']?></td>
				<td>
					<?php foreach($display_options as $display_option) { ?>
                    <label for="display_attribute_<?php echo $display_option['value']?>_<?php echo $attribute['attribute_id']?>">
                <input type="radio" id="display_attribute_<?php echo $display_option['value']?>_<?php echo $attribute['attribute_id']?>" name="ave_product_filter_setting[display_attribute_<?php echo $attribute['attribute_id']?>]" value="<?php echo $display_option['value']?>"
						<?php if(isset($setting['display_attribute_' . $attribute['attribute_id']]) && $display_option['value']==$setting['display_attribute_' . $attribute['attribute_id']]) echo '  checked="checked"';?>/>
						<?php echo $display_option['name']?></label>
					<?php }?></td>
			</tr>
			<?php }?>
          </table> 
          </div>
     </div>     
          
   <div class="tab-pane fade" id="tab-more">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
			<tr>
				<td><?php echo $text_option_mode?></td>
				<td>	<label for="option_mode_or">
                <input id="option_mode_or" type="radio" name="ave_product_filter_setting[option_mode]"
						   value="or" <?php if(!isset($setting['option_mode']) || $setting['option_mode'] == 'or') echo " checked='checked'"?>>
				<?php echo $text_mode_or?></label>
                
                	<label for="option_mode_and">
					<input id="option_mode_and" type="radio" name="ave_product_filter_setting[option_mode]"
						   value="and" <?php if(isset($setting['option_mode']) && $setting['option_mode'] == 'and') echo " checked='checked'"?>>
				<?php echo $text_mode_and?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_attribute_mode?></td>
				<td><label for="attribute_mode_or"><input id="attribute_mode_or" type="radio" name="ave_product_filter_setting[attribute_mode]"
						   value="or" <?php if(!isset($setting['attribute_mode']) || $setting['attribute_mode'] == 'or') echo " checked='checked'"?>>
					
                    <?php echo $text_mode_or?></label>
                    
                    <label for="attribute_mode_and">
					<input id="attribute_mode_and" type="radio" name="ave_product_filter_setting[attribute_mode]"
						   value="and" <?php if(isset($setting['attribute_mode']) && $setting['attribute_mode'] == 'and') echo " checked='checked'"?>>
					<?php echo $text_mode_and?></label>
				</td>
			</tr>
            </table>
            </div>
              <div class="table-responsive">
                <table class="table table-bordered table-hover" style="display:none;">
			<tr>
				<td><?php echo $text_sku_display?></td>
				<td><input id="sku_display_yes" type="radio" name="ave_product_filter_setting[sku_display]"
						   value="1" <?php if(isset($setting['sku_display']) && $setting['sku_display'] == '1') echo " checked='checked'"?>>
					<label for="sku_display_yes"><?php echo $text_yes?></label>
					<input id="sku_display_no" type="radio" name="ave_product_filter_setting[sku_display]"
						   value="0" <?php if(!isset($setting['sku_display']) || $setting['sku_display'] == '0') echo " checked='checked'"?>>
					<label for="sku_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_model_display?></td>
				<td><input id="model_display_yes" type="radio" name="ave_product_filter_setting[model_display]"
						   value="1" <?php if(isset($setting['model_display']) && $setting['model_display'] == '1') echo " checked='checked'"?>>
					<label for="model_display_yes"><?php echo $text_yes?></label>
					<input id="model_display_no" type="radio" name="ave_product_filter_setting[model_display]"
						   value="0" <?php if(!isset($setting['model_display']) || $setting['model_display'] == '0') echo " checked='checked'"?>>
					<label for="model_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_brand_display?></td>
				<td><input id="brand_display_yes" type="radio" name="ave_product_filter_setting[brand_display]"
						   value="1" <?php if(isset($setting['brand_display']) && $setting['brand_display'] == '1') echo " checked='checked'"?>>
					<label for="brand_display_yes"><?php echo $text_yes?></label>
					<input id="brand_display_no" type="radio" name="ave_product_filter_setting[brand_display]"
						   value="0" <?php if(!isset($setting['brand_display']) || $setting['brand_display'] == '0') echo " checked='checked'"?>>
					<label for="brand_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_location_display?></td>
				<td><input id="location_display_yes" type="radio" name="ave_product_filter_setting[location_display]"
						   value="1" <?php if(isset($setting['location_display']) && $setting['location_display'] == '1') echo " checked='checked'"?>>
					<label for="location_display_yes"><?php echo $text_yes?></label>
					<input id="location_display_no" type="radio" name="ave_product_filter_setting[location_display]"
						   value="0" <?php if(!isset($setting['location_display']) || $setting['location_display'] == '0') echo " checked='checked'"?>>
					<label for="location_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_upc_display?></td>
				<td><input id="upc_display_yes" type="radio" name="ave_product_filter_setting[upc_display]"
						   value="1" <?php if(isset($setting['upc_display']) && $setting['upc_display'] == '1') echo " checked='checked'"?>>
					<label for="upc_display_yes"><?php echo $text_yes?></label>
					<input id="upc_display_no" type="radio" name="ave_product_filter_setting[upc_display]"
						   value="0" <?php if(!isset($setting['upc_display']) || $setting['upc_display'] == '0') echo " checked='checked'"?>>
					<label for="upc_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_stock_display?></td>
				<td><input id="stock_display_yes" type="radio" name="ave_product_filter_setting[stock_display]"
						   value="1" <?php if(isset($setting['stock_display']) && $setting['stock_display'] == '1') echo " checked='checked'"?>>
					<label for="stock_display_yes"><?php echo $text_yes?></label>
					<input id="stock_display_no" type="radio" name="ave_product_filter_setting[stock_display]"
						   value="0" <?php if(!isset($setting['stock_display']) || $setting['stock_display'] == '0') echo " checked='checked'"?>>
					<label for="stock_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
		</table>
        </div>
        </div>
        </div><!--//tab-content --> 
        
        </form>
      </div>
    </div>
  </div></div>
<?php echo $footer; ?>