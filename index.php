<?php

use Symfony\Component\Dotenv\Dotenv;
session_start();
define('PROJECT_ROOT', dirname(__FILE__));

require_once realpath('vendor/autoload.php');
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
require("Bootstrap/App.php");
require "routes/web.php";

use support\lib\core;;
new core();