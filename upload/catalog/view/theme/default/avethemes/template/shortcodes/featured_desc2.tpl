<div class="section bg_fixed  <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
                <div class="full_con clearfix">
					<div class="half_full_con <?php echo $bgmode;?> large_spacer <?php echo($desc_position=='right')?'pull-right':''; ?>">
                    <?php if(isset($sections['title'][$language_id])){?>
						<div class="heading_title upper no_line">
										<h2><?php echo ($sections['icon'])?'<span class="red"><i class="'.$sections['icon'].'"></i></span>':'';?> <?php echo $sections['title'][$language_id];?></h2>
						</div>
                     <?php } ?>
                       <?php if(isset($sections['description'][$language_id])){?>
			<?php echo html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8');;?>
             <?php } ?>
             
             	<ul class="list1 black list_circle clearfix">
             <?php 
              foreach ($sections['features'] as $feature) { ?>
             <?php echo (isset($feature[$language_id])&&!empty($feature[$language_id])) ?'<li>'. $feature[$language_id].'</li>' : ''; ?>
                <?php } ?>
			</ul>
            <div>
				<?php if(!empty($sections['btn_href1'])&&isset($sections['btn_title1'][$language_id])){?>
					<a class="btn_b white_btn italic" href="<?php echo $sections['btn_href1'];?>" target="<?php echo $sections['btn_target1'];?>">
						<span class="hidden_element" data-text="<?php echo $sections['btn_title1'][$language_id];?>"><?php echo $sections['btn_title1'][$language_id];?></span>
					</a>
				 <?php } ?>
				<?php if(!empty($sections['btn_href2'])&&isset($sections['btn_title2'][$language_id])){?>
					<a class="btn_b italic" href="<?php echo $sections['btn_href2'];?>" target="<?php echo $sections['btn_target2'];?>">
						<span class="hidden_element" data-text="<?php echo $sections['btn_title2'][$language_id];?>"><?php echo $sections['btn_title2'][$language_id];?></span>
					</a>
				 <?php } ?>
				</div>
             
			</div><!--//half_full_con --> 
                    
            
            
				</div>


</div>