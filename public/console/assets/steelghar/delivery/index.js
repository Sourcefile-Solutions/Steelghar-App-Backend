"use strict";


var KTDatatablesServerSide = (function () {
    var table;
    var dt;
    let submitBtn, cancelBtn, validation, form, modal, i;



    const editBtn = document.querySelectorAll('.editBtn');

    editBtn.forEach((element) => (
        element.addEventListener("click", function (e) {
            setupEditModal(JSON.parse(e.target.dataset.data))
        })
    ))





    var setupEditModal = (charge) => {
        form.additional_charge.value = charge.additional_charge;
        form.additional_km.value = charge.additional_km;
        form.from_kg.value = charge.from_kg;
        form.from_km.value = charge.from_km;
        form.minimum_charge.value = charge.minimum_charge;
        form.to_kg.value = charge.to_kg;
        form.to_km.value = charge.to_km;
        form.action = BASE_URL + "/delivery-charges/" + charge.id;
        modal.show();
    };

    (i = document.querySelector("#CategoryModal")) &&
        (modal = new bootstrap.Modal(i)),
        (form = document.querySelector("#categoryForm")),
        (submitBtn = document.getElementById("category_submit")),
        (cancelBtn = document.getElementById("category_cancel")),
        (validation = FormValidation.formValidation(form, {
            fields: {
                status: {
                    validators: {
                        notEmpty: { message: "Status field is required" },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "is-invalid",
                    eleValidClass: "",
                }),
            },
        })),

        submitBtn.addEventListener("click", function (e) {
            e.preventDefault(),
                validation &&
                validation.validate().then(function (e) {
                    console.log("validated!");

                    if ("Valid" == e) {
                        submitBtn.setAttribute("data-kt-indicator", "on");
                        submitBtn.disabled = !0;
                        axios
                            .post(
                                form.getAttribute("action"),
                                new FormData(form)
                            )
                            .then(function (response) {
                                console.log(response);
                                if (response.data.status == "success") {

                                    location.reload()
                                    form.reset(), modal.hide();
                                    Swal.fire({
                                        title: response.data.title,
                                        text: response.data.message,
                                        icon: response.data.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton:
                                                "btn btn-primary",
                                        },
                                    });
                                } else if (
                                    response.data.status == "error" ||
                                    response.data.status == "info"
                                ) {
                                    Swal.fire({
                                        title: response.data.title,
                                        text: response.data.message,
                                        icon: response.data.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton:
                                                "btn btn-primary",
                                        },
                                    });
                                }
                            })
                            .catch(function (error) {

                                console.log(error)
                                let dataMessage =
                                    error.response.data.message;
                                let dataErrors = error.response.data.errors;

                                // for (const errorsKey in dataErrors) {
                                //     if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                //     dataMessage += "\r\n" + dataErrors[errorsKey];
                                // }

                                if (error.response) {
                                    Swal.fire({
                                        text: dataMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton:
                                                "btn btn-primary",
                                        },
                                    });
                                }
                            })
                            .then(function () {
                                submitBtn.removeAttribute(
                                    "data-kt-indicator"
                                );
                                submitBtn.disabled = false;
                            });
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
        });




    return {
        init: function () {



        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
