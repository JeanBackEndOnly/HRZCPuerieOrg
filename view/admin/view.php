<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../../authentication/config.php';

    // System Fetching ==================================================================================
    function getUnitSection(){
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT * FROM unit_section");
            $stmt->execute();
            $allUnitSections = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [
                'Unit_Sections' => $allUnitSections
            ];
        } catch (PDOException $e) {
            echo 'An error occured: ' . $e->getMessage();
        }
    }

    

