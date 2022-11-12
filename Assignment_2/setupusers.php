<?php //setupusers.php
  require_once 'login.php';

  echo "Setting up users...";
  try
  {
    $pdo = new PDO($attr, $user, $pass, $opts);
  }
  catch (\PDOException $e)
  {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }

  $query = "CREATE TABLE users (
    forename VARCHAR(32) NOT NULL,
    surname  VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    lastlogin timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    isadmin BOOLEAN DEFAULT FALSE
  )";

$result = $pdo->query($query);

$forename = 'admin';
$surname  = 'admin';
$username = 'admin';
$password = 'nimda22';
$hash     = password_hash($password . DB_HASH, PASSWORD_DEFAULT);

add_user($pdo, $forename, $surname, $username, $hash);

$forename = 'Pauline';
$surname  = 'Jones';
$username = 'pjones';
$password = 'acrobat';
$hash     = password_hash($password . DB_HASH, PASSWORD_DEFAULT);

add_user($pdo, $forename, $surname, $username, $hash);

  function add_user($pdo, $fn, $sn, $un, $pw)
  {
    $stmt = $pdo->prepare('INSERT INTO users VALUES(?,?,?,?, DEFAULT, DEFAULT,?)');

    $stmt->bindParam(1, $fn, PDO::PARAM_STR,  32);
    $stmt->bindParam(2, $sn, PDO::PARAM_STR,  32);
    $stmt->bindParam(3, $un, PDO::PARAM_STR,  32);
    $stmt->bindParam(4, $pw, PDO::PARAM_STR, 255);

    $stmt->execute([$fn, $sn, $un, $pw, 0]);
  }

function add_admin($pdo, $fn, $sn, $un, $pw)
{
  $stmt = $pdo->prepare('INSERT INTO users VALUES(?,?,?,?, DEFAULT, DEFAULT,?)');

  $stmt->bindParam(1, $fn, PDO::PARAM_STR,  32);
  $stmt->bindParam(2, $sn, PDO::PARAM_STR,  32);
  $stmt->bindParam(3, $un, PDO::PARAM_STR,  32);
  $stmt->bindParam(4, $pw, PDO::PARAM_STR, 255);

  $stmt->execute([$fn, $sn, $un, $pw, 1]);
}
?>
