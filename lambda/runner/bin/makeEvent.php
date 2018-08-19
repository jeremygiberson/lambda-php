<?php
require 'vendor/autoload.php';

use PHPLambda\Lambda\InvocationParameters;




$params = new InvocationParameters();
$params->context = ["foo"=>"bar"];
$params->event = ["biz"=>"buz"];

echo escapeshellarg(serialize($params));