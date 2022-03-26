<div class="row h-100">
    <div class="col-lg-6 col-12">
        <div id="auth-left">
            <h5 class="auth-title">Reset Password</h5>


            <form id="reset_pass_form" autocomplete="off">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="tel"  class="form-control form-control-xl"
                                   name="pin" placeholder="Account Pin" required maxlength="4" minlength="4" pattern="">
                        </div>


                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl"
                                   name="newpass" placeholder="New Password">
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl"
                                   name="confnewpass" placeholder="Confirm New Password">
                        </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="button" id="reset_pass">
                    <span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    Reset
                </button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p><a class="font-bold" href="/auth/login">Have access?</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>