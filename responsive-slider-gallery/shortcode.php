<?php
/**
 * Responsive Slider Shortcode
 *
 * @access    public
 *
 * @return    Create Fontend Slider Gallery Output
 */
add_shortcode('responsive-slider', 'responsive_slider_shortcode');
function responsive_slider_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts,
        'responsive-slider'
    );

    $post_id = absint($atts['id']);
    if (!$post_id) {
        return '';
    }

    wp_enqueue_script('awl-fotorama-js');
    wp_enqueue_style('awl-fotorama-css');

    ob_start();

    $query_args = array(
        'p' => $post_id,
        'post_type' => 'responsive_slider',
    );
    $slider_query = new WP_Query($query_args);

    if ($slider_query->have_posts()):
        while ($slider_query->have_posts()):
            $slider_query->the_post();
            $current_post_id = get_the_ID();
            $meta_value = get_post_meta($current_post_id, 'awl_slider_settings_' . $current_post_id, true);
            $allslidesetting = unserialize(base64_decode($meta_value));

            // Default settings
            $defaults = array(
                'width' => '100%',
                'height' => '',
                'nav-style' => 'dots',
                'nav-width' => '',
                'fullscreen' => 'true',
                'fit-slides' => 'cover',
                'transition-duration' => '300',
                'slide-text' => 'false',
                'autoplay' => 'true',
                'loop' => 'true',
                'nav-arrow' => 'true',
                'touch-slide' => 'true',
                'spinner' => 'true',
            );

            $settings = wp_parse_args((array) $allslidesetting, $defaults);

            ?>
            <div class="fotorama responsive-image-silder" 
                data-width="<?php echo esc_attr($settings['width']); ?>"
                data-height="<?php echo esc_attr($settings['height']); ?>" 
                data-nav="<?php echo esc_attr($settings['nav-style']); ?>"
                data-navwidth="<?php echo esc_attr($settings['nav-width']); ?>" 
                data-allowfullscreen="<?php echo esc_attr($settings['fullscreen']); ?>"
                data-fit="<?php echo esc_attr($settings['fit-slides']); ?>"
                data-transitionduration="<?php echo esc_attr($settings['transition-duration']); ?>"
                data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>" 
                data-loop="<?php echo esc_attr($settings['loop']); ?>"
                data-arrows="<?php echo esc_attr($settings['nav-arrow']); ?>" 
                data-swipe="<?php echo esc_attr($settings['touch-slide']); ?>"
                data-spinner="<?php echo esc_attr($settings['spinner']); ?>" 
                data-transition="slide">
                <?php
                if (isset($settings['slide-ids']) && is_array($settings['slide-ids']) && count($settings['slide-ids']) > 0) {
                    foreach ($settings['slide-ids'] as $attachment_id) {
                        $attachment_id = absint($attachment_id);
                        $full_url = wp_get_attachment_url($attachment_id);
                        $thumb_url = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
                        
                        $attachment = get_post($attachment_id);
                        if (!$attachment) continue;

                        $title = $attachment->post_title;
                        $caption = ($settings['slide-text'] == 'true') ? $title : '';
                        ?>
                        <img src="<?php echo esc_url($full_url); ?>" data-thumb="<?php echo esc_url($thumb_url[0]); ?>" data-caption="<?php echo esc_attr($caption); ?>">
                        <?php
                    }
                } else {
                    echo '<p>' . esc_html__('Sorry! No slides added to the slider shortcode yet. Please add a few slides into the shortcode.', 'responsive-slider-gallery') . '</p>';
                }
                ?>
            </div>
            
            <!-- Initialization Script - Inside the container to ensure it's returned by the shortcode -->
            <script>
                jQuery(function ($) {
                    $('.responsive-image-silder').fotorama({
                        spinner: {
                            lines: 13,
                            color: 'rgba(0, 0, 0, .75)',
                            className: 'fotorama',
                        }
                    });
                });
            </script>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;

    return ob_get_clean();
}