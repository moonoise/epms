$(document).ready(function () {
    "use strict";
    $("#submit").click(function () {

        var username = $("#myusername").val(), password = $("#mypassword").val();

        if ((username === "") || (password === "")) {
            $("#message").html("<div class=\"text text-danger \"> กรุณาใส่ เลขบัตรประจำตัวประชาชน และรหัสผ่าน</div>");
        } else {
            $.ajax({
                type: "POST",
                url: "checklogin-dpis.php",
                data: "myusername=" + username + "&mypassword=" + password,
                dataType: 'JSON',
                success: function (html) {
                    //  console.log(html.response + ' ' + html.username);
                    //  $("#message").html(html.response);
                    if (html.response === 'true') {
                        location.assign("index.php");
                       //location.reload();
                        return html.username;
                    } else {
                        $("#message").html(html.response);
                    }
                },
                error: function (textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                },
                beforeSend: function () {
                    $("#message").html("<p class='text-center'><img src='images/blocks-1s-200px.gif' height='42' width='42'></p>");
                }
            });
        }
        return false;
    });
});