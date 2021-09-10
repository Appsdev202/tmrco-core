<?php
defined( 'ABSPATH' ) || exit;


if (! class_exists('tmrco_Core_Base')) {

    class tmrco_Core_Base{

        protected static $_instance = null;
        public static function instance(){
            if (is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct(){
			add_action( 'init', array( $this, 'blocks_init' ));
			add_action( 'enqueue_block_editor_assets', array( $this, 'post_editor_assets' ) );
			add_action( 'enqueue_block_assets', array( $this, 'post_block_assets' ) );
			add_filter( 'block_categories', array( $this, 'block_categories'), 1 , 2 );
		}

		/**
		 * Blocks Init
		 */
		public function blocks_init(){
			require_once tmrco_CORE_PATH . 'core/blocks/rimcourcourse/rimcourcourse.php';
			require_once tmrco_CORE_PATH . 'core/blocks/courseauthor/courseauthor.php';
			require_once tmrco_CORE_PATH . 'core/blocks/tmrcosearch/tmrcosearch.php';
			require_once tmrco_CORE_PATH . 'core/blocks/tmrco-countdown/tmrco-countdown.php';
			require_once tmrco_CORE_PATH . 'core/blocks/tmrcocoursecategory/coursecategory.php';
			require_once tmrco_CORE_PATH . 'core/blocks/tmrco-course-tab/tmrco-course-tab.php';
			require_once tmrco_CORE_PATH . 'core/blocks/tmrco-lessons/tmrco-lessons.php';
        }
        
		/**
		 * Only for the Gutenberg Editor(Backend Only)
		 */
		public function post_editor_assets(){
			wp_enqueue_style(
				'tmrco-core-editor-editor-css',
				tmrco_CORE_URL . 'assets/css/blocks.editor.build.css',
				array( 'wp-edit-blocks' ),
				false
			);

			// Scripts.
			wp_enqueue_script(
				'tmrco-core-block-script-js',
				tmrco_CORE_URL . 'assets/js/blocks.script.build.min.js', 
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor','qubely-blocks-js' ),
				false,
				true
			);

			wp_localize_script( 'tmrco-core-block-script-js', 
			'thm_option', array(
                'plugin' => tmrco_CORE_URL,
				'name' => 'tmrco'
			) );
		}

		/**
		 * All Block Assets (Frontend & Backend)
		 */
		public function post_block_assets(){
			// Styles.
			wp_enqueue_style(
				'tmrco-core-global-style-css',
				tmrco_CORE_URL . 'assets/css/blocks.style.build.css', 
				array( 'wp-editor' ),
				false
			);
		}

		/**
		 * Block Category Add
		 */
		public function block_categories( $categories, $post ){
			return array_merge(
				array(
					array(
						'slug' => 'tmrco-core',
						'title' => __( 'tmrco Core', 'tmrco-core' ),
					)
				),
				$categories
			);
		}


		
    }
}
tmrco_Core_Base::instance();





