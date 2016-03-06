<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<table class="table">
  <tr>
  <td rowspan="2" width="100">
  <div class="relative">
  <img alt="<?php echo $review['author']; ?>" src="assets/theme/img/avatar.jpg" class="avatar_img">
  </div>
  </td>
    <td style="width: 50%;"><strong><?php echo $review['author']; ?></strong> - <?php echo $review['date_added']; ?></td>
    <td class="text-right"><div class="item-rating f_right">
							<span class="star-<?php echo $review['rating'];?>"></span>
						</div></td>
  </tr>
  <tr>
    <td colspan="3"><p><?php echo $review['text']; ?></p></td>
  </tr>
</table>
<?php } ?>
  <div class="row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
