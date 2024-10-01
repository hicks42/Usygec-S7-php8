<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (is_array($env = @include dirname(__DIR__) . '/.env.local.php')) {
  $_SERVER += $env;
  $_ENV += $env;
} elseif (file_exists(dirname(__DIR__) . '/.env')) {
  (new Dotenv())->loadEnv(dirname(__DIR__) . '/.env');
}

$authFiles = [
  'vault/DKIM_key.txt' => 'DKIM_KEY',
  'vault/db/password.txt' => 'DB_PASSWORD',
  'vault/jwt/private.pem' => 'JWT_PRIVATE_KEY',
  'vault/jwt/public.pem' => 'JWT_PUBLIC_KEY',
  'vault/mailgun/password.txt' => 'MAILGUN_PASSWORD',
  'vault/mailjet/private.txt' => 'MAILJET_PRIVATE_KEY',
  'vault/mailjet/public.txt' => 'MAILJET_PUBLIC_KEY',
  'vault/recaptcha/key.txt' => 'RECAPTCHA_KEY',
  'vault/recaptcha/secret.txt' => 'RECAPTCHA_SECRET',
];

foreach ($authFiles as $filePath => $envVar) {
  $fullPath = dirname(__DIR__) . "/{$filePath}";
  if (file_exists($fullPath)) {
    $fileContent = trim(file_get_contents($fullPath));
    $_ENV[$envVar] = $fileContent;
    $_SERVER[$envVar] = $fileContent;
  }
}
