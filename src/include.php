<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(dirname(__FILE__) .'/../');
$dotenv->load();