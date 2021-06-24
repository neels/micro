<?php
require($_SERVER["DOCUMENT_ROOT"].'include.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use MicroEmail\Services\MailSender;

$connection = new AMQPStreamConnection('micro_email_rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('emails', false, false, false, false);

echo '# Waiting for e-mails from RabbitMQ. To exit press CTRL+C', "\n";

/**
 * @param $msg
 */
$callback = function ($msg) {

    echo '- Proccessing Email', "\n";

    $data = json_decode($msg->body, true);

    if(MailSender::sendNow($data)){
        echo " - Email was sent", "\n";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }

};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('emails', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
