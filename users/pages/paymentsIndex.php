<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
    <h4>All Payments</h4>
    </div>
</div>


<div class="row">
    <div class="col-md-12 mb-3">
    <div class="card">
        <div class="card-header">
        <span><i class="bi bi-table me-2"></i></span> Payments
        </div>
        <div class="card-body">
        <div class="table-responsive">

        <table
            id="example"
            class="table table-striped data-table"
            style="width: 100%"
            >
            <thead>
                <tr>
                <th>Reference No</th>
                <th>Amount</th>
                <th>Status </th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $payments = $user->getUserPayments();
                if (isset($payments) && !empty($payments)) {
                    foreach ($payments as $payment) {
                        ?>
                        <tr>
                        <td><?php echo $payment['reference_no']; ?></td>
                        <td><?php echo number_format($payment['amount']) ; ?></td>
                        <td><?php 
                        switch ($payment['status']) {
                            case '0':
                                echo "<span class='badge bg-warning'>Pending</span>";
                                break;
                            case '1':
                                echo "<span class='badge bg-success'>Paid</span>";
                                break;
                            case '2':
                                echo "<span class='badge bg-danger'>Failed</span>";
                                break;
                            case '3':
                                echo "<span class='badge bg-info'>Cancelled</span>";
                                break;
                            case '4':
                                echo "<span class='badge bg-info'>Refunded</span>";
                                break;
                            case '5':
                                echo "<span class='badge bg-info'>Partially Refunded</span>";
                                break;
                            
                            default:
                               echo "<span class='badge bg-warning'>N/A</span>";
                                break;
                        }
                        ?></td>

                        <td><?php echo $payment['date']; ?></td>
                        <td><?php echo $payment['type']; ?></td>
                        <td><?php echo $payment['notes']; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                    <td colspan="5">No payments found</td>
                    </tr>
                    <?php
                }
                ?>
                

            </tbody>
            </table>
            
        </div>
        </div>
    </div>
    </div>
</div>
</div>
