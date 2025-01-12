(function($) {
    'use strict';

    // Page loading
    $(window).on('load', function() {
        $('.preloader').delay(450).fadeOut('slow');
    });

    // toggle dark/light
    var toggleLight = function() {
        var n = document.querySelectorAll(".js-toggle-dark-light"),
            l = document.documentElement;

        n.forEach(function (t) {
            t.addEventListener("click", function (e) {
                e.preventDefault();
                var t = l.getAttribute("data-theme");
                null !== t && "dark" === t ? (l.setAttribute("data-theme", "light"), localStorage.setItem("selected-theme", "light")) : (l.setAttribute("data-theme", "dark"), localStorage.setItem("selected-theme", "dark"));
            });
        });
    };

    // Scroll progress
    var scrollProgress = function() {
        var docHeight = $(document).height(),
            windowHeight = $(window).height(),
            scrollPercent;
        $(window).on('scroll', function() {
            scrollPercent = $(window).scrollTop() / (docHeight - windowHeight) * 100;
            $('.scroll-progress').width(scrollPercent + '%');
        });
    };

    // Off canvas sidebar
    var OffCanvas = function() {
        $('#off-canvas-toggle').on('click', function() {
            $('body').toggleClass("canvas-opened");
        });

        $('.dark-mark').on('click', function() {
            $('body').removeClass("canvas-opened");
        });
        $('.off-canvas-close').on('click', function() {
            $('body').removeClass("canvas-opened");
        });
    };

    // Search form
    var openSearchForm = function() {
        $('.js-search-button').on('click', function() {
            $('.search-popup').toggleClass("visible");
        });

        $('#search-close').on('click', function() {
            $('.search-popup').toggleClass("visible");
        });

        $(document).keydown(function(e){
            if(e.keyCode == 27) {
                if ($('.search-popup').hasClass('visible')) {
                    $('.search-popup').removeClass('visible');
                } else {
                    $('.search-popup').addClass('visible');
                }
            }
        });
    };

    var SubMenu = function() {
        // $(".sub-menu").hide();
        $(".menu li.menu-item-has-children").on({
            mouseenter: function() {
                $('.sub-menu:first, .children:first', this).stop(true, true).slideDown('fast');
            },
            mouseleave: function() {
                $('.sub-menu:first, .children:first', this).stop(true, true).slideUp('fast');
            }
        });
    };

    var WidgetSubMenu = function() {
        //$(".sub-menu").hide();
        $('.menu li.menu-item-has-children').on('click', function() {
            var element = $(this);
            if (element.hasClass('open')) {
                element.removeClass('open');
                element.find('li').removeClass('open');
                element.find('ul').slideUp(200);
            } else {
                element.addClass('open');
                element.children('ul').slideDown(200);
                element.siblings('li').children('ul').slideUp(200);
                element.siblings('li').removeClass('open');
                element.siblings('li').find('li').removeClass('open');
                element.siblings('li').find('ul').slideUp(200);
            }
        });
    };

    //Header sticky
    var headerSticky = function() {
        $(window).on('scroll', function() {
            var scroll = $(window).scrollTop();
            if (scroll < 80) {
                $(".site-header").removeClass("small");
            } else {
                $(".site-header").addClass("small");
            }
        });
    };

    //Mega menu
    var megaMenu = function() {
        $('.sub-mega-menu .nav-pills > a').on('mouseover', function(event) {
            $(this).tab('show');
        });
    };

    //Copy to clipboard
    var coptToClipboard = function() {
        $('.js-copy-link').on('click', function(event) {
            var copyText = $(this).data("clipboard-text");
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(copyText).select();
            document.execCommand("copy");
            $temp.remove();

            $(this).find('.tooltip').text('Copied');
            setTimeout(function() {
                $(this).find('.tooltip').text('Copy');
            },500);
        });
    }

    // Back to top
    var scrollToTop = function() {
        $(window).scroll(function() {
            var height = $(window).scrollTop();

            if (height > 400) {
                $('#backto-top').fadeIn('slow');
            } else {
                $('#backto-top').fadeOut('slow');
            }
        });

        $("#backto-top").on('click', function(event) {
            event.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });
    }

    $("body").bind("cut copy paste", function (e) {
        // e.preventDefault();
    });
   
    $("body").on("contextmenu",function(e){
        //return false;
    });

	/*
	* add prettyprint on pre
	*/
	jQuery(".prettyprint").each(function(){
		jQuery(this).html( PR.prettyPrintOne(jQuery(this).html()) );
	});

   
    // $(".social-link").on("click", function(e) {
    //     var url = $(this).data('link');
    //     var target = $(this).data('target');

    //     window.open(url, target);
    // });

    //Load functions
    $(document).ready(function() {
        toggleLight();
        openSearchForm();
        OffCanvas();
        headerSticky();
        megaMenu();
        WidgetSubMenu();
        scrollProgress();
        coptToClipboard();
        scrollToTop();
    });

})(jQuery);



jQuery(document).ready(function() {

    jQuery(".upload-file").on('click', function () {
        // console.log('change');
        jQuery('.file-upload-input').trigger('click');
    });

    jQuery(".file-upload-input").on('change', function () {
        var files = this.files;
        var parent = jQuery('#file-uploader-wrap');
        var filePreview = parent.find('.file-uploader-body');
        var id = jQuery('#file_form').find('input[name="id"]').val();
        var total = files.length;

        console.log('Total:- ' + total);

        parent.find('h2').text('Uploading ' + total + ' items');

        jQuery.each(files, function(index, file) {
            let count = parent.find('h2').attr('data-file-count');
            let newCount = parseInt(count) + parseInt(1);
            parent.find('h2').attr('data-file-count', newCount);

            var fileName = jQuery('<span>').text(file.name);
            // var fileSize = jQuery('<p>').text('Size: ' + (file.size / 1024).toFixed(2) + ' KB');
            // var fileExt = jQuery('<p>').text('Extension: ' + file.name.split('.').pop());
            var progressBar = jQuery('<progress>', { value: 0, max: 100 });
            var fileDetails = jQuery('<div class="file-item">').append(fileName, progressBar);

            filePreview.append(fileDetails);

            // Create FormData object for each file
            var formData = new FormData();
            formData.append('file', file);
            formData.append('id', id);
            formData.append('action', 'add_file');

            // Send file via Ajax with progress
            var xhr = new XMLHttpRequest();
            xhr.open('POST', ajax_options.ajax_url, true);

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    progressBar.val(percentComplete);
                }
            };

            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // fileDetails.append(jQuery('<p>').text('Upload successful!'));
                    } else {
                        // fileDetails.append(jQuery('<p>').text('Upload failed: ' + response.data));
                    }
                    parent.find('h2').text(newCount + ' uploads complete');
                } else {
                    // fileDetails.append(jQuery('<p>').text('An error occurred during the upload.'));
                }
            };

            xhr.send(formData);
        });
    });

    jQuery('#file_form').on('submit', function(e) {
        e.preventDefault();

        var form = jQuery(this);
        var action = form.find('#action').val();
        var id = form.find('#id').val();

        var formData = new FormData(this);

        formData.append('action', 'add_file');
        jQuery.ajax({
            type: 'POST',
            url: ajax_options.ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                var res_arr = res.split("|");
                if (jQuery.trim(res_arr[0]) == "1") {
                    // $('.profile-pic').attr('src', res_arr[1]);
                    // $('.resize').attr('src', res_arr[1]);
                    // $('#img-upload-success').show();

                    jQuery('.avatar-upload .dz-text').hide();
                    jQuery('#imagePreview').css('background-image', 'url('+res_arr[1] +')');
                    jQuery('#imagePreview').hide();
                    jQuery('#imagePreview').fadeIn(650);
                    jQuery('.user-profile-header img').attr('src', res_arr[1]);
                } else if (jQuery.trim(res_arr[0]) == "0") {
                    jQuery('#max-img-size').show();
                } else {
                    jQuery('#error-messages').show();
                }

            }
        });
    });

    /*
     * Change Password
     */
    jQuery('#changePassword').on('submit', function (e) {
        e.isDefaultPrevented();
        var btn = jQuery(this).find(".btn-primary");

        startLoading(btn);
        jQuery.post(ajax_options.ajax_url, {
            action: 'update_user_password', 
            collect_data: jQuery("form#changePassword").serialize(), 
        }).done(function (response) {
            let el = jQuery.parseJSON(response);

            show_alert(true, el);
            endLoading(btn);

            if (el.success) {
                // modal(true);
                window.setTimeout(function () {
                    // window.location.reload(true);
                }, 1000);
            }
        });
        return false;
    });

    /*
     * Profile Update
     */
    jQuery('#profile-update').on('submit', function (e) {
        e.isDefaultPrevented();
        e.preventDefault();
        var btn = jQuery(this).find(".btn-primary");

        startLoading(btn);
        jQuery.post(ajax_options.ajax_url, {
            action: 'user_profile_update', 
            collect_data: jQuery("form#profile-update").serialize(), 
        }).done(function (response) {
            let el = jQuery.parseJSON(response);

            show_alert(true, el);
            endLoading(btn);

            if (el.success) {
                // modal(true);
                window.setTimeout(function () {
                    // window.location.reload(true);
                }, 1000);
            }
        });
        return false;
    });

    /*
    * toggle password type
    */
    jQuery(document).on('click', '.toggle-password', function() {
        jQuery(this).toggleClass("cc-eye-on cc-eye-off");
        var input = jQuery(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
            // input.removeClass('type-password');
            // input.addClass('type-text');
        } else {
            input.attr("type", "password");
            // input.removeClass('type-text');
            // input.addClass('type-password');
        }
    });

    /*--- Registration Form Action ---*/
    jQuery('#register-form').on('submit', function (e) {
        e.preventDefault();
        e.isDefaultPrevented();
        var form = jQuery(this);
        var error;
        var first_name = form.find("#first_name");
        var last_name = form.find("#last_name");
        var user_email = form.find("#user_email");
        var user_password = form.find("#user_password");
        var user_cpassword = form.find("#user_cpassword");
        var is_remember = form.find("#is_remember");
        var security = form.find("#register_user_nonce");
        var btn = form.find(".submit-btn");

        startLoading(btn);
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_options.ajax_url,
            data: {
                action: "register_user", //calls wp_ajax_nopriv_ajaxlogin
                first_name: first_name.val(),
                last_name: last_name.val(),
                user_email: user_email.val(),
                user_password: user_password.val(),
                user_cpassword: user_cpassword.val(),
                is_remember: is_remember.val(),
                register_user_nonce: security.val(),
            },
            success: function (response) {
                // let el = $.parseJSON(response);
                show_alert(true, response);
                endLoading(btn);

                if (response.success) {
                    window.setTimeout(function () {
                        window.location = response.redirect;
                    }, 1500);
                }
            },
            error: function (jqXHR, exception) {
                var msg = "";
                if (jqXHR.status === 0) {
                    msg = "Not connect.\n Verify Network.";
                } else if (jqXHR.status == 404) {
                    msg = "Requested page not found. [404]";
                } else if (jqXHR.status == 500) {
                    msg = "Internal Server Error [500].";
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error.";
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else if (jqXHR.responseText === "-1") {
                    msg = "Please refresh page and try again.";
                } else {
                    msg = "Uncaught Error.\n" + jqXHR.responseText;
                }

                endLoading(btn);
                form.find(".notification").html(msg).removeClass("success").addClass("error").show();
            },
        });

        /*--- stop submitting ---*/
        return false;
    });

    /*--- Login Form Action ---*/
    jQuery("#login-form").on("submit", function (e) {
        e.preventDefault();
        e.isDefaultPrevented();
        var form = jQuery(this);
        var error;
        var email = form.find("#emailAddress");
        var password = form.find("#password");
        var security = form.find("#login_user_nonce");
        var btn = form.find(".submit-btn");

        // console.log(ajax_options.ajax_url);

        form.find(".submit-btn").attr('disabled', true);
        startLoading(btn);
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: ajax_options.ajax_url,
            data: {
                action: "login_user", //calls wp_ajax_nopriv_ajaxlogin
                email: email.val(),
                password: password.val(),
                login_security: security.val(),
            },
            success: function (response) {
                // let el = $.parseJSON(response);
                show_alert(true, response);
                endLoading(btn);

                if (response.success) {
                    window.setTimeout(function () {
                        window.location = response.redirect;
                    }, 500);
                }
            },
            error: function (jqXHR, exception) {
                var msg = "";
                if (jqXHR.status === 0) {
                    msg = "Not connect.\n Verify Network.";
                } else if (jqXHR.status == 404) {
                    msg = "Requested page not found. [404]";
                } else if (jqXHR.status == 500) {
                    msg = "Internal Server Error [500].";
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error.";
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else if (jqXHR.responseText === "-1") {
                    msg = "Please refresh page and try again.";
                } else {
                    msg = "Uncaught Error.\n" + jqXHR.responseText;
                }

                endLoading(btn);
                form.find(".notification").html(msg).removeClass("success").addClass("error").show();
            },
        });
    });

    jQuery(document).on('click', function(e) {
        var target = jQuery(e.target);
        // Check if the click target is not within the footer-actions or action-list
        if (!target.closest('.footer-actions').length && !target.closest('.action-list').length) {
            // Hide the popup
            jQuery('.action-list').addClass('hidden');
        }
    });

    jQuery(document).on('click', '.footer-actions .action', function(e) {
        e.preventDefault();
        var parent = jQuery(this).parent();
        var list = parent.find('.action-list');

        // Close all other popups before opening this one
        jQuery('.action-list').not(list).addClass('hidden');
        
        // Toggle the visibility of this popup
        list.toggleClass('hidden');
    });

    /*
     * On click body do actions
     */
    jQuery(document).on('click', function(e) {
        var target = jQuery(e.target);

        // Check if the click target is not within the footer-actions or action-list
        if (!target.closest('.footer-actions').length && !target.closest('.action-list').length) {
            // Hide the popup
            jQuery('.action-list').addClass('hidden');
        }
        
        // Check if the click target is outside the modal
        if (!target.closest('.open-modal').length && !target.closest('.modal-box').length && !target.is('.modal-box')) {
            // Hide the popup
            closeModal();
        }
    });

    /*
     * On click open modal
     */
    jQuery(document).on('click', '.open-modal', function(e) {
        e.preventDefault();
        var button = jQuery(this);

        var modal = button.data('modal');
        var id = button.data('id');
        var form = button.data('form');

        var form_icon = jQuery(form).find('.form-icon').html();
        if (form_icon) {
            jQuery(modal).find('.modal-icon').html(form_icon);
        }

        var form_title = jQuery(form).find('.form-title').html();
        if (form_title) {
            jQuery(modal).find('.modal-title').text(form_title);
        }

        var btn_title = jQuery(form).find('.button-title').html();
        if (btn_title) {
            jQuery(modal).find('#submit_btn').attr('data-label', btn_title);
            jQuery(modal).find('#submit_btn').text(btn_title);
        }

        if (id) {
            jQuery(modal).find('#submit_btn').removeClass('disabled');
        }

        jQuery(modal).addClass('show');
        jQuery(modal).find('form').html(jQuery(form).html());
        jQuery(modal).find('#id').val(id);

        getData(button);
    });

    /*
     * On click close modal
     */
    jQuery('.close-modal').on('click', function(e) {
        e.preventDefault();
        closeModal();
    });

    function closeModal() {
        jQuery('#modal').find('.modal-icon').html('');
        jQuery('#modal').find('.modal-title').text('');
        jQuery('#modal').find('form').empty();
        jQuery('#modal').removeClass('show');
        jQuery('#modal #submit_btn').addClass('disabled');
    }

    /*
     * On input fiat_amount update coin_ammount
     */
    jQuery('#submit_btn').on('click', function () {
        jQuery('#block_form').submit();
    });

    jQuery(document).on('keyup', '#block_form #bookmark_url, #block_form #title', function() {
        var val = jQuery(this).val();

        if (val=='') {
            jQuery('#modal #submit_btn').addClass('disabled');
        } else {
            jQuery('#modal #submit_btn').removeClass('disabled');
        }
    });

    jQuery(document).on('change', '#block_form #collection', function() {
        var val = jQuery(this).val();

        if (val=='') {
            jQuery('#modal #submit_btn').addClass('disabled');
        } else {
            jQuery('#modal #submit_btn').removeClass('disabled');
        }
    });

    /*
     * On click add folder
     */
    jQuery('#block_form').on('submit', function(e) {
        e.preventDefault();
        var form = jQuery('#block_form');
        var action = form.find('#action').val();
        var id = form.find('#id').val();
        var btn = jQuery('#submit_btn');

        var formData = new FormData(this);

        startLoading(btn);
        jQuery.ajax({
            type: 'POST',
            url: ajax_options.ajax_url, // WordPress AJAX URL
            data: formData,
            dataType: 'json',
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Set content type to false
            success: function(response) {
                let el = response.data;

                if (response.success===true) {
                    if (action=='add_folder') {
                        jQuery('.folder-list').prepend(response.html);
                    }else if (action=='update_collection') {
                        jQuery('.dashboard-header').find('.page-title').text(el.title);
                        jQuery('.dashboard-header').find('.description').text(el.description);
                    } else if (action=='add_bookmark') {
                        jQuery('#bookmark_wrap').prepend(response.html);
                    } else if (action=='update_bookmark') {
                        var block = jQuery('#bookmark_'+id);

                        block.find('.grid-media-block img').attr('href', el.img);
                        block.find('.grid-item-content .title').attr('href', el.title);
                        block.find('.publisher').text(el.site_name);
                    }
                    closeModal();
                }
                showToastAlert(response.msg);
                endLoading(btn);
            },
            error: function (jqXHR, exception) {
                endLoading(btn);
            },
        });
    });

    /*
     * On click delete bookmark collection
     */
    jQuery(document).on('click', '.delete-collection', function(e) {
        e.preventDefault();
        var id = jQuery(this).data('id');

        if (confirm('Are you sure you want to remove this collection?')) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_options.ajax_url,
                data: { 
                    'action': 'delete_collection',
                    'id': id, 
                    // 'security': ajax_options.get_favorites,
                },
                success: function(response) {
                    if (response.success==true) {
                        jQuery('#collection_'+id).remove();
                    } else {

                    }
                    showToastAlert(response.msg);
                },
                error: function (jqXHR, exception) {

                },
            });
        } else {
            return false;
        }
    });

    /*
     * On click delete file
     */
    jQuery(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var type = jQuery(this).data('type');
        var id = jQuery(this).data('id');

        if (confirm('Are you sure you want to remove this item?')) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_options.ajax_url,
                data: { 
                    'action': 'delete_item',
                    'id': id, 
                    'type': type, 
                    // 'security': ajax_options.get_favorites,
                },
                success: function(response) {
                    if (response.success==true) {
                        jQuery('#'+type+'_'+id).remove();
                    } else {

                    }
                    showToastAlert(response.msg);
                },
                error: function (jqXHR, exception) {

                },
            });
        } else {
            return false;
        }
    });

    /*
     * Show toast alert
     */
    function showToastAlert(text) {
        jQuery('.toast').text(text).fadeIn().delay(2000).fadeOut();
    }

    jQuery('.accordion-field-header').on('click', function() {
        var b = jQuery(this);
        var w = jQuery(this).parent().find('.accordion-field-body');
        var l = w.find('.field-block');

        w.height(l.outerHeight(true));

        if(w.hasClass('open')) {
            w.removeClass('open');
            w.height(0);
        } else {
            w.addClass('open');
            w.height(l.outerHeight(true));
        }
    });

    function show_alert(show = false, data) {
        jQuery('.alert').attr('class', 'alert');
        if (show) {
            if (data.success) {
                jQuery('.alert').attr('class', 'alert alert-success');
                jQuery('.alert').find('i').attr('class', 'cc-check-circle lead mr-2 mr-sm-3');
            } else {
                jQuery('.alert').attr('class', 'alert alert-danger');
                jQuery('.alert').find('i').attr('class', 'cc-x-circle lead mr-2 mr-sm-3');
            }

            jQuery('.alert').find('.alert-desc').text(data.msg);
            jQuery('.alert').addClass('show');
            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
        } else {
            jQuery('.alert').attr('class', 'alert');
            jQuery('.alert').find('.alert-desc').text('');
            jQuery('.alert').removeClass('show');
        }
    }

    function startLoading($this) {
        $this.addClass('loading').text('Processing...').attr('disabled', true);
    }

    function endLoading($this) {
        var label = $this.data('label');
        $this.removeClass('loading').text(label).attr('disabled', false);
    }

    function getData(button) {
        var id = button.data('id');
        var form = button.data('form');
        var modal = jQuery('#modal');

        if (form=='#update_bookmark_modal') {
            jQuery.ajax({
                type: 'POST',
                url: ajax_options.ajax_url, // WordPress AJAX URL
                data: {
                    'action': 'get_bookmark',
                    'id': id,
                },
                dataType: 'json',
                success: function(response) {
                    modal.find('#title').val(response.title);
                    modal.find('#site_name').val(response.site_name);
                    modal.find('#image').val(response.image);
                    modal.find('#description').val(response.description);
                    modal.find('#note').val(response.note);
                },
                error: function (jqXHR, exception) {

                },
            });
        }
    }

    jQuery('.dropdown-button').on('click', function() {
        let height = jQuery(this).outerHeight();
        if (jQuery(this).next('.dropdown-menu').hasClass('hidden')) {
            jQuery(this).next('.dropdown-menu').css('top', height);
            jQuery(this).next('.dropdown-menu').removeClass('hidden');
        } else {
            jQuery(this).next('.dropdown-menu').css('top', '');
            jQuery(this).next('.dropdown-menu').addClass('hidden');
        }
    });
});