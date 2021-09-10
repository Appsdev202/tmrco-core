<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('tmrco_Core_rimcour_Course_Lessons')) {
    class tmrco_Core_rimcour_Course_Lessons{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } 
        public function __construct(){
			register_block_type(
                'qubely/tmrco-core-rimcour-course-lessons',
                array(
                    'attributes' => array(
                        'uniqueId'      => array(
                            'type'      => 'string',
                            'default'   => ''
                        ),
                        'courseId'   => array(
                            'type'      => 'string',
                            'default'   => ''
                        ),
                    ),
                    'render_callback' => array( $this, 'tmrco_Core_rimcour_Course_Lessons_block_callback' ),
                )
            );
        }
    
		public function tmrco_Core_rimcour_Course_Lessons_block_callback( $att ){

            $uniqueId               = isset($att['uniqueId']) ? $att['uniqueId'] : '';
            $courseId               = isset($att['courseId']) ? $att['courseId'] : '';
            $courseId       = (int)$courseId;

            $html = '';
            $html .= '<div class="qubely-block-' . $uniqueId . '">';

                $html .= '<div id="course-content" class="what-you-get-package-wrap">';
                    $html .= '<div class="container">';
                        $html .= '<div class="get-package-wrap-top">';
                                $html .= '<div class="row">';
                                    $html .= '<div class="col-12">';
                                    $args = array(
                                        'post_type'  => 'topics',
                                        'post_parent'  => $courseId,
                                        'orderby' => 'menu_order',
                                        'order'   => 'ASC',
                                        'posts_per_page'    => -1,
                                    );
                                    $topics = new \WP_Query($args);

                                    $is_enrolled = rimcour_utils()->is_enrolled($courseId);

                                    if($topics->have_posts()) { 
                                    
                                        $html .= '<div class="rimcour-single-course-segment rimcour-course-topics-wrap">';
                                            $html .= '<div class="rimcour-course-topics-contents">';
                                            
                                                $index = 0;

                                                if ($topics->have_posts()){
                                                    while ($topics->have_posts()){ $topics->the_post();
                                                        $index++;
                                                        $rimcour_active_class = '';

                                                        if($index == 1 ){
                                                            $rimcour_active_class = 'rimcour-active';
                                                        }

                                                        $course_lesson_style = '';
                                                        if($index > 1){
                                                            $course_lesson_style = 'display: none';
                                                        }

                                                        $html .= '<div class="rimcour-course-topic '.$rimcour_active_class.'">';
                                                            $html .= '<div class="row">';
                                                                $html .= '<div class="col-md-9">';
                                                                    $html .= '<div class="rimcour-course-title">';
                                                                        $html .= '<h4> <i class="rimcour-icon-plus"></i>'.get_the_title().'</h4>';
                                                                            $html .= '<p>'.get_the_content().'</p>';
                                                                        $html .= '</div>';
                                                                    $html .= '<div class="rimcour-course-lessons" style="'.$course_lesson_style.'">';
                                                                    
                                                                        $lessons = rimcour_utils()->get_course_contents_by_topic(get_the_ID(), -1);

                                                                        $lesson_count = 0;

                                                                        if ($lessons->have_posts()){
                                                                            while ($lessons->have_posts()){ $lessons->the_post();
                                                                                $lesson_count++;
                                                                                global $post;
                                                                                $_is_preview = get_post_meta(get_the_ID(), '_is_preview', true);
                                                                                $video = rimcour_utils()->get_video_info();
                                            
                                                                                $thumbURL = get_the_post_thumbnail_url();
                                            
                                                                                $play_time = false;
                                                                                if ($video){
                                                                                    $play_time = $video->playtime;
                                                                                }
                                                                                $is_completed_lesson = rimcour_utils()->is_completed_lesson();
                                                                                
                                                                                if($is_completed_lesson){
                                                                                    $lesson_icon = $play_time ? 'rimcour-icon-youtube' : 'rimcour-icon-document-alt';
                                                                                }else{
                                                                                    $lesson_icon = $play_time ? 'rimcour-icon-lock' : 'rimcour-icon-document-alt';
                                                                                }   
                                            
                                                                                if ($post->post_type === 'rimcour_quiz'){
                                                                                    $lesson_icon = 'rimcour-icon-doubt lesson-bg';
                                                                                }
                                                                                if ($post->post_type === 'rimcour_assignments'){
                                                                                    $lesson_icon = 'rimcour-icon-clipboard lesson-bg';
                                                                                }

                                                                                if($_is_preview) {
                                                                                $html .= '<div class="rimcour-course-lesson preview-enabled-lesson">';
                                                                                    } else{ 
                                                                                $html .= '<div class="rimcour-course-lesson">';
                                                                                    } 
                                            
                                                                                    $html .= '<h5>';
                                                                                    
                                                                                            $lesson_title = "<i style='background:url(".esc_url($thumbURL).")' class='$lesson_icon'></i>";
                                            
                                                                                            if ($is_enrolled){
                                                                                                $lesson_title .= "<div class='rimcour-course-lesson-content'><a href='".get_the_permalink()."'> ".get_the_title()." </a>";
                                            
                                            
                                                                                                $lesson_title .= $play_time ? "<span class='rimcour-lesson-duration'>$play_time</span></div>" : '';
                                            
                                                                                                if($is_completed_lesson){
                                                                                                    $lesson_title .= '<div class="lesson-completed-text"><i class="fa fa-check"></i>';
                                                                                                        $lesson_title .= '<span>'.esc_html__('Viewed', 'tmrco').'</span>';
                                                                                                    $lesson_title .= '</div>';
                                                                                                }
                                            
                                                                                                $html .= $lesson_title;
                                                                                            }else{
                                                                                                $lesson_title .= '<div class="rimcour-course-lesson-content">';
                                                                                                    $lesson_title .= '<div class="course-lesson-title-inner">'.get_the_title().'</div>';
                                                                                                    $lesson_title .= $play_time ? "<span class='rimcour-lesson-duration'>$play_time</span>" : '';
                                                                                                $lesson_title .= '</div>';
                                                                                                //$html .= $lesson_title;
                                                                                                $html .= apply_filters('rimcour_course/contents/lesson/title', $lesson_title, get_the_ID());
                                                                                            }
                                            
                                                                                        
                                                                                    $html .= '</h5>';
                                                                                $html .= '</div>';
                                            
                                                                            }
                                                                            $lessons->reset_postdata();
                                                                        }
                                                                        
                                                                    $html .= '</div>';
                                                                $html .= '</div>';
                                                                $html .= '<div class="col-md-3">';
                                                                    $html .= '<div class="course-2-lesson-count text-right">';
                                                                        $html .= $lesson_count.' '.esc_html__('Lecture', 'tmrco');
                                                                        
                                                                    $html .= '</div>';
                                                                $html .= '</div>';
                                                            $html .= '</div>';

                                                        $html .= '</div>';
                                                    
                                                    }
                                                    $topics->reset_postdata();
                                                    wp_reset_postdata(); 
                                                }
                                            
                                            $html .= '</div>';
                                        $html .= '</div>';
                                    } else{
                                        echo 'No Post Found';
                                    }
                                
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';

            return $html; 

		}
    }
}
tmrco_Core_rimcour_Course_Lessons::instance();


