<?php
include_once('header.php');

// Funkcija vstavi nov oglas v bazo. Preveri tudi, ali so podatki pravilno izpolnjeni. 
// Vrne false, če je prišlo do napake oz. true, če je oglas bil uspešno vstavljen.
function edit($id, $title, $desc, $img, $category_id){
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $desc = mysqli_real_escape_string($conn, $desc);
    $user_id = $_SESSION["USER_ID"];
    $date = date('Y-m-d H:i:s');
    //Preberemo vsebino (byte array) slike
    $img_file = file_get_contents($img["tmp_name"]);
    //Pripravimo byte array za pisanje v bazo (v polje tipa LONGBLOB)
    $img_file = mysqli_real_escape_string($conn, $img_file);

    $query = "UPDATE ads SET title='$title', description='$desc', user_id='$user_id', image='$img_file', categories_id='$category_id', date='$date'
              WHERE id='$id'";
	mysqli_query($conn, $query);
	$query = "UPDATE images SET image='$img_file' WHERE ad_id = $id AND isMain = 1";
	mysqli_query($conn, $query);
				
    if ($conn->query($query)) {
        return true;
    } else {
        //Izpis MYSQL napake z: echo mysqli_error($conn); 
        return false;
    }
}

$error = "";
if(isset($_POST["submit"])){
	if(edit($_POST["iduredi2"],$_POST["title"], $_POST["description"], $_FILES["image"],$_POST["category"])){
		header("Location: index.php");
		die();
	}
	else{
		$error = "Prišlo je do našpake pri objavi oglasa.";
	}
}
?>
<h2>Urejanje oglasa</h2>
	<form action="edit.php" method="POST" enctype="multipart/form-data">
	<label for="category">Izberi kategorijo:</label>
		<select name="category" id="category">
			<?php
				$sql = "SELECT id, kategorija FROM categories";
				$result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						echo '<option value="' . $row['id'] . '">' . $row['kategorija'] . '</option>';
					}
				}
			?>
		</select>
		<br/><br/>
		<label>Naslov</label><input type="text" name="title" /> <br/>
		<label>Vsebina</label><br/><textarea name="description" rows="10" cols="50"></textarea> <br/>
		<label>Slika</label><input type="file" name="image" /> <br/>
		<input type="submit" name="submit" value="Objavi" /> <br/>
		<input type="hidden" name="iduredi2" value="<?php echo $_POST["iduredi"]; ?>">
		<label><?php echo $error; ?></label>
	</form>