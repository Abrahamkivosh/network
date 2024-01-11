<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
    <h4>Dashboard</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
    <div 
    <?php 
    if( $getExpirationDate['remaining_days'] <= 0){
        echo "class='card bg-danger text-white h-100'>";
        echo "<div class='card-body pt-2'>Account Is Expired</div>";
    }else{
        echo "class='card bg-success text-white h-100'>";
        echo "<div class='card-body pt-2'>Account Is Active</div>";
    }
    ?>
     
        <div class="card-body pt-2">Days Remaing : <?php echo $getExpirationDate['remaining_days'] ?> </div>

    </div>
    </div>
    <div class="col-md-3 mb-3">
    <div class="card bg-warning text-dark h-100">
    <div class="card-body pt-2">Package Subscribed</div>
        <div class="card-body pt-2">
        <?php
        echo $getUserBillingPlan['planName'];
        ?>
        </div>

    </div>
    </div>
    <div class="col-md-3 mb-3">
    <div class="card bg-secondary text-white h-100">
    <div class="card-body pt-2">Account No:</div>
        <div class="card-body pt-2">
        <?php
        echo $user->getUserName() ;
        ?>
        </div>

    </div>
    </div>

    <div class="col-md-3 mb-3">
    <div class="card bg-orange text-white h-100">
    <div class="card-body pt-2">Account Balance:</div>
        <div class="card-body pt-2">
            KES   <?php echo  number_format($getUserBillInfo['balance'] ) ; ?>
        </div>

    </div>
    </div>

    <div class="col-md-3 mb-3">
    <div 
    <?php 
    if( $getExpirationDate['remaining_days'] <= 0){
        echo "class='card bg-danger text-white h-100'";
    }else 
    {
        echo "class='card bg-success text-white h-100'";
    }
    ?>
    >
    <div class="card-body pt-2">Expiry Date:</div>
        <div class="card-body pt-2"> <?php echo $getExpirationDate['expire_date']; ?></div>

    </div>
    </div>

    <div class="col-md-3 mb-3">
    <div class="card bg-blue text-white h-100">
    <div class="card-body pt-2">Online Time:</div>
        <div class="card-body pt-2"> 
            <?php
            echo $userConnectionStatus['userOnlineTime'];
            ?>
        </div>

    </div>
    </div>
    <div class="col-md-3 mb-3">
    <div class="card bg-yellow text-white h-100">
    <div class="card-body pt-2">Last Connection:</div>
        <div class="card-body pt-2"> 
            <?php
            echo $userConnectionStatus['userLastConnected'];
            ?>
        </div>

    </div>
    </div>
    <div class="col-md-3 mb-3">
    <div class="card bg-purple text-white h-100">
    <div class="card-body pt-2">Contact Number:</div>
        <div class="card-body pt-2"> <?php echo $getUserBillInfo['phone']; ?></div>

    </div>
    </div>

</div>
<div class="row">
 
    <div class="col-md-12 mb-3">
    <div class="card custom-card">
            <div class="card-body custom-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="custom-card-title">Account Balance</h5>
                        <p class="card-text custom-card-balance">Ksh <?php echo  number_format($getUserBillInfo['balance']) ; ?>  overpaid</p>
                        <h5 class="custom-card-title">Service Days Remaining</h5>
                        <p class="card-text custom-card-expiryDate"><?php echo  $getExpirationDate['remaining_days'] ." days (until ".   $getExpirationDate['expire_date'].")" ?></p>
                        <p class="card-text custom-card-text">The approximate number of days during which services will be provided based on the amount on the account balance</p>
                    </div>
                    <div class="col-md-6">
                        <form action="" method="post">
                        <h5 class="custom-card-title bg-success">Top up account balance to extend your service</h5>
                        <div class="input-group">
                        <input type="text" class="form-control" name="amount" placeholder="Enter amount">
                        </div>
                        <div class="input-group">
                        <input type="text" class="form-control" name="phone" placeholder="Enter Phone">
                        </div>
                        <div class="input-group d-grid gap-2">
                        
                            <button class="btn btn-primary btn-success  " type="submit">Top Up</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-2">
    <div class="card">
        <div class="card-header">
            <span><i class="bi bi-bar-chart-fill"></i></span> Live Bandwidth Usage
        </div>
        <div class="card-body">
            <canvas class="liveBandwidthUsageChart" id="liveBandwidthUsageChart" width="100" height="20"></canvas>
        </div>
    </div>
    </div>

    <div class="col-md-12">
        <?php
       userPlanInformation($getUserBillInfo['username'], 1);
        echo "<hr>";
        userConnectionStatus($getUserBillInfo['username'], 1);
        echo "<hr />";
        userSubscriptionAnalysis($getUserBillInfo['username'], 1);
         
        ?>
    </div>
   

</div>
</div>
