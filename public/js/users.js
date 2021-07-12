;(function (global, $) {
    'use strict';

    // Document ready handler
    $(function () {
        console.log('Document ready');
        let $list = $('#users-list');
        $list.on('click', 'li', function() {
            console.log($(this).data('user'));
        });

        $.ajax({
            url: '/api/users',
            type: 'get',

            dataType: 'json',
            success: function(json) {
                console.log(json);
                let template = Handlebars.compile( '<li><a href="javascript:void(0)">{{ username }}</a>');

                for ( let i = 0; i < json.length; i++ ) {
                    let user = json[i];
                    let $li = $(template({
                        'username' : user.Username
                    }));
                    $li.data( 'user', user );
                    $list.append($li);
                }
            },
            error: (xhr) => {
                console.log(xhr);
                alert("Error");
            }
        });
    });
})(this, jQuery);
