<?php
session_start();
$username = "";
//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800) {
  session_regenerate_id(true);
}
$_SESSION['LAST_ACTIVITY'] = time();

//Poveži se z bazo
$conn = new mysqli('localhost', 'root', '', 'vaja1');
//Nastavi kodiranje znakov, ki se uporablja pri komunikaciji z bazo
$conn->set_charset("UTF8");

if (isset($_SESSION["USER_ID"])) {
  $user_id = $_SESSION["USER_ID"];
  $query = "SELECT * FROM users WHERE id='$user_id'";
  $res = $conn->query($query);
  if ($user_obj = $res->fetch_object()) {
    $username = $user_obj->username;
  }
}
?>
<html>

<head>
  <title>Vaja 1</title>
  <link rel="stylesheet" href="header_style.css">
</head>

<body>
  <div id=header>
    <h1>OGLASNIK<?php echo isset($_SESSION["USER_ID"]) ? " - Dobrodošel/a, " . $username : ''; ?></h1>
    <nav>
      <ul>
        <li><a href="index.php">Domov</a></li>
        <?php
        if (isset($_SESSION["USER_ID"])) {

        ?>
          <li><a href="publish.php">Objavi oglas</a></li>
          <li><a href="myads.php">Moji oglasi</a></li>
          <li><a href="logout.php">Odjava</a></li>
        <?php
        } else {
        ?>
          <li><a href="login.php">Prijava</a></li>
          <li><a href="register.php">Registracija</a></li>
        <?php
        }
        ?>
      </ul>
    </nav>

  </div>
</body>

</html>