;(function (global, $) {
    'use strict';

    // Document ready handler
    $(function () {
        console.log('Document ready');
        $.ajax({
            url: '/api/users',
            type: 'get',

            dataType: 'json',
            success: function(json) {
                console.log(json);
                let $list = $('#users-list');
                for ( let i = 0; i < json.length; i++ ) {
                    let user = json[i];
                    let $li = $('<li>');
                    let $a = $('<a>').attr('href', 'javascript:void(0)').text(user.Username);
                    $li.append($a);
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
