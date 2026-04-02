<?php
/**
 * @package Responsive Slider Gallery
 */

/**
 * Plugin Name:       Responsive Slider Gallery
 * Plugin URI:        https://awplife.com/wordpress-plugins/responsive-slider-gallery-premium/
 * Description:       A Responsive Simple Beautiful Easy Powerful CSS & JS Based WordPress Image Slider Gallery Plugin [standard]
 * Version:           1.5.3
 * Requires at least: 5.4
 * Requires PHP:      7.2
 * Author:            A WP Life
 * Author URI:        https://profiles.wordpress.org/awordpresslife
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       responsive-slider-gallery
 * Domain Path:       /languages
 * License:           GPL2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Responsive_Slider_Gallery')) {

	class Responsive_Slider_Gallery
	{

		protected $protected_plugin_api;
		protected $ajax_plugin_nonce;

		public function __construct()
		{
			$this->_constants();
			$this->_hooks();
		}

		protected function _constants()
		{
			/**
			 * Plugin Version
			 */
			define('RSG_PLUGIN_VER', '1.5.3');

			/**
			 * Plugin Text Domain
			 */
			define('rsg_txt_dm', 'responsive-slider-gallery');

			/**
			 * Plugin Name
			 */
			define('RSG_PLUGIN_NAME', 'Responsive Slider Gallery');

			/**
			 * Plugin Slug
			 */
			define('RSG_PLUGIN_SLUG', 'responsive_slider');

			/**
			 * Plugin Directory Path
			 */
			define('RSG_PLUGIN_DIR', plugin_dir_path(__FILE__));

			/**
			 * Plugin Directory URL
			 */
			define('RSG_PLUGIN_URL', plugin_dir_url(__FILE__));

			/**
			 * Create a key for the .htaccess secure download link.
			 *
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define('EWPT_SECURE_KEY', md5(NONCE_KEY));

		} // end of constructor function


		/**
		 * Setup the default filters and actions
		 *
		 * @uses      add_action()  To add various actions
		 * @access    private
		 * @return    void
		 */
		protected function _hooks()
		{
			/**
			 * Load text domain
			 */
			add_action('init', array($this, '_load_textdomain'));

			/**
			 * Create Responsive Slider Gallery Custom Post
			 */
			add_action('init', array($this, '_Responsive_Slider_Gallery'));

			/**
			 * Add meta box to custom post
			 */
			add_action('add_meta_boxes', array($this, '_admin_add_meta_box'));

			add_action('wp_ajax_slide', array(&$this, '_ajax_slide'));
			add_action('wp_ajax_batch_slides', array(&$this, '_ajax_batch_slides'));

			add_action('save_post', array(&$this, '_save_settings'));

			/**
			 * Shortcode Compatibility in Text Widgets
			 */
			add_filter('widget_text', 'do_shortcode');

			// add pfg cpt shortcode column - manage_{$post_type}_posts_columns
			add_filter('manage_responsive_slider_posts_columns', array(&$this, 'set_responsive_slider_shortcode_column_name'));

			// add pfg cpt shortcode column data - manage_{$post_type}_posts_custom_column
			add_action('manage_responsive_slider_posts_custom_column', array(&$this, 'custom_responsive_slider_shodrcode_data'), 10, 2);

			add_action('wp_enqueue_scripts', array(&$this, 'responsive_enqueue_scripts_in_header'));

		} // end of hook function

		public function responsive_enqueue_scripts_in_header()
		{
			wp_enqueue_script('jquery');
			if (is_admin()) {
				wp_enqueue_script('rsg-admin-js', RSG_PLUGIN_URL . 'js/rsg-admin.js', array('jquery'), RSG_PLUGIN_VER, true);
			}
		}

		// Responsiv Slider cpt shortcode column before date columns
		public function set_responsive_slider_shortcode_column_name($defaults)
		{
			$new = array();
			foreach ($defaults as $key => $value) {
				if ($key == 'date') {
					$new['responsive_slider_shortcode'] = __('Shortcode', 'responsive-slider-gallery');
				}
				$new[$key] = $value;
			}
			return $new;
		}

		// Responsiv Slider cpt shortcode column data
		public function custom_responsive_slider_shodrcode_data($column, $post_id)
		{
			switch ($column) {
				case 'responsive_slider_shortcode':
					echo "<input type='text' id='responsive-slider-shortcode-" . esc_attr($post_id) . "' value='[responsive-slider id=" . esc_attr($post_id) . "]' style='font-weight:bold; background-color:#32373C; color:#FFFFFF; text-align:center;' readonly />";
					echo "<input type='button' class='button button-primary rsg-list-copy-btn' data-post-id='" . esc_attr($post_id) . "' value='" . esc_attr__('Copy', 'responsive-slider-gallery') . "' style='margin-left:4px;' />";
					echo "<span id='copy-msg-" . esc_attr($post_id) . "' class='button button-primary' style='display:none; background-color:#32CD32; color:#FFFFFF; margin-left:4px; border-radius: 4px;'>" . esc_html__('copied', 'responsive-slider-gallery') . "</span>";
					break;
			}
		}

		/**
		 * Loads the text domain.
		 *
		 * @return    void
		 * @access    private
		 */
		public function _load_textdomain()
		{
			load_plugin_textdomain('responsive-slider-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages');
		}


		/**
		 * Responsive Slider Gallery Custom Post
		 * Create slider post type in admin dashboard.
		 *
		 * @access    private
		 * @return    void      Return custom post type.
		 */
		public function _Responsive_Slider_Gallery()
		{
			$labels = array(
				'name' => _x('Responsive Slider Galleries', 'Post Type General Name', 'responsive-slider-gallery'),
				'singular_name' => _x('Responsive Slider Gallery', 'Post Type Singular Name', 'responsive-slider-gallery'),
				'menu_name' => __('Responsive Slider Gallery', 'responsive-slider-gallery'),
				'name_admin_bar' => __('Responsive Slider Gallery', 'responsive-slider-gallery'),
				'parent_item_colon' => __('Parent Item', 'responsive-slider-gallery'),
				'all_items' => __('All Slider Gallery', 'responsive-slider-gallery'),
				'add_new_item' => __('Add Slider Gallery', 'responsive-slider-gallery'),
				'add_new' => __('Add Slider Gallery', 'responsive-slider-gallery'),
				'new_item' => __('New Gallery', 'responsive-slider-gallery'),
				'edit_item' => __('Edit Gallery', 'responsive-slider-gallery'),
				'update_item' => __('Update Gallery', 'responsive-slider-gallery'),
				'search_items' => __('Search Gallery', 'responsive-slider-gallery'),
				'not_found' => __('Gallery Not found', 'responsive-slider-gallery'),
				'not_found_in_trash' => __('Gallery Not found in Trash', 'responsive-slider-gallery'),
			);
			$args = array(
				'label' => __('Responsive Slider Gallery', 'responsive-slider-gallery'),
				'description' => __('Custom Post Type For Responsive Slider Gallery', 'responsive-slider-gallery'),
				'labels' => $labels,
				'supports' => array('title'),
				'taxonomies' => array(),
				'hierarchical' => false,
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 65,
				'menu_icon' => 'dashicons-images-alt2',
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => true,
				'can_export' => true,
				'has_archive' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'capability_type' => 'page',
			);
			register_post_type('responsive_slider', $args);

		} // end of post type function

		/**
		 * Adds Meta Boxes
		 *
		 * @access    private
		 * @return    void
		 */
		public function _admin_add_meta_box()
		{
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box('1', __('Copy Responsive Slider Shortcode', 'responsive-slider-gallery'), array(&$this, '_rsg_shortcode_left_metabox'), 'responsive_slider', 'side', 'default');
			add_meta_box('', __('Add Image Slides', 'responsive-slider-gallery'), array(&$this, 'upload_multiple_images'), 'responsive_slider', 'normal', 'default');
		}

		// image gallery copy shortcode meta box under publish button
		public function _rsg_shortcode_left_metabox($post)
		{ ?>
			<p class="input-text-wrap">
				<input type="text" name="RSGcopyshortcode" id="RSGcopyshortcode"
					value="<?php echo esc_attr("[responsive-slider id=" . $post->ID . "]"); ?>" readonly
					style="height: 90px; text-align: center; width:100%;  font-size: 20px; border: 2px dashed;">
			<p id="rsg-copy-code"><?php esc_html_e('Shortcode copied to clipboard!', 'responsive-slider-gallery'); ?></p>
			<p style="margin-top: 10px">
				<?php esc_html_e('Copy & Embed shotcode into any Page/ Post / Text Widget to display gallery.', 'responsive-slider-gallery'); ?>
			</p>
			</p>
			<span class="rsg-copy-metabox dashicons dashicons-clipboard"></span>
			<style>
				.rsg-copy {
					position: absolute;
					top: 9px;
					right: 30px;
					font-size: 30px;
					cursor: pointer;
				}

				.ui-sortable-handle>span {
					font-size: 16px !important;
				}
			</style>
			<script>
				jQuery("#rsg-copy-code").hide();
			</script>
			<?php
		}

		public function upload_multiple_images($post)
		{
			wp_enqueue_script('media-upload');
			wp_enqueue_script('awl-uploader-js', RSG_PLUGIN_URL . 'js/awl-uploader.js', array('jquery'));
			wp_enqueue_script('rsg-admin-js', RSG_PLUGIN_URL . 'js/rsg-admin.js', array('jquery'), RSG_PLUGIN_VER, true);
			wp_enqueue_style('awl-uploader-css', RSG_PLUGIN_URL . 'css/awl-uploader.css');
			wp_enqueue_style('rsg-admin-css', RSG_PLUGIN_URL . 'css/rsg-admin-clean.css', array(), RSG_PLUGIN_VER);
			wp_enqueue_media();
			?>


			<!--Add New Slide Button-->
			<?php wp_nonce_field('rsg_add_images', 'rsg_add_images_nonce'); ?>

			<?php
			require_once 'slider-settings.php';
		} // end of upload multiple image

		public function _rsg_ajax_callback_function($id)
		{
			$thumbnail = wp_get_attachment_image_src($id, 'large', true);

			if (!$thumbnail) {
				return;
			}
			?>
			<li class="slide rsg-gallery-item">
				<div class="rsg-slide-image-wrapper">
					<img class="new-slide rsg-slide-image" src="<?php echo esc_url($thumbnail[0]); ?>" alt="">
					<a class="pw-trash-icon rsg-delete-btn" name="remove-slide" id="remove-slide" href="#"
						title="Delete Slide"><span class="dashicons dashicons-trash"></span></a>
				</div>
				<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo esc_attr($id); ?>" />
				<input type="text" class="rsg-slide-title" name="slide-title[]" id="slide-title[]"
					placeholder="<?php _e('Slide Title', 'responsive-slider-gallery'); ?>" readonly
					value="<?php echo esc_attr(get_the_title($id)); ?>">
			</li>
			<?php
		}

		public function _ajax_slide()
		{
			if (current_user_can('manage_options')) {
				if (!isset($_POST['rsg_add_images_nonce']) || !wp_verify_nonce($_POST['rsg_add_images_nonce'], 'rsg_add_images')) {
					wp_send_json_error('Sorry, your nonce did not verify.');
					exit;
				} else {
					$slide_id = absint($_POST['slideId']);
					$this->_rsg_ajax_callback_function($slide_id);
					die;
				}
			}
		}

		public function _ajax_batch_slides()
		{
			if (current_user_can('manage_options')) {
				if (!isset($_POST['rsg_add_images_nonce']) || !wp_verify_nonce($_POST['rsg_add_images_nonce'], 'rsg_add_images')) {
					wp_send_json_error('Sorry, your nonce did not verify.');
					exit;
				} else {
					$slide_ids = isset($_POST['slideIds']) ? (array) $_POST['slideIds'] : array();
					foreach ($slide_ids as $id) {
						$this->_rsg_ajax_callback_function(absint($id));
					}
					die;
				}
			}
		}

		public function _save_settings($post_id)
		{
			if (isset($_POST['rsg_save_nonce'])) {
				if (wp_verify_nonce($_POST['rsg_save_nonce'], 'save_settings')) {

					$width = sanitize_text_field($_POST['width']);
					$height = sanitize_text_field($_POST['height']);
					$navstyle = sanitize_text_field($_POST['nav-style']);
					$navwidth = sanitize_text_field($_POST['nav-width']);
					$fullscreen = sanitize_text_field($_POST['fullscreen']);
					$fitslides = sanitize_text_field($_POST['fit-slides']);
					$transitionduration = sanitize_text_field($_POST['transition-duration']);
					$slidetext = sanitize_text_field($_POST['slide-text']);
					$autoplay = sanitize_text_field($_POST['autoplay']);
					$loop = sanitize_text_field($_POST['loop']);
					$navarrow = sanitize_text_field($_POST['nav-arrow']);
					$touchslide = sanitize_text_field($_POST['touch-slide']);
					$spinner = sanitize_text_field($_POST['spinner']);

					$image_ids = array();
					$image_titles = array();
					$image_ids_raw = isset($_POST['slide-ids']) ? (array) $_POST['slide-ids'] : array();
					$image_titles_raw = isset($_POST['slide-title']) ? (array) $_POST['slide-title'] : array();

					foreach ($image_ids_raw as $i => $image_id) {
						$sanitized_id = absint($image_id);
						$sanitized_title = isset($image_titles_raw[$i]) ? sanitize_text_field($image_titles_raw[$i]) : '';

						$image_ids[] = $sanitized_id;
						$image_titles[] = $sanitized_title;

						// Update image post title
						$single_image_update = array(
							'ID' => $sanitized_id,
							'post_title' => $sanitized_title,
						);
						wp_update_post($single_image_update);
					}

					$allslidesetting = array(
						'slide-ids' => $image_ids,
						'slide-title' => $image_titles,
						'width' => $width,
						'height' => $height,
						'nav-style' => $navstyle,
						'nav-width' => $navwidth,
						'fullscreen' => $fullscreen,
						'fit-slides' => $fitslides,
						'transition-duration' => $transitionduration,
						'slide-text' => $slidetext,
						'autoplay' => $autoplay,
						'loop' => $loop,
						'nav-arrow' => $navarrow,
						'touch-slide' => $touchslide,
						'spinner' => $spinner,
					);
					$awl_slider_shortcode_setting = 'awl_slider_settings_' . $post_id;
					update_post_meta($post_id, $awl_slider_shortcode_setting, base64_encode(serialize($allslidesetting)));
				}
			}

		}

		/**
		 * Responsive Slider Gallery Docs Page
		 * Create doc page to help user to setup plugin
		 *
		 * @access    private
		 * @return    void.
		 */
		public function _rsgallery_featured_plugin_page()
		{
			// Unused
		}

		public function _rs_upgrade_plugin_page()
		{
			// Unused
		}

		// theme page
		public function _rs_theme_page()
		{
			// Unused
		}

	} // end of class

	// register sf scripts
	function awplife_rsg_register_scripts()
	{

		// css & JS
		wp_register_script('awl-fotorama-js', plugin_dir_url(__FILE__) . 'js/fotorama.min.js', array('jquery'));
		wp_register_style('awl-fotorama-css', plugin_dir_url(__FILE__) . 'css/awl-fotorama.min.css');
		// css & JS
	}
	add_action('wp_enqueue_scripts', 'awplife_rsg_register_scripts');



	/**
	 * Instantiates the Class
	 *
	 * @global    object    $rs_gallery_object
	 */
	$rs_gallery_object = new Responsive_Slider_Gallery();
	require_once 'shortcode.php';
} // end of if class exists
?>