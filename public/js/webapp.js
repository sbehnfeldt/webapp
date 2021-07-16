;(function (global, $) {
    'use strict';

    global.Webapp = global.Webapp || {};

    Webapp.Spinner = (function () {

        let loading;
        let $loading;

        function init(selector) {
            loading = 0;
            $loading = $(selector);
        }

        function loadAnother() {
            loading++;
            $loading.show();
        }

        function doneLoading() {
            loading--;
            if (0 === loading) {
                $loading.hide();
            }
        }

        return {init, loadAnother, doneLoading};
    })();


})(this, jQuery);
