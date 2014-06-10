<?php
namespace Usuario\Model;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class Email
{

    static function configurarEmail()
    {
        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'connection_class' => 'plain',
            'connection_config' => array(
                'username' => 'nataniel.paiva@gmail.com',
                'password' => 'senhadoseuemail',
                'ssl' => 'tls'
            )
        ));
        return $transport->setOptions($options);
    }

}


