<?php
include_once('header.php');

// Check if user is logged in
if(!isset($_SESSION["USER_ID"])){
    // Redirect to login page
    header("Location: login.php");
    die();
}
$user_id = $_SESSION['USER_ID'];

// Get ads published by the user
function get_user_ads($user_id){
    global $conn;
    $query = "SELECT ads.*, categories.kategorija 
              FROM ads 
              LEFT JOIN categories ON categories.id = ads.categories_id 
              WHERE ads.user_id = $user_id
              ORDER BY date DESC;";
    $res = $conn->query($query);
    $ads = array();
    while($ad = $res->fetch_object()){
        array_push($ads, $ad);
    }
    return $ads;
}

// Delete ad if requested
if(isset($_POST["delete"])){
    $ad_id = $_POST["ad_id"];
    $query = "DELETE FROM ads WHERE id=$ad_id AND user_id=$user_id;";
    $conn->query($query);
    $query = "DELETE FROM images WHERE ad_id=$ad_id;";
    $conn->query($query);
}

// Preberi oglase iz baze
$ads = get_user_ads($user_id);

foreach($ads as $ad):
    // Convert image to base64
    $img_data = base64_encode($ad->image);
?>
    <div class="ad">
        <h4><?php echo $ad->title;?></h4>
        <p><?php echo $ad->description;?></p>
        <img src="data:image/jpg;base64, <?php echo $img_data;?>" width="400"/>
        <p>Datum: <?php echo $ad->date; ?></p>
        <a href="index.php"><button>Nazaj</button></a>

        <!-- Edit form -->
        <form action="edit.php" method="POST" style="display:inline-block;">
            <input type="hidden" name="iduredi" value="<?php echo $ad->id; ?>">
            <input type="hidden" name="title" value="<?php echo $ad->title; ?>">
            <input type="hidden" name="category" value="<?php echo $ad->kategorija; ?>">
            <input type="hidden" name="description" value="<?php echo $ad->description; ?>">
            <input type="hidden" name="image_data" value="<?php echo $img_data; ?>">
            <button type="submit" name="uredi">Uredi</button>
        </form>

        <!-- Delete form -->
        <form method="POST" action="myAds.php" style="display:inline-block;">
            <input type="hidden" name="ad_id" value="<?php echo $ad->id;?>">
            <button type="submit" name="delete">Izbrisi</button>
        </form>

        <hr/>
    </div>
<?php endforeach; ?>