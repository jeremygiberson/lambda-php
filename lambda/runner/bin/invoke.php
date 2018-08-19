<?php
require 'vendor/autoload.php';


use PHPLambda\Lambda\Invoker;

$options = getopt("f:h:w:");
// IF missing file, handler or workdir params return error
$serializedInput = file_get_contents("/var/io/stdin.io");
$invocationParams = unserialize($serializedInput);

var_dump($options, $serializedInput, $invocationParams);

if(!$options['w'] || !$options['h'] || !$options['f']) {
    throw new Error("invoke was not called correctly. Usage `php invoke.php -w -h -f");
}

ob_start();
try {
    $invoker = new Invoker($options['w']);
    $result = $invoker->call_lambda_function($options['f'], $options['h'], $invocationParams->context, $invocationParams->event);
    print(serialize($result));
} catch (Exception $e) {
    ob_start();
    var_dump($e);
    $err = ob_get_clean();
    file_put_contents("/var/io/stderr.io", $err);
}
$out = ob_get_clean();

file_put_contents("/var/io/stdout.io", $out);