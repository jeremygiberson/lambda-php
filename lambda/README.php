# invocation.php
Responsible for executing the function and returning the result
```bash
php invocation.php --file=index.php --function=Greeting.hello --workdir=./test/hello < O:8:"stdClass":1:{s:4:"name";s:3:"Bob";} > ./test/hello/out.ser
```

# worker.php
Responsible for getting work from the queue, passing it to invocation and reading the result to send reply
```bash
php worker.php --queue=myGreeterFunction
```
