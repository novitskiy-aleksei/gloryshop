 		<table class="table table-bordered table-hover">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="testimonial-v1" <?php echo ($display=='testimonial-v1')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option> 
    <option value="testimonial-v2" <?php echo ($display=='testimonial-v2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option> 
            </select>
                  </td></tr>
              <tr>
               
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/testimonial-v1.png" class="display otp-testimonial-v1"/>
                <img src="../assets/editor/img/mockup/testimonial-v2.png" class="display otp-testimonial-v2"/>
                </div>
                  </td>
                  </tr>
                  
                  <tr>
               <td width="150"><?php echo $text_limit;?></td>
               <td>
              <input type="text" name="sections[limit]" value="<?php echo $sections['limit']; ?>" id="input-limit" class="form-control" /> 
                  </td>
                  </tr>
                  <tr class="display otp-testimonial-v2">
               <td width="150"><?php echo $text_shown;?></td>
               <td>
              <select name="sections[carousel_limit]" id="input-carousel_limit" class="form-control">
                <option value="2" <?php if ($sections['carousel_limit']=='2') { ?>selected="selected"<?php } ?>>2</option>
                <option value="3" <?php if ($sections['carousel_limit']=='3') { ?>selected="selected"<?php } ?>>3</option>
                <option value="4" <?php if ($sections['carousel_limit']=='4') { ?>selected="selected"<?php } ?>>4</option>
              </select>
                  </td>
                  </tr>
                 
                  <tr class="display otp-testimonial-v2"> 
               <td width="150"><?php echo $entry_num_row;?></td>
               <td>
              <select name="sections[num_row]" class="form-control">  
                  <option value="1" <?php echo($sections['num_row']=='1')?'selected="selected"':''; ?>>1</option>
                  <option value="2" <?php echo($sections['num_row']=='2')?'selected="selected"':''; ?>>2</option>
                  <option value="3" <?php echo($sections['num_row']=='3')?'selected="selected"':''; ?>>3</option>            
                </select>
                  </td>
                  </tr>
                  
                  
                    <tr>
                  <td><?php echo $entry_testimonial_type;?></td><td>
              <select name="sections[type]" class="form-control tr_change" onchange="Plus.activeObj('testimonial_type',this.options[this.selectedIndex].value);">
                  <option value="random" <?php if ($sections['type']=='random') { ?>selected="selected"<?php } ?>><?php echo $text_random; ?></option> 
                  <option value="custom" <?php if ($sections['type']=='custom') { ?>selected="selected"<?php } ?>><?php echo $text_custom; ?></option>                
                </select>      
                    </td>
                </tr>	 
                
                                  
               <tr class="testimonial_type otp-custom">
                  <td><?php echo $text_custom;?></td><td>
                                  <p><?php echo $entry_choose_testimonial; ?></p>
            <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_testimonial_input" value="" class="form-control" />
                </div>
                <div class="autosuggest_content" id="filter_testimonial_result">            
                </div>
                <div id="custom_testimonial" class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php if(!empty($testimonial_datas)) {   ?>
                <?php foreach ($testimonial_datas as $testimonial) {             
                	 $class = ($class=='even' ? 'odd' : 'even'); 
                     ?>                     
                    <div id="custom_testimonial<?php echo $testimonial['testimonial_id']; ?>" class="<?php echo $class; ?>"><?php echo $testimonial['customer_name']; ?> <img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                      <input type="hidden" name="sections[custom_testimonial][<?php echo $testimonial['testimonial_id']; ?>]" value="<?php echo $testimonial['testimonial_id']; ?>" />
                    </div>
                    <?php } ?>
                    <?php } ?>
              </div><!-- //scrollbox--> 	
                    </td>
                </tr>	
    
             </table>
             
  <script type="text/javascript">
  $('input[name=\'filter_testimonial_input\']').autocomplete({
		delay: 0,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=ave/testimonial/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(data) {		
						var from= 'filter_testimonial_result';
						var to='custom_testimonial';
						$('#'+from+' div').remove();			
					for (i = 0; i < data.length; i++) {
						var value=data[i]['testimonial_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="sections[custom_testimonial][' + value + ']" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');	
		$('#'+from+' div:even').attr('class', 'odd');	
		$('#'+from+' div:odd').attr('class', 'even');							
					}
				}
			});
			
		}
	});
  </script>