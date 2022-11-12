<?php
require_once 'login.php';


session_start();

try
{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (\PDOException $e)
{
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (!isset($_SESSION['user'])) {
    echo "Please login to view this page.";
    echo "<script>
    setTimeout(\"location.href = 'signin.php';\",1500);
    </script>";
}
else {
    echo "Welcome to the User Page! <br>";
    $un = $_SESSION['user'];
    $fn = $_SESSION['forename'];
    $sn = $_SESSION['surname'];
    echo "Name: $fn $sn, Username: $un <br>";

    echo "<form method='post' action='mainpage.php'> 
              <input type='submit' value='Main Page'> 
              </form>
              <form method='post' action='signin.php'> 
        <input type='submit' name='signedout' value='Sign Out'> 
    </form> ";
}
