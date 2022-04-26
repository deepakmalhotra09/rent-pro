<?php

require_once "router.php";

route('/', function () {
     include 'src/common/pages/login.php';
});

route('/login', function () {
    include 'src/common/pages/login.php';
});


$action = $_SERVER['REQUEST_URI'];
dispatch($action);

?>