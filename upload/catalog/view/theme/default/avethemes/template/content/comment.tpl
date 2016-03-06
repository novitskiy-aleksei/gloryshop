<?php if ($comments) { ?>
<?php foreach ($comments as $comment) { ?>
<table class="table">
  <tr>
  <td rowspan="2" width="100">
  <div class="relative">
  <img alt="<?php echo $review['author']; ?>" src="assets/theme/img/avatar.jpg" class="avatar_img">
  </div>
  </td>
    <td style="width: 50%;"><strong><?php echo $comment['author']; ?></strong> - <?php echo $comment['date_added']; ?></td>
    <td class="text-right"><div class="item-rating f_right">
							<span class="star-<?php echo $comment['rating'];?>"></span>
						</div></td>
  </tr>
  <tr>
    <td colspan="3"><p><?php echo $comment['text']; ?></p></td>
  </tr>
</table>
<?php } ?>
  <div class="content_row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
<?php } else { ?>
<p><?php echo $text_no_comments; ?></p>
<?php } ?>
