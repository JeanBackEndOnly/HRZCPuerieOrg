<body>
   <?php 
            $leaveCounts = $stmt = $pdo->prepare("SELECT * FROM  leaveCounts WHERE employee_id = :employee_id");
            $leaveCounts->execute([
               'employee_id' => $employee_id
            ]);
            $getCounts = $stmt->fetch(PDO::FETCH_ASSOC);
            $VacationBalance = $getCounts["VacationBalance"];
            $SickBalance = $getCounts["SickBalance"];
            $SpecialBalance = $getCounts["SpecialBalance"];
            $OthersBalance = $getCounts["OthersBalance"];
         ?>
   <section class="">
      <div class="mb-4">
         <div class="mx-2">
            <h4><i class="fa fa-tv mx-2"></i>Employee Dashboard</h4>
            <small class="text-muted">Overviews</small>
         </div>
      </div>

      <!-- Grid Row -->
      <div class="row text-center pb-2 ms-2 gap-2">
         <a href="index.php?page=contents/leave" class="col-md-2 col-5 hover min-height rounded d-flex flex-column py-4  shadow text-white align-items-center justify-content-center cursor-pointer bg-color-lr">
            <div class="col-md-12 text-center">
               <i class="fa-solid fa-person-through-window fs-1"></i>
            </div>
            <div class="col-md-12">
               <strong class="mt-2">Request a Leave</strong>
            </div>
         </a>
         <a href="index.php?page=contents/leave" class="col-md-2 col-5 hover min-height rounded d-flex flex-column py-4 shadow text-white align-items-center justify-content-center cursor-pointer bg-color-mp">
            <div class="col-md-12 text-center">
               <i class="fa-solid fa-gear fs-1"></i>
            </div>
            <div class="col-md-12">
               <strong class="mt-2">Manage Profile and settings</strong>
            </div>
         </a>
         <a href="index.php?page=contents/leave" class="col-md-2 col-5 hover min-height rounded d-flex flex-column py-4 shadow text-white align-items-center justify-content-center cursor-pointer bg-color-mf">
            <div class="col-md-12 text-center">
               <i class="fa-solid fa-file fs-1"></i>
            </div>
            <div class="col-md-12">
               <strong class="mt-2">Manage 201 files</strong>
            </div>
         </a>
      </div>
      <div class="row ms-1 gap-2 pb-5">
         <label class="col-md-2 col-5 d-flex flex-column min-height align-items-center justify-content-center shadow rounded py-4 bg-color-lr">
            <div class="col-md-12 text-center text-white">
               <strong class="text-wite fs-2"><?= htmlspecialchars($SickBalance) ?></strong>
            </div>
            <div class="col-md-12 d-flex">
               <div class="col-md-6 d-flex flex-column text-white text-end">
                  <strong class="font-12">SICK LEAVE</strong>
                  <strong class="font-12">BALANCE</strong>
               </div>
               <div class="col-md-6 ms-2 d-flex align-items-center text-white">
                  <i class="fa-solid fa-disease"></i>
               </div>
            </div>
         </label>
         <label class="col-md-2 col-5 d-flex flex-column min-height  align-items-center justify-content-center shadow rounded py-4 bg-color-mp">
            <div class="col-md-12 text-center text-white">
               <strong class="text-wite fs-2"><?= htmlspecialchars($SickBalance) ?></strong>
            </div>
            <div class="col-md-12 d-flex">
               <div class="col-md-6 d-flex flex-column text-white text-end">
                  <strong class="font-12">VACATION LEAVE</strong>
                  <strong class="font-12">BALANCE</strong>
               </div>
               <div class="col-md-6 ms-2 d-flex align-items-center text-white">
                  <i class="fa-solid fa-umbrella-beach fs-1"></i>
               </div>
            </div>
         </label>
         <label class="col-md-2 col-5 d-flex flex-column min-height align-items-center justify-content-center shadow rounded py-4 bg-color-mf">
            <div class="col-md-12 text-center text-white">
               <strong class="text-wite fs-2"><?= htmlspecialchars($SickBalance) ?></strong>
            </div>
            <div class="col-md-12 d-flex">
               <div class="col-md-6 d-flex flex-column text-white text-end">
                  <strong class="font-12">SPECIAL LEAVE</strong>
                  <strong class="font-12">BALANCE</strong>
               </div>
               <div class="col-md-6 ms-2 d-flex align-items-center text-white">
                  <i class="fa-solid fa-cake-candles fs-1"></i>
               </div>
            </div>
         </label>
         <label class="col-md-2 col-5 d-flex flex-column min-height  align-items-center justify-content-center shadow rounded py-4 bg-color-others">
            <div class="col-md-12 text-center text-white">
               <strong class="text-wite fs-2"><?= htmlspecialchars($SickBalance) ?></strong>
            </div>
            <div class="col-md-12 d-flex">
               <div class="col-md-6 d-flex flex-column text-white text-end">
                  <strong class="font-12">OTHERS LEAVE</strong>
                  <strong class="font-12">BALANCE</strong>
               </div>
               <div class="col-md-6 ms-2 d-flex align-items-center text-white">
                  <i class="fa-solid fa-biohazard fs-1"></i>
               </div>
            </div>
         </label>

      </div>
   </section>
</body>