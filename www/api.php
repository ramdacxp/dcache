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
    if ($_REQUEST['method'] === "delete") {
      handleDelete($db, $_REQUEST['token'], $_REQUEST['property']);
    } elseif (isset($_REQUEST['value'])) {
      handleGetUpdate($db, $_REQUEST['token'], $_REQUEST['property'], $_REQUEST['value']);
    } else {
      handleGet($db, $_REQUEST['token'], $_REQUEST['property']);
    }
    break;

  case "POST":
    handlePost($db, $_REQUEST['token'], $_SERVER['CONTENT_TYPE']);
    break;

  case "DELETE":
    handleDelete($db, $_REQUEST['token'], $_REQUEST['property']);
    break;

  default:
    Rest::respondError(Rest::CODE_500_INTERNAL_SERVER_ERROR, "Not implemented.");
    break;
}

// phpinfo(INFO_VARIABLES);
exit();

// =============================================================================

function validateToken($token): bool
{
  if (!isset($token) || is_null($token) || empty($token)) {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "No token given.");
    return false;
  }

  if (strlen($token) < 8) {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "Token is too short. Must be at least 8 characters long.");
    return false;
  }

  if (!preg_match('/^[a-zA-Z0-9\.-]+$/', $token)) {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "Token contains invalid characters. Only letters, numbers, dots and dashes are allowed.");
    return false;
  }

  return true;
}

function handleGet($db, $token, $property)
{
  if (!validateToken($token)) return;

  $data = $db->getData($token);

  if (isset($property)) {
    if (isset($data[$property])) {
      Rest::respond(Rest::CODE_200_OK, $data[$property]);
    } else {
      Rest::respondError(Rest::CODE_404_NOT_FOUND, "Property not found in dataset.");
    }
  } else {
    if ($data !== null) {
      Rest::respond(Rest::CODE_200_OK, $data);
    } else {
      Rest::respondError(Rest::CODE_404_NOT_FOUND, "Dataset not found.");
    }
  }
}

function handleGetUpdate($db, $token, $property, $value)
{
  if (!validateToken($token)) return false;

  if (!isset($property) || is_null($property) || empty($property)) {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "No property given.");
    return false;
  }

  $db->deleteProperty($token, $property);
  $db->insertProperty($token, $property, $value);

  $data = $db->getData($token);
  Rest::respond(Rest::CODE_200_OK, $data);
}

function handlePost($db, $token, $contentType)
{
  if (!validateToken($token)) return;

  if ($contentType !== "application/json") {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "Invalid content type. Expected application/json.");
    return;
  }

  $input = json_decode(file_get_contents('php://input'), true);
  if ($input === null) {
    Rest::respondError(Rest::CODE_400_BAD_REQUEST, "Content is not valid JSON.");
    return;
  }

  // update all given properties
  foreach ($input as $key => $value) {
    $db->deleteProperty($token, $key);
    $db->insertProperty($token, $key, $value);
  }

  // done - return new/updated dataset
  $data = $db->getData($token);
  Rest::respond(Rest::CODE_200_OK, $data);
}

function handleDelete($db, $token, $name = null)
{
  if (!validateToken($token)) return;

  if (!empty($name)) {
    $db->deleteProperty($token, $name);
  } else {
    $db->deleteData($token);
  }

  Rest::respond(Rest::CODE_200_OK, true);
}
