jQuery(function(jQuery) {
    
    var file_frame,
    awlslider = {
        ul: '',
        init: function() {
            this.ul = jQuery('.sbox');
            this.ul.sortable({
                placeholder: 'ui-sortable-placeholder',
                forcePlaceholderSize: true,
                revert: false, // Disable revert to prevent the "jump to right" effect on drop
                opacity: 0.8,
                tolerance: 'intersect', // Better for grid-based sorting
                cursor: 'grabbing',
                start: function(event, ui) {
                    // Match placeholder size exactly to the dragging item
                    ui.placeholder.height(ui.item.outerHeight());
                    ui.placeholder.width(ui.item.outerWidth());
                },
                change: function(event, ui) {
                    // Ensure the placeholder maintains height in CSS Grid
                    ui.placeholder.height(ui.item.outerHeight());
                }
            });			
			
            /**
			 * Add Slide Callback Function
			 */
            jQuery('#add-new-slider').on('click', function(event) {
				var rsg_add_images_nonce = jQuery("#rsg_add_images_nonce").val();
                event.preventDefault();
                if (file_frame) {
                    file_frame.open();
                    return;
                }
                file_frame = wp.media.frames.file_frame = wp.media({
                    multiple: true
                });

                file_frame.on('select', function() {
                    var selection = file_frame.state().get('selection');
                    var ids = [];
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if (attachment.id) {
                            ids.push(attachment.id);
                        }
                    });

                    if (ids.length > 0) {
                        awlslider.batch_thumbnails(ids, rsg_add_images_nonce);
                    }
                });
                file_frame.open();
            });
			
			/**
			 * Delete Slide Callback Function
			 */
            this.ul.on('click', '#remove-slide', function() {
                if (confirm('Do you want to delete this slide?')) {
                    jQuery(this).closest('.slide').fadeOut(400, function() {
                        jQuery(this).remove();
                    });
                }
                return false;
            });
			
			/**
			 * Delete All Slides Callback Function
			 */
			jQuery('#remove-all-slides').on('click', function() {
                if (confirm('Do you want to delete all slides?')) {
                    awlslider.ul.empty();
                }
                return false;
            });
           
        },
        batch_thumbnails: function(ids, rsg_add_images_nonce) {
            var data = {
                action: 'batch_slides',
                slideIds: ids,
				rsg_add_images_nonce: rsg_add_images_nonce,
            };
            jQuery.post(ajaxurl, data, function(response) {
                awlslider.ul.append(response);
            });
        }
    };
    awlslider.init();
});