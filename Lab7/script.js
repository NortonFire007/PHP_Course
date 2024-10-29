$(document).ready(function () {
    $('#profileBtn').click(function () {
        window.location.href = 'profile.php';
    });

    $('#logoutBtn').click(function () {
        $.ajax({
            url: 'server.php',
            type: 'POST',
            data: {action: 'logout'},
            success: function () {
                window.location.href = 'index.php';
            }
        });
    });

    $('#registerBtn').click(function () {
        window.location.href = 'register.html';
    });

    $('#loginBtn').click(function () {
        window.location.href = 'login.html';
    });

    $('#registerForm').submit(function (e) {
        e.preventDefault();

        const username = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();

        const validationMessage = validateForm(
            username,
            email,
            password,
            confirmPassword
        );

        if (validationMessage) {
            $("#registerError").text(validationMessage);
        }
        else {
            console.log('fd')
            $.ajax({
                url: 'server.php',
                type: 'POST',
                data: {
                    action: 'register',
                    username: username,
                    email: email,
                    password: password
                },
                success: function (response) {
                    if (response.success) {
                        alert("Реєстрація успішна!");
                        window.location.href = 'index.php';
                    } else {
                        $('#registerError').text(response.message);
                    }
                },
                error: function () {
                    $('#registerError').text('Помилка з\'єднання з сервером.');
                }
            });
        }
    });

    $('#loginForm').submit(function (e) {
        e.preventDefault();

        const email = $('#loginEmail').val();
        const password = $('#loginPassword').val();

        $.ajax({
            url: 'server.php',
            type: 'POST',
            data: {
                action: 'login',
                email: email,
                password: password
            },
            success: function (response) {
                if (response.success) {
                    $('#userName').text(response.username);
                    alert("Вхід успішний!");
                    window.location.href = 'profile.php';
                } else {
                    $('#loginError').text(response.message);
                }
            }
        });
    });

    $('#updateProfileForm').submit(function (e) {
        e.preventDefault();

        const newPassword = $('#newPassword').val();

        if (!validatePassword(newPassword)) {
            $('#profileMessage').text('Пароль повинен бути не менше 8 символів, містити хоча б одну велику букву, одну малу букву і одну цифру.');
            return;
        }
        $.ajax({
            url: 'server.php',
            type: 'POST',
            data: {
                action: 'updateProfile',
                newUsername: $('#newUsername').val(),
                newPassword: newPassword
            },
            success: function (response) {
                $('#profileMessage').text(response.message);
                $('#newUsername').val('');
                $('#newPassword').val('');
            },
            error: function () {
                $('#profileMessage').text('Помилка з\'єднання з сервером.');
            }
        });
    });

    function validateForm(username, email, password, confirmPassword) {
        if (!validateEmail(email)) {
            return "Невірний формат електронної пошти";
        }

        if (!validateUsername(username)) {
            return "Ім'я користувача повинно бути від 3 до 15 символів і містити тільки букви, цифри та підкреслення";
        }

        if (!validatePassword(password)) {
            return "Пароль повинен бути не менше 8 символів, містити хоча б одну велику літеру, одну малу літеру і одну цифру";
        }

        if (confirmPassword !== undefined && password !== confirmPassword) {
            return "Паролі не співпадають";
        }

        return null;
    }

    function validateEmail(email) {
        const regex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
        return regex.test(email);
    }

    function validateUsername(username) {
        const regex = /^[a-zA-Z0-9_]{3,15}$/;
        return regex.test(username);
    }

    function validatePassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        return regex.test(password);
    }
})

