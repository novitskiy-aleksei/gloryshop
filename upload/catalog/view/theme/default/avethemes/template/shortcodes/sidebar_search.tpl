<div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title; ?></h3>
    <div class="search_block">
        <div  class="widget_search">
            
            <input type="text" class="search_input" value="<?php echo $filter_name; ?>" placeholder="<?php echo $filter_name; ?>..." name="sidebar_search_<?php echo $module;?>" onclick="this.value = '';" onkeydown="this.style.color = '#333'"/>
            <button onclick="sidebarSearch('<?php echo $sections['type'];?>');" id="sidebar_search_<?php echo $module;?>" class="search_btn"><i class="fa fa-search"></i></button> 
            <div class="clear"></div>
        </div>
    </div>
           <a href="<?php echo ($sections['type']=='blog')?$advanced_blog:$advanced_product; ?>" style="float:left; margin:5px 0 0 5px;"><?php echo $text_advanced; ?></a>
          
	<script type="text/javascript">
		$('input[name=\'sidebar_search_<?php echo $module;?>\']').keydown(function(e) {
			if (e.keyCode == 13) {
				$('#sidebar_search_<?php echo $module;?>').trigger('click');
			}
		});
		function sidebarSearch(type) {
			if(type=='blog'){
				url = 'index.php?route=content/search';
			}else{
				url = 'index.php?route=product/search';
			}
			
			var filter_name = $('input[name=\'sidebar_search_<?php echo $module;?>\']').attr('value');
			
			if (filter_name) {
				url += '&search=' + encodeURIComponent(filter_name);
			}
		
			location = url;
		};
    </script>
</div>