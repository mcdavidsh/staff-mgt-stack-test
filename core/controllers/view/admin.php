<?php
/** @var \mcdavidsh\controllers\template\template $temp */
$temp->modal();
?>
<div class="page-content">
    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-account-modal"> Create Account</button>
            </div>
            <div class="card-body">
                <table class="table" id="admin-table">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>OID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Wallet Balance</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                   <tbody>

                   </tbody>
                </table>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
</div>