#!/usr/bin/php
<?php
require('include.php');

use MicroEmail\Services\MailSender;

function arguments ($argv)
{
    $_ARG = array();
    foreach ($argv as $arg) {
        if (preg_match('/--([^=]+)=(.*)/', $arg, $reg)) {
            $_ARG[$reg[1]] = $reg[2];
        } elseif (preg_match('/-([a-zA-Z0-9])/', $arg, $reg)) {
            $_ARG[$reg[1]] = 'true';
        }

    }
    return $_ARG;
}

function array_keys_exists (array $keys, array $arr)
{
    return !array_diff_key(array_flip($keys), $arr);
}

function helper ()
{
    return "\n--email=\"To email address\" (  \n" .
        "\n--name=\"Name of customer\" (  \n" .
        "\n--subject=\"Email subject\" (  \n" .
        "\n--body=\"Your msg\" (  \n" .
        "\n--type=\"text/html or text/plain\" (  \n" .
        "\n\n-example:\n" .
        "php cmd.php --email=\"micromailer@cocobean.co.za\" --name=\"Micro Mail\" --subject=\"Example Subject\" --body=\"Welcome\" --type=\"text/plain\"\n\n";

}

$data = arguments($argv);

if (array_keys_exists(['email', 'name', 'subject', 'body'], $data)) {
    if (MailSender::sendNow($data)) {
        echo "\nEmail was sent\n";
    } else {
        echo "\nEmail sending Failed\n";
    }
} else {
    echo
    "\nERROR:\n\nPlease make sure you have all the fields\n";
    echo helper();
}

