<?php
include_once 'connection.php';

//Fetch rating deatails from database
$query = "SELECT rating_number, FORMAT((total_points / rating_number),1) as average_rating FROM view_rating WHERE post_id = 1 AND status = 1";
$result = $db->query($query);
$ratingRow = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="css/rating.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/rating.js"></script>
<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star").spaceo_rating_widget({
        starLength: '5',
        initialValue: '',
        callbackFunctionName: 'processRating',
        imageDirectory: 'img/',
        inputAttr: 'post_id'
    });
});

function processRating(val, attrVal){
    $.ajax({
        type: 'POST',
        url: 'rating.php',
        data: 'post_id=1&points='+val,
        dataType: 'json',
        success : function(data) {
            if (data.status == 'ok') {
                alert('You have rated '+val+' to SPACE-O');
                $('#avgrat').text(data.average_rating);
                $('#totalrat').text(data.rating_number);
            }else{
                alert('please after some time.');
            }
        }
    });
}
</script>
<style type="text/css">
    .overall-rating{font-size: 14px;margin-top: 5px;color: #8e8d8d;}
</style>
<title>SAPCE-O - Rating Blog</title>
</head>
<body>
    <h1>SAPCE-O - Rating Blog</h1>
    <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
    <div class="overall-rating">(Average Rating <span id="avgrat"><?php echo $ratingRow['average_rating']; ?></span>
    Based on <span id="totalrat"><?php echo $ratingRow['rating_number']; ?></span>  rating)</span></div>
    
</body>
</html>