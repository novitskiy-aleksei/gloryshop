<li id="avepack"><a class="parent"><i class="fa fa-font fa-fw" style="color:#fff;"></i> <span><?php echo $text_ave_tool;?></span></a>
    <ul>
        <li><a href="<?php echo $layout_builder; ?>"><?php echo $text_layout_composer;?></a></li>
    <?php if($ave_confirm_installed&&$ave_installed){?>
                <li><a href="<?php echo $article; ?>"><?php echo $text_blog_manager;?></a></li>
          <li><a href="<?php echo $quote; ?>"><?php echo $text_quote;?></a></li>
        <?php }else{ ?>  
          <li><a href="<?php echo $dashboard; ?>"><?php echo $text_content_install;?></a></li>
    <?php } ?>   
        </ul>
</li>	  