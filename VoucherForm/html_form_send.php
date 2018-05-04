<?php
require_once "vendor/autoload.php";

/***Connection DB*/
    $user = "root"; // issue tu rentres es param de ta base.
    $pass = "root";
    $dbname = "voucher";
    $host = "localhost";
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=voucher', $user, $pass);
        var_dump("connected");
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
/****Recupeartion des datas*/

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
/***Enregistrement en db*/

$token = uniqid();
try {

    $sql = "INSERT INTO users (first_name, last_name, email,token)
            VALUES ('".$_POST["first_name"]."','".$_POST["last_name"]."','".$_POST["email"]."','".$token."')";
    if (!$dbh->query($sql)) {
        echo "<script type= 'text/javascript'>alert('Something wrong happened please try again');</script>";
    }

} catch(PDOException $e) {
    echo $e->getMessage();
}

/***Envoi mail*/
$mail = new \PHPMailer\PHPMailer\PHPMailer();

//From email address and name
$mail->From = "test@test.com";
$mail->FromName = "ali";

//To address and name
$mail->addAddress("nadji-ali@hotmail.fr"); //Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo("reply@yourdomain.com", "Reply");

//CC and BCC
$mail->addCC("cc@example.com");
$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Subject Text";
$mail->Body = "<i>voucher code is </i>$token";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    echo "<script type= 'text/javascript'>alert('Check your mailBox');</script>";
}
