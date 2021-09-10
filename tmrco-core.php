<?php
/*
 * Plugin Name:       Skillate Core 
 * Plugin URI:        https://www.themeum.com/
 * Description:       Skillate Core Plugin
 * Version: 		  1.1.1
 * Author:            Themeum.com
 * Author URI:        https://themeum.com/
 * Text Domain:       Skillate-core 
 * Requires at least: 5.0
 * Tested up to: 	  5.2
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

define('tmrco_CORE_VERSION', '1.1.1');
define( 'tmrco_CORE_URL', plugin_dir_url(__FILE__) );
define( 'tmrco_CORE_PATH', plugin_dir_path(__FILE__) );

# Language Load
add_action( 'init', 'tmrco_core_language_load');
function tmrco_core_language_load(){
    load_plugin_textdomain( 'tmrco-core', false,  basename(dirname(__FILE__)).'/languages/' );
}

require_once tmrco_CORE_PATH . 'core/Functions.php';
function tmrco_core(){
    return new tmrco_Core_Functions();
    //add_action( 'rest_api_init', array($this, 'tmrco_core_register_api_hook'));
}

/* -------------------------------------------
*              login system
* -------------------------------------------- */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once( tmrco_CORE_PATH . '/lib/login/login.php' );
require_once tmrco_CORE_PATH . 'core/Base.php';

# Metabox Include
include_once( 'meta_box.php' );
include_once( 'meta-box/meta-box.php' );

# widget
require_once('widgets/about_widget.php');
require_once('widgets/social_share.php');

# Course Load More.
require_once( 'lib/tmrco-course-loadmore.php' );
require_once ( 'lib/auto-update.php');

# Themme Feature.
require_once( 'lib/course-option.php' );

# Show Post ID
require_once( 'lib/show-post-id.php' );

# wp load login modal
function tmrco_core_load_login_modal() {
    include_once( 'lib/login-modal.php' );
}
add_action( 'wp_footer', 'tmrco_core_load_login_modal' );

# Add CSS for Frontend
add_action( 'wp_enqueue_scripts', 'tmrco_core_style' );
if(!function_exists('tmrco_core_style')):
    function tmrco_core_style(){
        # CSS
        //wp_enqueue_style('tmrco-core-css',plugins_url('assets/css/blocks.style.build.css',__FILE__));
        # JS
        wp_enqueue_script('custom',plugins_url('assets/js/custom.js',__FILE__), array('jquery'));
        wp_enqueue_script('countdown-script', plugins_url('assets/js/countdown-script.js',__FILE__), array('jquery'));	
    }
endif;

function tmrco_core_load_admin_assets() {
    wp_enqueue_script( 'tmrco-core-admin', plugins_url('assets/js/admin.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'widget-js', plugins_url('assets/js/widget-js.js', __FILE__), array('jquery') );
}
add_action( 'admin_enqueue_scripts', 'tmrco_core_load_admin_assets' );

if ( ! function_exists( 'tmrco_core_rest_fields' ) ) {
    function tmrco_core_rest_fields() {
        $post_types = get_post_types();
        register_rest_field( $post_types, 'post_excerpt_tmrco_core',
            array(
                'get_callback'      => 'tmrco_core_post_excerpt',
                'update_callback'   => null,
                'schema'            => array(
                    'description'   => __( 'Post excerpt' ),
                    'type'          => 'string',
                ),
            )
        );
        register_rest_field( 'portfolio', 'tmrco_core_portfolio_cat_single',
            array(
                'get_callback'      => 'tmrco_core_catlist',
                'update_callback'   => null,
                'schema'            => array(
                    'description'   => __( 'cat List' ),
                    'type'          => 'string',
                ),
            )
        );
        register_rest_field( 'courses', 'tmrco_core_price_item',
            array(
                'get_callback'      => 'tmrco_core_price',
                'update_callback'   => null,
                'schema'            => array(
                    'description'   => __( 'Course Price' ),
                    'type'          => 'string',
                ),
            )
        );
        register_rest_field( 'portfolio', 'tmrco_core_portfolio_cat',
            array(
                'get_callback'      => 'tmrco_core_portfolio_catlist',
                'update_callback'   => null,
                'schema'            => array(
                    'description'   => __( 'cat List' ),
                    'type'          => 'string',
                ),
            )
        );
        register_rest_field( $post_types, 'tmrco_core_image_urls',
            array(
                'get_callback'          => 'tmrco_core_featured_image_urls',
                'update_callback'       => null,
                'schema'                => array(
                    'description'       => __( 'Different sized featured images' ),
                    'type'              => 'array',
                ),
            )
        );

    }
}
add_action( 'rest_api_init', 'tmrco_core_rest_fields' );



/* ----------------------------------
*           Post Excerpt 
------------------------------------- */
if ( ! function_exists( 'tmrco_core_post_excerpt' ) ) {
    function tmrco_core_post_excerpt( $post_id, $post = null ) {
        $post_content = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
        return apply_filters( 'the_excerpt', wp_trim_words( $post_content, 55 ) );
    }
}

if ( ! function_exists( 'tmrco_core_catlist' ) ) {
    function tmrco_core_catlist( $object ) {
        return get_the_term_list( $object['id'], 'portfolio-cat' );
    }
}

if ( ! function_exists( 'tmrco_core_price' ) ) {
    function tmrco_core_price( $object ) {
        //return rimcour_course_loop_price( $object['id'], 'courses' );
        //$ssss = $price_html;
        //$ssss = rimcour_course_loop_price();
        //return  $price_html;
    }
}

if ( ! function_exists( 'tmrco_core_portfolio_catlist' ) ) {
    function tmrco_core_portfolio_catlist( $object ) {
        return get_terms( 'portfolio-cat' );
    }
}

if ( ! function_exists( 'tmrco_core_featured_image_urls' ) ) {
    function tmrco_core_featured_image_urls( $object, $field_name, $request ) {
        $image = wp_get_attachment_image_src( $object['featured_media'], 'full', false );
        return array(
            'full'      => is_array( $image ) ? $image : '',
            'portrait'      => is_array( $image ) ? wp_get_attachment_image_src( $object['featured_media'], 'tmrco-core-portrait', false ) : '',
            'portraitab'    => is_array( $image ) ? wp_get_attachment_image_src( $object['featured_media'], 'tmrco-course-tab', false ) : '',
            'thumbnail'     => is_array( $image ) ? wp_get_attachment_image_src( $object['featured_media'], 'tmrco-core-thumbnail', false ) : '',
        );
    }
}

if ( ! function_exists( 'tmrco_core_blog_posts_image_sizes' ) ) {
    function tmrco_core_blog_posts_image_sizes() {
        add_image_size( 'tmrco-core-portrait', 700, 870, true );
        add_image_size( 'tmrco-course-tab', 322, 300, true );
        add_image_size( 'tmrco-core-thumbnail', 140, 100, true );
    }
    add_action( 'after_setup_theme', 'tmrco_core_blog_posts_image_sizes' );
}



//Register api hook
function tmrco_core_register_api_hook(){

    register_rest_field(
        'courses',
        'price',
        array(
            'get_callback'      => 'tmrco_course_get_price',
            'update_callback'   => null,
            'schema'            => array(
                'description'   => __('Course price'),
                'type'          => 'string',
            ),
        )
    );

    # Course Author name.
    register_rest_field(
        'courses',
        'tmrco_author',
        array(
            'get_callback'    => 'tmrco_rimcour_get_author_info',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    // register_rest_field(
    //     'courses',
    //     'course_author',
    //     array(
    //         'get_callback'    => 'tmrco_rimcour_course_author',
    //         'update_callback' => null,
    //         'schema'          => null,
    //     )
    // );

    # Category List.
    register_rest_field(
        'courses',
        'tmrco_category',
        array(
            'get_callback'      => 'tmrco_get_category_list',
            'update_callback'   => null,
            'schema'            => array(
                'description'   => __('Category list links'),
                'type'          => 'string',
            ),
        )
    );

    # Course Rating
    register_rest_field(
        'courses',
        'rating',
        array(
            'get_callback'      => 'tmrco_course_rating',
            'update_callback'   => null,
            'schema'            => array(
                'description'   => __('Course price'),
                'type'          => 'string',
            ),
        )
    );

    # tmrco_duration_level
    register_rest_field(
        'courses',
        'duration',
        array(
            'get_callback'      => 'tmrco_duration_level',
            'update_callback'   => null,
            'schema'            => array(
                'description'   => __('Course Duration'),
                'type'          => 'string',
            ),
        )
    );
}	
add_action('rest_api_init','tmrco_core_register_api_hook');

# Callback functions: Author Name
function tmrco_rimcour_get_author_info($object) {
    global $authordata;
    $author['url']          = get_avatar_url(get_current_user_id(), 'thumbnail');
    $author['display_name'] = get_the_author_meta('display_name', $object->ID);
    $author['author_link']  = get_author_posts_url($object->ID);
    $author['tmrco_best_selling'] = get_post_meta($object->ID, 'tmrco_best_selling', true);
    if(function_exists('rimcour_utils')){
        $author['rimcour_author'] = rimcour_utils()->get_rimcour_avatar(get_current_user_id(), 'thumbnail');
        $author['profile_url']  = rimcour_utils()->profile_url($authordata->ID);
    }else{
        $author['rimcour_author'] = get_avatar_url(get_current_user_id(), 'thumbnail'); 
        $author['profile_url']  = rimcour_utils()->profile_url($authordata->ID);
    }
    $author['author_name']      = get_the_author($authordata->ID);
    return $author;
}

# Callback functions: category list
if (!function_exists('tmrco_get_category_list')) {
    function tmrco_get_category_list($object) {
        $course_categories = get_rimcour_course_categories();
        if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
            $ind = 0;
            foreach ($course_categories as $course_category){
                $category_name['course_category'] = $course_category->name;
                $image_id = get_term_meta($course_category->term_id, 'thumbnail_id', true );
                $category_name['course_count'] = $course_category->count;
                $category_name['image_link'] = wp_get_attachment_image($image_id, 'tmrco-large');
                $ind++;
            }
        }
        return $category_name;
    }
}

# Callback founction: Course Price.
function tmrco_course_get_price($object) {
    $posts = get_posts( array(
        'numberposts'		=> 3,
        'post_type'		    => 'courses',
    ) );
    if ( empty( $posts ) ) { return null; }
    $price = [];
    foreach ( $posts as $post ) {
        ob_start();
        $price = rimcour_course_price();
        $price = ob_get_clean();
    }
    return $price;
}
 
# Callback Functions: Rating.
function tmrco_course_rating($object) {
    $rating = [];
    ob_start();
    $course_rating = rimcour_utils()->get_course_rating();
    $rating = rimcour_utils()->star_rating_generator($course_rating->rating_avg);
    $rating = ob_get_clean();
    return $rating;
}

# Callback Functions: Level.
function tmrco_duration_level($object) {
    $level = [];
    $level['course_level']      = get_rimcour_course_level();
    $level['course_duration']   = get_rimcour_course_duration_context();
    $level['course_excerpt']    = get_the_excerpt();
    return $level;
} 

# rimcour Courses Rest Api.
add_action( 'rest_api_init', function () {
    register_rest_route( 'tmrcoapi/v2', '/courses', array(
        'methods' => 'GET',
        'callback' => 'tmrco_get_courses_list',
    ));
    register_rest_route( 'tmrcoapi/v2', '/category', array(
        'methods' => 'GET',
        'callback' => 'tmrco_get_courses_category_list',
    ));
    register_rest_route( 'tmrcoapi/v2', '/categories', array(
        'methods' => 'GET',
        'callback' => 'tmrco_get_courses_categories',
    ));
});

if ( ! function_exists( 'tmrco_get_courses_categories' ) ) {
    function tmrco_get_courses_categories( $object ) {
        try{
            $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'DESC';
            $per_page = isset($_GET['per_page']) ? (int) sanitize_text_field($_GET['per_page']) : '';
            $tmrco_cat = isset($_GET['tmrco_cat']) ? $_GET['tmrco_cat'] : array();
            $catdata = [];
            if ( $tmrco_cat ){
                if( $tmrco_cat[0]['value'] != 'all' ){
                    foreach ($tmrco_cat as $value) {
                        $apicatdata = [];
                        $term           = get_term_by('slug', $value['value'] , 'course-category');
                        $image_id = get_term_meta($term->term_id, 'thumbnail_id', true );
                        $apicatdata['image_link'] = wp_get_attachment_image($image_id, 'tmrco-large');
                        $apicatdata['name'] =  $term->name;
                        $apicatdata['term_id'] =  $term->term_id;
                        $apicatdata['count'] =  $term->count;
                        $apicatdata['slug'] =  $term->slug;
                        $apicatdata['description'] =  $term->description;
                        $catdata[] = $apicatdata;
                    }
                    return $catdata;
                } else {
                    //return get_terms( 'course-category' );
                }
                return $catdata;
            } else {
                // return get_terms( 'course-category' );
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
        // return get_terms( 'course-category' );
    }
}

if ( ! function_exists( 'tmrco_get_courses_category_list' ) ) {
    function tmrco_get_courses_category_list( $object ) {
        return get_terms( 'course-category' );
    }
}

if ( ! function_exists( 'tmrco_get_courses_list' ) ) {
    function tmrco_get_courses_list(){
        try{
            $per_page = isset($_GET['per_page']) ? (int) sanitize_text_field($_GET['per_page']) : '';
            $category = isset($_GET['category']) ? $_GET['category'] : array();
            $paged = isset($_GET['paged']) ? (int) sanitize_text_field($_GET['paged']) : '';
            $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'DESC';
            $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
            $offset = isset($_GET['offset']) ? (int) sanitize_text_field($_GET['offset']) : '';
            $include = isset($_GET['include']) ? sanitize_text_field($_GET['include']) : array();
            $exclude = isset($_GET['exclude']) ? sanitize_text_field($_GET['exclude']) : array();
            $p = isset($_GET['p']) ? (int) sanitize_text_field($_GET['p']) : '';
            $slug = isset($_GET['slug']) ? sanitize_text_field($_GET['slug']) : '';

            $args = array(
                'post_type'     => 'courses',
                'post_status'   => 'publish',
            );
            if($per_page){
                $args['posts_per_page'] = $per_page;
            }
            if($offset) {
                $args['offset'] = $offset;
            }
            if($order) {
                $args['order'] = $order;
            }
            if($p){
                $args['p'] = $p;
            }
            if($slug){
                $args['name'] = $slug;
            }
            if($paged) {
                $args['paged'] = $paged;
            }  
            //include
            if ( ! empty($include) ){
                $include = (array) explode(',', $include);
                $args['post__in'] = $include;
            }
            //exclude
            if ( ! empty($exclude) ){
                $exclude = (array) explode(',', $exclude);
                $args['post__not_in'] = $exclude;
            }
            if($orderby) {
                $args['orderby'] = $orderby;
            }
            //category
            if ( $category ){
                if( $category != 'all' ){
                    $catitem = array();
                    foreach ($category as $cat){
                        $catitem[] = $cat['value'];
                    }
                    $args['tax_query'] =  array(
                        array(
                            'taxonomy' 	=> 'course-category',
                            'field' 	=> 'slug',
                            'terms'    	=> $catitem,
                        ),
                    );
                }
            }

            $data = [];
            query_posts($args);
            if(have_posts()){
                while(have_posts()){
                    the_post();
                    global $post;

                    //price
                    $is_purchasable = rimcour_utils()->is_course_purchasable();
                    $price = apply_filters('get_rimcour_course_price', null, get_the_ID());
                    if ($is_purchasable && $price){
                        $price_data =  '<div class="price">'.$price.'</div>';
                    }else{
                        $price_data = '<div class="price">'.__("Free", "tmrco-core").'</div>';
                    }

                    //cart
                    if (rimcour_utils()->is_course_purchasable()) {
                        $product_id = rimcour_utils()->get_course_product_id(get_the_ID());
                        $cart_data = rimcour_course_loop_add_to_cart(false);
                    }else{
                        $cart_data = '<a href="'.esc_url(get_the_permalink(get_the_ID())).'" class="btn btn-classic btn-no-fill">'.__('Enroll Now','tmrco-core').'</a>';
                    }

                    //wishlisted
                    $is_wishlisted = rimcour_utils()->is_wishlisted(get_the_ID());
                    $has_wish_list = '';
                    if ($is_wishlisted){
                        $has_wish_list = 'has-wish-listed';
                    }
                    if(is_user_logged_in()){ 
                        $wish_list_data = '<a href="javascript:" class="rimcour-icon-fav-line rimcour-course-wishlist-btn '.$has_wish_list.' " data-course-id="'.get_the_ID().'"></a>';
                    }else{
                        $wish_list_data = '<a class="rimcour-icon-fav-line" data-toggle="modal" href="#modal-login"></a>';
                    }

                    //rimcour
                    global $authordata;
                    if(function_exists('rimcour_utils')){
                        $avatar_data = rimcour_utils()->get_rimcour_avatar(get_current_user_id(), 'thumbnail');
                    } else {
                        $avatar_data = get_avatar_url(get_current_user_id(), 'thumbnail');
                    }

                    //single_category
                    $course_categories = get_rimcour_course_categories();
                    if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
                        $ind = 0;
                        foreach ($course_categories as $course_category){
                            $category_name['course_category'] = $course_category->name;
                            $image_id = get_term_meta($course_category->term_id, 'thumbnail_id', true );
                            $category_name['course_count'] = $course_category->count;
                            $category_name['image_link'] = wp_get_attachment_image($image_id, 'tmrco-large');
                            $ind++;
                        }
                    }
                    $category_name = $category_name;

                    //images
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID()), 'full', false );
                    $featured_images = array(
                        'full'      => is_array( $image ) ? $image : '',
                        'portrait'      => is_array( $image ) ? wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID()), 'tmrco-core-portrait', false ) : '',
                        'portraitab'    => is_array( $image ) ? wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID()), 'tmrco-course-tab', false ) : '',
                        'thumbnail'     => is_array( $image ) ? wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID()), 'tmrco-core-thumbnail', false ) : '',
                    );
                    
                    //rating
                    $rating = [];
                    ob_start();
                    $course_rating = rimcour_utils()->get_course_rating();
                    $rating = rimcour_utils()->star_rating_generator($course_rating->rating_avg);
                    $rating = ob_get_clean();  
                    
                    //apidata
                    $apidata = [];
                    $apidata['id'] = get_the_ID();
                    $apidata['name'] = get_the_title();
                    $apidata['slug'] = $post->post_name;
                    $apidata['image'] = $featured_images;
                    $apidata['url'] = get_the_permalink();
                    $apidata['categories'] = get_rimcour_course_categories();
                    $apidata['category_name'] = $category_name;
                    $apidata['price'] = $price_data;
                    $apidata['cart'] = $cart_data;
                    $apidata['wishlist'] = $wish_list_data;
                    $apidata['authorurl'] = rimcour_utils()->profile_url($authordata->ID);
                    $apidata['authoravatar'] = get_avatar_url(get_current_user_id(), 'thumbnail');
                    $apidata['authorname'] = get_the_author_meta( 'display_name' , $post->post_author );
                    $apidata['level'] = get_rimcour_course_level();
                    $apidata['courseduration'] = get_rimcour_course_duration_context();
                    $apidata['excerpt'] = get_the_excerpt();
                    $apidata['lessoncount'] = rimcour_utils()->get_lesson_count_by_course(get_the_ID());
                    $apidata['ratingcount'] = $course_rating->rating_count;
                    $apidata['rating'] = $rating;
                    $data[] = $apidata;  
                }
            }
            wp_reset_query();
            // return ['success' => true, 'data' => $data];
            return $data;
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}