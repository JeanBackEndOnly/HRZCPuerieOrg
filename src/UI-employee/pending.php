<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <style>
        @media(max-width: 720px){
           .media-pending-img{
            height: 40px !important;
            width: 40px !important;
           }
           h2{
                font-size: 13px !important;
           }
           .button-media-text{
            font-size: 12px !important;
           }
            .bg-gradient-primary{
                margin: 0 !important;
                padding: .5rem !important;s
            }
        }
    </style>
    <div class="bg-gradient-primary h-auto p-3 d-flex  align-items-center justify-content-between" style="background-image: linear-gradient(300deg,#E32126, #FF6F8F,#E32126);
    color: #fff;">
        <div class="col-md-7 d-flex col-7">
            <img src="../../assets/image/system_logo/pueri-logo.png" class="me-2 media-pending-img" style="height: auto; width: 50px;">
            <h2 class="m-0 d-flex align-items-center fw-bold">Zamboanga Puericulture Center</h2>
        </div>  
        <div class="col-md-3 col-5 d-flex justify-content-end gap-2">
            <div class="col-md-5 col-8">
                <a href="201.php?user_id=<?= $_SESSION['employeeData']['user_id'] ?>"><button class="button-media-text btn btn-warning shadow m-0 fw-bold text-white">APPLICATIONS</button></a>
            </div>
            <div class="col-md-5 col-4">
                <a href="pds.php?user_id=<?= $_SESSION['employeeData']['user_id'] ?>"><button class="button-media-text btn shadow btn-info m-0 fw-bold text-white">PDS</button></a>
            </div>
            
            
        </div>
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center" style="width: 100vw; height: 85vh; overflow-hidden;">
        <strong>Waiting for admin approval</strong>
        <a href="../index.php"><button class="btn btn-danger px-5 m-0 fw-bold mt-3">Back to login</button></a>
    </div>  
</body>
</html>
