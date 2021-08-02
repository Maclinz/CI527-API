<?php 

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

//Includes
include_once('../Db.php');
include_once('../models/Post.php');

//Instanciaye DB and connect
$database = new Db();
$db = $database->connect();

//Instanciate Post
$post = new Post($db);

//Post Query
$result = $post->readData();
//Get Post Count
$count = $result->rowCount();

if($count > 0){
    $post_arr = array();
    $post_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'name' => $name,
            'comment' => $comment
        );

        //Push to data
        array_push($post_arr['data'], $post_item);
    }
    //Convert into Json
    echo json_encode($post_arr);
}else{
    echo json_encode(
        array('message' => 'There are no Posts Found')
    );
}


?>