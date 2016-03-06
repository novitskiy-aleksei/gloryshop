<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesShortcodes extends Model {
	public function getSections($element) {
		
		/*.category_wall*/ 	
		$return['category_wall'] =   array(
									0=>array (
										'image' =>'',
										'title' => array(1 => 'Featured category 1'),
										'category_1' => array(1=>'Category 1'),
										'href_1' => '',
										'category_2' => array(1=>'Category 2'),
										'href_2' => '',
										'category_3' => array(1=>'Category 3'),
										'href_3' => '',
										'category_4' => array(1=>'Category 4'),
										'href_4' => '',
										'category_5' => array(1=>'Category 5'),
										'href_5' => ''
									),
									1=>array (
										'image' =>'',
										'title' => array(1 => 'Featured category 2'),
										'category_1' => array(1=>'Category 1'),
										'href_1' => '',
										'category_2' => array(1=>'Category 2'),
										'href_2' => '',
										'category_3' => array(1=>'Category 3'),
										'href_3' => '',
										'category_4' => array(1=>'Category 4'),
										'href_4' => '',
										'category_5' => array(1=>'Category 5'),
										'href_5' => ''
									),
									2=>array (
										'image' =>'',
										'title' => array(1 => 'Featured category 3'),
										'category_1' => array(1=>'Category 1'),
										'href_1' => '',
										'category_2' => array(1=>'Category 2'),
										'href_2' => '',
										'category_3' => array(1=>'Category 3'),
										'href_3' => '',
										'category_4' => array(1=>'Category 4'),
										'href_4' => '',
										'category_5' => array(1=>'Category 5'),
										'href_5' => ''
									)
		);	
		/*.revolution*/ 
		 $return['google_comment'] =   array('google_comment' => 'google_comment');
		 $return['disqus_comment'] =   array('disqus_shortname' => 'avethemes');
		 $return['revoslider'] =   array('primary_id' => 1);
		 $return['twitter_timeline'] =   array(
					  'twitter_lang' => 'en',
					  'twitter_shown' => 3,
					  'twitter_widget_id' => '353398084929208320',
					  'twitter_username' => 'social',
					  'twitter_style' => 'dark',
					  'twitter_button' => 0);
		 $return['facebook_page'] =   array(
					  'page_url' => 'Opencartplus-202513626602360/',
					  'position' => 'bottom_right',
					  'width' => '280',
					  'height' => '225',
					  'cwidth' => '300',
					  'cheight' => '320',
					  'show_cover' => 'true',
					  'show_faces' => 'true',
					  'show_posts' => 'false',
					  'locale' => 'en_US'
					 );
		/*.custom_video*/ 
		 $return['custom_video'] =   array(
								'title' => array(1 => 'Video title'),
								 'type' => 'youtube',
								 'image' => 'catalog/avethemes/blog/blog1.jpg',
								 'vimeo_href'=>'http://vimeo.com/29193046',
								 'youtube_href'=>'http://www.youtube.com/watch?v=0O2aH4XLbto'
					 );
		/*.author_team*/ 
		 $return['author_team'] =   array('author_id'=>1,'description' => array(1 => 'We believe in a diverse range of personel to bring creative skills, thoughts, and ideas to the table.'));
		/*.poll*/ 
		 $return['poll'] =   array('poll_id' => 1);
		/*.tags_cloud*/ 
		 $return['free_download'] =   array('free_file' => array());
		/*.tags_cloud*/ 
		 $return['tags_cloud'] =   array('type' => 'product','limit'=>9);
		/*.sidebar_search*/ 
		 $return['sidebar_search'] =   array('type' => 'product');
		/*.contact_form*/ 
		 $return['newsletter'] =   array('description' => array(1 => 'By subscribing to our mailing list you will always be update with the latest news.'));
		/*.contact_form*/ 
		 $return['contact_form'] =   array(
		 'title' => array(1 => 'Get on touch'),
		 'description' => array(1 => 'Contact us or give us a call to discover how we can help.')
		 );
		 
		/*.featured_desc*/ 			
		 $return['contact_info'] =   array(
											array(
												'title' => array(1 => 'Address:'),
												'desc' => array(1 => '34 Depot Street Massapequa, NY 11758')
											),
											array(
												'title' => array(1 => 'Phone:'),
												'desc' => array(1 => '(305) 1234 5678 7891')
											),
											array(
												'title' => array(1 => 'Email:'),
												'desc' => array(1 => 'info@mail.com')
											),
											array(
												'title' => array(1 => 'Site:'),
												'desc' => array(1 => 'www.avethemes.com')
											),
		);
		
		/*.Social block*/ 						
		$return['social_link'] =   array(	
											array(
												'icon' =>'fa fa-twitter',
												'href' => 'https://www.twitter.com/',
												'target' => '_blank',
												'title' => 'Twitter'
											),array(
												'icon' =>'fa fa-facebook',
												'href' => 'https://www.facebook.com/',
												'target' => '_blank',
												'title' => 'Facebook'
											),array(
												'icon' =>'fa fa-google-plus',
												'href' => 'https://plus.google.com/',
												'target' => '_blank',
												'title' => 'Google+'
											),array(
												'icon' =>'fa fa-linkedin',
												'href' => 'https://www.linkedin.com/',
												'target' => '_blank',
												'title' => 'Linkedin'
											),array(
												'icon' =>'fa fa-youtube',
												'href' => 'https://www.youtube.com/',
												'target' => '_blank',
												'title' => 'Youtube'
											),array(
												'icon' =>'fa fa-dropbox',
												'href' => 'https://www.dropbox.com/',
												'target' => '_blank',
												'title' => 'Dropbox'
											),
									);	
		/*.featured block*/ 						
		$return['live_preview'] =   array(	
											array(
												'image' =>'catalog/avethemes/demo/demo1.png',
												'href' => 'http://demo.avethemes.com/',
												'admin' => 'http://demo.avethemes.com/admin',
												'target' => '_blank',
												'title' => array(1 => 'Demo 1'),
												'desc' => array(1 => 'User/pass: demo/demo')
											),array(
												'image' =>'catalog/avethemes/demo/demo2.png',
												'href' => 'http://demo2.avethemes.com/',
												'admin' => 'http://demo.avethemes.com/admin',
												'target' => '_blank',
												'title' => array(1 => 'Demo 2'),
												'desc' => array(1 => 'User/pass: demo/demo')
											),array(
												'image' =>'catalog/avethemes/demo/demo3.png',
												'href' => 'http://demo3.avethemes.com/',
												'admin' => 'http://demo3.avethemes.com/admin',
												'target' => '_blank',
												'title' => array(1 => 'Demo 3'),
												'desc' => array(1 => 'User/pass: demo/demo')
											),array(
												'image' =>'catalog/avethemes/demo/demo4.png',
												'href' => 'http://demo4.avethemes.com/',
												'admin' => 'http://demo4.avethemes.com/admin',
												'target' => '_blank',
												'title' => array(1 => 'Demo 4'),
												'desc' => array(1 => 'User/pass: demo/demo')
											),array(
												'image' =>'catalog/avethemes/demo/demo5.png',
												'href' => 'http://demo5.avethemes.com/',
												'admin' => 'http://demo5.avethemes.com/admin',
												'target' => '_blank',
												'title' => array(1 => 'Demo 5'),
												'desc' => array(1 => 'User/pass: demo/demo')
											),array(
												'image' =>'catalog/avethemes/demo/demo6.png',
												'href' => 'http://demo6.avethemes.com/',
												'admin' => 'http://demo6.avethemes.com/admin',
												'target' => '_blank',
												'title' => array(1 => 'Demo 6'),
												'desc' => array(1 => 'User/pass: demo/demo')
											),
									);	
		/*.contact_block*/ 						
		$return['contact_block'] =   array(	
										array(
											'icon' =>'fa fa-map-marker',
											'title' => array(1 => 'Address'),
											'title1' => array(1 => 'Main Office'),
											'desc1' => array(1 => 'NO.28 - 23 Street Name - City, Country'),
											'title2' => array(1 => 'Customer Center'),
											'desc2' => array(1 => ' NO.123 - 45 Street Name - City, Country'),
											'title3' => array(1 => 'Service Center'),
											'desc3' => array(1 => 'NO.28 - 67 Street Name - City, Country')
										),
										array(
											'icon' =>'fa fa-phone',
											'title' => array(1 => 'Phone number'),
											'title1' => array(1 => 'Main support'),
											'desc1' => array(1 => '+000 123 456 789'),
											'title2' => array(1 => 'Customer support'),
											'desc2' => array(1 => '+000 234 567 890'),
											'title3' => array(1 => 'Service Center'),
											'desc3' => array(1 => '+000 567 890 123')
										),
										array(
											'icon' =>'fa fa-paper-plane',
											'title' => array(1 => 'Email address'),
											'title1' => array(1 => 'Main email:'),
											'desc1' => array(1 => 'company@mail.com'),
											'title2' => array(1 => 'Customer Support:'),
											'desc2' => array(1 => 'info@mail.com'),
											'title3' => array(1 => 'Technical Center'),
											'desc3' => array(1 => 'support@mail.com')
										)
								);
								
		/*.call_to_action*/ 
		 $return['section_title'] =   array('title_color' =>'','show_icon' =>0);
		/*.call_to_action*/ 
		 $return['testimonial'] =   array(
										'limit' =>6,
										'carousel_limit' =>2,
										'num_row' =>2,
										'type' =>'random',
										'custom_testimonial' =>array(),
								);
		/*.call_to_action*/ 
		 $return['call_to_action'] =   array(
										'class' =>'full_colored',
										'title' => array(1 => 'Best HTML5 Theme Ever!'),
										'description' => array(1 => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour of this randomised words which don\'t look even slightly believable If you are going to use a passage of Lorem Ipsum.'),
										'icon' =>'fa fa-shopping-cart',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Purchase Now')
								);
			
		/*.google_map*/ 			
		 $return['google_map'] =   array(
		 								'type' => 'boxed',
		 								'height' => '300px',
		 								'latitude' => '-13.004333',
		 								'longitude' => '-38.494333',
		 								'title' => array(1 => 'Your Store title'),
										'description' => array(1 => '<b>Address: 123 Avethemes</b><br/><b>Phone: 0123456789</b><br/><b>Opening time: 9:AM-17:PM</b>')
								);
				
		/*.featured_desc*/ 			
		 $return['featured_desc'] =   array('image' =>'catalog/avethemes/tab1.png',
										'icon' =>'fa fa-globe',
										'title' => array(1 => 'Unique And Modern Design'),
										'description' => array(1 => 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.\r\n And scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum available, but the majority have to suffered alteration iner some form with injected randomised words which.'),
										'features' => array(
											1=>array(1=>'Multiple Layout'),
											2=>array(1=>'Browser Compatibility'),
											3=>array(1=>'Parallax Effect'),
											4=>array(1=>'Many Home Page Versions'),
											5=>array(1=>'Awesome Shortcodes'),
											6=>array(1=>'Easy to Edit Animations'),
											7=>array(1=>'Responsive Design'),
											8=>array(1=>'Many Blog Pages')
										),
										'btn_href1' => 'http://codecanyon.net/user/legendtheme',
										'btn_target1' => '_blank',
										'btn_title1' => array(1=>'Purchase Now'),
										'btn_href2' => 'http://codecanyon.net/user/legendtheme',
										'btn_target2' => '_blank',
										'btn_title2' => array(1=>'Read more'),
		);
		/*.counter block*/ 						
		$return['counter'] =   array(	
											array(
												'icon' =>'fa fa-female',
												'num' => '1500',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Clients')
											),
											array(
												'icon' =>'fa fa-trophy',
												'num' => '30',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Awards')
											),
											array(
												'icon' =>'fa fa-map-marker',
												'num' => '564',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Location')
											),
											array(
												'icon' =>'fa fa-suitcase',
												'num' => '384',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Project')
											)
									);	
		/*.counter block*/ 						
		$return['skill'] =   array(	
											array(
												'color' =>'#0BACB8',
												'percent' => '80',
												'title' => array(1 => 'Web Design')
											),
											array(
												'color' =>'#0BACB8',
												'percent' => '70',
												'title' => array(1 => 'HTML/CSS')
											),
											array(
												'color' =>'#00BC90',
												'percent' => '100',
												'title' => array(1 => 'Wordpress')
											),
											array(
												'color' =>'#FF513E',
												'percent' => '40',
												'title' => array(1 => 'Joomla')
											)
									);	
		
		
		/*.description block*/ 						
		$return['description_block'] =   array(	
											0=>array(
												'image' =>'catalog/avethemes/device.png',
												'img_pos' =>'',
												'animation' =>'',
												'title' => array(1 => 'Title 1'),
												'description' => array(1 => 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type and scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum.
There are many variations of demo text passed sages of Lorem Ipsum available but the majority Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known.')
												),
												
											1=>array(
												'image' =>'catalog/avethemes/device.png',
												'img_pos' =>'',
												'animation' =>'',
												'title' => array(1 => 'Title 2'),
												'description' => array(1 => 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type and scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum.
There are many variations of demo text passed sages of Lorem Ipsum available but the majority Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known.')
												)
		
		);
		/*.featured_slider block*/ 						
		$return['featured_slider'] =   array(	
											0=>array(
												'image' =>'catalog/avethemes/browser1.png',
												'description' => array(1 => 'There are many variations of demo text passed sages of Lorem Ipsum available the majority.')
												),
												
											1=>array(
												'image' =>'catalog/avethemes/browser1.png',
												'description' => array(1 => 'There are many variations of demo text passed sages of Lorem Ipsum available the majority.')
											)
		
		);
		/*.featured block*/ 						
		$return['featured_block'] =   array(	
											array(
												'icon' =>'fa fa-trophy',
												'image' =>'catalog/avethemes/icon/clipboard.png',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Super Coding'),
												'description' => array(1 => 'There are many variations of demo text passed sages of Lorem Ipsum available the majority.')
											),
											array(
												'icon' =>'fa fa-mobile',
												'image' =>'catalog/avethemes/icon/console.png',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Best User Interface'),
												'description' => array(1 => 'There are many variations of demo text passed sages of Lorem Ipsum available the majority.')
											),
											array(
												'icon' =>'fa fa-heart',
												'image' =>'catalog/avethemes/icon/weather.png',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Unique Design'),
												'description' => array(1 => 'There are many variations of demo text passed sages of Lorem Ipsum available the majority.')
											),
											array(
												'icon' =>'fa fa-key',
												'image' =>'catalog/avethemes/icon/browser.png',
												'btn_href' => 'http://codecanyon.net/user/legendtheme',
												'btn_target' => '_blank',
												'title' => array(1 => 'Easy to Customize'),
												'description' => array(1 => 'There are many variations of demo text passed sages of Lorem Ipsum available the majority.')
											)
									);	
		/*.tabs_section*/ 						
		$return['tabs_section'] =   array(	
							array(
										'icon' =>'fa fa-star',
										'title' => array(1 => 'Vision'),
										'description' => array(1 => 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.\r\n And scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum available, but the majority have to suffered alteration iner some form with injected randomised words which.')
									)
								);
		/*.accordion_section*/ 						
		$return['accordion_section'] =   array(	
							array(
										'icon' =>'fa fa-star',
										'title' => array(1 => 'Vision'),
										'description' => array(1 => 'Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type.\r\n And scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum available, but the majority have to suffered alteration iner some form with injected randomised words which.')
									)
								);
		
		/*.text_slider*/ 		
		$return['wobbly_slider'] =   array(	
									array(
										'title' => array(1 => 'Wobbly Slideshow Effect'),
										'description' => array(1 => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour of this randomised words.'),
										'image' =>'catalog/avethemes/icons/shopping-bag.svg',
										'icon' =>'fa fa-arrow-right',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Follow Us')
									),	
									array(
										'title' => array(1 => 'A real Time-Saver'),
										'description' => array(1 => 'Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour of this randomised words There are many variations of passages.'),
										'image' =>'catalog/avethemes/icons/heart.svg',
										'icon' =>'fa fa-arrow-right',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Like Us')
									),	
									array(
										'title' => array(1 => 'Free updates & support'),
										'description' => array(1 => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour of this randomised words.'),
										'image' =>'catalog/avethemes/icons/letter.svg',
										'icon' =>'fa fa-arrow-right',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Hire me')
									)
								);	
		/*.text_slider*/ 		
		$return['text_slider'] =   array(	
									array(
										'description' => array(1 => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.'),
										'icon' =>'fa fa-arrow-right',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Follow Us')
									),	
									array(
										'description' => array(1 => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.'),
										'icon' =>'fa fa-arrow-right',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Like Us')
									),	
									array(
										'description' => array(1 => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.'),
										'icon' =>'fa fa-arrow-right',
										'btn_href' => 'http://codecanyon.net/user/legendtheme',
										'btn_target' => '_blank',
										'btn_title' => array(1=>'Hire me')
									)
								);	
		/*.pricing*/ 	
		$return['pricing'] =   array(
									0=>array (
										'image' =>'',
										'icon' =>'fa fa-rocket',
										'state' => '',
										'href' => '',
										'target' =>' _blank',
										'title' => array(1 => 'Starter 1'),
										'btn_title' => array(1 => 'Sign up'),
										'description' => array(1 => 'Description'),
										'line_price' => array(1=>'123'),
										'line_currency' => array(1=>'$'),
										'line_period' => array(1=>'month'),
										'line_feature1' => array(1=>'Feature 1'),
										'line_feature2' => array(1=>'Feature 2'),
										'line_feature3' => array(1=>'Feature 3'),
										'line_feature4' => array(1=>'Feature 4'),
										'line_feature5' => array(1=>'Feature 5'),
										'line_feature6' => array(1=>'Feature 6'),
										'line_feature7' => array( ),
										'line_feature8' => array( ),
										'more_desc' => array( )			
									)
		);	
		
		/*.featured_slider*/ 	
		$return['featured_group'] =   array(
											0=>array (
												'image' =>'catalog/avethemes/img1.jpg',
												'column_left'=> array(
																	0=> array(
																		'color' =>'#0072A5',
																		'icon' => 'fa fa-rocket',
																		'title' => array(1=>'Easy to customize'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'target' => '_blank'
																	),	
																	1=> array(
																		'color' =>'#4D4294',
																		'icon' => 'fa fa-laptop',
																		'title' => array(1=>'Responsive Design'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'target' => '_blank'
																	),	
																	2=> array(
																		'color' =>'#F36A71',
																		'icon' => 'fa fa-send-o',
																		'title' => array(1=>'Awesome Shortcodes'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'target' => '_blank'
																	)
												),
												'column_right'=> array(
																	0=> array(
																		'color' =>'#B853A3',
																		'icon' => 'fa fa-heart',
																		'title' => array(1=>'Endless Possibilities'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'target' => '_blank'
																	),	
																	1=> array(
																		'color' =>'#0CAEBF',
																		'icon' => 'fa fa-home',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'Boxed & Wide'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	),	
																	2=> array(
																		'color' =>'#0dc0c0',
																		'icon' => 'fa fa-play',
																		'title' => array(1=>'HTML5 Video'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'target' => '_blank'
																	)
												)
											),
											1=>array (
												'image' =>'catalog/avethemes/img2.jpg',
												'column_left'=> array(
																	0=> array(
																		'color' =>'#0072A5',
																		'icon' => 'fa fa-leaf',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'Diffrent Themes'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	),	
																	1=> array(
																		'color' =>'#4D4294',
																		'icon' => 'fa fa-paint-brush',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'Modern Design'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	),	
																	2=> array(
																		'color' =>'#F36A71',
																		'icon' => 'fa fa-gear',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'Easy to Use'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	)
												),
												'column_right'=> array(
																	0=> array(
																		'color' =>'#B853A3',
																		'icon' => 'fa fa-leaf',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'New Layout'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	),	
																	1=> array(
																		'color' =>'#0CAEBF',
																		'icon' => 'fa fa-leaf',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'Pricing Tables'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	),	
																	2=> array(
																		'color' =>'#0dc0c0',
																		'icon' => 'fa fa-leaf',
																		'href' => 'http://codecanyon.net/user/legendtheme',
																		'title' => array(1=>'Many Sections'),
																		'desc' => array(1=>'There are many variations of passages of Lorem Ipsum available but the majority.'),
																		'target' => '_blank'
																	)
												)
											)
										);	
								
		if(isset($return[$element])){						
			return $return[$element];
		}else{
			return array();
		}
		
	}
	
}
?>