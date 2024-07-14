<h2>View Data</h2>

<p>
  The <i>data set</i> related to the token
  <code><?= $_GET['token'] ?></code>
  contains the following properties:
</p>

<table class="datatable mt-4">
  <tr>
    <th>Name</th>
    <th>Value</th>
  </tr>
  <?php foreach ($data as $key => $value) { ?>
    <tr>
      <td><?= $key ?></td>
      <td>
        <code><?= $value ?></code>
      </td>
    </tr>
  <?php } ?>
</table>

<?php $jsonUrl = '/api.php?token=' . $_GET['token']; ?>

<p class="mt-4">
  This data set is available as <code>JSON Object</code> at:
  <a href="<?= $jsonUrl ?>" target="_blank"><code><?= $jsonUrl ?></code></a>
</p>

<div class="mt-4">
  <button onclick="document.location.href='index.php'">&ltcc; Back</button>
  <button onclick="window.location.reload()">Refresh</button>
</div>