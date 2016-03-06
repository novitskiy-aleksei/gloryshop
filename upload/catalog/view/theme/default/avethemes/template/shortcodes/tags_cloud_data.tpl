<?php if ($tags_cloud) {?>
    <?php foreach ($tags_cloud as $tag) {?>
    <a href="<?php echo $tag['href'];?>"><span class="tag"><i class="fa fa-tags"></i> <?php echo $tag['name'];?></span></a>
    <?php  } ?> 
<?php  } ?> 