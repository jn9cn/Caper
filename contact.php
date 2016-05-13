<?php

$post = $_POST;

if (isset($post['purveyor_Fname']) && $post['purveyor_Fname'] && isset($post['purveyor_Email']) && $post['purveyor_Email']) {
    $message = '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color: #F4F4F4; border-bottom: 1px solid #CCCCCC;"> 
<tr> <td align="center" valign="top" style="background-color: #F4F4F4; border-top: 1px solid #FFFFFF; border-bottom: 1px solid #CCCCCC;"> 
<table border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #BBBBBB; width: 600px;"> 
<tr> <td align="center" valign="top"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F4F4F4; border-bottom: 1px solid #CCCCCC;"> 
<tr> <td valign="top" style="color: #808080; font-family: Helvetica; font-size: 10px; line-height: 125%; text-align:center; padding-top:10px; padding-right:20px; padding-bottom:10px; padding-left:0;" mc:edit="preheader_content01"> Email not displaying correctly? <a href="#" target="_blank">View it in your browser</a>. </td></tr>
</table> </td></tr>
<tr> <td align="center" valign="top"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff; border-top:1px solid #FFFFFF; border-bottom:1px solid #CCCCCC;"> 
<tr> <td valign="top" style="text-align:center; color:#505050;font-family:Helvetica;font-size:20px;font-weight:700;line-height:100%;vertical-align:middle; padding:10px;"> <img src="http://caper.ly/beta/img/Caper.png" style="max-width:600px; max-height: 50px;" id="headerImage" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext/> </td></tr>
</table> </td></tr>
<tr> <td align="center" valign="top"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-bottom:20px; background-color:#ffffff;border-top:1px solid #FFF;border-bottom:1px solid #CCC"> 
<tr> <td valign="top" class="bodyContent" style="padding-left:20px;" mc:edit="body_content"> <h1>Enquiry</h1> </td></tr>
<tr><td style="width:100%; padding:10px 20px 40px">
<table cellpadding="10" cellspacing="0" width="100%" style="border:1px solid #ccc;line-height:24px; font-size:16px; font-family: Helvetica;">
<tr><td width="30%" bgcolor="#ebebeb">First Name: </td><td bgcolor="#f6f6f6">' . $post['purveyor_Fname'] . '</td></tr>
<tr><td bgcolor="#f8f8f8">Last Name: </td><td bgcolor="#fff">' . $post['purveyor_Lname'] . '</td></tr>
<tr><td bgcolor="#ebebeb">Email Id: </td><td bgcolor="#f6f6f6">' . $post['purveyor_Email'] . '</td></tr>
<tr><td bgcolor="#f8f8f8">Business Name: </td><td bgcolor="#fff">' . $post['purveyor_Businessname'] . '</td></tr>
<tr><td bgcolor="#ebebeb">Signature Dish: </td><td bgcolor="#f6f6f6">' . $post['purveyor_Dish'] . '</td></tr>
<tr><td bgcolor="#f8f8f8">Biography: </td><td bgcolor="#fff">' . $post['purveyor_Bio'] . '</td></tr>
<tr><td bgcolor="#ebebeb">Customers Serve: </td><td bgcolor="#f6f6f6">' . $post['purveyor_Customers'] . '</td></tr>
<tr><td bgcolor="#f8f8f8">Hear About Us: </td><td bgcolor="#fff">' . $post['purveyor_Aboutus'] . '</td></tr>
<tr><td bgcolor="#ebebeb">Address: </td><td bgcolor="#f6f6f6">' . $post['purveyor_Address'] . '</td></tr>
<tr><td bgcolor="#f8f8f8">City: </td><td bgcolor="#fff">' . $post['purveyor_City'] . '</td></tr>
<tr><td bgcolor="#ebebeb">Zipcode: </td><td bgcolor="#f6f6f6">' . $post['purveyor_Zipcode'] . '</td></tr>
<tr><td bgcolor="#f8f8f8">Social Links: </td><td bgcolor="#fff">' . $post['purveyor_Social'] . '</td></tr>
</table></td></tr></table> </td></tr>
<tr> <td align="center" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F4F4F4; border-top:1px solid #FFFFFF;"><tr><td valign="top" style="text-align:center; color:grey;font-family:Helvetica;font-size:10px;line-height:150%;padding:20px" mc:edit="footer_content01"><em>Copyright &copy; 2016 Caper, All rights reserved.</em></td></tr>
</table> </td></tr></table> </td></tr></table>';

    require_once('PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer();

    $mail->isSMTP();

    //For loaclhost
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.googlemail.com';
    $mail->Port = 465;
    $mail->Username = "tu06510@gmail.com";  // GMAIL username
    $mail->Password = "prabhukiran510";

    $mail->SetFrom($post['purveyor_Email'], $post['purveyor_Fname']);
    $mail->AddAddress('purveyors@caper.ly', "Caper"); //
    $mail->Subject = "Caper - Purveyor Enquiry";
    $mail->MsgHTML($message);
    $mail->Send();
    /* if(!$mail->Send())
      echo $mail->ErrorInfo;
      else */
    echo "Thank you for your interest, a email been sent.<br/> Will get back to you shortly";
}
?>