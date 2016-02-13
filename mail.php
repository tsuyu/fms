<?php

$from_user = 'from@test.com';
$from_pass = '123456';
$from = array('from@test.com' => 'From Test');
$to = array('from@test.com' => 'To Test');
$subject = 'Wonderful Subject';
$textmail = '';
$htmlmail = '<html><head><style type=\'text/css\'>body { font-family: Arial; font-size: 10pt; }p { margin: 0; }</style></head>'
        . '<body><div align="left">'
        . 'This is the text of the mail send by Swift using SMTP transport.</div>'
        . '</body></html>';

echo "Sent " . sendmail($from_user, $from_pass, $to, $from, $subject, $textmail, $htmlmail) . " messages ";

function sendmail($from_user, $from_pass, $to, $from, $subject, $textmail, $htmlmail = NULL, $attachment = NULL) {

    require_once './include/Swift/lib/swift_required.php';
    //Mail
    $transport = Swift_SmtpTransport::newInstance('mail.test.com', 25)
            ->setUsername($from_user)
            ->setPassword($from_pass);
    //Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    //Create the message
    $message = Swift_Message::newInstance()

            //Give the message a subject
            ->setSubject($subject)

            //Set the From address with an associative array
            ->setFrom($from)

            //Set the To addresses with an associative array
            ->setTo($to)

            //Give it a body
            ->setBody($textmail)
            ->setReturnPath($from_user);

    if ($htmlmail != '') {

        //And optionally an alternative body
        $message->addPart($htmlmail, 'text/html');
    }

    if ($attachment != '') {

        //Optionally add any attachments
        $message->attach(
                Swift_Attachment::fromPath($attachment)->setDisposition('inline')
        );
    }

    //Send the message
    $result = $mailer->send($message);

    return $result;
}

?>