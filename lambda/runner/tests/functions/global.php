<?php
function foo() {
    return "bar";
}

function inAndOut($context, $event) {
    return (object)["context" =>$context, "event" => $event];
}