<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html dir="<?php echo $ave->layout('direction');?>" lang="<?php echo $this->language->get('code'); ?>">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
  <meta charset="utf-8">
  <title><?php echo $heading_title; ?></title>

  <?php if($ave->get('responsive')=='responsive'){?>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <?php }else{?>
  <meta content="width=1024" name="viewport">  
  <?php }?>
  


  <meta content="opencartplus" name="author">

  <meta property="og:site_name" content="-CUSTOMER VALUE-">
  <meta property="og:title" content="-CUSTOMER VALUE-">
  <meta property="og:description" content="-CUSTOMER VALUE-">
  <meta property="og:type" content="website">
  <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
  <meta property="og:url" content="-CUSTOMER VALUE-">


 <?php  $dir=$ave->layout('dir');?>
  <!-- Global styles START -->          
  <link href="assets/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
  
  <link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
 
  <!-- Global styles END --> 
   

    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->
    <script src="assets/plugins/jquery.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

</head>
<!-- Head END -->

<!-- Body BEGIN -->
<body class="<?php echo $ave->layout('body');?>">
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>" target="_parent"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
</div><!-- container --> <div class="container">

<div id="content" class="<?php echo $ave->layout('content');?>">
<div class="content">
      <div class="box-heading main-title"><?php echo $heading_title; ?></div>
       <div class="box-content">
            <div class="content-info with-shadow"><?php echo $text_error; ?>
<div class="form-group">
                        <div class="buttons">
                                <div class="right">
                                <a href="<?php echo $continue; ?>" class="btn btn-primary" target="_parent"><?php echo $button_continue; ?></a>
                              </div>
                        </div>
                      </div>
</div>      </div><!-- end main box-content -->
</div><!-- //end main box -->

</div><!--#content-->
</div><!--//row-->
</div><!-- //END CONTAINER -->
    

    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) --> 
    <script src="assets/plugins/bootstrap/js/bootstrap.js" type="text/javascript"></script>  
    <!-- END CORE PLUGINS -->
 
</body>
</html>