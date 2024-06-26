<?php
include_once('header.php');

// Funkcija preveri, ali v bazi obstaja uporabnik z določenim imenom in vrne true, če obstaja.
function username_exists($username){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query);
	return mysqli_num_rows($res) > 0;
}

// Funkcija ustvari uporabnika v tabeli users. Poskrbi tudi za ustrezno šifriranje uporabniškega gesla.
function register_user($username, $password, $naslov, $posta, $telefon){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username,);
	$pass = sha1($password);
	$naslov = mysqli_real_escape_string($conn, $naslov);
    $posta = mysqli_real_escape_string($conn, $posta);
    $telefon = mysqli_real_escape_string($conn, $telefon);
    $query = "INSERT INTO users (username, password, naslov, posta, telefon) VALUES ('$username', '$pass', '$naslov', '$posta', '$telefon');";
	if($conn->query($query)){
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

$error = "";
if(isset($_POST["submit"])){
	/*
		VALIDACIJA: preveriti moramo, ali je uporabnik pravilno vnesel podatke (unikatno uporabniško ime, dolžina gesla,...)
		Validacijo vnesenih podatkov VEDNO izvajamo na strežniški strani. Validacija, ki se izvede na strani odjemalca (recimo Javascript), 
		služi za bolj prijazne uporabniške vmesnike, saj uporabnika sproti obvešča o napakah. Validacija na strani odjemalca ne zagotavlja
		nobene varnosti, saj jo lahko uporabnik enostavno zaobide (developer tools,...).
	*/
	//Preveri če se gesli ujemata
	if($_POST["password"] != $_POST["repeat_password"]){
		$error = "Gesli se ne ujemata.";
	}
	//Preveri ali uporabniško ime obstaja
	else if(username_exists($_POST["username"])){
		$error = "Uporabniško ime je že zasedeno.";
	}
	//Podatki so pravilno izpolnjeni, registriraj uporabnika
	else if(register_user($_POST["username"], $_POST["password"],$_POST["naslov"],$_POST["posta"],$_POST["telefon"])){
		header("Location: login.php");
		die();
	}
	//Prišlo je do napake pri registraciji
	else{
		$error = "Prišlo je do napake med registracijo uporabnika.";
	}
}

?>
	<h2>Registracija</h2>
	<form action="register.php" method="POST" class = "form">
		<label>Uporabniško ime (obvezno)</label><input type="text" name="username" /> <br/>
    	<label>Geslo (obvezno)</label><input type="password" name="password" /> <br/>
    	<label>Ponovi geslo (obvezno)</label><input type="password" name="repeat_password" /> <br/>
    	<label>Naslov</label><input type="text" name="naslov" /> <br/>
    	<label>Pošta</label><input type="text" name="posta" />  <br/>
    	<label>Telefon</label><input type="text" name="telefon" /> <br/>
    	<input type="submit" name="submit" value="Pošlji" /> <br/>
		<label><?php echo $error; ?></label>
	</form>
<?php
include_once('footer.php');
?>