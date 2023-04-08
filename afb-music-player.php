<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://aliyanfaisal.greymatter.com.pk
 * @since             1.0.0
 * @package           Afb_Music_Player
 *
 * @wordpress-plugin
 * Plugin Name:       Music Player
 * Plugin URI:        https://https://aliyanfaisal.greymatter.com.pk
 * Description:       A Music Player where you can add Audio of many types / Voices and play them any where through a Shortcode.
 * Version:           1.0.0
 * Author:            Aliyan Faisal
 * Author URI:        https://https://aliyanfaisal.greymatter.com.pk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       afb-music-player
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AFB_MUSIC_PLAYER_VERSION', '1.0.0' );


define("AFB_MUSIC_PATH", plugin_dir_path( __FILE__ ));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-afb-music-player-activator.php
 */
function activate_afb_music_player() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-afb-music-player-activator.php';
	Afb_Music_Player_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-afb-music-player-deactivator.php
 */
function deactivate_afb_music_player() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-afb-music-player-deactivator.php';
	Afb_Music_Player_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_afb_music_player' );
register_deactivation_hook( __FILE__, 'deactivate_afb_music_player' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-afb-music-player.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_afb_music_player() {

	$plugin = new Afb_Music_Player();
	$plugin->run();

}
run_afb_music_player();




add_shortcode("get_next_audio_url_afb", "afb_next_audio_shortcode");

add_shortcode("get_prev_audio_url_afb", "afb_prev_audio_shortcode");

function afb_next_audio_shortcode($args){
	
	
	if(empty($args['element'])){
		return "<h3>Please Provide the Element ID</h3>";
	}
	
	$element_id= $args['element'];
	
?>
<style>
	.loading_{
		text-align:center;
		min-height: 240px
	}
</style>
<script>
var current_audio_id= 0
var curr_post_id= "<?php echo get_the_ID(); ?>"

jQuery(function($){
	
	$("#<?php echo $element_id; ?>").click(function(e){
		e.preventDefault()
		console.log("clicked")
		$(".afb_player_div").html(afbGetSkeleton())
		$.post({
			"url":"<?php echo get_site_url(null , "wp-json/afb-player/get-next") ?>",
			"data": {"curr_id": current_audio_id+1, "post_id": curr_post_id},
			"dataType": "html",
			"success": function(data){
				console.log("next html", current_audio_id)
				data= JSON.parse(data)
				current_audio_id= data['id']
				$(".afb_player_div").html(data["html"])
			}
		})
	})
	
})
	
function afbGetSkeleton(){
	return `<style>
	.my_flex{
  width: 100%;
  display: flex; 
  justify-content: center;
  flex-direction: column;
  align-items: center;
}

.img_player{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  margin: 30px 0px;
  width: 100%;
  justify-content: center;
}
.details{
  flex-grow: 1
}


.cardx{
  width: 100%;
  background: #fff;
  padding: 30px;
  border-radius: 30px;
  box-shadow: 0px 0px 18px -3px rgb(200 200 200 / 50%);
  display: flex;
  justify-content: center;
}
.cardx .headerx{
  display: flex;
  align-items: center;
}
.headerx .img{
  height: 55px;
  width: 55px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
  overflow: hidden;
}

.img_2{
    height: 40px;
    width: 40px;
    background: #d9d9d9;
    border-radius: 50%;
    position: relative;
    overflow: hidden;
    margin-right: 5px
}

.headerx .details{
  margin:0px 12px;
}
.mybg{
  display: block;
  background: #d9d9d9;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}
.name{
  height: 32px;
  width: 45%;
}

.details .about{
  height: 70px;
  /*width: 150px;*/
  /*margin-top: 10px;*/
}
.cardx .description{
  margin: 25px 0;
}
.description .line{
  background: #d9d9d9;
  border-radius: 10px;
  height: 13px;
  margin: 10px 0;
  overflow: hidden;
  position: relative;
}
.description .line-1{
  width: calc(100% - 15%);
}
.description .line-3{
  width: calc(100% - 40%);
}
.cardx .btns{
  margin: 0px 30px;
  margin-top: 44px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  
}
.cardx .btns .btn{
  height: 35px;
  width: 100%;
  background: #d9d9d9;
  border-radius: 25px;
  position: relative;
  overflow: hidden;
}
.btns .btn-1{
  margin-right: 8px;
  background: #d9d9d9;
  width: 90px !important;
  /*height: 25px !important*/
}
.btns .btn-2{
  margin-left: 8px;
  max-width: 120px !important
}

.details span::before,
.description .line::before,
.btns .btn-2::before{
  position: absolute;
  content: "";
  height: 100%;
  width: 100%;
  background-image: linear-gradient(to right, #d9d9d9 0%, rgba(0,0,0,0.05) 20%, #d9d9d9 40%, #d9d9d9 100%);
  background-repeat: no-repeat;
  background-size: 450px 400px;
  animation: shimmer 1s linear infinite;
}
.headerx .img::before{
  background-size: 650px 600px;
}
.details span::before{
  animation-delay: 0.2s;
}
.btns .btn-2::before{
  animation-delay: 0.22s;
}
@keyframes shimmer {
  0%{
    background-position: -450px 0;
  }
  100%{
    background-position: 450px 0;
  }
}	
</style>

<div class="cardx">
  <div style="max-width:480px; width: 100%">
  <div class="headerx">

    <div class="my_flex">
      <span class="name mybg"></span>
      
      <div class="img_player">
        <div class="img"></div>
        <div class="details">
          <span class="about mybg"></span>
        </div>
        <div class="img_2"></div>
        <div class="img_2"></div>
      </div>

      <span class="name mybg"></span>
    </div>
    
  </div>
  <div class="description">
  </div>
  <div class="btns">
    <div class="btn btn-1"></div>
    <div class="btn btn-2"></div>
  </div>
  </div>
</div>`
}

</script>

<?php

};



function afb_prev_audio_shortcode($args){
	
	
	if(empty($args['element'])){
		return "<h3>Please Provide the Element ID</h3>";
	}
	
	$element_id= $args['element'];
	
?>
<style>
	.loading_{
		text-align:center;
		min-height: 240px
	}
</style>
<script>
// var current_audio_id= "<?php echo get_the_ID(); ?>"

jQuery(function($){
	
	$("#<?php echo $element_id; ?>").click(function(e){
		e.preventDefault()
		console.log("clicked")
		$(".afb_player_div").html(afbGetSkeleton())
		$.post({
			"url":"<?php echo get_site_url(null , "wp-json/afb-player/get-prev") ?>",
			"data": {"curr_id": current_audio_id-1, "post_id": curr_post_id},
			"dataType": "html",
			"success": function(data){
				data= JSON.parse(data)
				console.log("prev html received", current_audio_id , data)
				current_audio_id= data['id']
				$(".afb_player_div").html(data ['html'] )
			}
		})
	})
	
})
	

</script>

<?php

};



add_action( 'rest_api_init', function () {
  register_rest_route( 'afb-player', '/get-next', array(
    'methods' => 'POST',
    'callback' => 'send_next_audio',
    'permission_callback' => ""
  ) );
	
  register_rest_route( 'afb-player', '/get-prev', array(
    'methods' => 'POST',
    'callback' => 'send_next_audio',
    'permission_callback' => ""
  ) );
});

function send_next_audio(\WP_REST_Request $request){
	
	if($request['curr_id']==""){
		echo  json_encode( ["id"=> 0, "html" => "Current Audio ID Missing"]); exit;
	}
	
	if($request['post_id']==""){
		echo  json_encode( ["id"=> 0, "html" => "Post ID Missing"]); exit;
	}
	
	$curr_id= intval($request['curr_id']);
	if($curr_id < 0){
		$curr_id=0;
	}
	
// 	$next_audio= get_post_meta( $request['post_id'], 'audios', true);
// 	$next_id = $next_audio['item-'.$curr_id][]
	$reset=false;
	$post_id= $request['post_id'];
	$cont= do_shortcode("[MusicPlayerAFB id='$post_id' curr_id='{$curr_id}']");
	
	echo json_encode( [ "id"=> ($reset ? 0: $curr_id), "html" => $cont] );
}


function send_prev_audio(\WP_REST_Request $request){
	
	if($request['curr_id']==""){
		echo "Current Audio ID Missing"; exit;
	}

	$args=array(
		'post_type' => "musicplayer",
		'meta_key'   => 'musicplayer_next_id',
		'meta_value' => $request['curr_id'],
		"posts_per_page" => 1,
		"numberposts"  => 1
	);
	
	$prev_audio = get_posts($args )[0];
// 	echo json_encode($prev_audio); exit;
	$prev_id= $prev_audio->ID ??  $request['curr_id'] ;
	$cont= do_shortcode("[MusicPlayerAFB id='$prev_id' ]");
	
	echo json_encode( [ "id"=> $prev_id, "html" => $cont] );
}



function getLoadingFunc(){
	ob_start();
	?>

<?php
	$content= ob_get_contents();
	ob_clean();
	echo $content;
	
}




// .///// SHORTCODES
// 
add_shortcode("afb_media_url", function($args){
	$type= isset($args['type']) ? $args['type'] :  "male";
	$audio_id= get_post_meta( get_the_ID(), "afb_music_player_audio_{$type}", true);
	 $url = wp_get_attachment_url($audio_id);
	echo $url;
});


add_shortcode("get_curr_chapters", function($args){
	
	$terms = get_the_terms( get_the_ID() , array( 'chapters') );

	$att_chapters="";
	foreach($terms as $term){
// 		$att_chapters += $term->name;
		$att_chapters .= $term->name.",";
	}
	
	echo $att_chapters;
});
