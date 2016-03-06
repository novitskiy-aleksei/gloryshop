
 <input type="hidden" name="display" value="<?php echo $element;?>"/>  
     <table class="table table-bordered table-hover">
              
               <tr>
               
               <td width="150" valign="top"><?php echo $entry_file;?> </td><td>
                      <p><?php echo $entry_choose_download; ?></p>
            <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_download" value="" class="form-control" />
                </div>
                <div class="autosuggest_content" id="filter_download_result">            
                </div>
                <div id="free_file" class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php if(!empty($download_datas)) {   ?>
                <?php foreach ($download_datas as $download) {             
                	 $class = ($class=='even' ? 'odd' : 'even'); 
                     ?>                     
                    <div id="free_file<?php echo $download['download_id']; ?>" class="<?php echo $class; ?>"><?php echo $download['name']; ?> <img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                      <input type="hidden" name="sections[free_file][]" value="<?php echo $download['download_id']; ?>" />
                    </div>
                    <?php } ?>
                    <?php } ?>
              </div><!-- //scrollbox--> 
              
                  </td></tr>
               <tr>
               
                  
                  </table>
                  
                  
  <script type="text/javascript">
$(document).ready(function() {
  $('input[name=\'filter_download\']').autocomplete({
		delay: 0,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=ave/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(data) {		
						var from= 'filter_download_result';
						var to='free_file';
						$('#'+from+' div').remove();			
					for (i = 0; i < data.length; i++) {
						var value=data[i]['download_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="sections[free_file][' + value + ']" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');	
		$('#'+from+' div:even').attr('class', 'odd');	
		$('#'+from+' div:odd').attr('class', 'even');								
					}
				}
			});
			
		}
	});
});
  </script>