<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Include librari phpmailer
include('phpmailer/Exception.php');
include('phpmailer/PHPMailer.php');
include('phpmailer/SMTP.php');


$_POST['name'] = "test";
$_POST['email'] = "test@gmail.com";
$_POST['subject'] = "test subject";
$_POST['message'] = "test message";


$email_pengirim = 'notification@dikgroup.id'; // Isikan dengan email pengirim
$nama_pengirim = "Web DIK Group"; // Isikan dengan nama pengirim
$email_penerima = 'admin@dikgroup.id'; // Ambil email penerima dari inputan form
$email_penerima2 = 'division@dikgroup.id'; // Ambil email penerima dari inputan form
$subjek = $_POST['subject'];
$pesan = "<b>Nama Pengirim : </b>".$_POST['name']."<br>"."<b>Email Pengirim : </b>".$_POST['email']."<br>"."<b>Isi Pesan : </b><br>".$_POST['message']; // Ambil subjek dari inputan form

$recaptcha_secret = '6LfFT8opAAAAABjPiH_jnZsb3W7iE_d-rLYJ_iBY';
$response = $_POST['g-recaptcha-response'];
$remoteip = $_SERVER['REMOTE_ADDR'];
$api_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $response . '&remoteip=' . $remoteip;
$json_response = file_get_contents($api_url);
$response_data = json_decode($json_response);


if ($response_data->success) {
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'ssl://mail.dikgroup.id';
$mail->Username = $email_pengirim; // Email Pengirim
$mail->Password = 'NTDIKgroup123!'; // Isikan dengan Password email pengirim
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Timeout = 60; // timeout pengiriman (dalam detik)
$mail->SMTPKeepAlive = true; 
$mail->SMTPSecure = 'ssl';
$mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging
$mail->setFrom($email_pengirim, $nama_pengirim);
$mail->addAddress($email_penerima, '');
$mail->addAddress($email_penerima2, '');
$mail->isHTML(true); // Aktifkan jika isi emailnya berupa html

ob_start();

$mail->Subject = $subjek;
$mail->Body = $pesan;


$send = $mail->send();
session_start();



} else {
    $_SESSION['status_send'] = "fail";
}

if ($send) {
    $_SESSION['status_send'] = "sending";
}else {
    $_SESSION['status_send'] = "fail";
}



header("location:../page-contact.php");

?>
