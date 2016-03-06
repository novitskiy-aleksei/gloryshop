 <div class="content_row">
                <div class="elem-tabs tabs1 hide_arrow sidebar-tabs">

        <nav class="clearfix">

               <ul id="content_tabs<?php echo $module;?>" class="tabs-navi">
                             <?php $i=0;?>
              <?php foreach ($articles_sort as $key=>$value) { ?>
              <?php if (!empty($content_tabs[$value])) { ?> 
        <li class="<?php echo ($i==0)?'active':'';?>"><a href="#article<?php echo $module;?>-tabs-grid_<?php echo $value; ?>" data-toggle="tab" class="<?php echo ($i==0)?'selected':'';?>"><span <?php echo ($i==0)?'':'data-toggle="tooltip" title="'.$tabs_title[$value].'" class="icon_alone"';?>><?php echo ($i!=0)? $tabs_icon[$value]:'';?></span> <span class="tlabel <?php echo ($i==0)?'':'hide';?>"><?php echo $tabs_title[$value]; ?></span></a></li>      
                  
              <?php $i++; } ?>      
              <?php } ?> 
               </ul>
        </nav>
                  <div class="tab-content">
                  <?php $i=0;?>
      <?php foreach ($articles_sort as $key=>$value) {  ?>
      <?php if (!empty($content_tabs[$value])) { ?>
 <div class="tab-pane fade in <?php echo ($i==0)?'active':'';?>" id="article<?php echo $module;?>-tabs-grid_<?php echo $value; ?>">
<div id="<?php echo $module;?>_<?php echo $i;?>">
 
      <div class="posts_widget">
        <ul class="posts_widget_list">
     <?php foreach ($content_tabs[$value] as $article) { ?>
            <li class="clearfix">
                <a href="<?php echo $article['href']; ?>">
                    <img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>">
                    <span><?php echo $article['name']; ?></span>
                </a>
                <span class="post_date"><i class="fa fa-comments-o"></i><?php echo $article['comments_text']; ?></span>
            </li>
<?php } ?><!-- for--> 
        </ul>
    </div>
      
    </div><!--item-grid-->
   
    </div><!-- //tab-pane--> 
      <?php $i++; } ?>      
      <?php } ?>  
      </div><!-- //tab-content-->  
       </div><!-- elem-tabs--> 
    </div>