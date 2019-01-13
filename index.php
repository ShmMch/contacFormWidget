<?php
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $from = 'ספיין פילאטיס';
    $to = 'spinepilates@gmail.com';
    $subject = 'מייל חדש מהאתר ';

    $body = "From: $name\n E-Mail: $email\n Phone:\n $phone Message:\n $message";

    // Check if name has been entered
    if (!$_POST['name']) {
        $errName = 'שדה חובה';
    }

    // Check if email has been entered and is valid
    if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errEmail = 'שדה חובה';
    }

    // Check if phone has been entered and is valid
    if (!$_POST['phone'] || strlen(Preg_replace("/[^\d]/", "", $phone)) < 10) {
        $errPhone = 'שדה חובה';
    }

    //Check if message has been entered
    if (!$_POST['message']) {
        $errMessage = 'שדה חובה';
    }

// If there are no errors, send the email
    if (!$errName && !$errEmail && !$errPhone && !$errMessage) {
        if (mail($to, $subject, $body)) {
            $result = '<div><h2 class="Title">תודה רבה!</h2><p class="Normal-white ospfxwdc501ae0ff8c19f1a21b3e204b48823dossfx">נחזור אליכם בהקדם.</p></div>';
        } else {
            $result = '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
            $result = '<div><h2 class="Title">תודה רבה!</h2><p class="Normal-white">נחזור אליכם בהקדם.</p></div>';
        }
        //send to Arbox
        $url = "http://staging.arboxapp.com/manage/current/public/"; //"https://api.arboxapp.com/index.php";
        $path = "api/v2/leads";
        $location_box_fk = "";
        $source_fk = 1592;
		$params = array('first_name' => $name, 'phone' => $phone, 
		'email' => $email, 'location_box_fk' => $location_box_fk, 'source_fk' => $source_fk);
		$query = http_build_query($params);
		// Create Http context details
        $contextData = array(
			'method' => 'POST',
            'header' => "Connection: close\r\n" .
			"Content-Length: " . strlen($query) . "\r\n".
			"apiKey: " . $apiKey . "\r\n",
			'content' => $query);
		// Create context resource for our request
		$context = stream_context_create(array('http' => $contextData));
		// Read page rendered as result of your POST request
        $result = file_get_contents($url,false,$context);
		// Server response is now stored in $result variable so you can process it
		echo ($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap contact form ">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="./style.css">
  </head>
  <body id="contactForm">
  	<div class="container">
  		<div class="row">
  			<div class="col-md-9 col-md-offset-3">
  				<h1 class="page-header text-center">צרו קשר</h1>
				<form class="form-horizontal" role="form" method="post" action="index.php">
				<?php if (!isset($result)) {?>
					<div class="col-md-6">
						<div class="form-group">
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="שם מלא:" value="<?php echo htmlspecialchars($_POST['name']); ?>">
							<?php echo "<p class='text-danger'>$errName</p>"; ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="מייל:" value="<?php echo htmlspecialchars($_POST['email']); ?>">
							<?php echo "<p class='text-danger'>$errEmail</p>"; ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10">
							<input type="tel" class="form-control" id="phone" name="phone" placeholder="טלפון:" value="<?php echo htmlspecialchars($_POST['phone']); ?>">
							<?php echo "<p class='text-danger'>$errPhone</p>"; ?>
						</div>
					</div>
				</div>
					<div class="col-md-6">
						<div class="form-group">
						<div class="col-sm-10">
							<textarea class="form-control" rows="7" name="message"><?php echo htmlspecialchars($_POST['message']); ?></textarea>
							<?php echo "<p class='text-danger'>$errMessage </p>"; ?>
						</div>
					</div>
				</div>
				<div class="col-md-12" style="text-align:center;">
					<div class="form-group" >
						<div >
							<input id="submit" name="submit" type="submit" value="שלח" class="btn">
						</div>
					</div>
					</div>
					<?php }?>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
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