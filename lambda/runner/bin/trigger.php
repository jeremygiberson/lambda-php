<?php
require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'rabbitmq', 'rabbitmq');
$channel = $connection->channel();

$channel->queue_declare('test', false, false, false, false);


$serialized = serialize($params);

$msg = new AMQPMessage(json_encode([
    "event" => [
        "fiz"=>"buz"
    ], "context" => [
        "file"=>"handler.php",
        "handler"=>"hello",
        "workspace" =>"/var/task"
    ]
]));
$channel->basic_publish($msg, '', 'test');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();