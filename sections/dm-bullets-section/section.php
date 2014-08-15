<?php

/*

    Section: Bullets

    Description: Easily add bullet point lists to your Pagelines DMS site.

    Author: Catapult Impact

    Author URI: http://www.catapultimpact.com

    Demo: http://catapultimpact.com/pagelines/bullets/
	
	Class Name: catapultimpactDMSBullets

    Version: 1.0

	Filter: component
	
	Loading: active

*/

class catapultimpactDMSBullets extends PageLinesSection{

	function get_plugin_url() {
		$plugins_url = plugins_url();
		$path_dir = pathinfo(dirname(__file__));
		$path_main_dir = explode("/plugins/",$path_dir["dirname"]);
        $section = "/".$path_main_dir[1]."/".$path_dir['basename']."/";
		$url = $plugins_url.$section;
		return $url;
   }
   
   function section_head() {
		$link = $this->get_plugin_url();
	   ?>
		<link rel='stylesheet' href='<?php echo $link; ?>css/maincss.css' type='text/css' media='all' />
	   <?php
   }
	
	function section_opts(){
	
		$options = array();

		$options[] = array(

			'key'		=> 'dmsbullets_show_settings',

			'type'		=> 'multi',

			'title'		=> __('DMS Bullets Main Options', 'pagelines'),

			'col'		=> 1,

			'opts'	=> array(

				array(

					'key'	=> 'dmsbullets_font_size',

					'type' 	=> 'text',

					'label' => 'Font Size',					

					'help'	=> 'Enter font size in px (e.g. 10px)'

				),

				array(

					'key'	=> 'dmsbullets_line_hgt',

					'type' 	=> 'text',

					'label' => 'Line Height',
					
					'help'  => 'Enter line height in px (e.g. 2px)'

				),

				array(

					'key'	=> 'dmsbullets_padding',

					'type' 	=> 'text',

					'label' => 'Padding',

					'help'  => 'Enter padding in px (e.g. 10px)'
				),
				
				array(

					'key'	=> 'dmsbullets_bet_padding',

					'type' 	=> 'text',

					'label' => 'Padding between bullets',

					'help'  => 'Enter padding in px (e.g. 10px)'
				),
				
			),

		);
		
		$options[] = array(
			'key'		=> 'dmsbullets_array',
	    	'type'		=> 'accordion', 
			'col'		=> 2,
			'title'		=> __('DMS Bullets Setup', 'pagelines'), 
			'post_type'	=> __('DMS Bullets', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'text',
					'label'	=> __( 'DMS Bullets Text', 'pagelines' ),
					'type'	=> 'textarea'
				),
				array(
					'key'		=> 'bullet_to_text_dist',
					'label'	=> __( 'Bullet to text distance (in pixels)', 'pagelines' ),
					'type'	=> 'text'
				),
				array(
					'key'		=> 'icon',
					'label'		=> __( 'Icon (Icon Mode)', 'pagelines' ),
					'type'		=> 'select_icon'
				),
				array(
					'key'		=> 'image',
					'label'		=> __( 'Box Image (Image Mode)', 'pagelines' ),
					'type'		=> 'image_upload'
				),
				array(
					'key'		=> 'color',
					'label'		=> __( 'Icon Color', 'pagelines' ),
					'type'		=> 'color'
				),
				

			)
	    );

		return $options;
	
	}

	function section_template() {
	
		// The DMS Bullets
		
		$dmsbullets_array = $this->opt('dmsbullets_array');
		
		// Keep
		$dmsbullets_font_size = ($this->opt('dmsbullets_font_size')!='') ? rtrim( $this->opt('dmsbullets_font_size'),'px' ) : 20;
		$dmsbullets_line_hgt = ($this->opt('dmsbullets_line_hgt')!='') ? rtrim( $this->opt('dmsbullets_line_hgt'),'px' ) : '';
		$dmsbullets_padding = ($this->opt('dmsbullets_padding')!='') ? rtrim( $this->opt('dmsbullets_padding'),'px' ) : 10;
		$dmsbullets_bet_padding = ($this->opt('dmsbullets_bet_padding')!='') ? rtrim( $this->opt('dmsbullets_bet_padding'),'px' ) : 15;
		
		$padding_str = '';
		$line_hgt_str = '';
		$margin_top_str = '';
		
		if( $dmsbullets_line_hgt != '' ){
			$line_hgt_str = 'line-height: '.$dmsbullets_line_hgt.'px;';
			$margin_top_str = 'margin-top: -'.$dmsbullets_line_hgt.'px;';
		}else{
			$margin_top_str = 'margin-top:: -34px;';
		}
		
		if( is_array($dmsbullets_array) ){

			$dmsbullets = count( $dmsbullets_array );
				
			$count = 1;
			
			if( isset($dmsbullets_padding) && $dmsbullets_padding != '' ){
				$padding_str = 'padding: '.$dmsbullets_padding.'px;';
			}
		?> 

			<div id="outer_dms_bullets_div" style="<?php echo $padding_str; ?>">

				<ul style="font-size: <?php echo $dmsbullets_font_size; ?>px;">

		<?php 	foreach ($dmsbullets_array as $dmsbullet){
		
					$text = pl_array_get( 'text', $dmsbullet, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
					$bullet_to_text_dist = pl_array_get( 'bullet_to_text_dist', $dmsbullet,10 );
					$bullet_to_text_dist = rtrim( $bullet_to_text_dist,'px' );
					$bullet_to_text_dist = $bullet_to_text_dist + 28;
					$image = pl_array_get( 'image', $dmsbullet );
					$icon = pl_array_get( 'icon', $dmsbullet );
					$color = pl_hash( pl_array_get( 'color', $dmsbullet ), false);
					$imgStr = '';

					if( !$image || $image == '' ){
						
						if( !$icon || $icon == '' ){
							
							$icons = pl_icon_array();
							
							$icon = $icons[ array_rand($icons) ];
							
							$imgStr = '';
						
						}
						
					}elseif( isset($image) && $image != '' ){
					
						$src = $image;
						
						$imgStr = "<img src='".$src."' style='width: 32px;' />";
						
						$icon = '';
					
					}

		?>

					<li class='iii icon icon-1x icon-<?php echo $icon; ?>' style="<?php echo $line_hgt_str; ?>; color: <?php echo $color; ?>; padding-bottom: <?php echo $dmsbullets_bet_padding; ?>px;" id="dms_bullets_li" >
						
						<?php echo $imgStr; ?>
						
						<span style="color: #000000; margin-left: <?php echo $bullet_to_text_dist; ?>px; <?php echo $margin_top_str; ?> display: block;"><?php echo $text; ?></span>

					</li>

					

		<?php 	

				}

		?>

				</ul>

			</div>

			<div style="clear: both;"></div>

	<?php

			
		}

	}

}

?>