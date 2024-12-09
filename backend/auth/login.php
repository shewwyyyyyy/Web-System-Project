<?php

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
                    session_start();
                    $_SESSION = [];
                    $_SESSION['user_id'] = $users[0]['user_id'];
                    $_SESSION['username'] = $users[0]['username'];
                    $_SESSION['fullName'] = $users[0]['FullName'];


                    header("location: /index.php");                                      
                   exit;                   

                }else{
                    echo "<script>alert('Password not match');</script>";
                    $_SESSION["error"] = "Password not match";

                    header("location: /login.php");
                    exit;
               
            }
            
            }else{
                echo "<script>alert('User not found');</script>";
                $_SESSION["error"] = "User not found";

                header("location: /login.php");
                exit;
            }
                
            
        } catch (Exception $e){
            echo "Connection failed: ".$e->getMessage();
        }
    } 

?>