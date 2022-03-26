"use strict"

const domain = new URL(window.location.origin)
const baseurl = domain.origin
const endpoint = baseurl+ "/core/controllers/endpoint/"
const error_color = "#e31010"
const success_color = "#14c237"

const basename = (path) => {
    return path.split("/").reverse()[0]
}

const formSerialize = (formselector) => {
    let myform = document.querySelector(formselector),
        forment = new FormData(myform).entries()

    return Object.assign(...Array.from(forment, ([x, y]) => ({[x]: y})))
}
const currencyformatter = new Intl.NumberFormat('en-NG', {
    style: 'currency',
    currency: 'NGN',
    // maximumFractionDigits: 2
    minimumFractionDigits: 0
})


let view_pass =  document.querySelectorAll("#view_password"),password = document.querySelectorAll(".input_password")
view_pass.forEach((e,g )=> {
    e.addEventListener("click",(es) =>  {

        for (let x=0; x<password.length; x++) {

            if (password[x].type === "password") {
                password[x].type = "text"
            } else {
                password[x].type = "password"
            }
        }
    })
})
async function fetchPost(url, data = {}) {
    return await fetch(url, {
        method: "POST",
        body: JSON.stringify(data)
    }).then(res=> {
        return  res.json()
    })

}

function notify(text, color){
    Toastify({
        text: text,
        duration: 3000,
        gravity:"top",
        position: "left",
        backgroundColor: color,
        stopOnFocus: true
    }).showToast();
}

function target(e){
    let target = ""
    if (e.target.nodeName === "SPAN") {
        target = e.target.parentElement
    } else {
        target = e.target
    }

    return target

}

function add_spinner(target ){
    target.firstElementChild.classList.remove("d-none")
    target.setAttribute("disabled", "disabled")
    target.childNodes[0].textContent = ""
    target.childNodes[2].textContent = ""
}

function remove_spinner(target, text){
    target.removeAttribute("disabled", "disabled")
    target.firstElementChild.classList.add("d-none")
    target.childNodes[0].textContent = ""
    target.childNodes[2].textContent = text
}
function convert_input_to_currency (number) {
    var figure = number.value.toString().replace(/\D/g, "")
    var formatter = new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN',
        // maximumFractionDigits: 2
        minimumFractionDigits: 0
    });

    return number.value = formatter.format(figure)
}

function datatable(tableSel, data, column, btnName, btnId ){
    $.fn.dataTable.ext.errMode = 'none'

    let pay_btn = (basename(window.location.href) === "manage-staff")?'  <button type="button" id="pay_salary" class= "ml-5 btn btn-outline-success btn-sm"><span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Pay</button>':'', info_btn = (basename(window.location.href) === "manage-staff" || basename(window.location.href) === "manage-admin")?'<button type="button" class="btn btn-primary btn-sm mr-2"  id=' + btnId + '><span class="d-none spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>' + btnName + '</button> ': '', action_col = (basename(window.location.href) === "manage-staff" || basename(window.location.href) === "manage-admin")?  {

        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function () {
            return (
                '<div class="d-inline-flex">' +
                info_btn +'&nbsp;' + pay_btn+
                '</div>' +
                '</div>'
            )
        },
    } :''
    const table = tableSel.DataTable({
        processing: true,
        serverSide: true,
        sServerMethod: "post",
        ajax: {
            url: endpoint+"ajax.php",
            data: data,
            dataSrc: "data",

        },
        columns: column,
        searchable: true,
            columnDefs: [


                {
                    targets: 1,
                    visible: false,
                    searchable: false
                },

              action_col
            ],
        order: [[2, "desc"]],

        responsive: true,
        sPaging:true,
        displayLength: 5,
        lengthMenu: [5, 10, 25, 50, 75, 100],


        language: {
            paginate: {previous: "&nbsp;", next: "&nbsp;"},
            processing: "  <div class=\"d-flex justify-content-center bg-transparent\" >\n" +
                "            <div class=\"spinner-border text-primary\" role=\"status\" style='width: 50px; height: 50px; vertical-align: middle' aria-hidden=\"true\"></div>\n" +
                "          </div>",
            sLoadingRecords: "&nbsp;"
        },


        fnInfoCallback: (settings, start, end, max, total, pre) => {
            var mT = " Not found",
                mB = "Your request returned an error, please check and try again."
            if (settings.json.error === "error") {
                let err = settings.oPreviousSearch.sSearch

                notify(err + mT + mB, error_color)
            }
            return pre
        },
    });



    tableSel.on('click', 'button', () => {
        var btn = document.querySelectorAll('tr button'), pay = document.querySelector('#pay_salary');

        btn.forEach((e) => {
            try {
                e.addEventListener('click', (es) => {
                    let trdata = e.closest('tr'),
                        brew = table.row(trdata).data()
                    if (es.target.id ==='pay_salary'){
                        let table_info = {staff_info: ''},
                            $data = Object.assign(table_info, brew)
                        fetchPost(endpoint, $data).then(res => {

                            document.querySelector('#pay_salary_btn').addEventListener('click', (eg)=> {

                                let pid =res.status.id
                                add_spinner(target(eg))
                                let info_form = formSerialize("#account_salary_form"), req = {pay_single_salary:"", id:pid}, data = Object.assign(req,info_form)
                                fetchPost(endpoint, data).then(resp => {
                                    if (resp.status === "handshake"){
                                        notify(""+res.status.firstname+" has been paid "+info_form.salary+" ", success_color)
                                    }
                                }).finally(()=> {
                                    remove_spinner(target(eg), "Pay")
                                })
                            })

                        }).finally(() => {
                            $('#account-salary-modal').modal('show')
                        })
                    }else if (es.target.id ==='staff-info'){
                        if (basename(window.location.href) === "manage-staff")
                        {
                            let table_info = {staff_info: ''},
                                $data = Object.assign(table_info, brew)
                            add_spinner(target(es))
                            fetchPost(endpoint, $data).then(res => {
                                let info_form = document.getElementById('account_info_form')
                                document.getElementById('info-title').innerText = res.status.firstname+' '+res.status.lastname+' '+'Profile'
                                info_form.elements["id"].value = res.status.id
                                info_form.elements["fname"].value = res.status.firstname
                                let status  = info_form.elements["status"].options
                                for (let i = 0; i< status.length; i++){
                                    if (res.status.status === 1){
                                        status[1].setAttribute("selected", "selected")
                                    }else {
                                        status[i].setAttribute("selected", "selected")
                                    }
                                }

                                info_form.elements["lname"].value = res.status.lastname
                                info_form.elements["phone"].value = res.status.phone
                                info_form.elements["wallet"].value = currencyformatter.format(res.status.wallet)
                                info_form.elements["email"].value = res.status.email
                                info_form.elements["address"].value = res.status.address
                            }).finally(() => {
                                remove_spinner(target(es), "Info")
                                $('#account-info-modal').modal('show')
                            })

                        }
                    }else if(es.target.id ==='admin-info'){
                        if (basename(window.location.href) === "manage-admin")
                        {
                            let table_info = {staff_info: ''},
                                $data = Object.assign(table_info, brew)
                            add_spinner(target(es))
                            fetchPost(endpoint, $data).then(res => {
                                let info_form = document.getElementById('account_info_form')
                                document.getElementById('info-title').innerText = res.status.firstname+' '+res.status.lastname+' '+'Profile'
                                info_form.elements["id"].value = res.status.id
                                info_form.elements["fname"].value = res.status.firstname
                                info_form.elements["lname"].value = res.status.lastname
                                info_form.elements["phone"].value = res.status.phone
                                info_form.elements["wallet"].value = currencyformatter.format(res.status.wallet)
                                info_form.elements["email"].value = res.status.email
                                info_form.elements["address"].value = res.status.address
                            }).finally(() => {
                                remove_spinner(target(es), "Info")
                                $('#account-info-modal').modal('show')
                            })
                        }
                    }

                })
            } catch (e) {
                errorToastr(e)
            }
        })
    })



}
