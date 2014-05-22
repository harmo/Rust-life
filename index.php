<?php
session_start();
error_reporting(E_ALL);


define('ROOT_DIR', realpath(dirname(__FILE__)).'/');
define('APP_DIR', ROOT_DIR .'application/');

require(APP_DIR.'config.php');
require(ROOT_DIR.'core/model.class.php');
require(ROOT_DIR.'core/view.class.php');
require(ROOT_DIR.'core/controller.class.php');
require(ROOT_DIR.'core/core.class.php');

global $config;
define('BASE_URL', $config['base_url']);
$core = new Core($config);