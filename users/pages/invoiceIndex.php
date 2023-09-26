
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
    <h4>Invoices</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
    <div class="card bg-red text-white h-100">
        <div class="card-body pt-2">Open Invoices</div>
        <h2 class="card-body pt-1"> 
        <?php
        echo $invoiceStatus['open'];
        ?>
        </h2>
        
    </div>
    </div>
    <div class="col-md-3 mb-3">
    <div class="card bg-warning text-dark h-100">
    <div class="card-body pt-2">Dispurted invoice</div>
    <h2 class="card-body pt-1"> 
    <?php
        echo isset($invoiceStatus['disputed']) ? $invoiceStatus['disputed'] : 0;
        ?>

    </h2>
        
    </div>
    </div>



    <div class="col-md-3 mb-3">
    <div class="card bg-orange text-white h-100">
    <div class="card-body pt-2">Partially Paid</div>
    <h2 class="card-body pt-1">
    <?php
        echo isset ($invoiceStatus['partial']) ? $invoiceStatus['partial'] : 0;
        ?>
    </h2>
        
    </div>
    </div>

    <div class="col-md-3 mb-3">
    <div class="card bg-success text-white h-100">
    <div class="card-body pt-2">Paid</div>
    <h2 class="card-body pt-1"> 
    <?php
        echo isset($invoiceStatus['paid']) ? $invoiceStatus['paid'] : 0;
        ?>
    </h2>
        
    </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12 mb-3">
    <div class="card">
        <div class="card-header">
        <span><i class="bi bi-table me-2"></i></span> Invoices
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
                <th>Invoice No</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total Billed</th>
                <th>Total Paid</th>
                <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($invoices as $key => $invoice)
                {
                    echo "<tr>";
                    echo "<td>";
                    echo "<a class='text-primary outline-none' title='View Invoice' href='./invoiceShow.php'>{$invoice['id']}</a>";
                    echo "</td>";
                    echo "<td>{$invoice['date']}</td>";
                    echo "<td>{$invoice['status']}</td>";
                    echo "<td>{$invoice['total_billed']}</td>";
                    echo "<td>{$invoice['total_paid']}</td>";
                    echo "<td>".$invoice['total_paid'] - $invoice['total_billed']."</td>";
                    echo "</tr>";
                }
                ?>

                
            </tfoot>
            </table>
        </div>
        </div>
    </div>
    </div>
</div>
</div>
