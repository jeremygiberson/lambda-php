<?php
use PHPLambda\Lambda\Invoker;

class InvokerTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testItExecutesGloballyDefinedFunction(){
        $invoker = new Invoker(__DIR__ . '/functions');
        $result = $invoker->call_lambda_function('global.php', 'foo');
        self::assertEquals('bar', $result, 'return value');
    }

    public function testItExecutesNamespaceFunction(){
        $invoker = new Invoker(__DIR__ . '/functions');
        $result = $invoker->call_lambda_function('namespace.php', 'Fiz\\foo');
        self::assertEquals('baz', $result, 'return value');
    }

    public function testItExecutesClassStaticMethod(){
        $invoker = new Invoker(__DIR__ . '/functions');
        $result = $invoker->call_lambda_function('staticMethod.php', 'Baz::foo');
        self::assertEquals('bar', $result, 'return value');
    }

    public function testItExecutesNamespaceClassStaticMethod(){
        $invoker = new Invoker(__DIR__ . '/functions');
        $result = $invoker->call_lambda_function('namespaceStaticMethod.php', 'Fuz\\Baz::foo');
        self::assertEquals('bar', $result, 'return value');
    }

    public function testItPassesContextAndEventToHandler(){
        $context = [ 0 => 0, 1 => "one", "string"=>"string", "float" => 3.14159,
            "bool"=> false, "object" => (object)["fiz"=>"buz"], "array"=> [1,2,3]];
        $event = [ 3 => 0, 4 => "four", "string"=>"b string", "float" => 6.28,
            "bool"=> true, "object" => (object)["foo"=>"bar"], "array"=> [4,5,7]];

        $invoker = new Invoker(__DIR__ . '/functions');
        $result = $invoker->call_lambda_function('global.php', 'inAndOut', $context, $event);
        self::assertEquals((object)["context" => $context, "event" => $event], $result, 'return value');
    }


}
