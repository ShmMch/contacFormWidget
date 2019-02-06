<?php
if (isset($_POST["submit"])) {
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
mail($to, $subject, $body, $headers); 
 
//send to Arbox
if($_ENV["ARBOX"]){
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
echo($res);
}
}
?>