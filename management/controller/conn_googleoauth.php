<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new Google_Client();
$googleClientId = getenv('GOOGLE_CLIENT_ID');
$googleClientSecret = getenv('GOOGLE_CLIENT_SECRET');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host     = $_SERVER['HTTP_HOST'];
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

$redirectUri = $protocol . $host . $basePath . '/callback.php';

$client->setRedirectUri($redirectUri);

$client->addScope('email');
$client->addScope('profile');

// Redirect ke Google login
header('Location: ' . $client->createAuthUrl());
exit();
