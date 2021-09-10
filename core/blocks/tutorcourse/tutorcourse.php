<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('tmrco_Core_rimcour_Course')) {
    class tmrco_Core_rimcour_Course{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } 
        public function __construct(){
			register_block_type(
                'qubely/upskill-core-rimcour-course',
                array(
                    'attributes' => array(
                        //common settings
                        'uniqueId' => array(
                            'type' => 'string',
                            'default' => '',
                        ),
                        'layout'   => array(
                            'type'      => 'string',
                            'default'   => 1
                        ),
                        'postTypes'         => array(
                            'type'          => 'string',
                            'default'       => 'courses'
                        ),
                        'selectedCategory' => array(
                            'type' => 'array',
                            'default' => [],
                            'items'   => [
                                'type' => 'object'
                            ],
                        ),
                        'order'             => array(
                            'type'          => 'string',
                            'default'       => 'desc'
                        ),
                        'orderby'             => array(
                            'type'          => 'string',
                            'default'       => 'date'
                        ),
                        'disFilter'         => array(
                            'type'          => 'boolean',
                            'default'       => true
                        ),
                        'numbers'           => array(
                            'type'          => 'number',
                            'default'       => 6,
                        ),
                        'offset'           => array(
                            'type'          => 'number',
                            'default'       => 0,
                        ),
                        'include'           => array(
                            'type'          => 'string',
                            'default'       => '',
                        ),
                        'exclude'           => array(
                            'type'          => 'string',
                            'default'       => '',
                        ),
                        'columns'           => array(
                            'type'          => 'string',
                            'default'       => '4',
                        ),

                        //title
                        'enableTitle' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typographyTitle' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 0,
                                'family' => "Roboto",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => '', 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'condition' => [(object) ['key' => 'enableTitle', 'relation' => '==', 'value' => true]],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .rimcour-courses-grid-title a'
                            ]]
                        ),
                        'titleColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [(object) ['key' => 'enableTitle', 'relation' => '==', 'value' => true]],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .rimcour-courses-grid-title a {color: {{titleColor}};}'
                            ]]
                        ),
                        'titleHoverColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [(object) ['key' => 'enableTitle', 'relation' => '==', 'value' => true]],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .rimcour-courses-grid-title a:hover {color: {{titleHoverColor}};}'
                            ]]
                        ),

                        //Meta
                        'enableMeta' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typographyMeta' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 0,
                                'family' => "Roboto",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => '', 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableMeta', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .course-info ul.category-list li'
                            ]]
                        ),
                        'metaColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableMeta', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .course-info ul.category-list li, {{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .course-info ul.category-list li a {color: {{metaColor}};}'
                            ]]
                        ),

                        //Rating
                        'enableRating' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'ratingColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableRating', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-icon-star-line, {{QUBELY}} .rimcour-icon-star-full, {{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-content .rimcour-loop-rating-wrap .rimcour-star-rating-group {color: {{ratingColor}};}'
                            ]]
                        ),

                        //Price
                        'enablePrice' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typographyPrice' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 0,
                                'family' => "Roboto",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => '', 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-courses-grid-price .price'
                            ]]
                        ),
                        'priceColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-courses-grid-price .price {color: {{priceColor}};}'
                            ]]
                        ),
                        'arrowColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-courses-grid-price a.course-detail {color: {{arrowColor}};}'
                            ]]
                        ),
                        'arrowHoverColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-courses-grid-price a.course-detail:hover {color: {{arrowHoverColor}};}'
                            ]]
                        ),
                        'arrowHoverBg' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enablePrice', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-courses-grid-price a.course-detail:hover {background: {{arrowHoverBg}};}'
                            ]]
                        ),


                        //overlay
                        'enableProfile' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'enableWishlist' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'bgHoverColor' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .rimcour-course-grid-item .rimcour-course-grid-content .rimcour-course-overlay:after {background: {{bgHoverColor}};}'
                            ]]
                        ),

                        //load more
                        'enableLoadMore' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typography' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 1,
                                'family' => "Roboto",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => 16, 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableLoadMore', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .tmrco-course .view-all-course'
                            ]]
                        ),
                        'buttonColor' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableLoadMore', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .tmrco-course .view-all-course {color: {{buttonColor}};}'
                            ]]
                        ),
                        'buttonHoverColor' => array(
                            'type'    => 'string',
                            'default' => '#fff',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableLoadMore', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .tmrco-course .view-all-course:hover {color: {{buttonHoverColor}};}'
                            ]]
                        ),
                        'buttonBg' => array(
                            'type'    => 'string',
                            'default' => '#fff',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableLoadMore', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .tmrco-course .view-all-course {background: {{buttonBg}};}'
                            ]]
                        ),
                        'buttonHoverBg' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'condition' => [
                                    (object) ['key' => 'enableLoadMore', 'relation' => '==', 'value' => true]
                                ],
                                'selector' => '{{QUBELY}} .tmrco-course .view-all-course:hover {background: {{buttonHoverBg}};}'
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
                    'render_callback' => array( $this, 'tmrco_Core_rimcour_Course_block_callback' ),
                )
            );
        }
    
		public function tmrco_Core_rimcour_Course_block_callback( $att ){
            $uniqueId 		   = isset( $att['uniqueId'] ) ? $att['uniqueId'] : '';
            $layout 		   = isset( $att['layout'] ) ? $att['layout'] : '1';
			$columns 		   = isset( $att['columns'] ) ? $att['columns'] : '3';
			$order 		       = isset( $att['order'] ) ? $att['order'] : 'desc';
			$orderby 		   = isset( $att['orderby'] ) ? $att['orderby'] : 'date';
			$include 		   = isset( $att['include'] ) ? $att['include'] : '';
			$exclude 		   = isset( $att['exclude'] ) ? $att['exclude'] : '';
			$numbers 		   = isset( $att['numbers'] ) ? $att['numbers'] : 6;
			$offset 		   = isset( $att['offset'] ) ? $att['offset'] : '';
            $enableTitle 	   = isset($att['enableTitle']) ? $att['enableTitle'] : 1;
            $enableMeta 	   = isset($att['enableMeta']) ? $att['enableMeta'] : 1;
            $enableRating 	   = isset($att['enableRating']) ? $att['enableRating'] : 1;
            $enablePrice 	   = isset($att['enablePrice']) ? $att['enablePrice'] : 1;
            $enableProfile 	   = isset($att['enableProfile']) ? $att['enableProfile'] : 1;
            $enableWishlist    = isset($att['enableWishlist']) ? $att['enableWishlist'] : 1;
            $enableLoadMore    = isset($att['enableLoadMore']) ? $att['enableLoadMore'] : 1;
            // $category 		   = isset( $att['selectedCategory'] ) ? $att['selectedCategory'] : ['all'];
            $category             = $att['selectedCategory'];

            $animation 		= isset($att['animation']) ? ( count((array)$att['animation']) > 0 && $att['animation']['animation']  ? 'data-qubelyanimation="'.htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8').'"' : '' ) : '';
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
            $args = array(
                'post_type' 		=> 'courses',
                'post_status' 		=> 'publish',
                'posts_per_page'    => $numbers
            );

              if ( ! empty($category) ){
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

            if($order) {
                $args['order'] = $order;
            }
            if($orderby) {
                $args['orderby'] = $orderby;
            }
            //exclude
            if ( ! empty($exclude) ){
                $exclude = (array) explode(',', $exclude);
                $args['post__not_in'] = $exclude;
            }
            //include
            if ( ! empty($include) ){
                $include = (array) explode(',', $include);
                $args['post__in'] = $include;
            }
            if($offset) {
                $args['offset'] = $offset;
            }

            $count = 0;
            
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                $html .= '<div class="qubely-block-'. $uniqueId .'">';
                $html .= '<div class="course-container layout-'. $layout .' '.$interaction.'" '.$animation.'>';
                $html .= '<div class="tmrco-course row">';
                $i = 0;
                while ( $query->have_posts() ) {
                    global $post;
                    $i++;
                    $idd = get_the_ID();
                    $query->the_post();
                    $id = get_post_thumbnail_id(); 
                    $src = wp_get_attachment_image_src($id, 'tmrco-squre');
                    $best_selling = get_post_meta($idd, 'tmrco_best_selling', true);
                    $max_new_post = get_theme_mod('new_course_count', 5);

                    $is_wishlisted = rimcour_utils()->is_wishlisted($idd);
                    $has_wish_list = '';
                    if ($is_wishlisted){
                        $has_wish_list = 'has-wish-listed';
                    }

                    $src_layout_1 = wp_get_attachment_image_src($id, 'tmrco-wide');

                    global $authordata;
                    $profile_url = rimcour_utils()->profile_url($authordata->ID);
                    $get_avatar_url = '';

                    if ($layout == 1) {
                        $html .= '<div class="rimcour-course-grid-item col-md-'. $columns .'">'; 
                            $html .= '<div class="rimcour-course-grid-content">';
                                $html .= '<div class="rimcour-course-overlay">';   
                                    if($src_layout_1[0]){ $html .= '<img src="' . $src_layout_1[0] . '" class="img-responsive" />'; }
                                    $html .= '<div class="rimcour-course-grid-level-wishlist">';
                                        $html .= '<span class="rimcour-course-grid-wishlist rimcour-course-wishlist">';
                                            if($enableWishlist == 1) {   
                                                if(is_user_logged_in()){ 
                                                $html .= '<a href="javascript:" class="rimcour-icon-fav-line rimcour-course-wishlist-btn '.$has_wish_list.' " data-course-id="'.$idd.'"></a>';
                                                } else {
                                                    $html .= '<a class="rimcour-icon-fav-line" data-toggle="modal" href="#modal-login"></a>';
                                                }
                                            }
                                            if($enableProfile == 1) {  
                                                if(function_exists('rimcour_utils')){
                                                    $html .= '<a class="rimcour-course-author-thumb" href="'.$profile_url.'">'.rimcour_utils()->get_rimcour_avatar($authordata->ID, 'thumbnail').'</a>';
                                                } else {
                                                    $get_avatar_url = get_avatar_url($authordata->ID, 'thumbnail');
                                                    $html .= '<a class="rimcour-course-author-thumb" href="'.$profile_url.'"><img src="' . $get_avatar_url . '" class="img-responsive" />';  
                                                }
                                            }
                                        $html .= '</span>';
                                    $html .= '</div>';//rimcour-course-grid-level-wishlis
                                    $html .= '<div class="rimcour-course-grid-enroll">';
                                        if (rimcour_utils()->is_course_purchasable()) {
                                            $product_id = rimcour_utils()->get_course_product_id($idd);
                                            //$product    = wc_get_product( $product_id );
                                            $html .= rimcour_course_loop_add_to_cart(false);
                                        }else{
                                            if (rimcour_utils()->is_enrolled($idd)) {
                                            $html .= '<a href="'.esc_url(get_the_permalink()).'" class="btn btn-classic btn-no-fill">'.__('Enrolled','tmrco').'</a>';
                                            } else {
                                                $html .= '<a href="'.esc_url(get_the_permalink()).'" class="btn btn-classic btn-no-fill">'.__('Enroll Now','tmrco').'</a>';
                                            }
                                        }
                                    $html .= '</div>';
                                $html .= '</div>';//rimcour-course-overlay
                                $html .= '<div class="rimcour-course-content">';
                                    if( $enableRating == 1) {  
                                        $course_rating = rimcour_utils()->get_course_rating();
                                        $html .= '<div class="rimcour-loop-rating-wrap">';
                                            ob_start();
                                            rimcour_utils()->star_rating_generator($course_rating->rating_avg);
                                            $html .= ob_get_clean();
                                        $html .= '</div>';
                                    }
                                    if( $enableTitle == 1) {        
                                        $html .= '<h3 class="rimcour-courses-grid-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>';
                                    }
                                    if( $enableMeta == 1) {  
                                        $html .= '<div class="course-info">';
                                            $html .= '<ul class="category-list">';
                                                $html .= '<li><span>'.__('By ', 'tmrco-core').'</span></li>';
                                                $html .= '<li><a href="'.esc_url($profile_url).'">'.get_the_author().'</a></li>';
                                                $html .= '<li><span>'.__(' in ', 'tmrco-core').'</span></li>';

                                                $course_categories = get_rimcour_course_categories();
                                                if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
                                                    $html .= '<li><a href="'.get_category_link( $course_categories[0]->term_id ).'">'.$course_categories[0]->name.'</a></li>';
                                                }
                                            $html .= '</ul>';
                                        $html .= '</div>';
                                    }
                                $html .= '</div>';
                                if( $enablePrice == 1 ) {  
                                    $html .= '<div class="rimcour-courses-grid-price">';
                                        ob_start();
                                        $html .= rimcour_course_price();
                                        $html .= ob_get_clean();
                                        $html .=  '<a class="course-detail" href="'.esc_url(get_the_permalink()).'"><i class="fas fa-arrow-right"></i></a>';
                                    $html .= '</div>';
                                }
                            $html .= '</div>';//rimcour-course-grid-content
                        $html .= '</div>';//rimcour-course-grid-item
                    } else {
                        if ($count == 0) {
                            $html .= '<div class="rimcour-course-grid-item col-md-6">'; 
                                $html .= '<div class="rimcour-course-grid-content course-grid-content-video">';
                                    ob_start();
                                    $video_info = rimcour_utils()->get_video_info();
                                    $video_source = tutils()->array_get('source', $video_info);
                                    if ($video_source && $video_source !== '-1') {                          
                                        rimcour_course_video();
                                    }else{
                                        get_rimcour_course_thumbnail();
                                    }
                                    $html .= ob_get_clean();
                                $html .= '</div>';//rimcour-course-grid-content
                            $html .= '</div>';//rimcour-course-grid-item

                            $html .= '<div class="rimcour-course-content col-md-6"">';
                                if( $enableTitle == 1) {  
                                    $html .= '<h3 class="rimcour-courses-grid-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>';
                                }
                                if( $enableMeta == 1) {  
                                    $html .= '<div class="course-info">';
                                        $html .= '<ul>';
                                            $html .= '<li><a href="'.esc_url($profile_url).'">';
                                                if(function_exists('rimcour_utils')){
                                                    $html .= rimcour_utils()->get_rimcour_avatar($authordata->ID, 'thumbnail');
                                                }else{
                                                    $get_avatar_url = get_avatar_url($authordata->ID, 'thumbnail');
                                                    $html .= '<img src="' . $get_avatar_url . '" class="img-responsive" />';  
                                                }

                                                $html .= get_the_author_meta('display_name');
                                            $html .= '</a></li>';
                                            $html .= '<li><span class="course-level">'.get_rimcour_course_level().'</span></li>';
                                            $course_duration = get_rimcour_course_duration_context();
                                            if(!empty($course_duration)) {
                                                $html .= '<li><span class="course-duration">'.$course_duration.'</span></li>';
                                            } 
                                        $html .= '</ul>';
                                    $html .= '</div>';
                                }
                                $html .= '<p>'.wp_kses_post(tmrco_excerpt_max_charlength(130)).'</p>';
                                $html .= '<div class="rimcour-courses-grid-price">';
                                    ob_start();
                                    if( $enablePrice == 1 ) {
                                        $html .= rimcour_course_price();
                                    }
                                    if( $enableRating == 1) {  
                                        $course_rating = rimcour_utils()->get_course_rating();
                                        rimcour_utils()->star_rating_generator($course_rating->rating_avg);
                                    }
                                    $html .= ob_get_clean();
                                $html .= '</div>';
                            $html .= '</div>';
                        }else {
                            $html .= '<div class="rimcour-course-grid-item course-wrap col-md-'. $columns .'">'; 
                                $html .= '<div class="rimcour-course-grid-content">';
                                    $html .= '<div class="rimcour-course-overlay">';   
                                        if($src[0]){ $html .= '<img src="' . $src[0] . '" class="img-responsive" />'; }
                                        $html .= '<div class="rimcour-course-grid-level-wishlist">';
                                            $html .= '<span class="rimcour-course-grid-wishlist rimcour-course-wishlist">';
                                                if($best_selling == !false) {
                                                    $html .= '<span class="best-sell-tag">'.esc_html__('Featured', 'tmrco').'</span>';
                                                }elseif($i <= $max_new_post){
                                                    $html .= '<span class="best-sell-tag new">'.esc_html__('New', 'tmrco').'</span>';
                                                }
                                                if($enableWishlist == 1) {  
                                                    if(is_user_logged_in()){
                                                    $html .= '<a href="javascript:;" class="rimcour-icon-fav-line rimcour-course-wishlist-btn '.$has_wish_list.' " data-course-id="'.$idd.'"></a>';
                                                    }else{
                                                        $html .= '<a class="rimcour-icon-fav-line" data-toggle="modal" href="#modal-login"></a>';
                                                    }
                                                }
                                            $html .= '</span>';
                                        $html .= '</div>'; //rimcour-course-grid-level-wishlis
                                        $html .= '<div class="rimcour-course-grid-enroll">';
                                            if (rimcour_utils()->is_course_purchasable()) {
                                                $product_id = rimcour_utils()->get_course_product_id($idd);
                                                //$product    = wc_get_product( $product_id );
                                                $html .= rimcour_course_loop_add_to_cart(false);
                                            }else{
                                                if (rimcour_utils()->is_enrolled($idd)) {
                                                    $html .= '<a href="'.esc_url(get_the_permalink()).'" class="btn btn-classic btn-no-fill">'.__('Enrolled','tmrco').'</a>';
                                                } else {
                                                    $html .= '<a href="'.esc_url(get_the_permalink()).'" class="btn btn-classic btn-no-fill">'.__('Enroll Now','tmrco').'</a>';
                                                }
                                            }
                                        $html .= '</div>';
                                    $html .= '</div>'; //rimcour-course-overlay
                                    $html .= '<div class="rimcour-course-content">';
                                        $html .= '<div class="rimcour-courses-grid-price">';
                                            ob_start();
                                            $html .= rimcour_course_price();
                                            $html .= ob_get_clean();
                                        $html .= '</div>';
                                        $html .= '<h3 class="rimcour-courses-grid-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>';
                                    $html .= '</div>';

                                $html .= '</div>';//rimcour-course-grid-content
                            $html .= '</div>';//rimcour-course-grid-item
                        }
                        $count++;
                    }
                }
                if($enableLoadMore == 1) {
                    $html .= '<div class="col-md-12">';
                        $allposts = wp_count_posts('courses');
                        $html .= '<div class="clearfix load-wrap">';
                            $html .= '<span class="ajax-loader"></span>';
                            $html .= '<div class="p-loadmore">';
                                $html .= '<a href="#" class="view-all-course load-more post-loadmore" data-show_layout="'. $layout .'" data-show_column="'.$columns.'" data-per_page="'.$numbers.'" data-total_posts="'.$allposts->publish.'">'.__('View all Courses', 'tmrco-core').'</a>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
                $html .= '</div>';//thm-grid-items
                $html .= '</div>';
                $html .= '</div>';
                
            }
            wp_reset_postdata();
			return $html;
		}
    }
}
tmrco_Core_rimcour_Course::instance();


