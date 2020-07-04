<?php

use Cake\Mailer\Mailer;
use Cake\Mailer\Message;


require '../../vendor/autoload.php';

require '../../config/bootstrap.php';

$mailer = new Mailer();

$message = new Message();

$message->setBodyText('This is the text body')->setTo('james@toggen.com.au')
    ->addAttachments([ __DIR__ . '/20200626172105-palletPrint.pdf']);


$mailer->setSubject("My Test Subject")
    ->setTo("james@toggen.com.au")->setMessage($message)->setProfile('production');

$mailer->send();