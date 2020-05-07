<?php
error_reporting(0);
/*
Plugin Name: Radio Plugin para WordPress 
Plugin URI: http://www.operdev.com
Description: Radio Streaming para NoticiasNEA.com
Version: 1.0.0
Author: Mauro Rementeria - Operdev
Author URI: http://www.operdev.com
*/ 


 
// Datos Introductorios


$radiolink		= 'http://server:port/';
$radiotype					= 'shoutcast';
$bcolor					= '000000';

$image					= 'logo.gif';
$facebook					= 'http://www.facebook.com/';
$twitter					= 'http://twitter.com/';


$title					= 'Radio Player';
$artist					= 'Radio Artista';


// Colocando los defaults dentro de la tabla "wp-options"



add_option("shoutcast-icecast-html5-player-radiolink", $radiolink);
add_option("shoutcast-icecast-html5-player-radiotype", $radiotype);

add_option("shoutcast-icecast-html5-player-bcolor", $bcolor);

add_option("shoutcast-icecast-html5-player-image", $image);
add_option("shoutcast-icecast-html5-player-facebook", $facebook);
add_option("shoutcast-icecast-html5-player-twitter", $twitter); 



add_option("shoutcast-icecast-html5-player-title", $title);
add_option("shoutcast-icecast-html5-player-artist", $artist); 


// Base de datos - Null por ahora





//AWS Información de acceso - Null por ahora



// Inicia plugin
if ( ! class_exists( 'Shoutcast_Icecast_HTML5_Player' ) ) {
	class Shoutcast_Icecast_HTML5_Player {
// prep options page insertion
		function add_config_page() {
			if ( function_exists('add_submenu_page') ) {
				add_options_page('Opciones Radio Streaming NoticiasNEA', 'Otras opciones', 10, basename(__FILE__), array('Shoutcast_Icecast_HTML5_Player','config_page'));
			}	
	}
// Opciones y seteos para WP-Admin
		function config_page() {
			if ( isset($_POST['submit']) ) {
				$nonce = $_REQUEST['_wpnonce'];
				if (! wp_verify_nonce($nonce, 'shoutcast-icecast-html5-player-updatesettings') ) die('Chequeo de seguridad fallido'); 
				if (!current_user_can('manage_options')) die(__('No se puede editar'));
				check_admin_referer('shoutcast-icecast-html5-player-updatesettings');	
			// Nuevos valores
			
			$radiolink	= $_POST['radiolink'];
			$radiotype	= $_POST['radiotype'];
			
			$bcolor	= $_POST['bcolor'];
			
			$image	= $_POST['image'];
			$facebook	= $_POST['facebook'];
			$twitter	= $_POST['twitter'];
			
			
			$title	= $_POST['title'];
			$artist	= $_POST['artist'];
			
		    // Update the DB with the new option values
			
			update_option("shoutcast-icecast-html5-player-radiolink", mysql_real_escape_string($radiolink));
			update_option("shoutcast-icecast-html5-player-radiotype", mysql_real_escape_string($radiotype));
			
			update_option("shoutcast-icecast-html5-player-bcolor", mysql_real_escape_string($bcolor));
			
			update_option("shoutcast-icecast-html5-player-image", mysql_real_escape_string($image));
			update_option("shoutcast-icecast-html5-player-facebook", mysql_real_escape_string($facebook));
			update_option("shoutcast-icecast-html5-player-twitter", mysql_real_escape_string($twitter));
			
			
			update_option("shoutcast-icecast-html5-player-title", mysql_real_escape_string($title));
			update_option("shoutcast-icecast-html5-player-artist", mysql_real_escape_string($artist));
			
			}
			
			
			$radiolink	= get_option("shoutcast-icecast-html5-player-radiolink");
			$radiotype	= get_option("shoutcast-icecast-html5-player-radiotype");	
			
			$bcolor	= get_option("shoutcast-icecast-html5-player-bcolor");	
			
			$image	= get_option("shoutcast-icecast-html5-player-image");	
			$facebook	= get_option("shoutcast-icecast-html5-player-facebook");	
			$twitter	= get_option("shoutcast-icecast-html5-player-twitter");	
			
			
			$title	= get_option("shoutcast-icecast-html5-player-title");	
			$artist	= get_option("shoutcast-icecast-html5-player-artist");	
			
?>

<div class="wrap">
  <h2>Radio Streaming NoticiasNEA</h2>
  
  
  <?php
  
  // Check for CURL
//if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) die("\nERROR: CURL extension not loaded\n\n");
  
  
  ?>
  
  
  <form action="" method="post" id="shoutcast-icecast-html5-player-config">
    <table class="form-table">
      <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('shoutcast-icecast-html5-player-updatesettings'); } ?>
       
      
      
            
      <tr>
        <th scope="row" valign="top"><label for="radiolink">Radio Stream Link:</label></th>
        <td><input type="text" name="radiolink" id="radiolink" class="regular-text" value="<?php echo $radiolink; ?>"/>(Servidor + puerto)</td>
      </tr>
      
      <tr>
        <th scope="row" valign="top"><label for="radiotype">Radio Tipo:</label></th>
        
        <td>
        <select name="radiotype">
        <option value="shoutcast" <?php if($radiotype=="shoutcast") echo ' selected="selected"'; ?>>Shoutcast</option>
        <option value="icecast" <?php if($radiotype=="icecast") echo ' selected="selected"'; ?>>Icecast</option>
        </select>
        </td>
      </tr>
      
      
     
      
      
      <tr>
        <th scope="row" valign="top"><label for="player">Color de fondo:</label></th>
        
        <td>
        #<input class="color" name="bcolor" type="text" value="<?php echo $bcolor; ?>" />
        </td>
      </tr>
      
      
       <tr>
        <th scope="row" valign="top"><label for="player">Imágen de fondo:</label></th>
        
        <td>
        <input name="image" type="text" class="regular-text" value="<?php echo $image; ?>" />
        </td>
      </tr>
      
      

      
      
      
      <tr>
        <th scope="row" valign="top"><label for="player">Titulo de la Radio:</label></th>
        
        <td>
        <input name="title" type="text" class="regular-text" value="<?php echo $title; ?>" />
        </td>
      </tr>
      
      <tr>
        <th scope="row" valign="top"><label for="player">Fuente de la Radio:</label></th>
        
        <td>
        <input name="artist" type="text" class="regular-text" value="<?php echo $artist; ?>" />
        </td>
      </tr>
      
      
      
       <tr>
        <th scope="row" valign="top"><label for="player">Facebook Link:</label></th>
        
        <td>
        <input name="facebook" type="text" class="regular-text" value="<?php echo $facebook; ?>" />
        </td>
      </tr>
      
       <tr>
        <th scope="row" valign="top"><label for="player">Twitter Link:</label></th>
        
        <td>
        <input name="twitter" type="text" class="regular-text" value="<?php echo $twitter; ?>" />
        </td>
      </tr>
      
      
      
      
      

    </table>
    <br/>
    <span class="submit" style="border: 0;">
    <input type="submit" name="submit" value="Save Settings" />
    </span>
  </form>
 <?php shoutcast_icecast_html5_player(); ?>
<br />
<?php /*?><h3>PHP Code for template php files</h3>
<code>&lt;?php shoutcast_icecast_html5_player(); ?&gt;</code><?php */?>

<h3>Código Web</h3>
<code>[html5radio radiolink="<?php echo $radiolink; ?>" radiotype="<?php echo $radiotype; ?>" bcolor="<?php echo $bcolor; ?>" image="<?php echo $image; ?>" title="<?php echo $title; ?>" artist="<?php echo $artist; ?>"]</code><br /><br />


<?php //echo $scode; ?>

<?php

$pluginurl	=	plugin_dir_url( __FILE__ );


$iframe = '<iframe src="http://html5radio.svnlabs.com/html5'.$radiotype.'.php?radiolink='.$radiolink.'&radiotype='.$radiotype.'&bcolor='.$bcolor.'&image='.$image.'&facebook='.$facebook.'&twitter='.$twitter.'&title='.$title.'&artist='.$artist.'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" width="367" height="227"></iframe>';


?>
<br />

<hr />

<h3>Código Embebido</h3>

<textarea cols="60" rows="10" onFocus="this.select();" style="border:1px dotted #343434" ><?php echo $iframe; ?></textarea>

<!-- Paypal etc.  --><br />


<strong><a href="http://html5plus.svnlabs.com/shop/html5-mp3-radio-fm-stream/" target="_blank">Radio Streaming NoticiasNEA</a></strong>

<br />



<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=181968385196620";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="https://www.facebook.com/Html5Mp3Player" data-send="true" data-width="450" data-show-faces="true"></div>  

 </div>
<?php		}
	}
} 
  
// Funciona Base
function shoutcast_icecast_html5_player($atts = null, $content = null) {

// URL del Plugin


$radiolink	= get_option("shoutcast-icecast-html5-player-radiolink");	
$radiotype	= get_option("shoutcast-icecast-html5-player-radiotype");

$bcolor	= get_option("shoutcast-icecast-html5-player-bcolor");

$image	= get_option("shoutcast-icecast-html5-player-image");
$facebook	= get_option("shoutcast-icecast-html5-player-facebook");
$twitter	= get_option("shoutcast-icecast-html5-player-twitter");


$title	= get_option("shoutcast-icecast-html5-player-title");
$artist	= get_option("shoutcast-icecast-html5-player-artist");



$pluginurl	=	plugin_dir_url( __FILE__ );


extract( shortcode_atts( array(
		'radiolink' => $radiolink,
		'radiotype' => $radiotype,
		'bcolor' => $bcolor,
		'image' => $image,
		'facebook' => $facebook,
		'twitter' => $twitter,
		'title' => $title,
		'artist' => $artist,
	), $atts ) );
 
 


echo '<br />';


/*echo '<iframe src="'.$pluginurl.'html5/html5'.$radiotype.'.php?radiotype='.$radiotype.'&radiolink='.$radiolink.'&rand='.rand().'&bcolor='.$bcolor.'&image='.$image.'&facebook='.$facebook.'&twitter='.$twitter.'&title='.$title.'&artist='.$artist.'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" width="367" height="227"></iframe>';*/

echo '<iframe src="http://html5radio.svnlabs.com/html5'.$radiotype.'.php?radiotype='.$radiotype.'&radiolink='.$radiolink.'&rand='.rand().'&bcolor='.$bcolor.'&image='.$image.'&facebook='.$facebook.'&twitter='.$twitter.'&title='.$title.'&artist='.$artist.'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" width="367" height="227"></iframe>';




}

// Insertar dentro del panel de control
add_action('admin_menu', array('Shoutcast_Icecast_HTML5_Player','add_config_page'));
add_shortcode( 'html5radio', 'shoutcast_icecast_html5_player' );


function  shoutcast_icecast_html5_player_scripts_method() {
	
    wp_register_script( 'shoutcast_icecast_html5_player_scripts1', plugins_url( '/html5/jscolor.js', __FILE__ ) );
    wp_enqueue_script( 'shoutcast_icecast_html5_player_scripts1' );
	
/*	wp_register_script( 'custom-script1', plugins_url( '/html5lyrics/js/jscolor.js', __FILE__ ) );
    wp_enqueue_script( 'custom-script1' );
	
	wp_register_script( 'custom-script2', plugins_url( '/html5lyrics/js/core.js', __FILE__ ) );
    wp_enqueue_script( 'custom-script2' );
*/	
	
	
}    
 
add_action('wp_enqueue_scripts', 'shoutcast_icecast_html5_player_scripts_method');


?>