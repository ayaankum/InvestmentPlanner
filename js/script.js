let a = 0;

function checkUser(val) {
    var check = /^[_a-z]+$/g;

    if (!check.test(val)) {
        $('#checktext').html('Only lower case Latin letters and underscore are allowed!');
        $('#checktext').css('color', 'red');
        a = 1;
    } else {
        $('#checktext').html('');
    }

    $.ajax({
        url: 'duplicateUsers.php',
        method: 'POST',
        data: {
            'username': val
        },
        async: false
    }).done(function (data) {
        var check = JSON.parse(data);
        if (check.success == true) {
            $('#checkuser').html('This username is already taken!');
            $('#checkuser').css('color', 'red');
            $('#uname').val('');
        }
        else if (a == 1) {
            $('#checkuser').html('Try again!');
            $('#checkuser').css('color', 'red');
            a = 0;
        }

        else {
            $('#checkuser').html('Username Available!');
            $('#checkuser').css('color', '#119d00');
        }

    });


}