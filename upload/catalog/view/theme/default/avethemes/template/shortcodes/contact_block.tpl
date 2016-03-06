<div class="content_row">
    <h3 class="title1 upper"><?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i><?php } ?><?php echo $heading_title;?></h3>
        <span class="spacer40"></span>
     
<?php $i=0;
 foreach($sections as $section){?>   
        <div class="contact_details_row clearfix">
            <span class="icon">
                <i class="fa fa-<?php echo $section['icon'];?>"></i>
            </span>
            <div class="c_con">
                <span class="c_title"><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
               <?php if(isset($section['desc1'])){?>
                <span class="c_detail">
                    <span class="c_name"><?php echo (isset($section['title1'][$language_id]))?html_entity_decode($section['title1'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                    <span class="c_desc"><?php echo (isset($section['desc1'][$language_id]))?html_entity_decode($section['desc1'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                </span>
                <?php } ?>
               <?php if(isset($section['desc2'])){?>
                <span class="c_detail">
                    <span class="c_name"><?php echo (isset($section['title2'][$language_id]))?html_entity_decode($section['title2'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                    <span class="c_desc"><?php echo (isset($section['desc2'][$language_id]))?html_entity_decode($section['desc2'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                </span>
                <?php } ?>
                
               <?php if(isset($section['desc3'])){?>
                <span class="c_detail">
                    <span class="c_name"><?php echo (isset($section['title3'][$language_id]))?html_entity_decode($section['title3'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                    <span class="c_desc"><?php echo (isset($section['desc3'][$language_id]))?html_entity_decode($section['desc3'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                </span>
                <?php } ?>
            </div>
        </div>	
	<?php
$i++;
 } ?>
 </div>
			