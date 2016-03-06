<?php global $ave;
 echo $header; ?>
<section class="section page_title">
    <div class="content clearfix">
        <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="title"><?php echo str_replace('<i class="fa fa-home"></i>','<i class="fa fa-home"></i><b>Home</b>',$breadcrumb['text']); ?></span></a></li>
        <?php } ?>
    </ul>
    </div>
</section>
<section class="section">
  <div class="content content_spacer clearfix">
<div class="content_row clearfix">
		<?php echo $column_left; ?>
        <div id="content" class="<?php echo $ave->layout('content');?>">
        <?php echo $content_top; ?>
        
                 <div class="heading_title centered upper">
				<h2><span class="line"><i class="fa fa-life-ring"></i></span><?php echo $heading_title; ?></h2>
		</div>
 <div class="content_row">
                <div class="col-md-3 col-sm-3">
                  <ul class="list-group"> 
                  <?php foreach ($fcategories as $category){?> 
                    	<li class="list-group-item <?php echo ($content_id==$category['content_id'])?'active':'';?>"><a href="<?php echo $category['href'];?>"><?php echo $category['name'];?></a></li>
                   <?php } ?> 
                  </ul>
                </div>
                <div class="col-md-9 col-sm-9">
         <?php if (!empty($description)) { ?>
            <?php echo $description; ?>
          <?php } ?>
      					<?php if (!empty($faqs)) { ?>
                       <!--accorfion -->    
                       <div class="panel-group" id="faqs-accordion">              
          					<?php 
                            $f=0; 
                            foreach ($faqs as $faq) { ?>     
                            <div class="panel panel-default">
                               <div class="panel-heading">
                                  <h4 class="panel-title">
                                     <a href="#accordion_<?php echo $content_id;?>_<?php echo $faq['sort_order'];?>" data-toggle="collapse" class="accordion-toggle <?php echo ($f==0)?'':'collapsed';?>" data-parent="#faqs-accordion">
                                     <?php echo $f+1;?>. <?php echo $faq['question'];?>
                                     </a>
                                  </h4>
                               </div>
                               <div class="panel-collapse collapse <?php echo ($f==0)?'in':'';?>" id="accordion_<?php echo $content_id;?>_<?php echo $faq['sort_order'];?>">
                                  <div class="panel-body">
                                   <?php echo $faq['answer'];?>
                                  </div>
                               </div>
                            </div>
                    <?php $f++; } ?>
                    </div>
                           <!--end accorfion --> 
   				 <?php } ?> 
                    
                </div><!--col-9 --> 
              </div><!--row --> 
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 
<?php echo $footer; ?>