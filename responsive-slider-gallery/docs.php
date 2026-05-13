<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<style>
    :root {
        --rsg-primary: #2271b1;
        --rsg-success: #00a32a;
        --rsg-dark: #1d2327;
        --rsg-border: #c3c4c7;
        --rsg-bg: #f0f0f1;
    }
    
    .rsg-doc-wrapper {
        margin: 20px 20px 0 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    .rsg-header {
        background: #fff;
        border: 1px solid var(--rsg-border);
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .rsg-header-content h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 10px 0;
        color: var(--rsg-dark);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .rsg-header-content h1 .dashicons {
        font-size: 36px;
        width: 36px;
        height: 36px;
        color: var(--rsg-primary);
    }

    .rsg-header-content p {
        font-size: 16px;
        color: #646970;
        margin: 0;
    }

    .rsg-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 25px;
    }

    @media (max-width: 1024px) {
        .rsg-grid { grid-template-columns: 1fr; }
    }

    .rsg-card {
        background: #fff;
        border: 1px solid var(--rsg-border);
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .rsg-card-header {
        padding: 20px 25px;
        border-bottom: 1px solid var(--rsg-border);
        background: #fafafa;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rsg-card-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--rsg-dark);
    }

    .rsg-card-body {
        padding: 25px;
    }

    .rsg-steps {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rsg-step-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px dashed #dcdcde;
    }
    .rsg-step-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .rsg-step-number {
        background: var(--rsg-primary);
        color: #fff;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        flex-shrink: 0;
        font-size: 13px;
    }

    .rsg-step-text strong {
        display: block;
        font-size: 15px;
        margin-bottom: 4px;
        color: var(--rsg-dark);
    }
    .rsg-step-text p {
        margin: 0;
        color: #50575e;
        line-height: 1.5;
    }

    .rsg-table-styled {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #e5e7eb;
    }
    .rsg-table-styled th {
        background: #f9fafb;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }
    .rsg-table-styled td {
        padding: 15px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: top;
    }
    .rsg-table-styled tr:hover td {
        background: #fafafa;
    }
    .rsg-badge {
        display: inline-block;
        background: #eef2ff;
        color: #4338ca;
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 600;
        font-family: monospace;
    }

    .rsg-sidebar-cta {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        color: white;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 25px;
        text-align: center;
    }
    .rsg-sidebar-cta h3 {
        color: white;
        margin-top: 0;
        font-size: 20px;
    }
    .rsg-btn-gold {
        display: block;
        background: #fbbf24;
        color: #78350f;
        text-decoration: none;
        font-weight: 700;
        padding: 12px;
        border-radius: 6px;
        margin-top: 15px;
        transition: all 0.2s;
    }
    .rsg-btn-gold:hover {
        background: #f59e0b;
        color: #78350f;
        transform: translateY(-1px);
    }

    .rsg-link-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .rsg-link-list li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        color: #2271b1;
        text-decoration: none;
        border-bottom: 1px solid #f0f0f1;
        font-weight: 500;
    }
    .rsg-link-list li a:hover {
        color: #135e96;
    }
    .rsg-link-list li:last-child a { border: none; }

    .rsg-tip {
        background: #f0f9ff;
        border-left: 4px solid #0ea5e9;
        padding: 15px;
        border-radius: 0 4px 4px 0;
        margin-top: 20px;
        display: flex;
        gap: 12px;
    }
    .rsg-tip span { color: #0284c7; font-size: 20px; }
    .rsg-tip-content p { margin: 0; font-size: 14px; color: #0369a1; }
</style>

<div class="rsg-doc-wrapper">
    <!-- HEADER SECTION -->
    <header class="rsg-header">
        <div class="rsg-header-content">
            <h1>
                <span class="dashicons dashicons-images-alt2"></span>
                <?php esc_html_e('Documentation Hub', 'responsive-slider-gallery'); ?>
            </h1>
            <p><?php esc_html_e('Everything you need to create master-class image slideshows quickly and easily.', 'responsive-slider-gallery'); ?></p>
        </div>
        <a href="https://paypal.me/awplife" target="_blank" class="button button-secondary" style="display: flex; align-items: center; gap: 5px;">
            <span class="dashicons dashicons-heart" style="color: #d63638; font-size: 16px; margin-top: 4px;"></span>
            <?php esc_html_e('Support Development', 'responsive-slider-gallery'); ?>
        </a>
    </header>

    <div class="rsg-grid">
        <!-- MAIN CONTENT -->
        <div class="rsg-main">
            
            <!-- STEP BY STEP CARDI -->
            <div class="rsg-card">
                <div class="rsg-card-header">
                    <span class="dashicons dashicons-controls-forward" style="color: var(--rsg-primary)"></span>
                    <h2><?php esc_html_e('Express Setup Guide', 'responsive-slider-gallery'); ?></h2>
                </div>
                <div class="rsg-card-body">
                    <ul class="rsg-steps">
                        <li class="rsg-step-item">
                            <div class="rsg-step-number">1</div>
                            <div class="rsg-step-text">
                                <strong><?php esc_html_e('Initiate New Slider', 'responsive-slider-gallery'); ?></strong>
                                <p><?php esc_html_e('Navigate to "Responsive Slider" in the main sidebar and select "Add New Slider". Assign a clear, recognizable name as your Title.', 'responsive-slider-gallery'); ?></p>
                            </div>
                        </li>
                        <li class="rsg-step-item">
                            <div class="rsg-step-number">2</div>
                            <div class="rsg-step-text">
                                <strong><?php esc_html_e('Upload & Batch Ingest', 'responsive-slider-gallery'); ?></strong>
                                <p><?php esc_html_e('Click "Add Images". You can dynamically multi-select files directly from your media library. They will stack automatically below.', 'responsive-slider-gallery'); ?></p>
                            </div>
                        </li>
                        <li class="rsg-step-item">
                            <div class="rsg-step-number">3</div>
                            <div class="rsg-step-text">
                                <strong><?php esc_html_e('Configure Behavioral Logic', 'responsive-slider-gallery'); ?></strong>
                                <p><?php esc_html_e('Locate the Settings grid. Set your behavior preferences such as Autoplay speeds, Fit Logic (Cover/Contain), and Navigation aesthetics.', 'responsive-slider-gallery'); ?></p>
                            </div>
                        </li>
                        <li class="rsg-step-item">
                            <div class="rsg-step-number">4</div>
                            <div class="rsg-step-text">
                                <strong><?php esc_html_e('Commit & Deploy', 'responsive-slider-gallery'); ?></strong>
                                <p><?php esc_html_e('Press Publish. Grab the shortcode string from the sidebar dashboard, and drop it into any Gutenberg Block, Elementor container, or Classic Editor text widget.', 'responsive-slider-gallery'); ?></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- SETTINGS DICTIONARY -->
            <div class="rsg-card">
                <div class="rsg-card-header">
                    <span class="dashicons dashicons-admin-settings" style="color: var(--rsg-primary)"></span>
                    <h2><?php esc_html_e('Deep-Dive Settings Glossary', 'responsive-slider-gallery'); ?></h2>
                </div>
                <div class="rsg-card-body" style="padding: 0;">
                    <table class="rsg-table-styled">
                        <thead>
                            <tr>
                                <th width="25%"><?php esc_html_e('Feature Mapping', 'responsive-slider-gallery'); ?></th>
                                <th><?php esc_html_e('Functional Utility', 'responsive-slider-gallery'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><?php esc_html_e('Slider Width', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Accepts fluid percentages (e.g. 100%) for dynamic scaling, or direct pixel lengths (e.g. 800px). Keep at 100% for best responsive results.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Slider Height', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Assigns fixed height constraints. Leaving this field empty activates automatic aspect-ratio sizing based on slide dimensions.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Navigation Style', 'responsive-slider-gallery'); ?></strong></td>
                                <td>
                                    <div style="margin-bottom:4px;"><code class="rsg-badge">Dots</code> <?php esc_html_e('Minimal rounded indicators below the frame.', 'responsive-slider-gallery'); ?></div>
                                    <div><code class="rsg-badge">Thumbs</code> <?php esc_html_e('Interactive ribbon of scrollable small image thumbnails.', 'responsive-slider-gallery'); ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Navigation Width', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Specific to thumbnail ribbons. Defines constraints on the size of individual nav thumbnail elements.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Fullscreen Button', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Toggles the expand icon in the top right corner, allowing site visitors to view imagery in distraction-free browser fullscreen mode.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Fit Slides', 'responsive-slider-gallery'); ?></strong></td>
                                <td>
                                    <div style="margin-bottom:5px;"><code class="rsg-badge">cover</code> <?php esc_html_e('Expands image to completely submerge viewport (crops edge overflow).', 'responsive-slider-gallery'); ?></div>
                                    <div><code class="rsg-badge">contain</code> <?php esc_html_e('Fits entire picture inside frame without cropping (adds bars if needed).', 'responsive-slider-gallery'); ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Transition Duration', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Duration of animation between frames in milliseconds. Low numbers (e.g. 200) are fast, high numbers (e.g. 1000+) create slow sweeping blends.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Slide Caption Text', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Automatically pulls the image titles you set in your dashboard and floats them as persistent dark overlays on top of the visuals.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Autoplay', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Forces the deck to advance forward iteratively without user mouse interaction.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Infinite Loop', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('When reaching the terminal end of the gallery list, the engine will silently loop and present the starting slide seamlessly.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Navigation Arrows', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Shows or hides the left and right physical chevron buttons overlapping the sides of your frame.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Touch Swipe Support', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Permits mobile visitors to trigger slide advances by flicking their fingers left or right across the screen viewport.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php esc_html_e('Loading Spinner', 'responsive-slider-gallery'); ?></strong></td>
                                <td><?php esc_html_e('Defines the animated SVG style displayed instantly while high-resolution heavy images finish pulling down from the server.', 'responsive-slider-gallery'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- SIDEBAR -->
        <div class="rsg-sidebar">
            
            <!-- PREMIUM CTA -->
            <div class="rsg-sidebar-cta">
                <span class="dashicons dashicons-awards" style="font-size: 48px; width: auto; height: auto; margin-bottom: 15px;"></span>
                <h3><?php esc_html_e('Unlock Pro Features', 'responsive-slider-gallery'); ?></h3>
                <p style="opacity: 0.9; font-size: 14px;"><?php esc_html_e('Get premium layouts, lightboxes, lightbox animations, and priority dedicated support queue.', 'responsive-slider-gallery'); ?></p>
                <a href="https://awplife.com/wordpress-plugins/responsive-slider-gallery-wordpress-plugin/" target="_blank" class="rsg-btn-gold">
                    <?php esc_html_e('Upgrade to Pro 🚀', 'responsive-slider-gallery'); ?>
                </a>
            </div>

            <!-- QUICK LINKS -->
            <div class="rsg-card">
                <div class="rsg-card-header">
                    <h2><?php esc_html_e('Helpful Resources', 'responsive-slider-gallery'); ?></h2>
                </div>
                <div class="rsg-card-body">
                    <ul class="rsg-link-list">
                        <li>
                            <a href="https://awplife.com/demo/responsive-slider-gallery-standard/" target="_blank">
                                <span class="dashicons dashicons-visibility"></span>
                                <?php esc_html_e('View Live Demos', 'responsive-slider-gallery'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="https://wordpress.org/support/plugin/responsive-slider-gallery/" target="_blank">
                                <span class="dashicons dashicons-sos"></span>
                                <?php esc_html_e('Community Forums', 'responsive-slider-gallery'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="https://wordpress.org/plugins/responsive-slider-gallery/#reviews" target="_blank">
                                <span class="dashicons dashicons-star-filled" style="color:#f59e0b"></span>
                                <?php esc_html_e('Submit a 5-Star Review', 'responsive-slider-gallery'); ?>
                            </a>
                        </li>
                    </ul>

                    <div class="rsg-tip">
                        <span class="dashicons dashicons-lightbulb"></span>
                        <div class="rsg-tip-content">
                            <p><strong><?php esc_html_e('Drag & Drop Logic:', 'responsive-slider-gallery'); ?></strong> <?php esc_html_e('You can fluidly reorder slides. Click and hold any image thumbnail and drag horizontally before saving.', 'responsive-slider-gallery'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
