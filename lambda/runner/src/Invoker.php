<?php


namespace PHPLambda\Lambda;


class Invoker
{
    private $workDir;
    /**
     * Invoker constructor.
     */
    public function __construct($workDir)
    {
        $this->workDir=$workDir;
    }

    public function call_lambda_function($file, $name, array $context = [], array $event = []){
        // todo prevent path backtracking
        // todo prevent absolute path
        // todo path should start in working directory and stay there
        require_once "{$this->workDir}/{$file}";
        return call_user_func($name, $context, $event);
    }
}