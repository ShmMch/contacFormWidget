<?php
$arbox=true;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // send the email
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $from = 'ספיין פילאטיס';
    $to ='spinepilates@gmail.com';
    $subject = 'מייל חדש מהאתר ';
    $body = "From: $name\n <br>E-Mail: $email\n <br>Phone:\n $phone <br>Message:\n $message";
    $headers = "From:" . $from;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    mail($to, $subject, $body, $headers);

    //send to Arbox
    if($arbox){
        $apiKey = "8a6b889a-c64e-4c72-bdb7-5d450929c3a2";
        $url = "http://api.arboxapp.com/index.php/api/v2/leads";
        $location_box_fk = 371;
        $source_fk = 1592;
        $name = explode(" ", $name);
        $params = array("first_name" => $name[0],"last_name" => $name[1], "phone" => $phone,
            "email" => $email, "location_box_fk" => $location_box_fk, "source_fk" => $source_fk);
        $query = http_build_query($params);
        $contextData = array(
            "method" => "POST",
            "header" => "Connection: close\r\n" .
            "Content-Length: " . strlen($query) . "\r\n" .
            "apiKey: " . $apiKey . "\r\n",
            "content" => $query);
        $context = stream_context_create(array("http" => $contextData));
        $res = file_get_contents($url, false, $context);
        echo ($res);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;" />

    <meta name="description" content="Bootstrap contact form">
    <title>Contact Form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    //Add validators
    document.querySelectorAll('input, textarea').forEach(function (element) {
        element.oninvalid = function (e) {
            e.target.parentNode.classList.add('error');
            e.preventDefault();
        };
        element.oninput = function (e) {
            e.target.parentNode.classList.remove('error')
        };
    });

    //Set submit function
    $(function () {
        $("#form").submit(function () {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    name: $("#name").val(),
                    phone: $("#phone").val(),
                    email: $("#email").val(),
                    message: $("[name='message']").val()
                },
                success: function () {
                    $('#form').hide();
                   $('.success').fadeIn(1000);
                }
            });
            return false;
        });
    });
})
</script>
<style>
    @import url(https://fonts.googleapis.com/earlyaccess/opensanshebrew.css);
@import url(https://fonts.googleapis.com/earlyaccess/opensanshebrewcondensed.css);

body {
    z-index:3333;
    text-align: center;
    margin: 0 auto;
    font-family: 'Open Sans Hebrew', serif;
    font-weight: 400;
    padding-top: 30px;
    overflow: hidden;
    background: transparent;
    direction: rtl;
}

div{
    position: relative;
}

#name,
#email,
#phone,
textarea {
    margin: 10px;
    color: #7F1416;
    border: none;
    font-family: 'Arial', serif;
    font-size:15px;
    padding-right: 12px;
}

.error::before {
    content: "שדה חובה";
    position: absolute;
    color: #c3bac4;
    font-family: Alef Hebrew;
    font-size: 16px;
    top:15px;
}

#submit {
    border: #7F1416 solid 1px;
    border-radius: 0;
    background: transparent;
    margin: 5px;
    height: 45px;
    width: 120px;
    font-size: 20px;
    color: #7F1416;
}

.sucsses {
    font-weight: 400;
    width: 100%;
    font-style: Normal;
    text-align: center
}

.success h2 {
    margin:0;
    margin-top:35px;
    font-weight: 300;
    color: #7f1416;
    font-size: 50px;
    letter-spacing: -1px;
}

.success p {
    margin:0;
    color: #282828;
    font-size: 16px;
    line-height: 22px;
    letter-spacing: 0;
}


input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
    box-shadow: 0 0 0 30px white inset !important;
}

input:-webkit-autofill {
    -webkit-text-fill-color: #7F1416 !important;
}

/* #region flexibility*/
@media (min-width: 450px) {

    #message,
    #personalDetails {
        width: 50%;
        margin: 0;
        float: right;
    }

    #message {
        text-align: right;
    }

    #personalDetails {
        text-align: left;
    }

    #name,
    #email,
    #phone,
    textarea {
        width: 327px;
    }

    #name,
    #email,
    #phone {
        height: 47px;
        margin-left: 20px !important;
    }

    textarea {
        margin-right: 20px !important;
        height: 185px;
    }

    .error::before {
        left:25px;
    }
    #message.error::before {
        right:300px;
    }
}

@media (min-width: 450px) and (max-width: 770px) {

    #name,
    #email,
    #phone,
    textarea {
        width: 190px;
    }

    #name,
    #email,
    #phone {
        height: 32px;
        margin-left: 20px !important;
    }

    textarea {
        margin-right: 20px !important;
        height: 135px;
    }

    #message.error::before {
        right:165px;
    }

}

@media (max-width: 450px) {

    #name,
    #email,
    #phone,
    textarea {
        width: 237px;
    }

    #name,
    #email,
    #phone {
        height: 25px;
    }

    textarea {
        height: 115px;
    }

    .error::before {
        left:15%;
    }
}

@media only screen and(max-width: 450px) {
#name,
#email,
#phone,
textarea {
    width: 237px;
    margin:5px;
    }  
}

/* #endregion */

/* #region placeholders color */

::placeholder {
    /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
    /* Firefox */
}

:-ms-input-placeholder {
    /* Internet Explorer 10-11 */
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

::-ms-input-placeholder {
    /* Microsoft Edge */
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

textarea::-webkit-input-placeholder {
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

textarea:-moz-placeholder {
    /* Firefox 18- */
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

textarea::-moz-placeholder {
    /* Firefox 19+ */
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

textarea:-ms-input-placeholder {
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

textarea::placeholder {
    color: #7F1416;
    font-size: 15px;
    font-family: 'Arial', serif;
}

/* #endregion */
</style>

</head>

<body>
    <form id="form" role="form" method="post"">
        <div id="personalDetails">
            <div><input type="text" id="name" name="name" placeholder="שם מלא:" required></div>
            <div><input type="email" id="email" name="email" placeholder="מייל:" required></div>
            <div><input type="tel" id="phone" name="phone" placeholder="טלפון:" required></div>
        </div>
        <div id="message"><textarea rows="6" name="message" placeholder="הודעה:" required></textarea></div>
        <input id="submit" name="submit" type="submit" value="שלח">
    </form>
    <div class="success" style="display: none;"><h2>תודה רבה!</h2><p>נחזור אליכם בהקדם.</p></div>
</body>
</html>
