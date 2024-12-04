<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/backend/config/Directories.php");
$username = $_POST["username"];
$password = $_POST["password"];

include('../config/DatabaseConnect.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $db = new DatabaseConnect();
    $conn = $db->connectDB();

        try {
            
            $stmt = $conn->prepare('SELECT * FROM `users` WHERE username = :p_username');    
            $stmt->bindParam(':p_username', $username);
            $stmt->execute();
            $users = $stmt->fetchAll();
            
            if($users){ 
                if(password_verify($password,$users[0]["password"])){
                    $_SESSION = [];
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $users[0]['id'];
                    $_SESSION['username'] = $users[0]['username'];
                    $_SESSION['fullName'] = $users[0]['fullName'];
                    //$_SESSION['is_admin'] = $users[0]['is_admin'];

                    
                    header("location: /index.php");
                    exit;                   

                }else{
                    header("location: /login.php");
                    $_SESSION["error"] = "Password not match";
                    exit;
               
            }
            
            }else{
                header("location: /login.php");
                $_SESSION["error"] = "User not found";
                exit;
                //echo "password did not match";
            }
                
            
        } catch (Exception $e){
            echo "Connection failed: ".$e->getMessage();
        }
    } 

?>