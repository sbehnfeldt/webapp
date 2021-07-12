;(function (global, $) {
    'use strict';


    let UsersList = (function(selector) {
        let $list = $(selector);

        $list.on('click', 'li', function() {
            console.log($(this).data('user'));
        });

        function load() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/api/users',
                    type: 'get',

                    dataType: 'json',
                    success: function(json) {
                        resolve(json);
                    },
                    error: (xhr) => {
                        reject(xhr);
                    }
                });

            });
        }

        function populate(users) {
            console.log(users);
            let template = Handlebars.compile( '<li><a href="javascript:void(0)">{{ username }}</a>');

            for ( let i = 0; i < users.length; i++ ) {
                let user = users[i];
                let $li = $(template({
                    'username' : user.Username
                }));
                $li.data( 'user', user );
                $list.append($li);
            }
        }

        return {load, populate};
    })( '#users-list');



    // Document ready handler
    $(function () {
        console.log('Document ready');
        UsersList.load()
            .then((json) => {
                UsersList.populate(json)
            })
            .catch((xhr) => {
                console.log(xhr)
            });
    });
})(this, jQuery);
