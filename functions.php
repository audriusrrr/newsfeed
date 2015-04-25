<?php

// POST TYPES

// TAXONOMIES

// NAV-WALKERS

// PLUGINS
include_once('functions/plugins/advanced-custom-fields/acf.php' );
include_once('functions/plugins/acf-options-page/acf-options-page.php' );
include_once('functions/plugins/acf-repeater/acf-repeater.php' );
include_once('functions/plugins/make-css.php' );
require_once('functions/composer/vendor/mailchimp/mailchimp/src/Mailchimp.php');


// WIDGETS

// CUSTOM FIELDS


// SUPPLEMENTARY FUNCTIONS


function add_meta_data_on_post_save( $post_id ) {

$type = get_field( 'type_of_post', $post_id );
if($type == 'instagram'):

  $url = get_field( 'instagram_url', $post_id );
  $api_call = 'http://api.instagram.com/oembed?url='.$url;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $api_call);
  $result=curl_exec($ch);
  curl_close($ch);

  $res = json_decode($result);

  //wp - bugfix
  delete_post_meta($post_id,'insta_obj');
  add_post_meta($post_id, 'insta_obj', $res);

elseif($type == 'video'):

  $url = get_field( 'video_url', $post_id );
  if(is_youtube($url)):

    $id = getIdFromYoutubeUrl($url);
    $img = "http://img.youtube.com/vi/{$id}/mqdefault.jpg";
    delete_post_meta($post_id,'video_img');
    add_post_meta($post_id, 'video_img', $img);

  elseif(is_vimeo($url)):

    $img = getImgFromVimeoUrl($url);
    delete_post_meta($post_id,'video_img');
    add_post_meta($post_id, 'video_img', $img);
    echo $img;

  endif;


elseif($type == 'facebook'):

  $app_id = get_field('facebook_app_id', 'options');
  $app_secret = get_field('facebook_app_secret', 'options');
  $token = $app_id.'|'.$app_secret;
  // $session = new FacebookSession('600923450036805|d4ed3ad1752156bdbfbbee212d577a7f');

  $url = get_field('facebook_status_url', $post_id);
  if(strpos($url,'/posts/') !== false):
    $url = trim(strtok($url, '?'), "/");
    $url = substr(strrchr($url, "/"), 1 );
  elseif(strpos($url,'video.php') !== false):
    parse_str(parse_url($url, PHP_URL_QUERY), $array);
    $url = $array['v'];
  elseif(strpos($url,'photo.php') !== false):
    parse_str(parse_url($url, PHP_URL_QUERY), $array);
    $url = $array['fbid'];
  endif;

  // echo $url;
  $ch = curl_init('https://graph.facebook.com/'.$url.'?access_token='.$token);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  $response = curl_exec($ch);
  $res = json_decode($response);
          delete_post_meta($post_id,'fb_obj');
          add_post_meta($post_id, 'fb_obj', $res);


$img = $res->images[2]->source;
$author = $res->from->name;

$name = facebookify($res->description);
if(!$name){
  $name = $res->name;
}

          update_field('facebook_api_return', $response, $post_id);
          update_field('facebook_image_url', $img, $post_id);
          update_field('facebook_author', $author, $post_id);
          update_field('post_name', $name, $post_id);
// die();


elseif($type == 'tumblr'):
  require 'functions/composer/vendor/autoload.php';
  
  $tumblr_key = get_field('tumblr_api_key', 'options');
      // Authenticate via API Key
    $client = new Tumblr\API\Client($tumblr_key);
    $url = get_field('tumblr_url', $post_id);
    $id = (int) get_tumblr_id($url);
    $subdomain = getHost($url);
    if($subdomain):
    // Make the request
    $res = $client->getBlogPosts($subdomain, array('id' => $id));
        delete_post_meta($post_id,'tumblr_obj');
        add_post_meta($post_id, 'tumblr_obj', $res);
          update_field('tumblr_return_api', json_encode($res), $post_id);

$img = $res->posts[0]->photos[0]->original_size->url;
$caption = strip_tags($res->posts[0]->caption);
$desc = $res->posts[0]->description;
$blog = $res->blog->title;
if(!$blog)
    $blog = $res->blog->name;

update_field('tumblr_image_url', $img, $post_id);
update_field('tumblr_image_caption', $caption, $post_id);
update_field('tumblr_image_description', $desc, $post_id);
update_field('tumblr_blog_title', $blog, $post_id);



    endif;
elseif($type == 'twitter'):
  include_once('functions/twitter.php' );
  
$oauth_access_token = get_field('twitter_oauth_access_token', 'options');
$oauth_access_token_secret = get_field('twitter_oauth_access_token_secret', 'options');
$consumer_key = get_field('twitter_consumer_key', 'options');
$consumer_secret = get_field('twitter_consumer_secret', 'options');

$settings = array(
    'oauth_access_token' => $oauth_access_token,
    'oauth_access_token_secret' => $oauth_access_token_secret,
    'consumer_key' => $consumer_key,
    'consumer_secret' => $consumer_secret
);

$input_url = get_field('twitter_url', $post_id);
$tweet_id = basename($input_url);
$url = 'https://api.twitter.com/1.1/statuses/show/'.$tweet_id.'.json';
$getfield = '?include_entities=true';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$result =  $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();  

$res = json_decode($result);
delete_post_meta($post_id,'tweet_obj');
add_post_meta($post_id, 'tweet_obj', $res);

endif;

}

// run after ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'add_meta_data_on_post_save', 20);

 function twitterify($ret) {
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a target=\"_blank\" href=\"\\2\" >\\2</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a target=\"_blank\" href=\"http://\\2\" >\\2</a>", $ret);
  $ret = preg_replace("/@(\w+)/", "<a target=\"_blank\" href=\"http://www.twitter.com/\\1\" >@\\1</a>", $ret);
  $ret = preg_replace("/#(\w+)/", "<a target=\"_blank\" href=\"http://search.twitter.com/search?q=\\1\" >#\\1</a>", $ret);
return $ret;
}

function facebookify($ret) {
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a target=\"_blank\" href=\"\\2\" >\\2</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a target=\"_blank\" href=\"http://\\2\" >\\2</a>", $ret);
  $ret = preg_replace("/#(\w+)/", "<a target=\"_blank\" href=\"https://www.facebook.com/hashtag/\\1\" >#\\1</a>", $ret);
return $ret;
}


// function redundant_cast( $post_id ) {
    
//     $people = "";
// if ( have_rows('people_cast', $post_id) ) : while( have_rows('people_cast', $post_id) ) : the_row();
//     $people .= ' '.get_sub_field('cast_name');
// endwhile;endif;

// if ( have_rows('Creatives', $post_id) ) : while( have_rows('Creatives', $post_id) ) : the_row();
//     $people .= ' '.get_sub_field('creatives_name');
// endwhile;endif;

// // die(print_r($a));   

// }
// add_action('acf/save_post', 'redundant_cast', 30);


add_action('wp_ajax_get_client', 'get_client');
function get_client(){
  $api_ID = $_GET['mcID'];

  require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_general.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_lists.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_clients.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_subscribers.php';


$api_key = get_field('campaign_monitor_api_key', 'options');
$client_id = get_field('campaign_monitor_client_id', 'options');
$list_id = get_field('campaign_monitor_list_id', 'options');

$auth = array('api_key' => $api_ID);
$wrap = new CS_REST_General($auth);

$result = $wrap->get_clients();
echo "<pre>";
var_dump($result->response);
echo "</pre>";


  exit;
}

add_action('wp_ajax_get_lists', 'get_lists');
function get_lists(){
  $api_ID = $_GET['mcID'];
  $client_id = $_GET['cID'];

  require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_general.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_lists.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_clients.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_subscribers.php';

$auth = array('api_key' => $api_ID);


$wrap = new CS_REST_Clients(
    'b45eebae99f7b69a20ed9447222c18e8', 
    $auth);

$result = $wrap->get_lists();

echo "Result of /api/v3.1/clients/{id}/lists\n<br />";
if($result->was_successful()) {
    echo "Got lists\n<br /><pre>";
    var_dump($result->response);
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
}
echo '</pre>';



  exit;
}


add_action('wp_ajax_nopriv_get_boxes', 'get_boxes');
add_action('wp_ajax_get_boxes', 'get_boxes');

function get_boxes(){
$page = $_GET['page'];
$tags = $_GET['tags'];
$secTags = $_GET['secTags'];
// print_r($tags);
$posts_per_page = get_field('posts_per_page', 'options');
  $args = array(
    'post_type'   => 'post',
    'posts_per_page'  => $posts_per_page,
    'paged' => $page,
    'tag__in'=> $tags,
    'meta_key'=>'type_of_post',
    'meta_value'=>$secTags
  );

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
  $type = get_field('type_of_post');
  if($type == 'tumblr'):
    get_template_part( 'content/article', 'small-tumblr' );
  elseif($type == 'facebook'):
    get_template_part( 'content/article', 'small-facebook' );
  elseif($type == 'instagram'):
    get_template_part( 'content/article', 'small-instagram' );
  elseif($type == 'twitter'):
    get_template_part( 'content/article', 'small-twitter' );
  elseif($type == 'video'):
    get_template_part( 'content/article', 'small-video' );
  else:
    get_template_part( 'content/article', 'small-other' );
  endif;
endwhile;
else:
  get_template_part( 'content/article', 'none-found' );
endif;

if($the_query->max_num_pages > $page):
  get_template_part( 'content/article', 'next-page' );
endif;


    exit;
}



add_action('wp_ajax_nopriv_subscribe_to_list', 'subscribe_to_list');
add_action('wp_ajax_subscribe_to_list', 'subscribe_to_list');

function subscribe_to_list(){

require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_general.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_lists.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_clients.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_subscribers.php';

$email_sub = $_GET['email_sub'];

$api_key = get_field('campaign_monitor_api_key', 'options');
$client_id = get_field('campaign_monitor_client_id', 'options');
$list_id = get_field('campaign_monitor_list_id', 'options');
$subscription_msg = get_field('subscription_msg', 'options');

$auth = array('api_key' => $api_key);
$wrap = new CS_REST_Subscribers($list_id, $auth);
$result = $wrap->add(array(
    'EmailAddress' => $email_sub,
    'Resubscribe' => true
));

if($result->was_successful()) {
    echo $subscription_msg;
} else {
    echo $result->response->Message;
}

    exit;
}




// DEFINE ACF
// define( 'ACF_LITE' , false );

add_filter('show_admin_bar', '__return_false');

// image sizes
add_theme_support( 'post-thumbnails' );
add_image_size( 'small-box', 300, 9999, false );
add_image_size( 'big-box', 940, 1200, false );

// ADMIN FAVICON
function pa_admin_area_favicon() {
	$size = 'full';
	$image_object = get_field('favcion', 'options');
	$attachment_id = $image_object['id'];
	$img_src = wp_get_attachment_image_src( $attachment_id, $size );
	echo '<link rel="shortcut icon" href="' . $img_src[0] . '" />';
}
 
add_action('admin_head', 'pa_admin_area_favicon'); 

// REGISTER NAVIGATIONS
function register_my_nav_menus(){
	register_nav_menus( array(
	    'bottom' => __( 'Bot Navigation' ),
    ));
}
// add_action('init', 'register_my_nav_menus');


function ai_register_style() {
	    wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
      wp_register_style( 'main_style', get_template_directory_uri() . '/assets/css/style.css' );

      // ENQUEUE
      wp_enqueue_style( 'bootstrap' );
      wp_enqueue_style( 'main_style' );

}


add_action( 'wp_enqueue_scripts', 'ai_register_style' );

function ai_admin_style() {
      wp_register_style('admin-style', get_template_directory_uri() . '/assets/css/admin.css' );
      wp_enqueue_style('admin-style');

}
add_action( 'admin_enqueue_scripts', 'ai_admin_style' );


// REGISTER SCRIPTS
function ai_register_scripts() {
    // HEADER
    
    // FOOTER 
    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), false, true );
    wp_register_script( 'imagesloaded-js', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array( 'jquery' ), false, true );
    wp_register_script( 'masonry-js', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', array( 'jquery' ), false, true );
    wp_register_script( 'magnific', get_template_directory_uri() . '/assets/js/magnific.min.js', array( 'jquery' ), false, true );
    wp_register_script( 'share-js', get_template_directory_uri() . '/assets/js/share.js', array( 'jquery' ), false, true );
    wp_register_script( 'footer-js', get_template_directory_uri() . '/assets/js/footer.js', array( 'jquery' ), false, true );
    wp_localize_script( 'footer-js', 'meta', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'page' => get_queried_object(),
        ));

    // ENQUEUE
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap-js' );
    wp_enqueue_script( 'imagesloaded-js' );
    wp_enqueue_script( 'masonry-js' );
    wp_enqueue_script( 'magnific' );
    wp_enqueue_script( 'share-js' );
    wp_enqueue_script( 'footer-js' );


}

add_action( 'wp_enqueue_scripts', 'ai_register_scripts' );

function ai_admin_scripts() {

    wp_register_script( 'footer-admin-js', get_template_directory_uri() . '/assets/js/footer-admin.js', array( 'jquery' ), false, true );
    wp_localize_script( 'footer-admin-js', 'meta', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'page' => get_queried_object(),
    ));  
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'footer-admin-js' );

}


add_action( 'admin_enqueue_scripts', 'ai_admin_scripts' );


// CHANGE LOGIN LOGO
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/assets/images/logo-.png) !important; background-size: 150px !important; width: 100% !important;height: 135px !important;  }
    </style>';
}
 
// add_action('login_head', 'my_custom_login_logo');


// HIDE WORDPRESS UPDATE
function wp_hide_update() {
  remove_action('admin_notices', 'update_nag', 3);
}
add_action('admin_menu','wp_hide_update');

// EXTRACT IMAGE URL
function the_image_url($fieldname, $imagesize) {
	  $size = $imagesize;
    $image_object = get_field($fieldname);
    $attachment_id = $image_object['id'];
    $img_src = wp_get_attachment_image_src( $attachment_id, $size );
    echo $img_src[0];
}

//REMOVE BUTTONS
function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('dashboard');
    $wp_admin_bar->remove_menu('themes');
    $wp_admin_bar->remove_menu('customize');
    $wp_admin_bar->remove_menu('menus');
    $wp_admin_bar->remove_menu('search');
}
// add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

// EXCERPTS LENGHTS
function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
    }

function custom_excerpt_length( $length ) {
	return 45;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function new_excerpt_more( $more ) {
  return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

// POST FORMAT TEMPLATE FILE STRUCTURE
function single_template_terms($template) {
    foreach( (array) wp_get_object_terms(get_the_ID(), get_taxonomies(array('public' => true, '_builtin' => true))) as $term ) {
        if ( file_exists(TEMPLATEPATH . "/single-{$term->slug}.php") ) {
            return TEMPLATEPATH . "/single-{$term->slug}.php";
        }
    }
    return $template;
}

// FILE SIZE
function getFilesize($fileSize, $digits=2) {
    $sizes = array("TB","GB","MB","KB","B");
    $total = count($sizes);
    while ($total-- && $fileSize > 1024) {
        $fileSize /= 1024;
    }
return round($fileSize, $digits)." ".$sizes[$total];
}

// VIDEO IFRAME WRAP
function div_wrapper($content) {
    // match any iframes
    $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // wrap matched iframe with div
        $wrappedframe = '<div class="video-container">' . $match . '</div>';

        //replace original iframe with new in content
        $content = str_replace($match, $wrappedframe, $content);
    }

    return $content;    
}
add_filter('the_content', 'div_wrapper');

function remove_admin_menu_items() {
$remove_menu_items = array(__('Links'),__('Portfolio'),__('Comments'),
  __('Dashboard'),
  __('Posts'),
  __('Media'),
  // __('Appearance'),
  // __('Plugins'),
  __('Tools'),);
  global $menu;
  end ($menu);
  while (prev($menu)){
    $item = explode(' ',$menu[key($menu)][0]);
    if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
    unset($menu[key($menu)]);}
  }
}
// add_action('admin_menu', 'remove_admin_menu_items');

function admin_default_page() {
  return home_url().'/wp-admin/admin.php?page=acf-options';
}

add_filter('login_redirect', 'admin_default_page');

function hd_get_image_url_from_id($id, $size) {
  $img = wp_get_attachment_image_src($id, $size);
  return $img[0];
}

function getIdFromYoutubeUrl($url){
    $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
    preg_match($pattern, $url, $matches);
    if (count($matches) && strlen($matches[7]) == 11){
      return $matches[7];
    }
}

function getImgFromVimeoUrl($url){

$imgid = vimeo_video_id($url);
$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
return $hash[0]['thumbnail_large'];  
}

function vimeo_video_id($url){

  if(is_vimeo($url)){

    $pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
    preg_match($pattern, $url, $matches);

    if (count($matches)){
      return $matches[2];
    }

  }
 
  return '';
}

function is_youtube($url){
  return (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url));
}

function is_vimeo($url){
  return (preg_match('/vimeo\.com/i', $url));
}


// filter for tags with comma
//  replace '--' with ', ' in the output - allow tags with comma this way
//  e.g. save tag as "Fox--Peter" but display thx 2 filters like "Fox, Peter"

if(!is_admin()){ // make sure the filters are only called in the frontend
    function comma_tag_filter($tag_arr){
        $tag_arr_new = $tag_arr;
        if($tag_arr->taxonomy == 'post_tag' && strpos($tag_arr->name, '--')){
            $tag_arr_new->name = str_replace('--',', ',$tag_arr->name);
        }
        return $tag_arr_new;    
    }
    add_filter('get_post_tag', 'comma_tag_filter');

    function comma_tags_filter($tags_arr){
        $tags_arr_new = array();
        foreach($tags_arr as $tag_arr){
            $tags_arr_new[] = comma_tag_filter($tag_arr);
        }
        return $tags_arr_new;
    }
    add_filter('get_terms', 'comma_tags_filter');
    add_filter('get_the_terms', 'comma_tags_filter');
}

function get_tumblr_subdomain($url){
  $re = "/https?:\/\/(\w+).tumblr.com/"; 
 
preg_match($re, $url, $matches);
return $matches[1].'.tumblr.com';
}

function get_tumblr_id($url){
  $re = "/\w+\/\w+\/([^\?&\"'>]+)/"; 
 
preg_match($re, $url, $matches);
return $matches[1];
}

function getHost($Address) { 
   $parseUrl = parse_url(trim($Address)); 
   return trim($parseUrl[host] ? $parseUrl[host] : array_shift(explode('/', $parseUrl[path], 2))); 
} 

function build_table($array){
    $html = '<table>';
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
            $html .= '<th>' . $key . '</th>';
        }
    $html .= '</tr>';
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . $value2 . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}

function ai_debug(){
if(isset($_GET['test'])){

require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_general.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_lists.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_clients.php';
require_once 'functions/composer/vendor/campaignmonitor/createsend-php/csrest_subscribers.php';


$api_key = get_field('campaign_monitor_api_key', 'options');
$client_id = get_field('campaign_monitor_client_id', 'options');
$list_id = get_field('campaign_monitor_list_id', 'options');

$auth = array('api_key' => '84e3d93e16a1328bc69b898dcb060447');
$wrap = new CS_REST_General($auth);

$result = $wrap->get_clients();
var_dump($result->response);




$wrap = new CS_REST_Clients(
    'b45eebae99f7b69a20ed9447222c18e8', 
    $auth);

$result = $wrap->get_lists();

echo "Result of /api/v3.1/clients/{id}/lists\n<br />";
if($result->was_successful()) {
    echo "Got lists\n<br /><pre>";
    var_dump($result->response);
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
}
echo '</pre>';


// list-id = c7300db6cc3bb77631b271f6c35947fc




$wrap = new CS_REST_Subscribers('c7300db6cc3bb77631b271f6c35947fc', $auth);
$result = $wrap->add(array(
    'EmailAddress' => 'paulius.ged@gmail.com',
    'Resubscribe' => true
));

echo "Result of POST /api/v3.1/subscribers/{list id}.{format}\n<br />";
if($result->was_successful()) {
    echo "Subscribed with code ".$result->http_status_code;
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
    echo '</pre>';
}




exit;

  die();
}

}

add_action('init', 'ai_debug' );