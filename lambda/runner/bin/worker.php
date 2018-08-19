<?php
require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPLambda\Lambda\Invoker;

$connection = new AMQPStreamConnection('localhost', 5672, 'rabbitmq', 'rabbitmq');
$channel = $connection->channel();

$lambdaName = $_SERVER['LAMBDA_NAME'];
$lambdaFile = $_SERVER['LAMBDA_FILE'];
$lambdaHandler = $_SERVER['LAMBDA_HANDLER'];
$workspace = $_SERVER['LAMBDA_WORKSPACE'];

$channel->queue_declare($lambdaName, false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) use ($workspace, $lambdaFile, $lambdaHandler) {
    echo ' [x] Received ', $msg->body, "\n";

    $message = json_decode($msg->body,  true);
    $invoker = new Invoker($workspace);

    $event = $message['event'];
    $context =  $message['context'];

    try {
        $result = $invoker->call_lambda_function($lambdaFile, $lambdaHandler, $context, $event);
        $out = json_encode(["success" => "true", "result" => $result]);
        echo ' [x] success: ', json_encode($out),"\n";
    } catch (Error $e) {
        $out = json_encode(["success" => "false", "result" => $e]);
        echo ' [x] error: ', json_encode($out),"\n";
    } catch (Exception $e) {
        $out = json_encode(["success" => "false", "result" => $e]);
        echo ' [x] exception: ', json_encode($out),"\n";
    }
};

$channel->basic_consume('test', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
