 <!-- BEGIN CALL TO ACTION BLOCK --> 
 <?php
$btn_class = 'bg-base';
$class_style = str_replace('action_','',$display);
        if(strpos($class_style, 'boxed_') !== false){
            $class_style = $class_style.' container';
        }
        if(strpos($class_style, '_colored') !== false||strpos($class_style, 'full_gray') !== false){
            $btn_class = '';
        }

 ?>
 <?php if($display=='action_full_bg'){?>
 <section class="section bg_fixed <?php echo $bgmode;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
		<div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
			<div class="content <?php echo $heading_align;?> large_spacer clearfix">
				<div class="heading_title upper light">
              <?php if(isset($sections['title'][$language_id])){?>
					<h3><?php echo $sections['title'][$language_id];?></h3>
             <?php } ?>
				</div>
                 <?php if(!empty($sections['description'][$language_id])){?>
                <div class="main_desc">
			<?php echo html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8');?>
           	 </div>
             <?php } ?>
             
				<a href="<?php echo $sections['btn_href'];?>" target="<?php echo $sections['btn_target'];?>" class="btn_a">
                    <span><i class="in_left <?php echo $sections['icon'];?>"></i>
                    
             <?php if(isset($sections['btn_title'][$language_id])){?>
			<span><?php echo $sections['btn_title'][$language_id];?></span>
             <?php } ?>
                    
                 <i class="in_right <?php echo $sections['icon'];?>"></i></span>
				</a>
			</div>
		</div>
	</section>

 <?php } else if($class_style=='classic_white'){?>
 
 <div class="call_to_action <?php echo (empty($sections['description'][$language_id]))?'not_desc':'';?> <?php echo $class_style;?>">
		    <div class="content clearfix <?php echo $heading_align;?>">
              <?php if(isset($sections['title'][$language_id])){?>
			    <h3 class=""><?php echo html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8');?></h3>
             <?php } ?>
            <?php if(isset($sections['description'][$language_id])){?>
                <span class="intro_text">
			<?php echo html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8');?>
           	 </span>
             <?php } ?>
              
        		 <a href="<?php echo $sections['btn_href'];?>" target="<?php echo $sections['btn_target'];?>" class="btn_a <?php echo $btn_class;?> btn_space">
                    <span><i class="in_left <?php echo $sections['icon'];?>"></i>
                    
             <?php if(isset($sections['btn_title'][$language_id])){?>
			<span><?php echo $sections['btn_title'][$language_id];?></span>
             <?php } ?>
                    
                 <i class="in_right <?php echo $sections['icon'];?>"></i></span>
                </a>
             
		    </div>
		</div>
        
        
 <?php }else{?>
 <div class="call_to_action <?php echo (empty($sections['description'][$language_id]))?'not_desc':'';?> <?php echo $class_style;?>">
		    <div class="content clearfix <?php echo $heading_align;?>">
              <?php if(isset($sections['title'][$language_id])){?>
			    <h3 class=""><?php echo html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8');?></h3>
             <?php } ?>
 		<?php if($class_style !='full_banner_colored'){?> 
        		 <a href="<?php echo $sections['btn_href'];?>" target="<?php echo $sections['btn_target'];?>" class="btn_a f_right">
                    <span><i class="in_left <?php echo $sections['icon'];?>"></i>
                    
             <?php if(isset($sections['btn_title'][$language_id])){?>
			<span><?php echo $sections['btn_title'][$language_id];?></span>
             <?php } ?>
                    
                 <i class="in_right <?php echo $sections['icon'];?>"></i></span>
                </a>
             
            <?php if(isset($sections['description'][$language_id])){?>
                <span class="intro_text">
			<?php echo html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8');?>
           	 </span>
             <?php } ?>
              
        <?php } else{?>
             <?php if(isset($sections['description'][$language_id])){?>
                <span class="intro_text">
			<?php echo html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8');?>
           	 </span>
             <?php } ?>
             <?php if($sections['icon']){?>
            <span class="rotate_icon"><a href="<?php echo $sections['btn_href'];?>" target="<?php echo $sections['btn_target'];?>" data-toggle="tooltip" title="<?php if(isset($sections['btn_title'][$language_id])){?><?php echo $sections['btn_title'][$language_id];?><?php } ?>"><i style="color:white;" class="<?php echo $sections['icon'];?>"></i></a></span>
        <?php } ?>

        <?php } ?>
		    </div>
		</div>
 <?php } ?>
 
<!-- END BEGIN CALL TO ACTION BLOCK -->