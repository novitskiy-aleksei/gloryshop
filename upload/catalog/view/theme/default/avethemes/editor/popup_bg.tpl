<?php echo $header;?>
<!-- Body BEGIN -->
<body class="popup-icon padding responsive" style="padding: 20px;">
<div class="row">
<div class="col-lg-12 col-md-12">
 				<div class="tabs-heading">
                         <ul class="nav nav-tabs" id="tab_preset_patterns">
                            <li class="active"><a href="#tab_1_2" data-toggle="tab"><?php echo $text_not_transparent;?></a></li>
                            <li><a href="#tab_1_1" data-toggle="tab"><?php echo $text_transparent;?> </a></li>
                         </ul>
                         </div>
                         <div id="presets" class="tab-content">
                            <div class="tab-pane" id="tab_1_1">
                                    <div class="row preset-bg children-tooltip">
    <?php for ($i = 1; $i <= 100; $i++) { ?>
     <div class="col-md-3 col-sm-4 col-xs-6 col-xxs-12 margin-bottom-20">
                  <a title="<?php echo $i;?>" onClick="$('#presets a>div').removeClass('active');$(this).children().addClass('active');" class="ave_pattern" data-value="assets/global/img/patterns/<?php echo $i;?>.png">                  
                  <?php if($active_image==$i){
                      $activeclass='class="active"';
                  }else{                  
                      $activeclass='';
                  }?>
                  <div <?php echo $activeclass; ?> style="background-image:url('assets/global/img/patterns/<?php echo $i;?>.png'); background-repeat:repeat;"></div>
                  </a>
                  </div>
     <?php } ?>          
                                    </div>
                                    
                            </div>
                            
                            <div class="tab-pane active" id="tab_1_2">
                                <div class="row preset-bg children-tooltip">                                        
                                       
                                <?php for ($i = 101; $i <= 173; $i++) { ?>
    <div class="col-md-3 col-sm-4 col-xs-6 col-xxs-12  margin-bottom-20">
                  <a title="<?php echo $i;?>" onClick="$(this).parent().parent().children().children().children().removeClass('active');$(this).children().addClass('active');" class="ave_pattern" data-value="assets/global/img/patterns/<?php echo $i;?>.png">                  
                  <?php if($active_image==$i){
                      $activeclass='class="active"';
                  }else{                  
                      $activeclass='';
                  }?>
                  <div <?php echo $activeclass; ?> style="background-image:url('assets/global/img/patterns/<?php echo $i;?>.png'); background-repeat:repeat;"></div>
                  </a>
                  </div>
                  <?php } ?> 
                          
                                    </div>
                            </div>
                           
            </div>

</div><!--#content-->
</div><!--//end content row--> 

 
           
         
    <!-- Load javascripts at bottom, this will reduce page load time -->
  
    <script>
	// Call template init (optional, but faster if called manually)
	$(document).ready(function() { 
		$('#presets a').on('click', function() {
			parent.$('#<?php echo $field; ?>').attr('value', $(this).attr('data-value'));
			var vl = $(this.children).attr('style');
			parent.$('<?php echo $preview; ?>').attr('style', vl);
			
			parent.$('.modal-box').modal('hide');		
			parent.$('.modal-backdrop').remove();	
		});
		$('#presets a').live('dblclick', function() {
				parent.$('#modal-box .modal-header .close').trigger('click');
		});
		$(document).on('click', '#tab_preset_patterns a',function() {	
			localStorage.setItem("tab_preset_patterns", $(this).attr("href") );
		} );

		if( localStorage.getItem("tab_preset_patterns") !="undefined" ){
			$('#tab_preset_patterns a').each( function(){ 
				if( $(this).attr("href") ==  localStorage.getItem("tab_preset_patterns") ){
					$(this).trigger('click');
					return ;
				}
			} );
			
		}
	});
	
	</script>        
         <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>