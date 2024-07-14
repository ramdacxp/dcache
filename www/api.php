<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'rest.php';

$config = new Config();
$config->saveSettingsForm();
$config->loadIfConfigured();

// Ensure configured server
if (!$config->isConfigured()) {
  Rest::respondError(Rest::CODE_500_INTERNAL_SERVER_ERROR, "Not configured.");
  exit();
}

$db = new Database($config);

switch ($_SERVER['REQUEST_METHOD']) {
  case "GET":
    handleGet($db, $_GET['token'], $_GET['property']);
    break;

  case "POST":
    Rest::respondError(Rest::CODE_500_INTERNAL_SERVER_ERROR, "Not implemented.");
    break;

  case "DELETE":
    Rest::respondError(Rest::CODE_500_INTERNAL_SERVER_ERROR, "Not implemented.");
    break;
}

// phpinfo(INFO_VARIABLES);
exit();

// =============================================================================

function handleGet($db, $token, $property)
{
  if (!isset($token)) {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "No token given.");
  } else {
    $data = $db->getData($_GET['token']);

    if (isset($property)) {
      if (isset($data[$property])) {
        Rest::respond(Rest::CODE_200_OK, $data[$property]);
      } else {
        Rest::respond(Rest::CODE_404_NOT_FOUND, null);
      }
    } else {
      if ($data !== null) {
        Rest::respond(Rest::CODE_200_OK, $data);
      } else {
        Rest::respond(Rest::CODE_404_NOT_FOUND, null);
      }
    }
  }
}
