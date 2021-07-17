;(function (global, $) {
    'use strict';


    let NewUserButton = (function (selector) {
        let $button = $(selector);

        $button.on('click', function () {
            UserForm.enable(true);
            SaveUserButton.enable(true);
            enable(false);
        });

        function enable(b = true) {
            $button.attr('disabled', !b);
        }

        return {enable};
    })('#new-user-button');


    let UsersList = (function (selector) {
        let $list = $(selector);

        $list.on('click', 'li', function () {
            console.log($(this).data('user'));
            UserForm.populate($(this).data('user'));
        });

        function load() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/api/users',
                    type: 'get',

                    dataType: 'json',
                    success: function (json) {
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
            let template = Handlebars.compile('<li><a href="javascript:void(0)">{{ username }}</a>');

            for (let i = 0; i < users.length; i++) {
                let user = users[i];
                let $li = $(template({
                    'username': user.Username
                }));
                $li.data('user', user);
                $list.append($li);
            }
        }

        return {load, populate};
    })('#users-list');


    let UserForm = (function (selector) {
        let $form = $(selector);
        let $textBoxes = $form.find('input[type=text], input[type=email]');
        let $checkBoxes = $form.find('input[type=checkbox]');

        function enable(b = true) {
            $textBoxes.attr('disabled', !b);
            $checkBoxes.attr('disabled', !b);
        }

        function populate(user) {
            $form.find('input[name=Username]').val(user.Username);
            $form.find('input[name=Email]').val(user.Email);
        }

        function getUser() {
            return {
                'Username' : $form.find('input[name=Username]').val(),
                'Email' : $form.find('input[name=Email').val()
            };
        }


        return {enable, populate, getUser};

    })('#users-form');


    let SaveUserButton = (function (selector) {
        let $button = $(selector);

        $button.on('click', function () {
            enable(false);
            let user = UserForm.getUser();
            Webapp.Spinner.loadAnother();
            save(user)
                .then((user) => {
                    console.log(user);
                    UserForm.enable(false);
                    NewUserButton.enable(true);
                    Webapp.Spinner.doneLoading();
                })
                .catch((xhr) => {
                    console.log(xhr);
                    UserForm.enable(false);
                    NewUserButton.enable(true);
                    Webapp.Spinner.doneLoading();
                });
        });

        function enable(b = true) {
            $button.attr('disabled', !b);
        }


        function save(user) {
            return new Promise((resolve, reject) => {

                $.ajax({
                    url: '/api/users',
                    type: 'post',
                    data: user,

                    dataType: 'json',
                    success: function(user) {
                        resolve(user);
                    },
                    error: function(xhr) {
                        reject(xhr);
                    }
                });
            });
        }

        return {enable};
    })("#save-user-button");


    // Document ready handler
    $(function () {
        console.log('Document ready');
        Webapp.Spinner.init('#loading');
        Webapp.Spinner.loadAnother()
        UsersList.load()
            .then((json) => {
                UsersList.populate(json)
                Webapp.Spinner.doneLoading();
            })
            .catch((xhr) => {
                console.log(xhr)
                Webapp.doneLoading();
            });

        NewUserButton.enable();
    });
})(this, jQuery);
