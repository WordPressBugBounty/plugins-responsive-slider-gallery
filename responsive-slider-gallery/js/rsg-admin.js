jQuery(document).ready(function ($) {
    // Copy to clipboard function using modern API with fallback
    function copyToClipboard(text, $msgElement, $inputElement) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() {
                showCopyMessage($msgElement, $inputElement);
            }, function() {
                legacyCopyToClipboard(text, $msgElement, $inputElement);
            });
        } else {
            legacyCopyToClipboard(text, $msgElement, $inputElement);
        }
    }

    function legacyCopyToClipboard(text, $msgElement, $inputElement) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        try {
            document.execCommand("copy");
            showCopyMessage($msgElement, $inputElement);
        } catch (err) {
            console.error('Unable to copy', err);
        }
        $temp.remove();
    }

    function showCopyMessage($msgElement, $inputElement) {
        if ($inputElement.length) {
            $inputElement.select();
        }
        if ($msgElement.length) {
            $msgElement.fadeIn(400).delay(2000).fadeOut(400);
        }
    }

    // List table copy button delegation
    $(document).on('click', '.rsg-list-copy-btn', function (e) {
        e.preventDefault();
        var postId = $(this).data('post-id');
        var $input = $('#responsive-slider-shortcode-' + postId);
        var $msg = $('#copy-msg-' + postId);
        copyToClipboard($input.val(), $msg, $input);
    });

    // Metabox copy button
    $(document).on('click', '.rsg-copy-metabox', function (e) {
        e.preventDefault();
        var $input = $('#RSGcopyshortcode');
        var $msg = $('#rsg-copy-code');
        copyToClipboard($input.val(), $msg, $input);
    });

    // Tab Switcher Logic
    $(document).on('click', '.rsg-tab-btn', function (e) {
        e.preventDefault();
        
        var tabId = $(this).data('tab');
        
        // Update Buttons
        $('.rsg-tab-btn').removeClass('active');
        $(this).addClass('active');
        
        // Update Content Panes
        $('.rsg-tab-pane').removeClass('active').hide();
        $('#' + tabId).addClass('active').fadeIn(300);
        
        // Persist Choice
        localStorage.setItem('rsg_active_tab', tabId);
    });

    // Tab persistence logic
    var activeTab = localStorage.getItem('rsg_active_tab');
    if (activeTab && $('.rsg-tab-btn[data-tab="' + activeTab + '"]').length) {
        $('.rsg-tab-btn[data-tab="' + activeTab + '"]').trigger('click');
    }

    // Scroll to Top
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 100) {
            $('#rsg-return-to-top').addClass('visible');
        } else {
            $('#rsg-return-to-top').removeClass('visible');
        }
    });

    $('#rsg-return-to-top').on('click', function (e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: 0
        }, 500);
    });

    // Navigation Style Dependency (Show/Hide Dots settings)
    function toggleDotsSettings() {
        var nav_style = $('input[name="nav-style"]:checked').val();
        if (nav_style === "dots") {
            $('.dots_hs').show();
        } else {
            $('.dots_hs').hide();
        }
    }

    // Initialize and bind change event
    toggleDotsSettings();
    $(document).on('change', 'input[name="nav-style"]', function () {
        toggleDotsSettings();
    });
});
