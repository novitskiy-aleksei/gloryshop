<?php foreach ($shortcuts as $shortcut) { ?>
   <a href="<?php echo $shortcut['href'];?>" class="btn <?php echo ($shortcut['route']==$route)?'btn-danger':'btn-primary';?> btn-sm margin-bottom-5"><span><i class="fa <?php echo $shortcut['class'];?>"></i> <?php echo $shortcut['text'];?></span></a>
<?php } ?>