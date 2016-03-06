<div class="section bg_fixed" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
             
	     <div class="content large_spacer">
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
		</div>
		
        <!-- My Accordion -->
        <div class="elem_accordion plus_minus" data-type="accordion"> 
                        
        <?php $i=0;
         foreach($sections as $section){?>
                            <div class="elem_accordion_container" data-expanded="<?php echo ($i==0)?'true':'false';?>">
                                <span class="elem_accordion_title"><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                <div class="elem_accordion_content">
                                    <div class="acc_content">
                                     <?php echo (isset($section['description'][$language_id]))?str_replace('../image/','image/',html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8')):'';?>
                                    </div>
                                </div>
                            </div><?php
        $i++;
         } ?>
                            
        </div>
        <!-- End My Accordion -->
	    </div>

</div>

