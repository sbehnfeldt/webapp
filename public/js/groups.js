;(function (global, $) {
    'use strict';

    function fetchGroups() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/api/groups',
                type: 'get',

                dataType: 'json',
                success: (json) => {
                    resolve(json);
                },
                error: (xhr) => {
                    reject(xhr);
                }
            });
        });
    }


    let GroupsList = (function (selector) {
        let $list = $(selector);

        $list.on('click', 'li', function () {
            let group = $(this).data('group');
            console.log(group);
        });

        function clear() {
            $list.empty();
            return this;
        }

        function populate(groups) {
            let template = Handlebars.compile('<li><a href="javascript:void(0)">{{ groupname }}</a>');
            for (let i = 0; i < groups.length; i++) {
                let g = groups[i];
                let $li = $(template({
                    'groupname': g.Groupname
                }));
                $li.data('group', g);
                $list.append($li);
            }
        }

        return {clear, populate}
    })('#groups-list');


    // Document ready handler
    $(function () {
        console.log('Document ready');
        Webapp.Spinner.init('#loading');
        Webapp.Spinner.loadAnother();
        fetchGroups()
            .then((json) => {
                console.log(json);
                GroupsList
                    .clear()
                    .populate(json);
                Webapp.Spinner.doneLoading();
            })
            .catch((xhr) => {
                console.log(xhr);
                Webapp.Spinner.doneLoading();
            });
    });
})(this, jQuery);
