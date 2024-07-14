<h2>Select Dataset</h2>
<form name="showToken" method="get" action="index.php">

  <p>
    <i>dcache</i> provides a REST API to exchange datasets, which are identified by <i>data tokens</i>.
    Everybody with access to a data token can view and modify the related data set.
    So keep your data tokens secret.
  </p>
  <p class="mt-4">
    Use this form to enter a known <i>data token</i> in order to view details of the related data set.
  </p>

  <label for="token">Data Token</label>
  <input type="text" name="token" size="66" placeholder="Data Token">

  <div id="validation" class="mt-4 text-red-600 hidden">Please enter a valid data token.</div>

  <div class="mt-4">
    <button onclick="return validate()">Show Details</button>
  </div>

</form>

<script type="text/javascript">
  function validate(action) {
    if (document.forms.showToken.token.value == '') {
      document.getElementById('validation').classList.remove('hidden');
      return false;
    }

    document.forms.showToken.submit();
    return true;
  }
</script>