<?php


namespace PHPLambda\Lambda;


class Worker
{
    public function work($message){
        // open a process w/ stdin,stdout,stderr
        // write message to stdin, close stdin
        // when process completes read stdout,stderr
        // complete message
    }
}