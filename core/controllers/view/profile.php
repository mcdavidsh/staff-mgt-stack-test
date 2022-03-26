

<div class="page-content">
    <section class="row">
        <div class="col-lg-12">
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title" id="profile-name"></h4>
                    <small id="join-date"></small>
                    <small ><b id="account-pin"></b></small>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" id="profile_form">
                            <input name="id" hidden>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="pin-column">Pin</label>
                                        <input id="pin-column" type="text" class="form-control"
                                               placeholder="Four digit pin" name="pin" maxlength="4" minlength="4">
                                    </div>
                                </div>
                                    <div class="row">
                                </div>  <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">First Name</label>
                                        <input id="first-name-column" type="text" class="form-control"
                                               placeholder="First Name" name="fname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Last Name</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                               placeholder="Last Name" name="lname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="phone-column">Email</label>
                                        <input type="tel" id="phone-column" class="form-control" placeholder="Phone"
                                               name="phone">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Email</label>
                                        <input type="email" id="email-id-column" class="form-control"
                                               name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <textarea class="form-control" placeholder="Address" name="address" rows="4"></textarea>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary me-1 mb-1" id="update_profile">
                                        <span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                        Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        </div>
    </section>
</div>