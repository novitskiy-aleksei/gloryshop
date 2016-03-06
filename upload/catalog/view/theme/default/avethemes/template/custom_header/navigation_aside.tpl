<?php
 $custom_logo = $ave->get('custom_logo');
 $cart_status = $ave->get('cart_status');
 $search_status = $ave->get('search_status');
 $text_welcome= $ave->text('text_welcome');
 $text_login= $ave->text('text_login');
 $text_logout= $ave->text('text_logout');
 $text_whist_list= $ave->text('text_whist_list');
 $text_register_account=$ave->text('text_register_account');
 $text_manager_account= $ave->text('text_manager_account');
 ?>
<header id="page_header">
		<div class="header-top"><!-- class ( header-top-colored  ) -->
			<div class="content clearfix">
			
				<div class="top_details clearfix pull-right">
               			 <!-- BEGIN CURRENCIES -->
                        <?php echo $currency;?>
                        <!-- END CURRENCIES -->
                        <!-- BEGIN LANGS-->
                        <?php echo $language;?>
                        <!-- END LANGS -->
					
					<div id="top-account" class="dropdown-select dropdown-drop">
						<span><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>"><i class="icon fa fa-user"></i><span class="title"><?php echo $text_account; ?></span></a></span>
						<div class="dropdown-panel">
							<ul class="dropdown-panel-con">
								<li><a href="<?php echo $register;?>"> <?php echo $text_register_account;?></a> </li>
								<li><a href="<?php echo $login;?>"><?php echo $text_login;?></a></li>
							</ul>
						</div>
					</div>
                    <div id="top-wishlist"><a href="<?php echo $wishlist; ?>" id="wishlist-total" data-toggle="tooltips" title="<?php echo $text_whist_list; ?>"><i class="icon fa fa-heart"></i><span class="title"><?php echo $text_whist_list; ?></span></a></div>
                 <?php if($cart_status==1){ ?>
                    <div><a href="<?php echo $shopping_cart; ?>" data-toggle="tooltips" title="<?php echo $text_shopping_cart; ?>"><i class="icon fa fa-shopping-cart"></i><span class="title"><?php echo $text_shopping_cart; ?></span></a></div>
                    <div><a href="<?php echo $checkout; ?>" data-toggle="tooltips" title="<?php echo $text_checkout; ?>"><i class="icon fa fa-share"></i><span class="title"><?php echo $text_checkout; ?></span></a></div>
                 <?php } ?>
				</div>
                 
                 
				<div class="top-socials box_socials pull-left">
                    <?php if($social_status&&!empty($social_data)){
         			 foreach ($social_data as $social) { 
                     if(!empty($social['link'])){?>      
                        <a href="<?php echo $social['link'];?>" target="<?php echo (!empty($social['target']))?'_blank':'_self';?>">
                            <span class="soc_name"><?php echo (isset($social['title'][$language_id]))?$social['title'][$language_id]:'';?></span>
                            <span class="soc_icon_bg"></span>
                            <i class="<?php echo $social['icon']; ?>"></i>
                        </a>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                        <?php if($ave->get('header_quick_support')){ ?>
					<div><i class="icon fa fa-phone"></i><span class="title"> <?php echo $telephone; ?></span></div>
                 	<?php } ?>
				 </div>
			</div>
			<!-- End content -->
			<span class="top_expande not_expanded">
				<i class="no_exp fa fa-angle-double-down"></i>
				<i class="exp fa fa-angle-double-up"></i>
			</span>
		</div>
		<!-- End header-top -->
		<div id="side_header">
			<div id="side_header_in">
            
		<div id="navigation_bar">
			<div class="content clearfix">
				<div id="logo">
					<a href="<?php echo $home;?>">
  <?php if ($custom_logo==1) { ?><img class="logo_img" src="<?php echo $config_custom_logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"/>  <?php }else{ ?><?php if ($logo) { ?><img class="logo_img" src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"/><?php } ?><?php } ?>
					</a>
				</div>
				
        <?php if($cart_status==1){ ?>
				<!-- Top Card -->
				<div id="cart" class="nav_cart">
                	<a class="nav_cart_toggle">
                        <strong class="nav_cart_label"><?php echo $text_shopping_cart;?></strong>
                        <i class="fa fa-shopping-cart"></i>
                        <span class="nav_cart_count">0</span>
                    </a>
				</div>
				<!-- End Top Card -->
            <?php } ?>
				
        <?php if($search_status==1){ ?>
				<!-- Top Search -->
				<div class="nav_search clearfix nav_search_small">
					<div class="nav_search_content">
						<input type="text" name="search" class="s" placeholder="<?php echo $ave->text('search_here');?>">
						<span class="nav_search_handle"><i class="fa fa-search"></i></span>
                        <span class="nav_search_close"><i class="fa fa-times"></i></span>
						<!-- <input type="submit" class="nav_search_submit" >--> 
                   	 	<div class="search-widget"></div>
					</div>
				</div>
				<!-- End Top Search -->
            <?php } ?>
				<?php echo $main_menu;?>
				
				<div class="clear"></div>
			</div>
		</div>
        
	
    
				<div class="side_header_social centered clearfix">
					<div id="socials_share">
                    <?php if($social_status&&!empty($social_data)){
                         foreach ($social_data as $social) { 
                     if(!empty($social['link'])){?>   
                            <a class="<?php echo str_replace('fa fa-','',$social['icon']); ?>" href="<?php echo $social['link'];?>" target="<?php echo (!empty($social['target']))?'_blank':'_self';?>" data-toggle="tooltips" title="<?php echo (isset($social['title'][$language_id]))?$social['title'][$language_id]:'';?>">
                                <i class="<?php echo $social['icon']; ?>"></i>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php } ?>
						
					</div>	
				</div>
                
			</div>
		</div><!--side header --> 
            
            
 	</header>
        <!-- End Main Header -->