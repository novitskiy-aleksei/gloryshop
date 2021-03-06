<link href="../assets/editor/plugins/jquery-ui/jquery-ui.css" type="text/css" rel="stylesheet" />  
<link href="../assets/editor/plugins/elfinder/css/elfinder.min.css" type="text/css" rel="stylesheet" />   
<script type="text/javascript" src="../assets/plugins/jquery-1.11.0.min.js"></script>

	   <script type="text/javascript" src="../assets/plugins/jquery-migrate-1.2.1.min.js"></script>
	   <script type="text/javascript" src="../assets/editor/plugins/jquery-ui/jquery-ui.min.js"></script>  	 
	   <script type="text/javascript" src="../assets/editor/plugins/elfinder/js/elFinder.js"></script>
	   <script type="text/javascript" src="../assets/editor/plugins/elfinder/js/ui/elfinder-ui.js"></script>	
	   <script type="text/javascript" src="../assets/editor/plugins/elfinder/js/commands/commands.js"></script>
	   <script type="text/javascript" src="../assets/editor/plugins/elfinder/js/i18n/elfinder.en.js"></script>	
	   <script type="text/javascript" src="../assets/editor/plugins/elfinder/js/proxy/elFinderSupportVer1.js"></script>
          
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
                'resize',	
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
            $cmd .="],";     
        ?> 
		<div id="elfinder" style="width:100%;min-height:450px;"></div>        
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
				 <?php } } ?>
                              ],
                 contextmenu: {
                     // navbarfolder menu
                     navbar: ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
                     // current directory menu
                     cwd: ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
                     // current directory file menu
                     files: [ 'getfile', '|', 'open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|','rm', '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info'
          	                    ]
                 },
				dirimage: '<?php echo $http_image;?>',
				getFileCallback: function (a) {			
				   var $value = decodeURIComponent(a.replace('<?php echo $http_image;?>',''));	
					 <?php if (!empty($field)){ ?>parent.$('#<?php echo $field;?>').attr('value', $value);
							var $input = parent.$('#<?php echo $field;?>');
							var obj_selector=$input.attr('data-selector');
							var obj_attr=$input.attr('data-attr');		
							if(obj_selector!=null&&obj_attr!='src'&&obj_attr!=null){
								parent.$("#preview_frame iframe").contents().find(obj_selector).css(obj_attr,'url(image/'+$value+')');	
							}
					 <?php }?>
					 <?php if (!empty($previewsrc)){ ?>
						parent.$('#<?php echo $previewsrc;?>').replaceWith('<img src="' + a + '" alt="" id="<?php echo $previewsrc; ?>" />');<?php } ?>
					 <?php if (!empty($thumb)){ ?>$.ajax({
						url: 'index.php?route=ave/image_manager_plus/thumb&token=<?php echo $token; ?>&image=' + encodeURIComponent($value),
						dataType: 'text',
						success: function(data) {									
							parent.$('#<?php echo $thumb;?>>img').attr('src', data);
						}
					});<?php } ?>
					parent.$('#modal-image-editor').modal('hide');
				}//getFileCallback
                });
         })	;	
//--></script>