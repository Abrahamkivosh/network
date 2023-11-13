<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4>Invoice Details</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <section class="invoice">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h2>Invoice Number: <span id="invoice-number"><?php echo $invoice->id; ?> </span></h2>
                        <p>Date: <span id="invoice-date"><?php echo $invoice->date; ?></span></p>
                        <p>Status: <?php echo getInvoiceStatus($invoice->status); ?> </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Total Billed: <span id="total-billed">
                                <?php echo number_format(floatval($invoice->total_billed)); ?>
                            </span></p>
                        <p>Total Paid: <span id="total-paid">
                                <?php echo number_format(floatval($invoice->total_paid)); ?>
                            </span></p>
                        <p>Balance: <span id="balance">
                                <?php echo number_format((floatval($invoice->total_billed)  - floatval($invoice->total_paid))); ?>
                            </span></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <h2>Invoice Items</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Plan Cost</th>
                                <th>Item Amount</th>
                                <th>Item Tax</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Use JavaScript to populate invoice items -->
                            <?php
                            foreach ($invoiceItems as $item) {

                                echo "<tr>";
                                echo "<td>" . $item['planName'] . "</td>";
                                echo "<td>" . number_format(floatval($item['planCost']))  . "</td>";
                                echo "<td>" . number_format(floatval($item['amount']))  . "</td>";
                                echo "<td>" . number_format(floatval($item['tax_amount']))  . "</td>";
                                echo "<td>" . $item['notes'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <table 
                                    style="
                                    width: 100%;
                                    border: 1px solid #dee2e6;
                                    border-radius: .25rem;
                                    padding: .5rem;
                                    vertical-align: top;
                                    font-size: 16px;
                                    font-weight: 700;
                                    "
                                     >
                                        <tr>
                                            <td>Total Billed: <span id="total-billed">
                                                    <?php echo number_format(floatval($invoice->total_billed)); ?>
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td>Total Paid: <span id="total-paid">
                                                    <?php echo number_format(floatval($invoice->total_paid)); ?>
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td>Balance: <span id="balance">
                                                    <?php echo number_format((floatval($invoice->total_billed)  - floatval($invoice->total_paid))); ?>
                                                </span></td>
                                        </tr>

                                    </table>





                                </td>


                            </tr>

                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>


            </section>
        </div>
        <!-- column 12 for actions download preview , Back -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <a href="#" class="btn btn-primary" title="Download invoice as PDF" type="button">
                        <i class="bi bi-download me-2"></i>Download
                    </a>
                    <a href="#" class="btn btn-primary" title="Preview invoice in a new tab" data-bs-toggle="modal" data-bs-target="#paymentModal" type="button">
                        <i class="bi bi-cash me-2"></i>Payments
                    </a>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="./invoices.php" class="btn btn-primary" title="Back to invoices list" type="button">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment For #123 Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- table -->
                <div class="table-responsive">
                    <table id="example" class="table table-striped data-table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Reference No</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-12345</td>
                                <td>September 16, 2023</td>
                                <td>Cash</td>
                                <td>$500.00</td>
                                <td>Payment 1 notes</td>
                            </tr>
                            <tr>
                                <td> INV-12345</td>
                                <td>September 16, 2023</td>
                                <td>Cash</td>
                                <td>$300.00</td>
                                <td>Payment 2 notes</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>