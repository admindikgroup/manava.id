<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$client = new Google_Client();
$googleClientId = $_ENV['GOOGLE_CLIENT_ID'];
$googleClientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];

$client->setClientId($googleClientId);
$client->setClientSecret($googleClientSecret);

$client->addScope('email');
$client->addScope('profile');
$client->setRedirectUri('http://localhost:8080/mng_dik-main/management/callback.php');

// Redirect ke Google login
header('Location: ' . $client->createAuthUrl());
exit();
