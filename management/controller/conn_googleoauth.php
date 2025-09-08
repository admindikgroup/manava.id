<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new Google_Client();
$googleClientId = getenv('GOOGLE_CLIENT_ID');
$googleClientSecret = getenv('GOOGLE_CLIENT_SECRET');
$client->setRedirectUri('http://localhost:8080/mng_dik-main/management/callback.php');
$client->addScope('email');
$client->addScope('profile');

// Redirect ke Google login
header('Location: ' . $client->createAuthUrl());
exit();
