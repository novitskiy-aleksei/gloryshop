<?php global $ave;?>
<?php
if(!defined('ave_check')){
	echo '<h1 style="text-align:center;">Ave Theme currently is not completed enabled.</h1><h2>If you are the owner of this website, please login to administrator area and completion install "Feed/Layout Composer" module!</h2>';
 } else { 
$direction = $ave->layout('direction');
  ?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>"><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. --> 
<head>
	<!-- Important stuff for SEO, don't neglect. (And don't dupicate values across your site!) -->
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>"/>
  <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!--[if ie]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
  <!--[if ie]><meta http-equiv="cleartype" content="on"/><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="author" content="" />
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if ($keywords) { ?>
    <meta name="keywords" content= "<?php echo $keywords; ?>" />
    <?php } ?>
    
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $ave->get('Current_URL');?>"/>
    <meta property="og:site_name" content="<?php echo $ave->getConfig('config_meta_title');?>"/>
    <meta property="og:image" content="<?php echo $ave->get('og_image');?>" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <?php if ($description) { ?>
    <meta property="og:description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if (isset($icon)) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" type="image/x-icon" />
    <?php } ?>
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>
    
	<link href='https://fonts.googleapis.com/css?family=Oswald:300,400,700|Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<?php if($ave->getConfig('skin_minify_code')==1&&!empty($ave_minify)){
   echo $ave_minify;
}else{ ?>
	<!-- concatenate and minify for production -->
	<link rel="stylesheet" href="assets/plugins/bootstrap/bootstrap.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/theme/css/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/theme/css/navigation.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/theme/css/heading.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/theme/css/buttons.css" type="text/css" media="all" />
    <?php if($direction=='rtl'){?>
	<link rel="stylesheet" href="assets/theme/css/rtl.css" type="text/css" media="all" />
    <?php } ?>
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/font-awesome.css" type="text/css" media="all" >
	<link rel="stylesheet" href="assets/plugins/magnific-popup/magnific-popup.css" type="text/css" media="all" />
    
<?php foreach ($styles as $style) { ?>
	<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
	<script src="assets/plugins/jquery.js" type="text/javascript"></script>
	<script src="assets/plugins/global-plugins.js" type="text/javascript"></script>
	<script src="assets/plugins/magnific-popup/magnific-popup.js" type="text/javascript"></script>
    <?php foreach ($scripts as $script) { ?>
        <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>
<?php } ?>

	<link rel="stylesheet" id="custom_style" href="index.php?route=avethemes/common/style" type="text/css" media="all" />
	<script src="index.php?route=avethemes/common/script"></script>
<?php if (isset($analytics)) { ?>
    <?php foreach ($analytics as $analytic) { ?>
    <?php echo $analytic; ?>
    <?php } ?>
<?php } ?>
<?php if (isset($google_analytics)) { ?>
<?php echo $google_analytics; ?>
<?php } ?>
</head>

<!-- Class ( body_boxed - dark - preloader1 - preloader2 - preloader3 - header_light - sub_nav_dark - menu_button_mode - header_transparent - navigation_aside ) -->
<body class="<?php echo $class.' '.$ave->layout('body');?>" id="body_elem" data-minify-checker="1">
<div id="preloader">
	<div class="spinner">
		<div class="sk-dot1"></div><div class="sk-dot2"></div>
		<div class="rect3"></div><div class="rect4"></div>
		<div class="rect5"></div>
	</div>
</div>

<div id="page_wrapper" class="<?php echo $ave->get('primary_btn');?> <?php echo $ave->get('default_btn');?>">
	<?php echo isset($pre_header)?$pre_header:''; ?>
   <?php echo isset($ave_header)?$ave_header:''; ?>
   <?php echo isset($after_header)?$after_header:''; ?>
<?php } ?>