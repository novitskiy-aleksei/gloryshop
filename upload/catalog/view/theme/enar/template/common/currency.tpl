<?php if (count($currencies) > 1) { ?>
<div id="top-currency" class="dropdown-select dropdown-drop">
<span><span class="title"><b></b>&nbsp; <?php echo $text_currency; ?>:</span>&nbsp;<?php foreach ($currencies as $currency) { ?> <?php if($currency['code']==$code){?><?php echo $currency['code'];?><?php } ?><?php } ?>
&nbsp;
<i class="fa fa-angle-down"></i>
</span>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="currency">
						<div class="dropdown-panel">
							<ul class="dropdown-panel-con">
      <?php foreach ($currencies as $currency) { ?>
      <li data-code="<?php echo $currency['code']; ?>">
		<a class="currency-select btn btn-link btn-block" href="<?php echo $currency['code']; ?>">
      <?php echo ($currency['symbol_left'])?$currency['symbol_left']:$currency['symbol_right']; ?>
        &nbsp;<?php echo $currency['title']; ?> <i class="icon_active fa fa-check <?php echo ($currency['code']==$code)?'active':''; ?>"></i></a>
		
      </li>
      <?php } ?>
							</ul>
						</div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div> 
<?php } ?> 
