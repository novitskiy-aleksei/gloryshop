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
				<h2><span class="line"><i class="fa fa-user"></i></span><?php echo $heading_title; ?></h2>
		</div>
      <?php if ($returns) { ?>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-right"><?php echo $column_return_id; ?></td>
            <td class="text-left"><?php echo $column_status; ?></td>
            <td class="text-left"><?php echo $column_date_added; ?></td>
            <td class="text-right"><?php echo $column_order_id; ?></td>
            <td class="text-left"><?php echo $column_customer; ?></td>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($returns as $return) { ?>
          <tr>
            <td class="text-right">#<?php echo $return['return_id']; ?></td>
            <td class="text-left"><?php echo $return['status']; ?></td>
            <td class="text-left"><?php echo $return['date_added']; ?></td>
            <td class="text-right"><?php echo $return['order_id']; ?></td>
            <td class="text-left"><?php echo $return['name']; ?></td>
            <td><a href="<?php echo $return['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="text-right"><?php echo $pagination; ?></div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 
<?php echo $footer; ?>