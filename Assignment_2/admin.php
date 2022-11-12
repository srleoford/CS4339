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

echo "Welcome to the Admin Page! <br>";

if (!isset($_SESSION['isadmin'])) {
    echo "Please login as an administrator to view this page.";
    echo "<script>
    setTimeout(\"location.href = 'signin.php';\",1500);
    </script>";
}
else {
    echo "<form method='post' action='mainpage.php'> 
              <input type='submit' value='Main Page'> 
              </form>
              <form method='post' action='signin.php'> 
        <input type='submit' name='signedout' value='Sign Out'> 
    </form> ";

    if (isset($_POST['delete']) && isset($_POST['username']))
    {
        $un   = get_post($pdo, 'username');
        $query  = "DELETE FROM users WHERE username=$un";
        $result = $pdo->query($query);
    }

    if (isset($_POST['modify']) &&
        isset($_POST['username']) &&
        isset($_POST['newusername']))
    {
        $un = sanitise($pdo, $_POST['username']);
        $nu = sanitise($pdo, $_POST['newusername']);


        $query = "UPDATE users SET username=$nu WHERE username=$un";
        $result = $pdo->query($query);
    }

    if (isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['forename']) &&
        isset($_POST['surname']))
    {
        $fn = $_POST['forename'];
        $sn = $_POST['surname'];
        $un = $_POST['username'];
        $pw = $_POST['password'];
        $hash = password_hash($pw . DB_HASH, PASSWORD_DEFAULT);


        add_user($pdo, $fn, $sn, $un, $hash);
    }

    echo <<<_END
  <form action="admin.php" method="post"><pre>
     First Name: <input type="text" name="forename">
     Last Name:  <input type="text" name="surname">
     Username:   <input type="text" name="username">
     Password:   <input type="text" name="password">
       <input type="submit" value="Add User">
  </pre></form>
_END;

    echo <<<_END
  <form action="admin.php" method="post"><pre>
     Username:      <input type="text" name="username">
     New Username:  <input type="text" name="newusername">
       <input type="submit" name='modify' value="Modify User">
  </pre></form>
_END;

    $query  = "SELECT * FROM users";
    $result = $pdo->query($query);

    while ($row = $result->fetch())
    {
        $r0 = $row['forename'];
        $r1 = $row['surname'];
        $r2 = $row['username'];
        $r3 = $row['lastlogin'];
        $r4 = $row['created'];
        $r5 = $row['isadmin'];


        if ($r5 === 1)
            $r5 = 'Yes';
        else
            $r5 = 'No';

        echo <<<_END
  <pre>
      Forename:   $r0
      Surname:    $r1
      Username:   $r2
      Last Login: $r3
      Created:    $r4
      isAdmin:    $r5
  </pre>
  <form action='admin.php' method='post'>
  <input type='hidden' name='delete' value='yes'>
  <input type='hidden' name='username' value='$r2'>
  <input type='submit' value='Delete User'></form>
_END;
    }
}

function get_post($pdo, $var)
{
    return $pdo->quote($_POST[$var]);
}

function sanitise($pdo, $str)
{
    $str = htmlentities($str);
    return $pdo->quote($str);
}

function add_user($pdo, $fn, $sn, $un, $pw)
{
    $stmt = $pdo->prepare('INSERT INTO users VALUES(?,?,?,?, DEFAULT, DEFAULT,?)');

    $stmt->bindParam(1, $fn, PDO::PARAM_STR,  32);
    $stmt->bindParam(2, $sn, PDO::PARAM_STR,  32);
    $stmt->bindParam(3, $un, PDO::PARAM_STR,  32);
    $stmt->bindParam(4, $pw, PDO::PARAM_STR, 255);

    $stmt->execute([$fn, $sn, $un, $pw, 0]);
    printf("%d Row inserted.\n", $stmt->rowCount());
}