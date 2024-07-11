<h2>Initial Configuration</h2>
<form method="get" action="?action=configure">

  <p>Please provide the details of your MySQL/MariaDB database or simply take over the development server defaults.</p>

  <label for="db-server">Server</label>
  <input type="text" name="db-server" placeholder="Server" value="localhost">

  <label for="db-user">User name</label>
  <input type="text" name="db-user" placeholder="User name" value="root">

  <label for="db-pwd">Password</label>
  <input type="text" name="db-pwd" placeholder="No password" value="">

  <label for="db-name">Database</label>
  <input type="text" name="db-name" placeholder="Database" value="dcache">

  <label for="db-prefix">Table Prefix</label>
  <input type="text" name="db-prefix" placeholder="Table Prefix" value="dc-">

  <div class="my-4">
    <input type="reset" value="Dev Defaults">
    <input type="submit" value="Save">
  </div>

</form>