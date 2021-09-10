<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('tmrco_Core_rimcour_Course_Tab')) {
    class tmrco_Core_rimcour_Course_Tab{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } 
        public function __construct(){
			register_block_type(
                'qubely/upskill-course-tab',
                array(
                    'attributes' => array(
                        //common settings
                        'uniqueId'          => array (
                            'type'          => 'string',
                        ),

                        'postTypes'         => array(
                            'type'          => 'string',
                            'default'       => 'courses'
                        ),
                        'order'             => array(
                            'type'          => 'string',
                            'default'       => 'desc',
                        ),
                        'orderby'             => array(
                            'type'          => 'string',
                            'default'       => 'date'
                        ),
                        'offset'           => array(
                            'type'          => 'number',
                            'default'       => 0,
                        ),
                        'numbers'           => array(
                            'type'          => 'number',
                            'default'       => 6,
                        ),
                        'columns'           => array(
                            'type'          => 'string',
                            'default'       => '3',
                        ),

                       

                        //courses Tab Title.
                        'enableTabTitle' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'courseTabTitle' => array (
                            'type'          => 'string',
                            'default'       => 'Add your text...',
                        ),
                        'typographyTabTitle'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 26, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .upskil-section-title'
                            ]]
                        ),
                        'titleTabColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .upskil-section-title, {{QUBELY}} .upskil-section-title h3 {color: {{titleTabColor}};}'
                            ]]
                        ),

                        # Course title
                        'enableTitle' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typographyTitle'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 16, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .rimcour-course-grid-item .rimcour-courses-grid-title a'
                            ]]
                        ),
                        'titleColor'    => array(
                            'type'      => 'string',
                            'default'   => '#1f2949',
                            'style'     => [(object) [
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-courses-grid-title a {color: {{titleColor}};}'
                            ]]
                        ),
                        'titleHoverColor' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-courses-grid-title a:hover {color: {{titleHoverColor}};}'
                            ]]
                        ),

                        //Price
                        'enablePrice' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typographyPrice'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 16, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .rimcour-course-overlay-element .price'
                            ]]
                        ),
                        'priceColor' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-overlay-element .price {color: {{priceColor}};}'
                            ]]
                        ),
                        'priceBg' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-overlay-element .price {background: {{priceBg}};}'
                            ]]
                        ),

                        //overlay
                        'enableBestSale' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'enableBookmark' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'overlayBg' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-overlay:after {background: {{overlayBg}};}'
                            ]]
                        ),


                        # Animation.
                        'animation' => array(
                            'type' => 'object',
                            'default' => (object) array(),
                        ),
                        'globalZindex' => array(
                            'type'    => 'string',
                            'default' => '0',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} {z-index:{{globalZindex}};}'
                            ]]
                        ),
                        'hideTablet' => array(
                            'type' => 'boolean',
                            'default' => false,
                            'style' => [(object) [
                                'selector' => '{{QUBELY}}{display:none;}'
                            ]]
                        ),
                        'hideMobile' => array(
                            'type' => 'boolean',
                            'default' => false,
                            'style' => [(object) [
                                'selector' => '{{QUBELY}}{display:none;}'
                            ]]
                        ),
                        'globalCss' => array(
                            'type' => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'selector' => ''
                            ]]
                        ),

                        'interaction' => array(
                            'type' => 'object',
                            'default' => (object) array(),
                        ),

                    ),
                    'render_callback' => array( $this, 'tmrco_Core_rimcour_Course_Tab_block_callback' ),
                )
            );
        }
    
		public function tmrco_Core_rimcour_Course_Tab_block_callback( $att ){
            $uniqueId 		= isset( $att['uniqueId'] ) ? $att['uniqueId'] : '';
            $courseTabTitle = isset( $att['courseTabTitle'] ) ? $att['courseTabTitle'] : '';
			$order 		    = isset( $att['order'] ) ? $att['order'] : 'desc';
			$orderby 		= isset( $att['orderby'] ) ? $att['orderby'] : 'date';
            $numbers 		= isset( $att['numbers'] ) ? $att['numbers'] : 6;
            $offset 		= isset( $att['offset'] ) ? $att['offset'] : '';
            $enableTitle 	= isset($att['enableTitle']) ? $att['enableTitle'] : 1;
            $enablePrice 	= isset($att['enablePrice']) ? $att['enablePrice'] : 1;
            $enableTabTitle = isset($att['enableTabTitle']) ? $att['enableTabTitle'] : 1;
            $enableBestSale = isset($att['enableBestSale']) ? $att['enableBestSale'] : 1;
            $enableBookmark = isset($att['enableBookmark']) ? $att['enableBookmark'] : 1;


            $animation  = isset($att['animation']) ? ( count((array)$att['animation']) > 0 && $att['animation']['animation']  ? 'data-qubelyanimation="'.htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8').'"' : '' ) : '';
            $interaction = '';
            if(isset($att['interaction'])) {
                if (!empty((array)$att['interaction'])) {
                    if(isset($att['interaction']['while_scroll_into_view'])) {
                        if($att['interaction']['while_scroll_into_view']['enable']){
                            $interaction = 'qubley-block-interaction';
                        }
                    }
                    if(isset($att['interaction']['mouse_movement'])) {
                        if($att['interaction']['mouse_movement']['enable']) {
                            $interaction = 'qubley-block-interaction';
                        }
                    }
                }
            }

    
            $html = '';
            $counts = 0;

            $filters = get_terms('course-category');
            
            $html .= '<section class="tmrco-courses-tab-wrapper tab-vertical qubely-block-'.$uniqueId.'">';
                $html .= '<div class="tmrco-content-tab-inner '.$interaction.'" '.$animation.'>';    
                    $html .= '<div class="tab-wrapper">';
                        $html .= '<div class="tab-nav-wrapper">';
                            if( $enableTabTitle == 1 ) {
                                $html .= '<div class="upskil-section-title">';
                                    $html .= '<h3>'.$courseTabTitle.'</h3>';
                                $html .= '</div>';
                            }
                            $html .= '<ul class="tmrco-tab-nav nav nav-tabs">';
                                $count = 1;
                                foreach ($filters as $filter) {
                                    if ($count == 1) {
                                        $html .= '<li class="tmrco-tab-nav-item"><a class="tmrco-tab-nav-link active" data-toggle="tab" href="#tab-v-'.$filter->slug.'">'.$filter->name.'</a></li>';
                                    } else {
                                        $html .= '<li class="tmrco-tab-nav-item"><a class="tmrco-tab-nav-link" data-toggle="tab" href="#tab-v-'.$filter->slug.'">'.$filter->name.'</a></li>';
                                    }
                                    $count ++;
                                }                                                                                                   
                            $html .= '</ul>';
                        $html .= '</div>';

                        $html .= '<div class="tab-content-wrapper">';
                        $html .= '<div class="tab-content">';
                        
                        $i = 0;
                        foreach ($filters as $filter) {

                            $html .= ( $i == 0 ) ? '<div class="tab-pane fade show active" id="tab-v-'. $filter->slug .'" tabindex="-1">' : '<div class="tab-pane fade show" id="tab-v-'.$filter->slug.'" tabindex="-1">'; $i++;
                           
                            $args = array(
                                'post_type'         => 'courses',
                                'posts_per_page'    => $numbers,
                                'post_status'       => 'publish',
                                'order' 			=> esc_attr($order),
                                'orderby' 			=> esc_attr($orderby),
                                'offset' 			=> esc_attr($offset),
                                'tax_query'         => array(
                                    array(
                                        'taxonomy' => 'course-category',
                                        'field'    => 'slug',
                                        'terms'    => $filter->slug,
                                    ),
                                ),
                            );

                            $data = new WP_Query($args);

                            $html .= '<div class="tmrco-related-course">';
                            $html .= '<div class="tmrco-related-course-items">';
                            $html .= '<div class="row">';
                            if ( $data->have_posts() ) :
                                while ( $data->have_posts() ) : $data->the_post(); 
                                    $html .= '<div class="col-md-4 col-6">';
                                        $html .= '<div class="rimcour-course-grid-item">';
                                            $html .= '<div class="rimcour-course-grid-content">';
                                                $html .= '<div class="rimcour-course-overlay">';
                                                    $thumb 	= wp_get_attachment_image_src( get_post_thumbnail_id($data->ID), 'tmrco-courses');
                                                    if($thumb[0]){ $html .= '<img src="'. $thumb[0] .'" class="img-responsive">'; }
                                                    $html .= '<div class="rimcour-course-overlay-element">';
                                                        if($enableBestSale == 1) {
                                                            $html .= '<div class="level-tag">';
                                                                $best_selling = get_post_meta(get_the_ID(), 'tmrco_best_selling', true);
                                                                if ($best_selling != false) {
                                                                    $html .= '<span class="tag intermediate">'.__('Featured', 'tmrco-core-main').'</span>';
                                                                }
                                                            $html .= '</div>';
                                                        }
                                                        if( $enableBookmark == 1 ) {
                                                            $is_wishlisted = rimcour_utils()->is_wishlisted($data->ID);
                                                            $has_wish_list = '';
                                                            if ($is_wishlisted){
                                                                $has_wish_list = 'has-wish-listed';
                                                            }
                                                            $html .= '<div class="bookmark">';
                                                                $html .= '<span class="rimcour-course-grid-wishlist rimcour-course-wishlist">';
                                                                    if(is_user_logged_in()){
                                                                    $html .= '<a href="javascript:;" class="rimcour-icon-fav-line rimcour-course-wishlist-btn '.esc_attr($has_wish_list).' " data-course-id="'.get_the_ID().'"></a>';
                                                                    }else{
                                                                        $html .= '<a class="rimcour-icon-fav-line" data-toggle="modal" href="#modal-login"></a>';
                                                                    }
                                                                $html .= '</span>';
                                                            $html .= '</div>';
                                                        }
                                                        if( ($enablePrice == 1 ) && !rimcour_utils()->is_enrolled($data->ID) ) {
                                                            $html .= '<div class="price">';
                                                                ob_start();
                                                                $html .= rimcour_course_price();
                                                                $html .= ob_get_clean();
                                                            $html .= '</div>'; 
                                                        }
                                                    $html .= '</div>';
                                                    
                                                    $html .= '<div class="rimcour-course-grid-enroll">';
                                                        $html .= '<div class="course-related-hover-price">';
                                                            ob_start();
                                                            $html .= rimcour_course_price();
                                                            $html .= ob_get_clean();        
                                                        $html .= '</div>';
                                                        $html .= '<span class="rimcour-course-grid-level">'.get_rimcour_course_level().'</span>';
                                                        
                                                        $course_duration = get_rimcour_course_duration_context();
                                                        if(!empty($course_duration)) {
                                                            $html .= '<span class="rimcour-course-duration">'.$course_duration.'</span>';
                                                        } 
                                                        //$html .= '<a href="'.esc_url(get_the_permalink()).'" class="btn btn-classic btn-no-fill" tabindex="-1">Enroll Now</a>';
                                                        if (rimcour_utils()->is_course_purchasable($data->ID)) {
                                                            $product_id = rimcour_utils()->get_course_product_id($data->ID);
                                                            //$product    = wc_get_product( $product_id );
                                                            $html .= rimcour_course_loop_add_to_cart(false);
                                                        }else{
                                                            if (rimcour_utils()->is_enrolled($data->ID)) {
                                                            $html .= '<a href="'.esc_url(get_the_permalink($data->ID)).'" class="btn btn-classic btn-no-fill">'.__('Enrolled','tmrco').'</a>';
                                                            } else {
                                                                $html .= '<a href="'.esc_url(get_the_permalink($data->ID)).'" class="btn btn-classic btn-no-fill">'.__('Enroll Now','tmrco').'</a>';
                                                            }
                                                        }
                                                    $html .= '</div>';
                                                $html .= '</div>';
                                                if( $enableTitle == 1) {  
                                                    $html .= '<h3 class="rimcour-courses-grid-title">';
                                                        $html .= '<a href="'.esc_url(get_the_permalink()).'" tabindex="-1">'.get_the_title($data->ID).'</a>';
                                                    $html .= '</h3>';
                                                }
                                                if( $enablePrice == 1 ){
                                                    $html .= '<div class="course-price-mobile d-lg-none">';
                                                        if ( ! function_exists('rimcour_course_price')) {
                                                            ob_start();
                                                            $html .= rimcour_course_price();
                                                            $html .= ob_get_clean();
                                                        }
                                                    $html .= '</div>';
                                                }
                                            $html .= '</div>';
                                        $html .= '</div>'; 
                                    $html .= '</div>';

                                endwhile;
                                wp_reset_query();
                            endif;

                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</div>';
                        }
                             
                        $html .= '</div>';
                        $html .= '</div>';

                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</section>';

            wp_reset_postdata();
			return $html;
		}
    }
}
tmrco_Core_rimcour_Course_Tab::instance();


