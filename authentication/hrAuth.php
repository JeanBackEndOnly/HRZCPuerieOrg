<?php
session_start();
require_once 'config.php';

// TO AVOID JAVA SCRIPT SCRIPTING =========================================================
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: eror.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") 

    if(isset($_POST["update_notification"]) && $_POST["update_notification"] == "true"){
        $admin_id = $_POST["admin_id"] ?? '';
        if($admin_id){
            $stmt = $pdo->prepare("UPDATE notifications SET status = 'Inactive' WHERE type = 'ADMIN'");
            $stmt->execute();
            header("Location: ../src/UI-Admin/index.php?page=contents/leave");
            $pdo = null;
            $stmt = null;
        }else{
            $stmt = $pdo->prepare("UPDATE notifications SET status = 'Inactive' WHERE type = 'HR'");
            $stmt->execute();
            header("Location: ../src/UI-HR/index.php?page=contents/leave");
            $pdo = null;
            $stmt = null;
        }
        
    }

    

    unset($_SESSION['csrf_token']);
}