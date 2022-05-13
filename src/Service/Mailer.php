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
            ->from('cuisinet@gmail.com')
            ->to('wassim.khemiri@esprit.tn')
            ->subject('nouvelle promotion')

            // path of the Twig template to render
            ->htmlTemplate('mail/promotion.html.twig')


        ;

        $this->mailer->send($email);
    }

}