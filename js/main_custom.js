'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
    var validation_lib = {
        isEmpty: function isEmpty(str) {
            str = $.trim(str);

            if (typeof str == 'undefined' || str.length == 0) {
                return true;
            } else {
                return false;
            }
        }
    };

    /**
     * Reading image from input and inserting it in image tag
     * @param input
     * @param img
     */
    function readAndShowImage(input, img) {
        input = $(input)[0];

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(img).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.readAndShowImage = readAndShowImage;

    /**
     * Confirm action modal
     * @param {required} title
     * @param {required} body
     * @param {required} url
     * @param {optional} confirmButtonText
     * @param {optional} cancelButtonText
     * @param {optional} confirmButtonClass
     * @param {optional} cancelButtonClass
     */
    function confirmActionModal(title, body, url) {
        var confirmButtonText = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'Yes';
        var cancelButtonText = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : 'No';
        var confirmButtonClass = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : 'btn-danger';
        var cancelButtonClass = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : 'btn-default';

        $("#confirmActionModalLabel").text(title);
        $("#confirmActionModalBody").html(body);
        $("#confirmActionModalCancel").addClass(cancelButtonClass).html(cancelButtonText);
        $("#confirmActionModalConfirm").attr('href', url).addClass(confirmButtonClass).html(confirmButtonText);

        $("#confirmActionModal").modal({ show: true });
    }

    /*
     * Document ready state
     */
    $(function () {
        // Delete confirm model
        $('.delete-confirm-model').click(function (e) {
            e.preventDefault();

            var deleteConfirmModal = "#deleteConfirmModal",
                deleteConfirmModalUrl = "#deleteConfirmModalUrl",
                deleteUrl = $(this).attr('href');

            // update link in model
            $(deleteConfirmModalUrl).attr('href', deleteUrl);

            // showing model
            $(deleteConfirmModal).modal({ show: true });
        });

        $('.confirm-action-model, .confirm_action_model').click(function (e) {
            e.preventDefault();

            var clickedEle = $(this),
                title = clickedEle.attr('title') || clickedEle.data('original-title') || clickedEle.data('title') || "Define title in 'title' attribute or 'data-title'",
                body = clickedEle.data('body') || "Define body in 'data-body' attribute",
                url = clickedEle.attr('href') || clickedEle.data('url') || "Define url in 'href' or 'data-url' attribute";

            confirmActionModal(title, body, url, 'Yes', 'No', 'btn-danger', 'btn-primary');
        });
    });

    function readMeta(name) {
        return $('meta[name=\'' + name + '\']').attr('content');
    }

    $.ajaxSetup({
        beforeSend: function beforeSend(xhr) {
            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader('X-CSRF-TOKEN', readMeta('csrf-token'));

            if (readMeta('api_token')) {
                xhr.setRequestHeader("Authorization", 'Bearer ' + readMeta('api_token'));
            }
        }
    });

    var App = function () {
        function App() {
            _classCallCheck(this, App);

            this.base_url = readMeta('base_url');

            //this.loadClass( $( '.branch' ).val() );
            //this.onBranchChange();
            //this.loadSection();
            //this.onClassChange( $( '.school_class' ).val() );

            this.fatherCnicEvents();
            this.showImgPreview();
            this.selectAllCheckbox();
            this.formCheckboxAndBtnRedirects();
            this.showHideOnClick();

            this.loadImagesOnPageLoad();
            this.loadImagesOnClick();

            this.confirmFormResubmission();
        }

        _createClass(App, [{
            key: 'fatherCnicEvents',
            value: function fatherCnicEvents() {
                var self = this;

                //self.loadFatherInformation();

                $('.father_cnic').change(function () {
                    self.loadFatherInformation();
                });
            }
        }, {
            key: 'loadFatherInformation',
            value: function loadFatherInformation() {
                var cnic = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '.father_cnic';
                var name = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '[name="father_name"]';
                var qualification = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '[name=\'father_qualification\']';
                var mobile = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : '[name=\'father_mobile\']';
                var sms_cell = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : '[name=\'father_sms_cell\']';
                var ptcl = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : '[name=\'father_ptcl\']';
                var email = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : '[name=\'father_email\']';
                var profession = arguments.length > 7 && arguments[7] !== undefined ? arguments[7] : '[name=\'father_profession\']';
                var job_address = arguments.length > 8 && arguments[8] !== undefined ? arguments[8] : '[name=\'father_job_address\']';

                var self = this,
                    cnic_val = $(cnic).val();

                if (cnic_val) {
                    $.get(this.base_url + '/api/father_details', { cnic: cnic_val }).done(function (data) {
                        $(name).val(data.name);
                        $(qualification).val(data.qualification);
                        $(mobile).val(data.mobile);
                        $(sms_cell).val(data.sms_cell);
                        $(ptcl).val(data.ptcl);
                        $(email).val(data.email);
                        $(profession).val(data.profession);
                        $(job_address).val(data.job_address).focus();
                    });
                }
            }
        }, {
            key: 'showImgPreview',
            value: function showImgPreview() {
                var self = this;

                $('.show-image-preview').change(function () {
                    self.readURL(this);
                });
            }
        }, {
            key: 'readURL',
            value: function readURL(input) {
                var preview_selector = $(input).attr('data-target');

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(preview_selector).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        }, {
            key: 'selectAllCheckbox',
            value: function selectAllCheckbox() {
                $(".select_all_checkbox_js").on('click', function (e) {
                    e.stopPropagation();

                    var isSelected = $(this).prop('checked'),
                        targetSelector = $(this).attr('data-target-selector'),
                        targetsCheckboxes = $(targetSelector);

                    targetsCheckboxes.each(function (i, d) {
                        $(d).prop('checked', isSelected);
                    });
                });
            }
        }, {
            key: 'formCheckboxAndBtnRedirects',
            value: function formCheckboxAndBtnRedirects() {
                var getValuesOfCheckbox = function getValuesOfCheckbox(selector) {
                    var values = [];
                    $(selector).each(function (i, d) {
                        d = $(d);
                        if (d.prop('checked') === true) {
                            values.push($(d).val());
                        }
                    });
                    return values;
                };

                $(".form_checkbox_value_btn").click(function () {
                    var t = $(this),
                        checkbox_selector = t.data('checkbox-selector'),
                        url = t.data('url'),
                        param_name = t.data('param-name'),
                        entity = t.data('entity'),
                        values = getValuesOfCheckbox(checkbox_selector);

                    if (values.length == 0) {
                        alert('Kindly make selection of ' + entity + ' first!');
                    } else {
                        window.location = url + '?' + param_name + '=' + encodeURIComponent(values);
                    }
                });
            }
        }, {
            key: 'showHideOnClick',
            value: function showHideOnClick() {
                $(".show_hide_on_click").click(function () {
                    var t = $(this),
                        target = $(t.data('target')),
                        hideText = t.data('hide-text'),
                        showText = t.data('show-text'),
                        textSelector = $(t.data('text-selector'));

                    // if target is hidden
                    if (target.css('display') == 'none') {
                        target.slideDown();
                        textSelector.html(hideText);
                    } else {
                        target.slideUp();
                        textSelector.html(showText);
                    }
                });
            }
        }, {
            key: 'loadImagesOnPageLoad',
            value: function loadImagesOnPageLoad() {
                var images = $('.load_image_on_page_load');

                if (images.length > 0) {
                    images.each(function (i, img) {
                        var image = $(img),
                            imageUrl = image.data('img-url');

                        image.attr('src', imageUrl);
                    });
                }
            }
        }, {
            key: 'loadImagesOnClick',
            value: function loadImagesOnClick() {
                var loadAll = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

                var selector = '.load_images_on_click';
                var images = void 0;

                $(selector).on('click', function () {
                    if (loadAll === true) {
                        images = $(selector);
                    } else {
                        images = $(this);
                    }

                    images.each(function (i, img) {
                        var image = $(img),
                            imageUrl = image.data('img-url'),
                            currentImageSrcUrl = image.attr('src');

                        if (imageUrl != currentImageSrcUrl) {
                            image.attr('src', imageUrl);

                            if (image.hasClass('cursor_pointer')) {
                                image.removeClass('cursor_pointer');
                            }
                        }
                    });
                });
            }
        }, {
            key: 'confirmFormResubmission',
            value: function confirmFormResubmission() {
                var confirm_resubmission = $("form.confirm_resubmission"),
                    confirm_within_seconds = 60;

                var storage_exists = function storage_exists() {
                    if (typeof Storage === 'undefined') {
                        throw "Storage not available!";
                    } else {
                        return true;
                    }
                };

                var get_time = function get_time() {
                    var t = new Date();
                    return Math.round(t.getTime() / 1000);
                };

                var add_submit_record = function add_submit_record(url) {
                    if (storage_exists() === true) {
                        sessionStorage.setItem(url, get_time());
                    }
                };

                var allow_submit = function allow_submit(url) {
                    if (storage_exists() === true) {
                        var rturl = sessionStorage.getItem(url),
                            now = get_time();

                        rturl = isNaN(parseInt(rturl)) ? 0 : parseInt(rturl);

                        // if there is not record for this url
                        if (rturl === 0) {
                            return true;
                        } else {
                            // if there is record of the url
                            // if difference is more than allowed. Means threshold passed, allow form submit.
                            if (now - rturl > confirm_within_seconds) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                };

                var get_time_difference = function get_time_difference(url) {
                    if (storage_exists() === true) {
                        var rturl = sessionStorage.getItem(url),
                            now = get_time();

                        rturl = isNaN(parseInt(rturl)) ? 0 : parseInt(rturl);

                        return now - rturl;
                    } else {
                        return 0;
                    }
                };

                confirm_resubmission.on('submit', function (e) {
                    var t = $(this),
                        action_url = t.attr('action'),
                        time_difference = get_time_difference(action_url);

                    if (allow_submit(action_url) === true) {
                        add_submit_record(action_url);
                    } else {
                        e.preventDefault();
                        alert('You\'ve submitted this form ' + time_difference + ' second(s) ago. This submission has been ignored.');
                    }
                });
            }
        }]);

        return App;
    }();

    $(function () {
        var _app = new App();
    });
})(jQuery);
//# sourceMappingURL=main_custom.js.map