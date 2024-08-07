<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'database.php';

$config = new Config();
$config->saveSettingsForm();
$config->loadIfConfigured();

if ($config->isConfigured()) {
  $db = new Database($config);
  $data = isset($_GET['token']) ? $db->getData($_GET['token']) : null;
}

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

      <?php
      if (!$config->isConfigured()) {
        if ($config->canBeConfigured()) {
          include __DIR__ . DIRECTORY_SEPARATOR . 'form-settings.php';
        }
      } else {
        // START CONFIGURED SERVER =============================================
      ?>

        <!-- Status -->
        <p>
          This <i>dcache</i> holds
          <code><?= $db->getNumberOfRows() ?></code> properties in
          <code><?= $db->getNumberOfTokens() ?></code> data sets.
        </p>

        <!-- Forms -->
        <?php
        if ($data !== null) {
          include __DIR__ . DIRECTORY_SEPARATOR . 'form-show.php';
        } else {
          include __DIR__ . DIRECTORY_SEPARATOR . 'form-token.php';
        }
        ?>

      <?php
        // END CONFIGURED SERVER ===============================================
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