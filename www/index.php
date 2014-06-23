<?php

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getService('application')->run();
