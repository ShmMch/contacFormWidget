<?php
if (isset($_POST["submit"])) {
    // Check if name has been entered
    if (!$_POST['name']) {
        $errName = 'שדה חובה';
    }
    // Check if email has been entered and is valid
    if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errEmail = 'שדה חובה';
    }
    // Check if phone has been entered and is valid
    if (!$_POST['phone'] || strlen(Preg_replace("/[^\d]/", "", $_POST['phone'])) < 10) {
        $errPhone = 'שדה חובה';
    }
    //Check if message has been entered
    if (!$_POST['message']) {
        $errMessage = 'שדה חובה';
    }
    if (!$errName && !$errEmail && !$errPhone && !$errMessage) {
        // send the email
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $from = 'ספיין פילאטיס';
        $to = 'spinepilates@gmail.com';
        $subject = 'מייל חדש מהאתר ';
        $body = "From: $name\n <br>E-Mail: $email\n <br>Phone:\n $phone <br>Message:\n $message";
        $headers = "From:" . $from;
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        if (mail($to, $subject, $body, $headers)) {
            $result = '<div class="sucsses"><h2>תודה רבה!</h2><p>נחזור אליכם בהקדם.</p></div>';
        } else {
            //$result = '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
            $result = '<div class="sucsses"><h2>תודה רבה!</h2><p>נחזור אליכם בהקדם.</p></div>';
        }

        //send to Arbox
        $apiKey = "8a6b889a-c64e-4c72-bdb7-5d450929c3a2";
        $url = "http://api.arboxapp.com/index.php/api/v2/leads";
        $location_box_fk = 371;
        $source_fk = 1592;
        $params = array("first_name" => $name, "phone" => $phone,
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap contact form">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/opensanshebrew.css);
        @import url(https://fonts.googleapis.com/earlyaccess/opensanshebrewcondensed.css);
        body {
            overflow: hidden;
            background: transparent;
	        direction: rtl;
	        padding-top:100px;
		}

        #contactForm .form-control {
        	border: none;
        	box-shadow: none;
        	border-radius: 0;
        	color: #7F1416;
        	padding: 0 13px 0 0;
        	margin: 0;
        	background: white;
        }

        #contactForm textarea.form-control {
        	height: 100%;
        	padding: 5px, 10px;
        }

        #contactForm .text-danger {
        	position: absolute;
        	top: 0;
        	left: 20px;
        	color: #c3bac4;
        	font-family: Alef Hebrew;
        	font-size: 16px;
        }


        @media (max-width: 250px) {
        	.row{
        		width: 250px;
        	}
        }

        @media (min-width: 992px) {
        	.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
        		float: right;
        	}
        }

        @media (min-width: 768px) {
        	.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
        		float: right;
        	}
        }
        @media (min-width: 470px) {
        	.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
        		float: right;
        	}
        }
        @media (max-width: 470px) {
        	.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
        		width:100%;
        	}
        	.row{
        		width:290px;
        		margin-left:8%;
        	}
        }

        @media (min-width: 992px) {
        	.row {
        		margin-right: 15%;
        	}
        	.form-control {
        		height: 45px;
        	}
        }

        @media (min-width: 768px) {
        	.row {
        		margin-right: 5%;
        	}
        	.form-control {
        		height: 40px;
        	}
        }
        @media (min-width: 470px) {
        	.row {
        		margin-right: 5%;
        	}
        	.form-control {
        		height: 40px;
        	}
        }

        #contactForm #submit {
        	border: #7F1416 solid 1px;
        	border-radius: 0;
        	background: transparent;
        	margin: 5px;
        	height: 45px;
        	width: 120px;
        	font-size: 20px;
        	color: #7F1416;
        }

        #contactForm input:focus, #contactForm textarea:focus {
        	outline: -webkit-focus-ring-color auto 1px;
        }

        #contactForm input:-webkit-autofill, #contactForm input:-webkit-autofill:hover, #contactForm input:-webkit-autofill:focus, #contactForm input:-webkit-autofill:active {
        	-webkit-box-shadow: 0 0 0 30px white inset !important;
        	box-shadow: 0 0 0 30px white inset !important;
        
        }

        #contactForm input:-webkit-autofill {
        	-webkit-text-fill-color: #7F1416 !important;
        }

        #contactForm ::placeholder {
        	/* Chrome, Firefox, Opera, Safari 10.1+ */
        	color: #7F1416;
        	opacity: 1;
        	/* Firefox */
        }

        #contactForm :-ms-input-placeholder {
        	/* Internet Explorer 10-11 */
        	color: #7F1416;
        }

        #contactForm ::-ms-input-placeholder {
        	/* Microsoft Edge */
        	color: #7F1416;
        }

        #contactForm textarea::-webkit-input-placeholder {
        	color: #7F1416;
        }

        #contactForm textarea:-moz-placeholder {
        	/* Firefox 18- */
        	color: #7F1416;
        }

        #contactForm textarea::-moz-placeholder {
        	/* Firefox 19+ */
        	color: #7F1416;
        }

        #contactForm textarea:-ms-input-placeholder {
        	color: #7F1416;
        }

        #contactForm textarea::placeholder {
        	color: #7F1416;
        }

        .sucsses {
            font-family: 'Open Sans Hebrew', serif;
            font-weight: 400;
        	width: 100%;
        	font-style: Normal;
        	text-align: center
        }

        .sucsses h2 {
        	color: #7f1416;
        	font-size: 50px;
        	letter-spacing: -1px;
        }

        .sucsses p {
        	color: #282828;
        	font-size: 16px;
        	line-height: 22px;
        	letter-spacing: 0;
        }
    </style>
</head>

<body id="contactForm">
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-horizontal" role="form" method="post" action="index.php">
                    <?php if (!isset($result)) {?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <div class="col-sm-11">
                                <input type="text" class="form-control" id="name" name="name" placeholder="שם מלא:"
                                    value="<?php echo htmlspecialchars($_POST['name']); ?>">
                                <?php echo "<p class='text-danger'>$errName</p>";?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-11">
                                <input type="email" class="form-control" id="email" name="email" placeholder="מייל:"
                                    value="<?php echo htmlspecialchars($_POST['email']);?>">
                                <?php echo "<p class='text-danger'>$errEmail</p>";?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-11">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="טלפון:"
                                    value="<?php echo htmlspecialchars($_POST['phone']);?>">
                                <?php echo "<p class='text-danger'>$errPhone</p>";?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="7" name="message" placeholder="הודעה:"><?php echo htmlspecialchars($_POST['message']);?></textarea>
                                <?php echo "<p class='text-danger'>$errMessage</p>"; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"
                        style="text-align:center;">
                        <div class="form-group">
                            <div>
                                <input id="submit" name="submit" type="submit" value="שלח" class="btn">
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                            <?php echo $result; ?>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>

</html>