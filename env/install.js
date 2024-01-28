const runProcess = require('./runProcess');

runProcess('composer install');
runProcess('yarn');
runProcess('yarn gulp install');
