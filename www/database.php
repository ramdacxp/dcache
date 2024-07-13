<?php

class Database
{
  private PDO $pdo;
  private string $prefix = "";

  public function __construct(Config $config)
  {
    if ($config->DbConfig !== "") {
      $this->pdo = new PDO(
        $config->DbConfig,
        $config->DbUser,
        $config->DbPassword
      );
      $this->prefix = $config->DbPrefix;
    }
  }

  public function getNumberOfRows(): int
  {
    $stmt = $this->pdo->prepare("SELECT `id` FROM `" . $this->prefix . "data`");
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function getNumberOfTokens(): int
  {
    $stmt = $this->pdo->prepare("SELECT DISTINCT `token` FROM `" . $this->prefix . "data`");
    $stmt->execute();
    return $stmt->rowCount();
  }
}
