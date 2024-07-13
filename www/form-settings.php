<h2>Initial Configuration</h2>
<form method="post" action="index.php">

  <p>Please provide the details of your MySQL/MariaDB database or simply take over the development server defaults.</p>

  <label for="db-config">Connection string (e.g. <code>mysql:host=myhost;dbname=mydb</code>)</label>
  <input type="text" name="db-config" size="80" placeholder="mysql:host=myhost;dbname=mydb" value="mysql:host=localhost;dbname=dcache">

  <label for="db-user">Database User</label>
  <input type="text" name="db-user" placeholder="Database user name" value="root">

  <label for="db-pwd">Password</label>
  <input type="text" name="db-pwd" placeholder="No password" value="">

  <label for="db-prefix">Table Prefix</label>
  <input type="text" name="db-prefix" placeholder="Table Prefix" value="dc-">

  <div class="my-4">
    <input type="reset" value="Dev Defaults">
    <input type="submit" name="init-config" value="Save">
  </div>

</form>