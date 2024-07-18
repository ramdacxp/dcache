<?php $jsonUrl = 'api.php?token=' . $_GET['token']; ?>

<h2>Dataset Details</h2>

<p>
  The <i>data set</i> related to the token
  <code><?= $_GET['token'] ?></code>
  contains the following
  <code><?= count($data) ?></code>
  properties:
</p>

<form name="addform" method="get" action="api.php" target="_blank">
  <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
  <table class="datatable mt-4">
    <tr>
      <th>Name</th>
      <th>Value</th>
      <th>Links</th>
    </tr>
    <?php foreach ($data as $key => $value) { ?>
      <tr>
        <td><?= $key ?></td>
        <td>
          <code><?= $value ?></code>
        </td>
        <td>
          <a class="underline decoration-dotted hover:decoration-solid text-slate-600" href="<?= $jsonUrl ?>&property=<?= $key ?>" target="_blank">JSON</a>
          |
          <a class="underline decoration-dotted hover:decoration-solid text-red-600" href="<?= $jsonUrl ?>&property=<?= $key ?>&method=delete" target="_blank">Delete</a>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <td>
        <input name="property" type="text" placeholder="Property Name">
      </td>
      <td>
        <input name="value" type="text" placeholder="New Value">
      </td>
      <td>
        <a class="underline decoration-dotted hover:decoration-solid text-slate-600" href="javascript:addform.submit();">Add</a>
      </td>
    </tr>
  </table>
</form>


<p class="mt-4">
  This data set is available as <code>JSON Object</code> at:
  <a href="<?= $jsonUrl ?>" target="_blank"><code>/<?= $jsonUrl ?></code></a>
</p>

<div class="mt-4">
  <button onclick="document.location.href='index.php'">&ltcc; Back</button>
  <button onclick="window.location.reload()">Refresh</button>
</div>