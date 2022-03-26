<?php
/** @var \mcdavidsh\controllers\template\template $temp */

?>
<div class="page-heading d-flex justify-content-between align-items-center">
    <h3>Home</h3>
    <span class="badge bg-primary float-end"><?php if ($temp->get_account_info()->role == 1) echo "Admin View";?></span>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-lg-4 ">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Salary</h6>
                                    <h6 class="font-extrabold mb-0"><?php
                                        echo $temp->naira_formatter($temp->get_salary_amount()->total_salary) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Times Paid</h6>
                                    <h6 class="font-extrabold mb-0"><?php /** @var \mcdavidsh\controllers\template\template $temp */
                                        echo $temp->get_salary()->num_rows ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-4">
                    <div class="card">

                        <div class="card-body py-4 px-5"><span class="badge bg-primary float-end"><?php if ($temp->get_account_info()->role == 1) echo "Admin"; else echo "Staff"?></span>
                            <div class="d-flex align-items-center">
                                <div class="ms-3 name">
                                    <h5 class="font-bold"><?php
                                        $fname = !empty($temp->get_account_info()->firstname)?$temp->get_account_info()->firstname:"";
                                        $lname =!empty($temp->get_account_info()->lastname)?$temp->get_account_info()->lastname:"";
                                        echo ucwords($fname." ".$lname)?></h5>
                                    <h6 class="text-muted mb-0"><?php echo $temp->naira_formatter($temp->get_account_info()->wallet) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</div>