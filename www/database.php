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

  public function getData(string $token): ?array
  {
    if ($token == '') return null;

    $stmt = $this->pdo->prepare("SELECT `name`, `value` FROM `" . $this->prefix . "data` WHERE (`token`=?)");
    $stmt->execute([$token]);

    if ($stmt->rowCount() < 1) return null;

    $result = [];
    $assoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($assoc as $row) {
      $result[$row['name']] = $row['value'];
    }
    return $result;
  }
}
