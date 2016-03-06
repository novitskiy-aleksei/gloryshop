<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $heading_title; ?></h4>
    </div>
    <div class="modal-body" style="padding:2px;overflow:hidden;">
    
<?php $insertfiles=(isset($_GET['bulk_insert'])==true)?"'insertfiles',":"'getfile',"; ?>
	 <?php       
     $image_command=(!empty($image_manager_plus_command))?$image_manager_plus_command:array();
            $commands=array(
                'mkdir',	
                'mkfile',	
                'upload',	
                'reload',	
                'up',	
                'download',	
                'rm',	
                'duplicate',	
                'rename',	
                'copy',	
                'cut',	
                'paste',	
                'edit',	
                'extract',	
                'archive',	
                'view',	
                'sort',	
                'search'
                );  
           $cmd = "commands: [";
            if($user_group_id){
                 foreach ($commands as $command=>$value) { 
                     if(!empty($image_command[$user_group_id][$command])){
                        $cmd .="'".$command."',";
                     }
                  } 
              }
            $cmd .=$insertfiles;
            $cmd .="],";     
        ?> 
		<div id="elfinder" style="width:100%;"></div>        
  </div><!--//modal-body --> 
  </div>
</div>
<script type="text/javascript"><!--
      $(document).ready(function() {
             $('#elfinder').elfinder({
                 url: 'index.php?route=ave/image_manager_plus/popup&token=<?php echo $token; ?>',
                 lang: 'en',
                 resizable: true,
                 commands: [<?php if($user_group_id){
				 	foreach ($commands as $command) { ?>
				  <?php echo (!empty($image_command[$user_group_id][$command]))?'\''.$command.'\',':''; ?>
				 <?php } } ?><?php echo $insertfiles;  ?> 
                              ],
                 contextmenu: {
                     // navbarfolder menu
                     navbar: ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
                     // current directory menu
                     cwd: ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
                     // current directory file menu
                     files: [<?php echo $insertfiles;?> '|', 'open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|','rm', '|', 'edit', 'rename', '|', 'archive', 'extract', '|', 'info'
          	                    ]
                 },
			dirimage: '<?php echo $http_image;?>',
				getFileCallback: function (a) {			
					 <?php if (isset($_GET['target'])==true){
						 $field = $_GET['target']; ?>
						   var b = decodeURIComponent(a.replace('<?php echo $http_image;?>',''));
							$('#<?php echo $field;?>').attr('value', b);
							 <?php if (isset($_GET['thumb'])==true){
								 $thumb = $_GET['thumb']; ?>
									$.ajax({
											url: 'index.php?route=ave/image_manager_plus/thumb&token=<?php echo $token; ?>&image=' + encodeURIComponent(b),
											dataType: 'text',
											success: function(data) {			
												$('#<?php echo $thumb;?>>img').attr('src', data);
											}
										});
						
							<?php } ?>
					<?php }?>
					<?php 	$bulk_insert = isset($_GET['bulk_insert'])?true:false;
							$thumb_insert = isset($_GET['thumb'])?true:false;
							$target_insert = isset($_GET['target'])?true:false;
					 if ($bulk_insert==false&&$thumb_insert==false&&$thumb_insert==false){ ?>
							var range, sel = window.getSelection(); 
							if (sel.rangeCount) { 
								var img = document.createElement('img');
								img.class = 'img_insert';
								img.src = a;
								range = sel.getRangeAt(0); 
								range.insertNode(img); 	
							} 
					<?php }?>
						parent.$('#modal-image').modal('hide');
						parent.$('.modal-backdrop').remove();
						parent.$('#modal-image').remove();
				}//getFileCallback
                });
         })	;	
//--></script>