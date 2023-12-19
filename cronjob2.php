<?php
$servername = "localhost";
$username = "u740941669_clubsattamatka";
$password = "cc3mYfw33fe2O";
$dbname = "u740941669_clubsattamatka";

$conn = new mysqli($servername, $username, $password, $dbname);
/*if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}*/
date_default_timezone_set('Asia/Kolkata');
$myDate = date("y-m-d h:i:s");


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://clubsattamatka.com/api/vr1/win-amount-transfer',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;

$test = "INSERT INTO cron_job_master (response, created_at)
VALUES ('Win Amount Transfer', '$myDate')";
$conn->query($test);
$conn->close();
?>