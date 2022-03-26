<div class="row h-100">
    <div class="col-lg-6 col-12">
        <div id="auth-left">

            <h5 class="auth-title">Log in</h5>

            <form id="login_form" autocomplete="off">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" name="email" autocomplete="off" class="form-control form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" autocomplete="off" name="password" class="form-control form-control-xl input_password" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox"  id="view_password">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                       Show Password
                    </label>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="button" id="login_button">
                    <span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    Login
                </button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p><a class="font-bold" href="/auth/forgot-password">Forgot password?</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>