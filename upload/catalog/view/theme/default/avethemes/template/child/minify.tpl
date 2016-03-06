<?php $dir=$ave->layout('dir');
        $core_styles= array();        
        $core_styles[]= array('href'=>'assets/plugins/bootstrap/bootstrap.css');
        $core_styles[]= array('href'=>'assets/plugins/fontawesome/css/font-awesome.css');
        $core_styles[]= array('href'=>'assets/theme/css/style.css');
        $core_styles[]= array('href'=>'assets/theme/css/navigation.css');
        $core_styles[]= array('href'=>'assets/theme/css/heading.css');
        $core_styles[]= array('href'=>'assets/theme/css/buttons.css');
        $core_styles[]= array('href'=>'assets/plugins/magnific-popup/magnific-popup.css');
        
        if($dir=='-rtl'){
        $core_styles[]= array('href'=>'assets/theme/css/rtl.css');
        }
        $jquerys=  array(
            'assets/plugins/jquery.js',
            'assets/plugins/global-plugins.js',
            'assets/plugins/magnific-popup/magnific-popup.js'
        );
        $external_styles = array();
        $internal_styles = array();
        
        foreach ($styles as $style) {
         if (strpos($style['href'], '//')!= false||strpos($style['href'], '.php?')!= false){//true
            	$external_styles[] = $style;
            }else{
            	$internal_styles[] = $style;
            }
        }
        $external_scripts = array();
        $internal_scripts = array();
        foreach ($scripts as $script) {
         if (strpos($script, '//')!= false||strpos($script, '.php?')!= false){//true
            	$external_scripts[] = $script;
         }else{
            	$internal_scripts[] = $script;
            }
        }
     ?> 
    <!-- MINIFY AND COMBINE  STYLESHEET --> 
<link rel="stylesheet" type="text/css" href="<?php echo $ave->minStyles($core_styles);?>" media="screen"/>
<?php if(!empty($internal_styles)){ ?><link rel="stylesheet" type="text/css" href="<?php echo $ave->minStyles($internal_styles);?>" media="screen"/><?php } ?>
<?php if(!empty($external_styles)){ ?><?php foreach ($external_styles as $style){ ?>
<link type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media'];?>" rel="<?php echo $style['rel'];?>"/><?php } ?><?php } ?>

<script type="text/javascript" src="<?php echo $ave->minScripts($jquerys);?>"></script>
<?php if(!empty($external_scripts)){?>
<?php foreach ($external_scripts as $script) { ?> <script type="text/javascript" src="<?php echo $script; ?>"></script><?php } ?>
<?php } ?>
<script type="text/javascript" src="<?php echo $ave->minScripts($internal_scripts);?>"></script>