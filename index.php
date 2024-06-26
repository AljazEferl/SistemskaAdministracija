<?php
include_once('header.php');

// Funkcija prebere oglase iz baze in vrne polje objektov
function get_ads(){
	global $conn;
	$query = "SELECT ads.*, categories.kategorija FROM ads LEFT JOIN categories ON categories.id = ads.categories_id ORDER BY date DESC ;";
	$res = $conn->query($query);
	$ads = array();
	while($ad = $res->fetch_object()){
		array_push($ads, $ad);
	}
	return $ads;
}

//Preberi oglase iz baze
$ads = get_ads();

//Izpiši oglase
//Doda link z GET parametrom id na oglasi.php za gumb 'Preberi več'
foreach($ads as $ad){
	$img_data = base64_encode($ad->image);
	?>
	<div class="ad">
		<h4><?php echo $ad->title;?></h4>
        <p>Kategorija: <?php echo $ad->kategorija;?></p>
		<a href="ad.php?id=<?php echo $ad->id;?>">
        <img src="data:image/jpg;base64, <?php echo $img_data;?>" width="400"/>
		<!--a href="ad.php?id=<//?php echo $ad->id;?>"><button>Preberi več</button--></a>
	</div>
	<hr/>
	<?php
}


include_once('footer.php');
?>