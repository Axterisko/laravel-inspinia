/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.9.3
 *
 */


$(document).ready(function () {

    // Fast fix bor position issue with Propper.js
    // Will be fixed in Bootstrap 4.1 - https://github.com/twbs/bootstrap/pull/24092
    Popper.Defaults.modifiers.computeStyle.gpuAcceleration = false;


    // Add body-small class if window less than 768px
    if (window.innerWidth < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetisMenu
    var sideMenu = $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').on('click', function (e) {
        e.preventDefault();
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.children('.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').on('click', function (e) {
        e.preventDefault();
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').on('click', function (e) {
        e.preventDefault();
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').on('click', function (e) {
        e.preventDefault();
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Run menu of canvas
    $('body.canvas-menu .sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').on('click', function (e) {
        e.preventDefault();
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').on('click', function (e) {
        e.preventDefault();
        $(this).children().toggleClass('fa-comments').toggleClass('fa-times');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').on('click', function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // Append config box / Only for demo purpose
    // Uncomment on server mode to enable XHR calls
    //$.get("skin-config.html", function (data) {
    //    if (!$('body').hasClass('no-skin-config'))
    //        $('body').append(data);
    //});

    // Minimalize menu
    $('.navbar-minimalize').on('click', function (event) {
        event.preventDefault();
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Tooltips demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });


    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
});

// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if (window.innerWidth < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

// Fixed Sidebar
$(window).bind("load", function () {
    if ($("body").hasClass('fixed-sidebar')) {
        $('.sidebar-collapse').slimScroll({
            height: '100%',
            railOpacity: 0.9
        });
    }
});


// check if browser support HTML5 local storage
function localStorageSupport() {
    return (('localStorage' in window) && window['localStorage'] !== null)
}

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function () {
    if (localStorageSupport()) {

        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        var body = $('body');

        if (fixedsidebar == 'on') {
            body.addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }

        if (collapse == 'on') {
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }

            }
        }

        if (fixednavbar == 'on') {
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            body.addClass('fixed-nav');
        }

        if (boxedlayout == 'on') {
            body.addClass('boxed-layout');
        }

        if (fixedfooter == 'on') {
            $(".footer").addClass('fixed');
        }
    }
});

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //wait for animation to finish before removing classes
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8
        })
        .disableSelection();
}

(function ($, DataTable) {

    // Datatable global configuration

    // Datatable global configuration
    $.extend(true, DataTable.defaults, {
        language: {
            "sEmptyTable": "Nessun dato presente nella tabella",
            "sInfo": "Vista da _START_ a _END_ di _TOTAL_ elementi",
            "sInfoEmpty": "Vista da 0 a 0 di 0 elementi",
            "sInfoFiltered": "(filtrati da _MAX_ elementi totali)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Visualizza _MENU_ elementi",
            "sLoadingRecords": "Caricamento...",
            "sProcessing": "Elaborazione...",
            "sSearch": "Cerca:",
            "sZeroRecords": "La ricerca non ha portato alcun risultato.",
            "oPaginate": {
                "sFirst": "Inizio",
                "sPrevious": "Precedente",
                "sNext": "Successivo",
                "sLast": "Fine"
            },
            "oAria": {
                "sSortAscending": ": attiva per ordinare la colonna in ordine crescente",
                "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
            }
        }
    });

    $.extend(DataTable.ext.buttons.print, {
        customize: function (win) {
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');

            $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
        }
    });

})(jQuery, jQuery.fn.dataTable);


function loadSheet(url, options) {

    var $sheet = openSheet(options.size ? options.size : 0.75);
    // Optionally the request above could also be done as
    return axios.get(url)
        .then(function (response) {
            $sheet.html(response.data);
            var $form = $sheet.find('form');
            if ($form.length) {
                var $actions = $sheet.find('.axt-sheet-header__actions');
                if ($actions.length) {
                    $actions.find('[type="submit"]').click(function () {
                        $form.submit();
                    });
                }
                $form.find('[type=reset]').on('click', function (e) {
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    e.preventDefault();
                    $form.closest('.axt-sheet').trigger('close');
                    $form.trigger('cancel');
                    return false;
                });
                $form.submit(function (e) {
                    $form.find('.bs-callout-errors').addClass('hidden').find('ul>li').remove();
                    $form.find('.form-group.has-error').removeClass('has-error').find('.help-block').remove();
                    axios.post($form.attr('action'), $form.serialize())
                        .then(function (res) {
                            $form.trigger('submitDone', res);
                        }).catch(function (err) {
                        console.log(err);
                        if (err.response && err.response.data.errors) {
                            var $errContainer = $form.find('.bs-callout-errors');
                            $.each(err.response.data.errors, function (field, errors) {
                                $errContainer.find('ul').append($('<li>').text(errors));
                                $form.find('[name="' + field + '"]').parents('.form-group').addClass('has-error').append($('<span>').addClass('help-block').html('<strong>' + errors[0] + '</strong>'));
                            });
                            $errContainer.removeClass('hidden');
                        }
                        $form.trigger('submitFail', err);
                    });
                    return false;
                });
            }

            $(document).trigger('sheet:loaded',[$sheet]);

        });
}

function resizeSheet() {
    var $sheetHolder = $('.axt-sheet-holder');
    var width = $(window).width();
    $sheetHolder.find('.axt-sheet.open').each(function () {
        var size = $(this).data('size');
        size = width < 500 ? 1 : size;
        if (!$(this).hasClass('parted')) {
            $(this).css({
                'transform': 'translate(' + (width * (1 - size)) + 'px, 0px)',
            });
        }
        $(this).css({
            'max-width': width * size + 'px'
        });
    });
}

function openSheet(options) {
    var size = options.size ? options.size : 0.75
    $('body').addClass('axt-disable-scroll');
    var width = $(window).width();
    var $sheetHolder = $('.axt-sheet-holder');
    $sheetHolder.find('.axt-sheet').css('transform', 'translate(0px, 0px)').addClass('parted');
    $sheetHolder.append($('<div>').addClass('axt-sheet-overlay'))
    $sheetHolder.append($('<div>').addClass('axt-sheet').css('transform', 'translate(' + width + 'px, 0px)'));

    size = width < 500 ? 1 : size;
    var $sheet = $sheetHolder.find('.axt-sheet').eq(-2).data('size', size).css({
        'transform': 'translate(' + (width * (1 - size)) + 'px, 0px)',
        'max-width': width * size + 'px'
    }).addClass('open').removeClass('parted').html('<div class="sk-spinner sk-spinner-wandering-cubes"><div class="sk-cube1"></div><div class="sk-cube2"></div></div>');
    $sheet.on('close', function () {
        return closeSheet($(this));
    });
    $sheet.on('click', '.axt-sheet-header__close', function () {
        return $sheet.trigger('close');
    });

    $sheet.prev().on('click', function () {
        return $sheet.trigger('close');
    });

    if (options.target) {
        $target = $(options.target).clone();
        $sheet.html($target.html());
    }

    resizeSheet();


    return $sheet;
}

function closeSheet($sheet) {
    $('body').removeClass('axt-disable-scroll');
    var width = $(window).width();
    $sheet.nextAll().remove();
    $sheet.empty().css('transform', 'translate(' + width + 'px, 0px)').removeClass('open');

    var $sheetHolder = $('.axt-sheet-holder');
    var $last_sheet = $sheetHolder.find('.axt-sheet').eq(-2);
    var size = $last_sheet.data('size');
    $last_sheet.data('size', size).css({
        'transform': 'translate(' + width * (1 - size) + 'px, 0px)',
        'max-width': width * size + 'px'
    }).addClass('open').removeClass('parted')

    if ($('.axt-sheet.open').length) {
        $('body').addClass('axt-disable-scroll');
    }
}

//
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table) {
    var $table = table.table().node();
    var $chkbox_all = $('tbody input[type="checkbox"]', $table);
    var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
    var chkbox_select_all = $('thead input[type="checkbox"]', $table).get(0);
    if ($chkbox_all.length == 0) return false;
    // If none of the checkboxes are checked
    if ($chkbox_checked.length === 0) {
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = false;
        }
        chkbox_select_all.checked = false;
        // If all of the checkboxes are checked
    } else if ($chkbox_checked.length === $chkbox_all.length) {
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = false;
        }
        chkbox_select_all.checked = true;
        // If some of the checkboxes are checked
    } else {
        if ('indeterminate' in chkbox_select_all) {
            chkbox_select_all.indeterminate = true;
        }
        chkbox_select_all.checked = true;
    }
}

var datatables_rows_selected = [];
jQuery(function ($) {
    $(document).on('click', '.dataTable tbody input[type="checkbox"]', function (e) {
        var table = new $.fn.dataTable.Api($(this).closest('table'));
        var $table = $(table.table().node());
        var tableId = $table.attr('id');
        if (!datatables_rows_selected[tableId]) datatables_rows_selected[tableId] = [];

        var $row = $(this).closest('tr');

        // Get row data
        var data = table.row($row).data();

        // Get row ID
        var rowId = data.id;

        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray(rowId, datatables_rows_selected[tableId]);

        // If checkbox is checked and row ID is not in list of selected row IDs
        if (this.checked && index === -1) {
            datatables_rows_selected[tableId].push(rowId);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1) {
            datatables_rows_selected[tableId].splice(index, 1);
        }

        if (this.checked) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }

        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);

        //console.log(datatables_rows_selected[tableId]);

        $row.trigger('load:selected', [datatables_rows_selected[tableId]]);
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    // Handle click on table cells with checkboxes
    $(document).on('click', '.dataTable tbody td, .dataTable thead th:last-child', function (e) {
        if ($(this).parent().find('input[type="checkbox"]').length)
            $(this).parent().find('input[type="checkbox"]').trigger('click');
    });
    /*
        $(document).on('draw.dt', function (e, settings) {
            console.log(settings);
        });
    */
    $(document).on('processing.dt', function (e, settings, processing) {
        var api = new $.fn.dataTable.Api(settings);
        if (processing)
            $(api.table().node()).closest('.ibox-content').addClass('sk-loading');
        else
            $(api.table().node()).closest('.ibox-content').removeClass('sk-loading');
    });
    $(document).on('draw.dt', function (e, settings) {
        var table = new $.fn.dataTable.Api(settings);
        var $table = $(table.table().node());
        var tableId = $table.attr('id');
        if (!datatables_rows_selected[tableId]) datatables_rows_selected[tableId] = [];
        $('tbody tr', $table).each(function (index, value) {
            var $row = $(this);
            // Get row data
            var data = table.row($row).data();
            if (data) {
                // Get row ID
                var rowId = data.id;

                if ($.inArray(rowId, datatables_rows_selected[tableId]) !== -1) {
                    $row.find('input[type="checkbox"]').prop('checked', true);
                    $row.addClass('selected');
                }
            }
        });
        $table.trigger('load:selected', [datatables_rows_selected[tableId]]);
        updateDataTableSelectAllCtrl(table);
    });

    // Handle click on "Select all" control
    $(document).on('click', '.dataTable thead input[type="checkbox"]', function (e) {
        if (this.checked) {
            $(this).closest('table').find('tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $(this).closest('table').find('tbody input[type="checkbox"]:checked').trigger('click');
        }

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });
});
$(function () {
    $(window).resize(function () {
        resizeSheet();
    });
    $(document).on('click', '[data-toggle=sheet]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var href = $(this).attr('href');
        var target = $(this).data('target');
        var options = {}
        if ($(this).data('sheet-size'))
            $.extend(options, {
                size: $(this).data('sheet-size') / 100
            })
        if (href) loadSheet(href, options);
        else {
            if ($(target).length) options.target = target;
            openSheet(options);
        }
    });

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            var $sheet = $('.axt-sheet-holder').find('.axt-sheet').eq(-2);
            if ($sheet.length) closeSheet($sheet);
        }
    });

});