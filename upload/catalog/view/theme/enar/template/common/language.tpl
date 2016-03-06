<?php if (count($languages) > 1) { ?><div id="top-language" class="dropdown-select dropdown-drop">
<span><span class="title">&nbsp; <?php echo $text_language; ?>:</span>&nbsp;
<?php foreach ($languages as $language) { ?><?php if($language['code']==$code){?><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"/><?php } ?><?php } ?>
&nbsp;<i class="fa fa-angle-down"></i></span>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="language">
						<div class="dropdown-panel">
							<ul class="dropdown-panel-con">
      <?php foreach ($languages as $language) { ?>
		<li data-code="<?php echo $language['code']; ?>"><a href="<?php echo $language['code']; ?>"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>"/>&nbsp;<?php echo $language['name']; ?>
         <i class="icon_active fa fa-check <?php echo ($language['code']==$code)?'active':''; ?>"></i></a></li>
      <?php } ?>
							</ul>
						</div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
 </div><?php } ?> 