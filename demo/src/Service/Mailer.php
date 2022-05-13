<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
{
    $this->mailer = $mailer;
}

    public function sendEmailProm($email)
    {
        $email = (new TemplatedEmail())
            ->from('cuisinet.app@gmail.com')
            ->to('wassim.khemiri@esprit.tn')
            ->subject('nouvelle promotion')

            // path of the Twig template to render
            ->htmlTemplate('mail/promotion.html.twig')


        ;

        $this->mailer->send($email);
    }
    
    public function sendEmail($email, $token)
    {
        $email = (new TemplatedEmail())
            ->from('cuisinet.app@gmail.com')
            ->to($email)
            ->subject('Confrimation du compte Cuisinet')

            // path of the Twig template to render
            ->htmlTemplate('email/inscription.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'token' => $token,
            ])
        ;

        $this->mailer->send($email);
    }
   

}