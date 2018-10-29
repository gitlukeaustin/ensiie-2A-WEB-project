<?php
require '../vendor/autoload.php';

@ob_start();
session_start();

if(!isset($_SESSION['uniqid']) && !isset($_SESSION['login'])){
    require 'index.php';
    exit();
}