window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    global.$ = global.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
}

try {
    // iCheck
    require('icheck');

    //Metis Menu
    require('metismenu');

    // jQuery SlimScroll
    require('jquery-slimscroll');

    // bootstrap-datepicker
    require('bootstrap-datepicker');

    // clockpicker
    require('clockpicker/dist/bootstrap-clockpicker');

    // select2
    require('select2');

    //Datatables
    require('datatables.net-bs4');
    require('datatables.net-buttons-bs4');


    // Inspinia
    require('./inspinia/inspinia');

    //moment
    window.moment = require('moment');

    // Pace JS
    window.pace = require('pace-js');
    pace.start();

    // toastr
    window.toastr = require('toastr');

    window.Noty = require('noty');

} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}



if (!window.console) {
    window.console = {
        log: function (str) {
            alert(str);
        }
    };
}

$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
    $('.js-datepicker').datepicker({
        todayHighlight: true
    });
    $('.js-clockpicker').clockpicker({
        autoclose: true
    });
    $('.js-select2').select2({
        allowClear: true,
        dropdownAutoWidth: true,
        theme: 'bootstrap4'
    });
});
