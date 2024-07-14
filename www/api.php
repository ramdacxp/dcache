<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'rest.php';

$config = new Config();
$config->saveSettingsForm();
$config->loadIfConfigured();

if (!$config->isConfigured()) {
  Rest::respondError(Rest::CODE_500_INTERNAL_SERVER_ERROR, "Not configured.");
} elseif (!isset($_GET['token'])) {
  Rest::respondError(Rest::CODE_400_BAD_REQUEST, "No token given.");
} else {
  $db = new Database($config);
  $data = $db->getData($_GET['token']);
  if ($data === null) {
    Rest::respond(Rest::CODE_404_NOT_FOUND, null);
  } else {
    Rest::respond(Rest::CODE_200_OK, $data);
  }
}
