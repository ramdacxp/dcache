<?php

class Config
{
  public $ConfigFilename = __DIR__ . DIRECTORY_SEPARATOR . 'settings.php';
  public $DatabaseServer = "";
  public $DatabaseUser = "";
  public $DatabasePassword = "";
  public $DatabaseName = "";
  public $DatabasePrefix = "";

  public function isConfigured(): bool
  {
    return file_exists($this->ConfigFilename);
  }

  public function canBeConfigured(): bool
  {
    return is_writeable(__DIR__);
  }

  public function loadIfConfigured(): bool
  {
    if (!$this->isConfigured()) return false;
    require_once $this->ConfigFilename;
    $this->DatabaseServer = $settings['server'];
    $this->DatabaseUser = $settings['user'];
    $this->DatabasePassword = $settings['password'];
    $this->DatabaseName = $settings['database'];
    $this->DatabasePrefix = $settings['prefix'];
    return true;
  }

  public function saveSettingsForm(): bool
  {
    if ($this->isConfigured()) return false;
    if (!$this->canBeConfigured()) return false;
    if (!isset($_GET['db-server'])) return false;
    if (!isset($_GET['db-user'])) return false;
    if (!isset($_GET['db-pwd'])) return false;
    if (!isset($_GET['db-name'])) return false;
    if (!isset($_GET['db-prefix'])) return false;

    $settings = "<" . "?php\n"
      . "\$settings = [];\n"
      . $this->getSettingsArrayStatement('server', $_GET['db-server'])
      . $this->getSettingsArrayStatement('user', $_GET['db-user'])
      . $this->getSettingsArrayStatement('password', $_GET['db-pwd'])
      . $this->getSettingsArrayStatement('database', $_GET['db-name'])
      . $this->getSettingsArrayStatement('prefix', $_GET['db-prefix']);

    file_put_contents($this->ConfigFilename, $settings);
    return true;
  }

  private function getSettingsArrayStatement($key, $value)
  {
    return "\$settings[\"" . $key . "\"] = " . json_encode($value) . ";\n";
  }
}
