if (basename(window.location.href) !== "login" && basename(window.location.href) !== "forgot-password") {
    document.querySelector("#logout").addEventListener("click", (e) => {

        fetchPost(endpoint, {logout: ""}).then(res => {
            if (res.status === "handshake") {
                window.location.replace(res.route)
            }
        })
    })
}
if (basename(window.location.href) === "login") {

    try {
        document.querySelector("#login_button").addEventListener("click", (e) => {
            let login_form = {login_form: ""}, serialize = formSerialize("#login_form"),
                data = Object.assign(login_form, serialize)
            add_spinner(target(e))

            fetchPost(endpoint, data).then(res => {
                if (res.status === 'handshake') {
                    window.location.replace(res.route)
                } else if (res.status === 'empty_email') {
                    notify("Please enter email.", error_color)
                } else if (res.status === 'empty_password') {
                    notify("Please enter password.", error_color)
                } else if (res.status === 'invalid_email') {
                    notify("Invalid email, please check and try again.", error_color)
                } else if (res.status === 'invalid_password') {
                    notify("Invalid email or password. Please check and try again.", error_color)
                } else if (res.status === 'inactive_account') {
                    notify("Account inactive. Please contact admin.", error_color)
                } else if (res.status === 'invalid_account') {
                    notify("Invalid email or password. Please check and try again.", error_color)
                } else {
                    notify("Error occured.", error_color)
                }
            }).finally(() => {
                remove_spinner(target(e), "Login")
            })


        })


    } catch (e) {
        notify(e, error_color)
    }

}
if (basename(window.location.href) === "security" || basename(window.location.href) === "forgot-password") {
    document.querySelector("#reset_pass").addEventListener("click", (e) => {
        try {
            add_spinner(target(e))
            let update_form = formSerialize("#reset_pass_form"), update_pass = {reset_pass: ""},
                data = Object.assign(update_pass, update_form)
            fetchPost(endpoint, data).then(res => {
                console.log(res)
                if (res.status === 'handshake') {
                    notify("Password Updated.", success_color)
                } else if (res.status === 'empty_pin') {
                    notify("Please enter pin.", error_color)
                } else if (res.status === 'empty_new') {
                    notify("Please enter new password.", error_color)
                } else if (res.status === 'empty_conf') {
                    notify("Please enter confirm password.", error_color)
                } else if (res.status === 'invalid_pin') {
                    notify("Pin must be digits.", error_color)
                } else if (res.status === 'four_pin') {
                    notify("Pin must be 4 digits.", error_color)
                } else if (res.status === 'mismatch_pin') {
                    notify("Invalid account pin.", error_color)
                } else if (res.status === 'mismatch') {
                    notify("Confirm password must be same with new password", error_color)
                } else if (res.status === 'mismatch') {
                    notify("Error occured.", error_color)
                } else {
                    notify("Error occured.", error_color)
                }
            }).finally(() => {
                remove_spinner(target(e), "Reset")
            }).catch((err)=> {
                notify("Error occured.", error_color)
            })
        }catch (e) {
            notify("Error occured.", error_color)
        }
    })

}
if (basename(window.location.href) === "profile") {
    let table_info = {staff_info: ''}
    fetchPost(endpoint, table_info).then(res => {

        let info_form = document.getElementById('profile_form')
        document.getElementById('profile-name').innerText = res.status.firstname + ' ' + res.status.lastname + ' ' + 'Profile'
        document.getElementById('account-pin').innerText = 'Create since ' + res.status.create_date
        document.getElementById('join-date').innerText = +res.status.pin
        info_form.elements["id"].value = res.status.id
        info_form.elements["fname"].value = res.status.firstname
        info_form.elements["pin"].value = res.status.pin
        info_form.elements["lname"].value = res.status.lastname
        info_form.elements["phone"].value = res.status.phone
        info_form.elements["email"].value = res.status.email
        info_form.elements["address"].value = res.status.address
    })
    document.querySelector("#update_profile").addEventListener("click", (e) => {
        let update_form = formSerialize("#profile_form"), update_account_form = {update_account_form: ""},
            data = Object.assign(update_account_form, update_form)
        add_spinner(target(e))
        fetchPost(endpoint, data).then(res => {
            if (res.status === 'handshake') {
                notify("Profile Updated.", success_color)
            } else if (res.status === 'error') {
                notify("Error occured.", error_color)
            }
        }).finally(() => {
            remove_spinner(target(e), "Save")
        })

    })
}
if (basename(window.location.href) === "manage-staff") {
    let data = {get_staff: ""}, selector = $("#staff-table"),
        cols = [{data: "id"}, {data: "pid"}, {data: "firstname"}, {data: "lastname"}, {data: "phone"}, {data: "wallet"}, {data: "status"}, {data: "actions"}]
    datatable(selector, data, cols, 'Info', 'staff-info')
    document.querySelector('#pay_salary_btn').addEventListener('click', (eg) => {
        add_spinner(target(eg))
        let info_form = formSerialize("#account_salary_form"), req = {pay_multi_salary: ""},
            data = Object.assign(req, info_form)
        fetchPost(endpoint, data).then(resp => {
            if (resp.status === "handshake") {
                notify("Salary has been paid to all employees", success_color)
            }
        }).finally(() => {
            remove_spinner(target(eg), "Pay")
        })
    })

}
if (basename(window.location.href) === "manage-admin") {
    let data = {get_admin: ""}, selector = $("#admin-table"),
        cols = [{data: "id"}, {data: "pid"}, {data: "firstname"}, {data: "lastname"}, {data: "phone"}, {data: "wallet"}, {data: "status"}, {data: "actions"}]
    datatable(selector, data, cols, "Info", "admin-info")
}

if (basename(window.location.href) === "manage-admin" || basename(window.location.href) === "manage-staff") {
    document.querySelector("#update_account_button").addEventListener("click", (e) => {
        let update_form = formSerialize("#account_info_form"), update_account_form = {update_account_form: ""},
            data = Object.assign(update_account_form, update_form)
        add_spinner(target(e))
        fetchPost(endpoint, data).then(res => {
            if (res.status === 'handshake') {
                notify("Profile Updated.", success_color)
            } else if (res.status === 'error') {
                notify("Error occured.", error_color)
            } else {
                notify("Error occured.", error_color)
            }
        }).finally(() => {
            remove_spinner(target(e), "Save")
        })

    })
    document.querySelector("#create_account_button").addEventListener("click", (e) => {
        add_spinner(target(e))
        let role = (basename(window.location.href) === "manage-admin") ? 1 : 2, req = {create_account: "", role: role},
            form = formSerialize("#create_account_form"), data = Object.assign(req, form)

        fetchPost(endpoint, data).then(res => {
            if (res.status === 'handshake') {
                notify("Account Created. Please login and update profile.", success_color)
            } else if (res.status === 'empty_fname') {
                notify("Please enter first name.", error_color)
            } else if (res.status === 'exists') {
                notify("Account with email exists, please use another email.", error_color)
            } else if (res.status === 'empty_lname') {
                notify("Please enter last name.", error_color)
            } else if (res.status === 'empty_email') {
                notify("Please enter email.", error_color)
            } else if (res.status === 'empty_password') {
                notify("Please enter password.", error_color)
            } else if (res.status === 'invalid_email') {
                notify("Invalid email, please check and try again.", error_color)
            } else if (res.status === 'error') {
                notify("Error occured.", error_color)
            } else {
                notify("Error occured.", error_color)
            }
        }).finally(() => {
            remove_spinner(target(e), "Create Account")
        })
    })
}
if (basename(window.location.href) === "salary-log") {
    let data = {salary_log: ""}, selector = $("#salary-table"),
        cols = [{data: "id"}, {data: "pid"}, {data: "admin_name"}, {data: "staff_name"}, {data: "salary"}, {data: "balance"}, {data: "date"}]
    datatable(selector, data, cols, "Info", "salary_info")
}

