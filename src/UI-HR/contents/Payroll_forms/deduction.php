<div id="formdeduction">
    <form id="itemForm">
        <input type="hidden" id="user_id">

        <!-- PAY TYPE -->
        <div class="mb-3">
            <label class="form-label">Payment Type</label>
            <select id="salary_type" class="form-control">
                <option value="">Select type</option>
                <option value="direct">Direct Pay</option>
                <option value="hourly">Hourly Pay</option>
            </select>
        </div>

        <!-- DIRECT PAY -->
        <div id="direct_pay" class="d-none">
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" id="item_desc" class="form-control" placeholder="Enter description">
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" id="item_amount" class="form-control" placeholder="0.00">
            </div>
        </div>

        <!-- HOURLY PAY -->
        <div id="hourly_pay" class="d-none">
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" id="hourly_desc" class="form-control" placeholder="Enter description">
            </div>

            <div class="mb-3">
                <label class="form-label">Hours Worked</label>
                <input type="number" id="hours_worked" class="form-control" placeholder="Hours">
            </div>

            <div class="mb-3">
                <label class="form-label">Pay Rate (₱ per hour)</label>
                <input type="number" id="pay_rate" class="form-control" placeholder="Rate per hour">
            </div>
        </div>

        <input type="hidden" id="item_type">

    </form>
</div>