<body>
    <section class="scroll leave-height p-2">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="">
                <h4><i class="fa fa-tv"></i>Main Dashboard</h4>
                <small class="text-muted">Employee status, system counts and leave management overview</small>
            </div>
        </div>

        <div class="col-md-12 mb-2 mt-4">
            <strong>LEAVE PENDING, RECOMMENDED, APPROVED AND DISAPPROVED OVERVIEW</strong>
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-dark border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($leavePendingCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fs-4 fa-calendar-minus"></i>
                        <span class="text-center font-12 mt-2 w-100">PENDING LEAVES</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-info border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($leaveRecommendedCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fs-4 fa-calendar-plus"></i>
                        <span class="text-center font-12 mt-2 w-100">RECOMMENDED LEAVES</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-success border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($leaveApprovedCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fs-4 fa-calendar-check"></i>
                        <span class="text-center font-12 mt-2 w-100">APPROVED LEAVES</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-danger border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($leaveDisapprovedCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fs-4 fa-calendar-xmark"></i>
                        <span class="text-center font-12 mt-2 w-100">DISAPPROVED LEAVES</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2 mt-5">
            <strong>ACCOUNT ACTIVE, PENDING AND INACTIVE OVERVIEW</strong>
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-dark border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($AccountPendingCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-user fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">PENDING ACCOUNTS</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-success border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($AccountActiveCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-user-shield fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">ACTIVE ACCOUNTS</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="rounded card d-flex flex-row border shadow">
                    <div class="col-4 card rounded-left bg-danger border-right d-flex align-items-center justify-content-center p-3">
                        <strong class="fs-3 text-white"><?= htmlspecialchars($AccountInactiveCounts ?? 0) ?></strong>
                    </div>
                    <div class="col-8 d-flex flex-column align-items-center justify-content-center p-3">
                        <i class="fa-solid fa-user-xmark fs-4"></i>
                        <span class="text-center font-12 mt-2 w-100">INACTIVE ACCOUNTS</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>