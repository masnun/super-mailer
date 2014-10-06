<?php
/**
 * Author: Abu Ashraf Masnun
 * URL: http://masnun.me
 */

require_once 'vendor/autoload.php';
require_once 'config.php';

use Masnun\SuperMailer\SuperMailer;

$mailer = new SuperMailer(
    // smtp data
    $smtp['host'],
    $smtp['port'],
    $smtp['username'],
    $smtp['password'],

    // Subject template
    'Hello {{name}}!',

    // Message body template
    'invitation.html.twig',

    //Sender details
    "Abu Ashraf Masnun",
    "masnun@gmail.com"
);


$sampleUsersArray = [

    [
        'name' => "Masnun",
        'email' => 'masnun@transcendio.net',
        'token' => '2eff42576ee8fc0dccdd38c0108fe8af'
    ],

    [
        'name' => 'The Doctor',
        'email' => 'thedoctor@transcendio.org',
        'token' => '2aa5a1d13d655a57dbc0e40b5b50365c'
    ]
];


foreach ($sampleUsersArray as $user)
{
    $mailer->sendEmail($user['name'], $user['email'], $user);
}