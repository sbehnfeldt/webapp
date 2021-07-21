;(function (global, $) {
    'use strict';

    function loadUsers() {
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

    function loadUserPermissions(userId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/api/permissions',
                type: 'get',
                data: {
                    userId: userId
                },

                dataType: 'json',
                success: (permissions) => {
                    resolve(permissions);
                },
                error: (xhr) => {
                    reject(xhr);
                }
            })
        });
    }

    function createUser(userData) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/api/users',
                type: 'post',
                data: userData,

                dataType: 'json',
                success: function (user) {
                    resolve(user);
                },
                error: function (xhr) {
                    reject(xhr);
                }
            });
        })
    }

    function updateUser(userId, userData) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/api/users/' + userId,
                type: 'put',
                data: userData,

                dataType: 'json',
                success: function (user) {
                    resolve(user);
                },
                error: function (xhr) {
                    reject(xhr);
                }
            });
        });
    }


    let NewUserButton = (function (selector) {
        let $button = $(selector);

        $button.on('click', function () {
            UserForm.enable(true).clear();
            SaveUserButton.enable(true);
            CancelFormButton.enable(true);
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
            let $li = $(this);
            let user = $li.data('user');
            console.log(user);

            loadUserPermissions(user.Id)
                .then((perms) => {
                    console.log(perms);
                    UserForm.enable(true)
                        .populate(user)
                        .populatePermissions(perms);
                    SaveUserButton.enable(true);
                    CancelFormButton.enable(true);

                    $li.data('perms', perms);
                })
                .catch((xhr) => {
                    console.log(xhr);
                });
        });


        function clear() {
            $list.clear();
            return this;
        }

        function populate(users) {
            let template = Handlebars.compile('<li><a href="javascript:void(0)">{{ username }}</a>');

            for (let i = 0; i < users.length; i++) {
                let user = users[i];
                let $li = $(template({
                    'username': user.Username
                }));
                $li.data('user', user);
                $list.append($li);
            }
            return this;
        }

        return {clear, populate};
    })('#users-list');


    let UserForm = (function (selector) {
        let $form = $(selector);
        let $textBoxes = $form.find('input[type=text], input[type=email]');
        let $checkBoxes = $form.find('input[type=checkbox]');

        $textBoxes.on('change', function () {

            if ($(this).data('db-data') !== $(this).val()) {
                $(this).addClass('modified');
            } else {
                $(this).removeClass('modified');
            }
        });

        function enable(b = true) {
            $textBoxes.attr('disabled', !b);
            $checkBoxes.attr('disabled', !b);
            return this;
        }

        function clear() {
            $form.data('user', undefined);
            $textBoxes.val('').data( 'db-data', undefined ).removeClass( 'modified' );
            $checkBoxes.prop('checked', false);
            return this;
        }

        function populate(user) {
            $form.data('user', user);   // Store the original value
            $form.find('input[name=Username]').val(user.Username).data('db-data', user.Username);
            $form.find('input[name=Email]').val(user.Email).data('db-data', user.Email);
            return this;
        }

        function populatePermissions(perms) {
            $checkBoxes.prop('checked', false);
            for (let i = 0; i < perms.length; i++) {
                let p = perms[i].Permission;
                let $checkbox = $checkBoxes.filter(`[name=${p.Slug}]`);
                $checkbox.prop('checked', true);
            }
            return this;
        }

        function getUser() {
            return $form.data('user');
        }

        function getUserPerms() {
            return $form.data('perms');
        }

        function getFormData() {
            let formData = {};
            return $form.serializeArray();
        }

        function getModifiedUserData() {
            let data = {};
            for ( let i = 0; i < $textBoxes.length; i++ ) {
                let $t = $textBoxes.eq(i);
                if ( $t.hasClass( 'modified' )) {
                    data[ $t.attr( 'name' )] = $t.val();
                }
            }
            return data;
        }

        return {enable, clear, populate, populatePermissions, getUser, getUserPerms, getFormData, getModifiedUserData};

    })('#users-form');


    let SaveUserButton = (function (selector) {
        let $button = $(selector);

        $button.on('click', function () {
            // Webapp.Spinner.loadAnother();
            let user = UserForm.getUser();
            let perms = UserForm.getUserPerms();
            let data = UserForm.getFormData();

            console.log(user);
            console.log(perms);
            console.log(data);
            let userData = {};
            let permData = {};

            if (!user) {
                // Create new user
                userData = {
                    'Username': ''
                }
                createUser(userData)
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

            } else {
                // Update existing user
                userData = UserForm.getModifiedUserData();
                updateUser(user.Id, userData)
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
            }
            return false;
        });

        function enable(b = true) {
            $button.attr('disabled', !b);
            return this;
        }

        return {enable};
    })("#save-user-button");


    let CancelFormButton = (function (selector) {
        let $button = $(selector);


        $button.on('click', function () {
            NewUserButton.enable();
            UserForm.clear().enable(false);
            SaveUserButton.enable(false);
            enable(false);
        });

        function enable(b = true) {
            $button.attr('disabled', !b);
            return this;
        }

        return {enable};
    })('#cancel-form-button');


    // Document ready handler
    $(function () {
        console.log('Document ready');
        Webapp.Spinner.init('#loading');
        Webapp.Spinner.loadAnother()
        loadUsers()
            .then((users) => {
                console.log(users);
                UsersList.populate(users);
                Webapp.Spinner.doneLoading();
            })
            .catch((xhr) => {
                console.log(xhr)
                Webapp.doneLoading();
            });

        NewUserButton.enable();
    });
})(this, jQuery);
