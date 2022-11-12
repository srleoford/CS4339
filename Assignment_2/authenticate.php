<?php // authenticate.php
require_once 'login.php';

try
{
  $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (\PDOException $e)
{
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST['username']) &&
    isset($_POST['password']))
{
  $un_temp = sanitise($pdo, $_POST['username']);
  $pw_temp = sanitise($pdo, $_POST['password']);
  $query   = "SELECT * FROM users WHERE username=$un_temp";
  $result  = $pdo->query($query);

  if (!$result->rowCount()) die("User not found");

  $row = $result->fetch();
  $fn  = $row['forename'];
  $sn  = $row['surname'];
  $un  = $row['username'];
  $pw  = $row['password'];
  $isadmin = $row['isadmin'];


  if (password_verify(str_replace("'", "", $pw_temp . DB_HASH), $pw))
  {
    session_start();

    $_SESSION['forename'] = $fn;
    $_SESSION['surname']  = $sn;
    $_SESSION['user'] = $un;

    $updateLastLogin = "UPDATE users SET lastlogin=CURRENT_TIMESTAMP WHERE username=$un_temp";
    $result = $pdo->query($updateLastLogin);

    echo htmlspecialchars("Hi $fn $sn,
        you are now logged in as '$un'");

    if ($row['isadmin']) {
      $_SESSION['isadmin'] = true;
      die ("<p><a href='mainpage.php'>Click here to go to main page</a></p>" .
          "<p><a href='admin.php'>Click here to go to admin page</a></p>" .
          "<p><a href='user.php'>Click here to go to user page</a></p>");
    }
    else {
      die ("<p><a href='mainpage.php'>Click here to go to main page</a></p>" .
          "<p><a href='user.php'>Click here to go to user page</a></p> <br>");
    }
  }
  else die("Invalid username/password combination");
}
else
{
  header('WWW-Authenticate: Basic realm="Restricted Area"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Please enter your username and password");
}

function sanitise($pdo, $str)
{
  $str = htmlentities($str);
  return $pdo->quote($str);
}
?>
