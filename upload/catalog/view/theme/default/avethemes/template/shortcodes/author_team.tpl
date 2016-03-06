<div class="content_row">
 <h3 class="heading_title"><?php echo $heading_title; ?></h3>
 <div class="clearfix">
      
  <?php if($type=='list'){?> 
	<ul class="list-group sidebar-menu lite-shadow">
      <?php foreach ($authors as $author) { ?>
      <li class="list-group-item"><a href="<?php echo $author['href']; ?>"><i class="fa fa-user"></i> <?php echo $author['author']; ?></a></li>
      <?php } ?>
    </ul>
    <p style="margin:0; text-align:right; padding:10px"><a href="<?php echo $author_list;?>"><?php echo $text_all_author; ?></a></p>
    <?php }else{ ?>    
     <select name="author" onchange="window.location.href=this.options[this.selectedIndex].value" class="form-control">
      <option>--Select an Author--</option>
      <?php foreach ($authors as $author) { ?>
        <?php if($author['author_id']==$author_id){?> 
      <option value="<?php echo $author['href']; ?>" selected="selected"><?php echo $author['author']; ?></option>
      <?php }else{ ?>      
      <option value="<?php echo $author['href']; ?>"><?php echo $author['author']; ?></option>
       <?php } ?>
       <?php } ?>
    </select>
    <p style="margin:0; text-align:right; padding-top:10px"><a href="<?php echo $author_list;?>"><?php echo $text_all_author; ?></a></p>
    <?php } ?>
    </div>
</div>
