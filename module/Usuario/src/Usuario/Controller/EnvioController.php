<?php
namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuario\Model\Email;
use Zend\Mail;


class EnvioController extends AbstractActionController
{
    public function enviarAction()
    {
        $corpoEmail  = $this->getRequest()->getPost('corpoEmail');
        $assuntoEmail= $this->getRequest()->getPost('assunto');
        $email       = $this->getRequest()->getPost('email');
        if ( $this->getRequest()->isPost() ) {
            
                $transport = Email::configurarEmail();
                $mail = new Mail\Message();
                $mail->setBody($corpoEmail);
                $mail->addFrom('nataniel.paiva@gmail.com');
                $mail->addTo($email);
                $mail->setSubject($assuntoEmail);
                
                try {
                	$transport->send($mail);
                	echo "enviou";
                } catch (Exception $e) {
                	echo "deu pala";
                }
        }
        
    }
}
