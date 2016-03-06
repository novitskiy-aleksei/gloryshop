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
				<h2><span class="line"><i class="fa fa-users"></i></span><?php echo $text_ours_author; ?></h2>
		</div>
      
  <?php if ($authors) {?>
    <?php foreach (array_chunk($authors, 4) as $author_row) { ?>
          <div class="content_row">
    <?php foreach ($author_row as $author) { ?>
      <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="item_block flipp_effect">
						<div class="item_content">
							<div class="front face">
								<span class="team_img">
									<img alt="<?php echo $author['author']; ?>" src="<?php echo $author['image']; ?>">
								</span>
								<span class="person_name"><?php echo $author['author']; ?></span>
								<span class="person_jop"><?php echo $author['competence']; ?></span>
							</div>
							<div class="back face">
								<span class="person_name"><?php echo $author['author']; ?></span>
								<span class="person_jop"><?php echo $author['competence']; ?></span>
								<span class="person_desc">
                      <?php if(!empty($author['description'])){ ?><?php echo $author['description'];?><?php } ?>
                      </span>
                      <?php if(!empty($author['socials'])){ ?>
								<div class="social_media clearfix">
                                
     					 <?php foreach ($author['socials'] as $social) { ?>
									<a href="<?php echo $social['href'];?>" target="<?php echo $social['target'];?>">
										<i class="<?php echo $social['social'];?>"></i>
									</a>
     					 <?php } ?>
								</div>
     			 		<?php } ?>
								<a class="arrow_btn" href="<?php echo $author['href'];?>"><i class="fa fa-arrow-right"></i><?php echo $text_full_profile;?></a>
							</div>
						</div>
					</div>
        </div><!--// col--> 
      <?php } ?>
      </div><!--row --> 
      <?php } ?>
<?php } else { ?>
<div class="alert alert-info">
      <div class="content_row clearfix">
        <div class="col-sm-6 text-left"><?php echo $text_empty; ?></div>
        <div class="col-sm-6 text-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><span><?php echo $button_continue; ?></span></a></div>
      </div>
  </div>
  <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 
<?php echo $footer; ?>