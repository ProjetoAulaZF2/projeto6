Sexto projeto das aulas de Zend Framework 2 com Nataniel Paiva
=======================

Introdução
------------

Esse sexto projeto contempla os seguintes tópicos:

* Criar uma tela para envio de email.
* Configurar o envio de email.



Criando uma classe para configurar o email
--------------------------------------------

Vamos criar uma classe para configurar nosso email dentro do módulo de usuário com o seguinto código:
~~~php
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
~~~
Depois vamos criar uma controller só para fazer o envio dentro do módulo de usuário também, com o seguinte código:
~~~php
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
~~~

Agora vamos criar nossa action para o envio do email:
~~~php
	<?php
	$title = 'Enviar o email';
	$this->headTitle($title);
	?>
	<h1><?php echo $this->escapeHtml($title); ?></h1>
	<div class="page-header">
	<form action= "<?php echo $this->basepath('usuario/envio/enviar') ?>" method="post" class="form-horizontal" role="form">
	    <div class="form-group">
	    	<label for="nome" class="col-sm-2 control-label">Para</label>
	    	<div class="col-sm-3">
	    		<input type='email' name='email' class='form-control' placeholder='Email' /> 
	    	</div>
	    </div>
	    <div class="form-group">
	    	<label for="nome" class="col-sm-2 control-label">Assunto</label>
	    	<div class="col-sm-3">
	    		<input type='text' name='assunto' class='form-control' placeholder='Assunto' /> 
	    	</div>
	    </div>
	    <div class="form-group">
	    	<label for="email" class="col-sm-2 control-label">Texto do Email</label>
	    	<div class="col-sm-3">
	    		<textarea  name='corpoEmail' class='form-control' placeholder='Texto do Email'></textarea> 
	    	</div>
	    </div>
	    <div class="form-group">
	    	<div class="col-sm-offset-2 col-sm-4">
	    		<input type="submit" value="Enviar Email" class="btn btn-default" />
	    	</div>
	    </div>
	</form>
	</div>
~~~
Pronto!Somente com isso já conseguiremos criar nossa tela de enviar email, podemos fazer um form para contatos e etc...






