<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/>
<link href="assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="assets/editor/plugins/jquery-ui/jquery-ui.css" type="text/css" rel="stylesheet" media="screen" />
<link href="assets/editor/css/front_editor.css" type="text/css" rel="stylesheet" media="screen" />
   <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->
<script src="assets/plugins/jquery.js" type="text/javascript"></script>
<script src="assets/editor/plugins/jquery-ui/jquery-ui.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap/bootstrap.js" type="text/javascript"></script>
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>"/>
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<style>
body {
  color: #3e4d5c;
  direction: ltr;
  background: #f6f7f7;
  font-family: 'Open Sans', Arial, sans-serif;
  font-size: 13px;
  font-weight: 400;
}
</style>
</head>