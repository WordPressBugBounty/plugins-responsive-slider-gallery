<?php
// Clean Admin CSS - No conflicts
wp_enqueue_style('rsg-admin-clean-css', RSG_PLUGIN_URL . 'css/rsg-admin-clean.css', array(), '2.0.0');

// Font Awesome for icons
wp_enqueue_style('awl-font-awesome-css', RSG_PLUGIN_URL . 'css/font-awesome.css');

// jQuery
wp_enqueue_script('jquery');
?>

<div class="rsg-settings-dashboard">
	<div class="rsg-modern-container">
		<!-- Modern Tab Navigation -->
		<div class="rsg-tab-navigation">
			<button class="rsg-tab-btn active" data-tab="tab-images">
				<span class="dashicons dashicons-images-alt2"></span>
				<?php esc_html_e('Add Images', 'responsive-slider-gallery'); ?>
			</button>
			<button class="rsg-tab-btn" data-tab="tab-settings">
				<span class="dashicons dashicons-admin-settings"></span>
				<?php esc_html_e('Settings', 'responsive-slider-gallery'); ?>
			</button>
			<button class="rsg-tab-btn" data-tab="tab-effects">
				<span class="dashicons dashicons-admin-appearance"></span>
				<?php esc_html_e('Effects', 'responsive-slider-gallery'); ?>
			</button>
			<button class="rsg-tab-btn" data-tab="tab-navigation">
				<span class="dashicons dashicons-arrow-left-alt2"></span>
				<?php esc_html_e('Navigation', 'responsive-slider-gallery'); ?>
			</button>
			<button class="rsg-tab-btn rsg-tab-pro" data-tab="tab-upgrade">
				<span class="dashicons dashicons-star-filled"></span>
				<?php esc_html_e('Upgrade', 'responsive-slider-gallery'); ?>
			</button>
		</div>

		<!-- Tab Content Container -->
		<div class="rsg-tab-content-wrapper">
			<!-- Tab 1: Add Images -->
			<div class="rsg-tab-pane active" id="tab-images">
				<div class="rsg-header">
					<h1><?php esc_html_e('Add Images', 'responsive-slider-gallery'); ?></h1>
					<p class="rsg-subtitle">Manage your slider images.</p>
				</div>
				<div id="slider-gallery">
					<div class="rsg-actions">
						<input type="button" id="add-new-slider" class="button button-large rsg-btn-primary"
							value="<?php esc_html_e('Add Images', 'responsive-slider-gallery'); ?>">
						<button class="button button-large rsg-btn-danger" id="remove-all-slides"
							name="remove-all-slides"><?php esc_html_e('Delete All Slides', 'responsive-slider-gallery'); ?></button>
					</div>
					<ul id="remove-slides" class="sbox rsg-gallery-grid">
						<?php
						$allslidesetting = unserialize(base64_decode(get_post_meta($post->ID, 'awl_slider_settings_' . $post->ID, true)));
						if (isset($allslidesetting['slide-ids'])) {
							foreach ($allslidesetting['slide-ids'] as $id) {
								$thumbnail = wp_get_attachment_image_src($id, 'large', true);
								$attachment = get_post($id);
								?>
								<li class="slide rsg-gallery-item">
									<div class="rsg-slide-image-wrapper">
										<img class="new-slide rsg-slide-image" src="<?php echo esc_url($thumbnail[0]); ?>"
											alt="">
										<a class="pw-trash-icon rsg-delete-btn" name="remove-slide" id="remove-slide"
											href="#"><span class="dashicons dashicons-trash"></span></a>
									</div>
									<input type="hidden" id="slide-ids[]" name="slide-ids[]"
										value="<?php echo esc_attr($id); ?>" />
									<!-- Slide Title-->
									<input type="text" class="rsg-slide-title" name="slide-title[]" id="slide-title[]"
										placeholder="<?php _e('Slide Title', 'responsive-slider-gallery'); ?>" readonly
										value="<?php echo esc_attr(get_the_title($id)); ?>">
								</li>
								<?php
							} // end of foreach
						} //end of if
						?>
					</ul>
				</div>
			</div>

			<!-- Tab 2: Settings -->
			<div class="rsg-tab-pane" id="tab-settings">
				<div class="rsg-header">
					<h1><?php esc_html_e('Configure Settings', 'responsive-slider-gallery'); ?></h1>
					<p class="rsg-subtitle">Customize your slider appearance.</p>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Slider Text', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set slider text visibility on slider', 'responsive-slider-gallery'); ?>
						</p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$slidetext = isset($allslidesetting['slide-text']) ? $allslidesetting['slide-text'] : 'false';
						?>
						<input type="radio" name="slide-text" id="slide-text1" value="true" <?php checked($slidetext, 'true'); ?>>
						<label for="slide-text1"><?php esc_html_e('Yes', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="slide-text" id="slide-text2" value="false" <?php checked($slidetext, 'false'); ?>>
						<label for="slide-text2"><?php esc_html_e('No', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Fit Slides', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set how to fit slides into slider frame', 'responsive-slider-gallery'); ?>
						</p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$fitslides = isset($allslidesetting['fit-slides']) ? $allslidesetting['fit-slides'] : 'cover';
						?>
						<input type="radio" name="fit-slides" id="fit-slides2" value="cover" <?php checked($fitslides, 'cover'); ?>>
						<label for="fit-slides2"><?php esc_html_e('Cover', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="fit-slides" id="fit-slides4" value="none" <?php checked($fitslides, 'none'); ?>>
						<label for="fit-slides4"><?php esc_html_e('None', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Full Screen Slider', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set full screen view of slider', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$fullscreen = isset($allslidesetting['fullscreen']) ? $allslidesetting['fullscreen'] : 'true';
						?>
						<input type="radio" name="fullscreen" id="fullscreen1" value="true" <?php checked($fullscreen, 'true'); ?>>
						<label for="fullscreen1"><?php esc_html_e('True', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="fullscreen" id="fullscreen2" value="false" <?php checked($fullscreen, 'false'); ?>>
						<label for="fullscreen2"><?php esc_html_e('False', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Width', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set slider width (px/%)', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input">
						<?php
						$width = isset($allslidesetting['width']) ? $allslidesetting['width'] : '100%';
						?>
						<input class="rsg-input" type="text" name="width" id="width"
							value="<?php echo esc_attr($width); ?>" placeholder="100%">
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Height', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set slider height (px/%)', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input">
						<?php
						$height = isset($allslidesetting['height']) ? $allslidesetting['height'] : '';
						?>
						<input class="rsg-input" type="text" name="height" id="height"
							value="<?php echo esc_attr($height); ?>" placeholder="500px">
					</div>
				</div>
			</div>

			<!-- Tab 3: Effects -->
			<div class="rsg-tab-pane" id="tab-effects">
				<div class="rsg-header">
					<h1><?php esc_html_e('Auto Play & Effects', 'responsive-slider-gallery'); ?></h1>
					<p class="rsg-subtitle">Control animation and transition behavior.</p>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Auto Play', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set auto play to slides automatically', 'responsive-slider-gallery'); ?>
						</p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$autoplay = isset($allslidesetting['autoplay']) ? $allslidesetting['autoplay'] : 'true';
						?>
						<input type="radio" name="autoplay" id="autoplay1" value="true" <?php checked($autoplay, 'true'); ?>>
						<label for="autoplay1"><?php esc_html_e('Yes', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="autoplay" id="autoplay2" value="false" <?php checked($autoplay, 'false'); ?>>
						<label for="autoplay2"><?php esc_html_e('No', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Loop', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set loop to slides continuously', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$loop = isset($allslidesetting['loop']) ? $allslidesetting['loop'] : 'true';
						?>
						<input type="radio" name="loop" id="loop1" value="true" <?php checked($loop, 'true'); ?>>
						<label for="loop1"><?php esc_html_e('Yes', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="loop" id="loop2" value="false" <?php checked($loop, 'false'); ?>>
						<label for="loop2"><?php esc_html_e('No', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Transition Duration', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Duration in milliseconds (e.g. 500)', 'responsive-slider-gallery'); ?>
						</p>
					</div>
					<div class="rsg-field-input">
						<?php
						$transitionduration = isset($allslidesetting['transition-duration']) ? $allslidesetting['transition-duration'] : '300';
						?>
						<input class="rsg-input" type="text" name="transition-duration" id="transition-duration"
							value="<?php echo esc_attr($transitionduration); ?>" placeholder="300">
					</div>
				</div>
			</div>

			<!-- Tab 4: Navigation -->
			<div class="rsg-tab-pane" id="tab-navigation">
				<div class="rsg-header">
					<h1><?php esc_html_e('Navigation Settings', 'responsive-slider-gallery'); ?></h1>
					<p class="rsg-subtitle">Customize navigation arrows and dots.</p>
				</div>
				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Navigation Style', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set a navigation style', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$navstyle = isset($allslidesetting['nav-style']) ? $allslidesetting['nav-style'] : 'dots';
						?>
						<input type="radio" name="nav-style" id="nav-style1" value="dots" <?php checked($navstyle, 'dots'); ?>>
						<label for="nav-style1"><?php esc_html_e('Dots', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="nav-style" id="nav-style3" value="false" <?php checked($navstyle, 'false'); ?>>
						<label for="nav-style3"><?php esc_html_e('None', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="dots_hs rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Navigation Width', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Set navigation width in pixels/percent', 'responsive-slider-gallery'); ?>
						</p>
					</div>
					<div class="rsg-field-input">
						<?php
						$navwidth = isset($allslidesetting['nav-width']) ? $allslidesetting['nav-width'] : '';
						?>
						<input class="rsg-input" type="text" name="nav-width" id="nav-width"
							value="<?php echo esc_attr($navwidth); ?>" placeholder="100px">
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Navigation Arrow', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Show or hide navigation arrows', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$navarrow = isset($allslidesetting['nav-arrow']) ? $allslidesetting['nav-arrow'] : 'true';
						?>
						<input type="radio" name="nav-arrow" id="nav-arrow2" value="true" <?php checked($navarrow, 'true'); ?>>
						<label for="nav-arrow2"><?php esc_html_e('Show', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="nav-arrow" id="nav-arrow3" value="false" <?php checked($navarrow, 'false'); ?>>
						<label for="nav-arrow3"><?php esc_html_e('Hide', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Touch Slide', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Enable touch/swipe actions', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$touchslide = isset($allslidesetting['touch-slide']) ? $allslidesetting['touch-slide'] : 'true';
						?>
						<input type="radio" name="touch-slide" id="touch-slide1" value="true" <?php checked($touchslide, 'true'); ?>>
						<label for="touch-slide1"><?php esc_html_e('Yes', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="touch-slide" id="touch-slide2" value="false" <?php checked($touchslide, 'false'); ?>>
						<label for="touch-slide2"><?php esc_html_e('No', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>

				<div class="rsg-field-group">
					<div class="rsg-field-label">
						<h6><?php esc_html_e('Slide Loading Spinner', 'responsive-slider-gallery'); ?></h6>
						<p><?php esc_html_e('Show spinner while loading', 'responsive-slider-gallery'); ?></p>
					</div>
					<div class="rsg-field-input switch-field">
						<?php
						$spinner = isset($allslidesetting['spinner']) ? $allslidesetting['spinner'] : 'true';
						?>
						<input type="radio" name="spinner" id="spinner1" value="true" <?php checked($spinner, 'true'); ?>>
						<label for="spinner1"><?php esc_html_e('Yes', 'responsive-slider-gallery'); ?></label>
						<input type="radio" name="spinner" id="spinner2" value="false" <?php checked($spinner, 'false'); ?>>
						<label for="spinner2"><?php esc_html_e('No', 'responsive-slider-gallery'); ?></label>
					</div>
				</div>
			</div>

			<!-- Tab 5: Upgrade -->
			<div class="rsg-tab-pane" id="tab-upgrade">
				<div class="rsg-upgrade-container">
					<!-- Hero Section -->
					<div class="rsg-upgrade-hero">
						<div class="rsg-upgrade-badge">
							<span class="dashicons dashicons-star-filled"></span>
							<?php esc_html_e('Premium Version', 'responsive-slider-gallery'); ?>
						</div>
						<h1 class="rsg-upgrade-title"><?php esc_html_e('Upgrade To Pro', 'responsive-slider-gallery'); ?></h1>
						<p class="rsg-upgrade-description">
							<?php esc_html_e('Unlock powerful features and take your sliders to the next level', 'responsive-slider-gallery'); ?>
						</p>

						<!-- Pricing -->
						<div class="rsg-pricing-box">
							<div class="rsg-price-tag">
								<span class="rsg-price-label"><?php esc_html_e('Special Offer', 'responsive-slider-gallery'); ?></span>
								<div class="rsg-price-amount">
									<span class="rsg-price-old">$20</span>
									<span class="rsg-price-new">$15</span>
									<span class="rsg-price-save"><?php esc_html_e('Save 25%', 'responsive-slider-gallery'); ?></span>
								</div>
							</div>
						</div>

						<!-- CTA Buttons -->
						<div class="rsg-upgrade-actions">
							<a href="<?php echo esc_url('https://awplife.com/wordpress-plugins/responsive-slider-gallery-premium/'); ?>"
								target="_blank" rel="noopener noreferrer" class="rsg-btn-upgrade-primary">
								<span class="dashicons dashicons-cart"></span>
								<?php esc_html_e('Buy Premium Version', 'responsive-slider-gallery'); ?>
							</a>
							<a href="<?php echo esc_url('https://awplife.com/demo/responsive-slider-gallery-premium/'); ?>"
								target="_blank" rel="noopener noreferrer" class="rsg-btn-upgrade-secondary">
								<span class="dashicons dashicons-visibility"></span>
								<?php esc_html_e('View Live Demo', 'responsive-slider-gallery'); ?>
							</a>
						</div>
					</div>

					<!-- Features Grid -->
					<div class="rsg-features-grid">
						<div class="rsg-feature-card">
							<div class="rsg-feature-icon">
								<span class="dashicons dashicons-images-alt2"></span>
							</div>
							<h3><?php esc_html_e('Advanced Layouts', 'responsive-slider-gallery'); ?></h3>
							<p><?php esc_html_e('Multiple slider layouts and styles to choose from', 'responsive-slider-gallery'); ?></p>
						</div>

						<div class="rsg-feature-card">
							<div class="rsg-feature-icon">
								<span class="dashicons dashicons-admin-appearance"></span>
							</div>
							<h3><?php esc_html_e('Slide Transition Effect', 'responsive-slider-gallery'); ?></h3>
							<p><?php esc_html_e('3+ transition effects and animations', 'responsive-slider-gallery'); ?></p>
						</div>

						<div class="rsg-feature-card">
							<div class="rsg-feature-icon">
								<span class="dashicons dashicons-smartphone"></span>
							</div>
							<h3><?php esc_html_e('Fully Responsive', 'responsive-slider-gallery'); ?></h3>
							<p><?php esc_html_e('Perfect display on all devices and screen sizes', 'responsive-slider-gallery'); ?></p>
						</div>

						<div class="rsg-feature-card">
							<div class="rsg-feature-icon">
								<span class="dashicons dashicons-admin-customizer"></span>
							</div>
							<h3><?php esc_html_e('Full Customization', 'responsive-slider-gallery'); ?></h3>
							<p><?php esc_html_e('Complete control over colors, fonts, and spacing', 'responsive-slider-gallery'); ?></p>
						</div>

						<div class="rsg-feature-card">
							<div class="rsg-feature-icon">
								<span class="dashicons dashicons-format-video"></span>
							</div>
							<h3><?php esc_html_e('Video Support', 'responsive-slider-gallery'); ?></h3>
							<p><?php esc_html_e('Add YouTube and Vimeo videos to your sliders', 'responsive-slider-gallery'); ?></p>
						</div>

						<div class="rsg-feature-card">
							<div class="rsg-feature-icon">
								<span class="dashicons dashicons-sos"></span>
							</div>
							<h3><?php esc_html_e('Priority Support', 'responsive-slider-gallery'); ?></h3>
							<p><?php esc_html_e('Get fast and dedicated support from our team', 'responsive-slider-gallery'); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<?php
// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
wp_nonce_field('save_settings', 'rsg_save_nonce');
?>

<script>
	// ===== Scroll to Top ==== 
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
			jQuery('#return-to-top').fadeIn(200);    // Fade in the arrow
		} else {
			jQuery('#return-to-top').fadeOut(200);   // Else fade out the arrow
		}
	});
	jQuery('#return-to-top').click(function () {      // When arrow is clicked
		jQuery('body,html').animate({
			scrollTop: 0                       // Scroll to top of body
		}, 500);
	});

	// Show Hide Settings
	jQuery(document).ready(function () {
		// Navigation settings
		var nav_style = jQuery('input[name="nav-style"]:checked').val();
		if (nav_style == "dots") {
			jQuery('.dots_hs').show();
		} else {
			jQuery('.dots_hs').hide();
		}

		// On change navigation setting
		jQuery('input[name="nav-style"]').change(function () {
			var nav_style = jQuery('input[name="nav-style"]:checked').val();
			if (nav_style == "dots") {
				jQuery('.dots_hs').show();
			} else {
				jQuery('.dots_hs').hide();
			}
		});
	});



	// start pulse on page load
	function pulseEff() {
		jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff, 1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff, 1500);
	}
	// Modern Tab Switching
	jQuery('.rsg-tab-btn').on('click', function (e) {
		e.preventDefault();

		// Remove active class from all tabs and buttons
		jQuery('.rsg-tab-btn').removeClass('active');
		jQuery('.rsg-tab-pane').removeClass('active');

		// Add active class to clicked button
		jQuery(this).addClass('active');

		// Show corresponding tab content
		var tabId = jQuery(this).data('tab');
		jQuery('#' + tabId).addClass('active');
	});
</script>