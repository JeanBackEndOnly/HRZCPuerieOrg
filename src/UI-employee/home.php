<body>
   <?php 
      $leaveCounts = $stmt = $pdo->prepare("SELECT * FROM  leaveCounts WHERE user_id = :user_id");
      $leaveCounts->execute([
            'user_id' => $user_id
         ]);
      $getCounts = $stmt->fetch(PDO::FETCH_ASSOC);
      $VacationBalance = $getCounts["VacationBalance"];
      $SickBalance = $getCounts["SickBalance"];
      $SpecialBalance = $getCounts["SpecialBalance"];
      $OthersBalance = $getCounts["OthersBalance"];

      $stmtSchedule = $pdo->prepare("SELECT es.schedule_at, st.scheduleName, st.schedule_from, st.schedule_to FROM employee_schedule es
         LEFT JOIN sched_template st ON es.schedule_id = st.template_id
         WHERE es.user_id = ? AND es.schedule_at = CURDATE()");
      $stmtSchedule->execute([$user_id]);
      $result = $stmtSchedule->fetch(PDO::FETCH_ASSOC);
   ?>
   <section>
       <div class="mb-4">
         <div class="mx-2">
            <h4><i class="fa fa-tv mx-2"></i>Employee Dashboard</h4>
            <small class="text-muted">Overviews</small>
         </div>
      </div>
      <div class="col-md-12 mb-2 mt-4">
            <strong>REDIRECT</strong>
        </div>
      <div class="row text-center pb-2 ms-1 gap-3">
         <a href="index.php?page=contents/leave" class="col-md-3 col-5 hover min-height rounded d-flex flex-column py-4  shadow text-white align-items-center justify-content-center cursor-pointer bg-color-lr">
            <div class="col-md-12 text-center">
               <i class="fa-solid fa-person-through-window fs-3"></i>
            </div>
            <div class="col-md-12">
               <strong class="mt-2">Request a Leave</strong>
            </div>
         </a>
         <a href="index.php?page=contents/setting" class="col-md-3 col-5 hover min-height rounded d-flex flex-column py-4 shadow text-white align-items-center justify-content-center cursor-pointer bg-color-mp">
            <div class="col-md-12 text-center">
               <i class="fa-solid fa-gear fs-3"></i>
            </div>
            <div class="col-md-12">
               <strong class="mt-2">Manage Profile and settings</strong>
            </div>
         </a>
         <a href="index.php?page=contents/201" class="col-md-3 col-5 hover min-height rounded d-flex flex-column py-4 shadow text-white align-items-center justify-content-center cursor-pointer bg-color-mf">
            <div class="col-md-12 text-center">
               <i class="fa-solid fa-file fs-3"></i>
            </div>
            <div class="col-md-12">
               <strong class="mt-2">Manage 201 files</strong>
            </div>
         </a>
      </div>
      <div class="col-md-12 mb-2 mt-4">
            <strong>LEAVE PENDING, RECOMMENDED, APPROVED AND DISAPPROVED OVERVIEW</strong>
        </div>
      <div class="row g-3">
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-dark border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($VacationBalance ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-head-side-cough fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">Sick Leave Balance</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-info border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($SickBalance ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-umbrella-beach fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">Vacation Leave Balance</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-success border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($SpecialBalance ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-cake-candles fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">Special Leave Balance</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-danger border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($OthersBalance ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-biohazard fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">Others Leave Balance</span>
                    </div>
                </div>
            </div>
        </div>
   </section>
</body>