<?php
include(ROOT_DIR.'backend/config/DatabaseConnect.php');
$db = new DatabaseConnect();
$conn = $db->connectDB();

$productList =[];
try {
    $sql  = "SELECT * FROM `posts`"; //select statement here
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //$productList = $stmt->fetchAll();   
        

}catch (PDOException $e){
    echo "Connection Failed: " . $e->getMessage();
    $db = null;
}
?>