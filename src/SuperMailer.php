<?php
/**
 * Author: Abu Ashraf Masnun
 * URL: http://masnun.me
 */


namespace Masnun\SuperMailer;


class SuperMailer
{
    public function __construct
    (
        $smtpHost,
        $smtpPort,
        $smtpUsername = null,
        $smtpPassword = null,
        $subject = null,
        $template = null,
        $fromName = "Abu Ashraf Masnun",
        $fromEmail = "masnun@transcendio.net"
    )
    {
        $this->transport = \Swift_SmtpTransport::newInstance($smtpHost, $smtpPort);
        if (!empty($smtpUsername))
        {
            $this->transport->setUsername($smtpUsername);
        }

        if (!empty($smtpPassword))
        {
            $this->transport->setPassword($smtpPassword);
        }

        $this->mailer = \Swift_Mailer::newInstance($this->transport);

        if (!empty($subject))
        {
            $this->subject = $subject;
        }

        if (!empty($template))
        {
            $this->template = $template;
        }

        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;

        $loader = new \Twig_Loader_Filesystem(".");
        $this->twig = new \Twig_Environment($loader, []);
    }

    public function sendEmail($toName, $toEmail, $data)
    {
        $body = $this->twig->render($this->template, $data);
        $twigStringLoader = new \Twig_Environment(new \Twig_Loader_String());
        $subject = $twigStringLoader->render($this->subject, $data);

        $message = \Swift_Message::newInstance($subject, $body, 'text/html');
        $message->addTo($toEmail, $toName);
        $message->addFrom($this->fromEmail, $this->fromName);

        echo "Sending email to {$toName} ({$toEmail})" . PHP_EOL;

        return $this->mailer->send($message);
    }
} 