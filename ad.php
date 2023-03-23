<?php 
include_once('header.php');

//Funkcija izbere oglas s podanim ID-jem. Doda tudi uporabnika, ki je objavil oglas.
function get_ad($id){
	global $conn;
	$id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT ads.*, users.username FROM ads LEFT JOIN users ON users.id = ads.user_id LEFT JOIN categories ON categories.id = ads.categories_id  WHERE ads.id = $id;";
	$res = $conn->query($query);
	if($obj = $res->fetch_object()){
		return $obj;
	}
	return null;
}

if(isset($_SESSION["USER_ID"])){
    $user_id = $_SESSION["USER_ID"];
    $ad_id = $_GET["id"];

    
    $query = "SELECT * FROM views WHERE user_id='$user_id' AND ad_id='$ad_id'";
    $res = $conn->query($query);
    
    if($res->num_rows == 0){
        $insert_query = "INSERT INTO views(user_id, ad_id) VALUES ('$user_id', '$ad_id')";
        $conn->query($insert_query);

		
		$update_query = " UPDATE ads SET viewsCount = viewsCount + 1 WHERE id = '$ad_id'";
        $conn->query($update_query);
    }
}


if(!isset($_GET["id"])){
	echo "Manjkajoči parametri.";
	die();
}
$id = $_GET["id"];
$ad = get_ad($id);
if($ad == null){
	echo "Oglas ne obstaja.";
	die();
}
//Base64 koda za sliko (hexadecimalni zapis byte-ov iz datoteke)
$img_data = base64_encode($ad->image);
?>
	<div class="ad">
		<h4><?php echo $ad->title;?></h4>
		<p><?php echo $ad->description;?></p>
		<!--img src="data:image/jpg;base64, <//?php echo $img_data;?>" width="400"/-->
		<?php 
		$query = "SELECT * FROM  images WHERE ad_id = $ad->id";
		$res = $conn->query($query);
		while ($row = $res->fetch_assoc()){
			$path = $row["image"];
			$isMain = $row["isMain"];
			$img_data = base64_encode($path);
			if($isMain == 1){
				echo '<img src="data:image/jpg;base64,  '.$img_data.' " width="400"/><br/>';
			} 
			else { 
				echo '<img src="data:image/jpg;base64,  '.$img_data.' " width="133" height="133"/>';
			}
		}
		?> 
		<p>Število ogledov: <?php echo $ad->viewsCount; ?></p>
		<p>Objavil: <?php echo $ad->username; ?></p>
		<p>Datum: <?php echo $ad->date; ?></p>
		<a href="index.php"><button>Nazaj</button></a>
	</div>
	<hr/>
	<?php

include_once('footer.php');
?>