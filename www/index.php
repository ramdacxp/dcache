<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';

$config = new Config();
$config->saveSettingsForm();
$config->loadIfConfigured();
$db = new Database($config);
?>
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles.css" rel="stylesheet">
  <title>dcache</title>
</head>

<body class="bg-gray-300">
  <div class="container mx-auto">

    <nav class="bg-slate-400 text-white rounded-t-lg mt-4 p-4 shadow-lg">
      <div class="text-3xl">
        <a href="<?= $_SERVER['PHP_SELF'] ?>">dcache</a>
      </div>
    </nav>

    <main class="bg-white shadow-x-lg p-4">

      <!-- Show DB settings of form -->
      <?php if ($config->isConfigured()) { ?>
        <p>
          This <i>dcache</i> holds
          <code><?= $db->getNumberOfRows() ?></code> values in
          <code><?= $db->getNumberOfTokens() ?></code> sets.
        </p>
      <?php } else if ($config->canBeConfigured()) {
        include __DIR__ . DIRECTORY_SEPARATOR . 'form-settings.php';
      } ?>

      <!--  -->
      <?php if ($config->isConfigured()) {
      } ?>

    </main>

    <footer class="text-gray-500 bg-gray-200 rounded-b-lg p-4 shadow-lg text-center border-t border-gray-300">
      Copyright &copy; 2024 Michael Hoser
      &mdash;
      Made with 🖤 on <a href="https://github.com/ramdacxp/dcache" class="hover:underline">GitHub</a>.
    </footer>

  </div>
</body>

</html>