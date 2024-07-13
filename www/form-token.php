<h2>Choose Dataset</h2>
<form name="showToken" method="get" action="index.php">

  <p>
    <i>dcache</i> receives data sets, which are identified by secret <i>data tokens</i>.
    Everybody with access to a data token can see and modify the related data set.
    So make sure, that your tokens are well hidden and not too simple to be guessed.
  </p>
  <p class="mt-4">
    Use this form to enter a known <i>data token</i> in order to see the currently cached data.
  </p>

  <input type="hidden" name="action" value="">

  <label for="token">Data Token</label>
  <input type="text" name="token" size="66" placeholder="Data Token">

  <div id="validation" class="mt-4 text-red-600 hidden">Please enter a valid data token.</div>

  <div class="mt-4">
    <button onclick="return send('show')">Show Data</button>
    <button onclick="return send('json')">JSON</button>
  </div>

</form>

<script type="text/javascript">
  function send(action) {
    if (document.forms.showToken.token.value == '') {
      document.getElementById('validation').classList.remove('hidden');
      return false;
    }

    document.forms.showToken.action.value = action;
    document.forms.showToken.submit();
    return true;
  }
</script>