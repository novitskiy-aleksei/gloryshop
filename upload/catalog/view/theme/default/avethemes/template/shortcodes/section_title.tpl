<div class="section bg_fixed <?php echo $sections['title_color'];?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            <?php if($sections['show_icon']==1){?>
            <div class="content no_padding">	
            	<span class="spacer30"></span>
                <div class="heading_title <?php echo $heading_align;?> upper">
                    <h2><span class="line"><i class="<?php echo $icon;?>"></i></span><?php echo $heading_title;?></h2>
                </div>
            </div>
             <?php }else{ ?>
              <?php if(!empty($heading_title)){?>
                   <div class="title_banner t_b_color3 upper centered">
                        <div class="content">
                            <h2><?php echo $heading_title;?></h2>
                        </div>
                    </div>
                 <?php } ?>
             <?php } ?>
</div>