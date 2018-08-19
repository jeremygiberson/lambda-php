# Docker Invocation
```
docker run -v "$PWD/io":/var/io -v "$PWD/task":/var/task -e LAMBDA_FILE=handler.php -e LAMBDA_HANDLER=hello lambda-php/worker:latest
```
# worker.php
```
php bin/trigger.php; LAMBDA_FILE=handler.php LAMBDA_HANDLER=hello LAMBDA_WORKSPACE="../task" php bin/worker.php
```

# invocation.php
Responsible for executing the function and returning the result
```bash
echo O:8:"stdClass":1:{s:4:"name";s:3:"Bob";} | php invocation.php --file=index.php --function=Greeting.hello --workdir=./test/hello > ./test/hello/out.ser
```

```bash
echo 'O:37:"PHPLambda\Lambda\InvocationParameters":2:{s:7:"context";a:1:{s:3:"foo";s:3:"bar";}s:5:"event";a:1:{s:3:"biz";s:3:"buz";}}' |  php bin/invoke.php -w ./ -f handler.php -h hello
```

# worker.php
Responsible for getting work from the queue, passing it to invocation and reading the result to send reply
```bash
php worker.php --queue=myGreeterFunction
```
