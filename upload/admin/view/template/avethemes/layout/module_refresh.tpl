<?php foreach ($extensions as $extension) { ?>
    <div class="ds_heading"> <?php echo strip_tags($extension['name']); ?>
    <div class="btn-group pull-right">
    		<?php if($extension['add']){?>
                <a class="btn btn-xs btn-edit" href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                <?php }else{?>
                <a class="btn btn-xs btn-edit" href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a>
                <?php } ?>
          </div>
    </div>
    <div class="ds_content drag_area">
                <?php if($extension['quick_add']){?> 
                <div class="module-block quick_add" data-href="<?php echo $extension['quick_href']; ?>" data-code="0" data-title="<?php echo strip_tags($extension['name']); ?>">
                 <a data-toggle="tooltip" title="<?php echo $help_add_default;?>"><i class="fa fa-arrows"></i> <?php echo $text_add_default;?></a>
           		</div>       
                <?php } ?>  
                
    <?php foreach ($extension['module'] as $module) { ?>    
            <div class="module-block" data-code="<?php echo $module['code']; ?>" data-title="<?php echo strip_tags($extension['name']); ?>" <?php echo ($module['thumb'])?'data-thumb="'.$module['thumb'].'"':''; ?>>
                <?php echo strip_tags($module['name']); ?>    
           <a class="btn btn-sm btn-edit" href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
           		</div>                 
    <?php } ?>     
    </div><!--ds_content --> 
<?php } ?>                