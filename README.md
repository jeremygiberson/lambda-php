# Backwards engineering AWS Lambda for PHun and Profit
This project is an exercise in systems building. Using AWS Lambda as an inspiration
this project will attempt to make a similar lambda service for the PHP language. 

Commits to this repository will serve as a work log for the design and implementation efforts.

## Notes on initial design process
Technologies:
  * Docker for services, clustering and scaling
  * PHP - used both for lambda but also for management of services
   

Pieces of the puzzle:
```
                               ↱  queue monitor       ↴
                 ↱ queue monitor => lambda monitor => swarm managment api
lambda sdk => request queue <= request consumer (lambda function)
           ^-  response queue ↲
            
docker-swarm:
  services:
    swarm-manager: provides api for managing docker-swarm
    logs: central service for log aggregation
  lambda-services:  
    message-queue: provides queues for lambda invokation/responses
    message-queue-scalar: using management api and queue metrics, scales message-queue service
    manager: create, update, remove lambda functions
  dynamic-lambda-services:   
    lambda-c230a9f2389: lambda wraper
    lambda-scalar-c230a9f2389: using management api and queue metrics, scales associated lambda service     
```

The sdk pushes an invocation onto the queue and subscribes to the response topic wait for a message w/ request id.
The sdk invocation has a client side timeout that may occur (but invocation may continue), lambda timeout where invocation is terminated mid execution.
```
$sdk->invoke($name, $params, $callback, $options);
```
 
 We will start with sdk support. Later we can make an API Gateway service that provides web server wrappers for function invocation.
 
 We will use cloudformation Lambda for inspiration in defining lambda services.