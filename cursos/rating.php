<?php
/**
    Código de terceiro
    Author: CodexWorld
    Author URL: http://www.codexworld.com/
    Author Email: contact@codexworld.com
    Tutorial Link: http://www.codexworld.com/star-rating-system-with-jquery-ajax-php/
 */
include_once '../core/conf/dbConfig.php';
if(!empty($_POST['ratingPoints'])){
    $postID = $_POST['postID'];
    $ratingNum = 1;
    $ratingPoints = $_POST['ratingPoints'];
    $usuario_id = $_POST['usuario_id'];
    $curso_id = $_POST['curso_id'];
    //Check the rating row with same post ID
    $prevRatingQuery = "SELECT * FROM post_rating WHERE  usuario_id = ".$usuario_id. " AND curso_id = ".$curso_id;
    $prevRatingResult = $db->query($prevRatingQuery);
    if($prevRatingResult->num_rows > 0):
        $prevRatingRow = $prevRatingResult->fetch_assoc();
        
        //Update rating data into the database
        $query = "UPDATE post_rating SET rating_number = '".$ratingPoints."', modified = '".date("Y-m-d H:i:s")."' WHERE usuario_id = ".$usuario_id. " AND curso_id = ".$curso_id;
        $update = $db->query($query);
    else:
        //Insert rating data into the database
        $query = "INSERT INTO post_rating (rating_number,created,modified, usuario_id, curso_id) VALUES(".$ratingPoints.",'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."',".$usuario_id.",".$curso_id.")";
  
        $insert = $db->query($query);
    endif;
    
    //Fetch rating deatails from database
    $query2 = "SELECT rating_number, FORMAT((total_points / rating_number),1) as average_rating FROM post_rating WHERE usuario_id = ".$usuario_id. " AND curso_id = ".$curso_id;
    $result = $db->query($query2);
    $ratingRow = $result->fetch_assoc();
    
    if($ratingRow){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    
    //Return json formatted rating data
    echo json_encode($ratingRow);
}
?>