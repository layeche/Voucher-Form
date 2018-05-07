<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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
/*$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('nadji-ali@hotmail.fr', 'Mailer');
    $mail->addAddress($email);               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
*/
/*essai dabord avec ça*/
$to = $email;
$subject = "Your Voucher code";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>$token</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);