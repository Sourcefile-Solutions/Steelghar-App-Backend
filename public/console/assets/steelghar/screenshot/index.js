"use strict";
// Class definition
var KTDatatablesServerSide = (function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    let submitBtn, cancelBtn, validation, form, modal, i;

    // Private functions
    var initDatatable = function () {
        dt = $("#screenshotTable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],

            rowCallback: function (nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(
                    oSettings._iDisplayStart + iDisplayIndex + 1
                );
                return nRow;
            },
            // stateSave: true,
            // select: {
            //     style: 'multi',
            //     selector: 'td:first-child input[type="checkbox"]',
            //     className: 'row-selected'
            // },
            // stateSave: true,
            // select: {
            //     style: 'multi',
            //     selector: 'td:first-child input[type="checkbox"]',
            //     className: 'row-selected'
            // },
            ajax: {
                url: BASE_URL + "/screenshots",
            },
            columns: [
                { data: "id" },
                { data: "screenshot_image" },
                { data: "screenshot_name" },
                { data: "review" },
                { data: "status" },
                { data: "action" },
            ],
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: "text-start",
                    render: function (data, type, row) {
                        return `
                        <div class="d-flex justify-content-start">
                        <div class="ms-2">
                      
                        <button  class="edit-row-btn btn btn-sm btn-icon btn-warning" data-kt-docs-table-filter="edit_row" data-id="${data}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                        </div>
                        <div class="ms-2">
                        <button type="button" class="delete-vendor btn btn-sm btn-icon btn-youtube me-2" data-kt-docs-table-filter="delete_row"  data-id="${data}">
                        <i class="fa-solid fa-trash"></i>
                        </button>
                        </div>
                    </div>
                        `;
                    },
                },
            ],
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on("draw", function () {
            handleDeleteRows();
            handleEditRows();
            KTMenu.createInstances();
        });
    };

    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll(
            '[data-kt-docs-table-filter="delete_row"]'
        );
        let id;
        deleteButtons.forEach((d) => {
            d.addEventListener("click", function (e) {
                e.preventDefault();
                id = this.dataset.id;
                const parent = e.target.closest("tr");
                const screenshotName =
                    parent.querySelectorAll("td")[2].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to delete " +
                        screenshotName +
                        " screenshot?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                    preConfirm: () => {
                        return axios
                            .delete(BASE_URL + "/screenshots/" + id)
                            .then(function (response) {
                                if (response.data.status == "success") {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    });
                                    dt.draw();
                                } else if (
                                    response.data.status == "info" ||
                                    response.status == "error"
                                ) {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    });
                                }
                            })
                            .catch(function (error) {})
                            .finally(function () {});
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                });
            });
        });
    };

    var handleEditRows = () => {
        const editButtons = document.querySelectorAll(
            '[data-kt-docs-table-filter="edit_row"]'
        );
        editButtons.forEach((d) => {
            d.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = e.target.closest("tr");
                const id = $(this).data("id");
                const screenshotName =
                    parent.querySelectorAll("td")[2].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to Edit this " +
                        screenshotName +
                        "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, Edit!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                    preConfirm: () => {
                        return axios
                            .get(BASE_URL + "/screenshots/" + id + "/edit")
                            .then(function (response) {
                                console.log(response.data);
                                setupEditModal(response.data.screenshot);
                            })
                            .catch(function (error) {})
                            .finally(function () {});
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                });
            });
        });
    };

    var setupEditModal = (screenshot) => {
        form.screenshot_name.value = screenshot.screenshot_name;
        let screenshot_image = "/assets/media/svg/files/blank-image.svg";
        if (screenshot.screenshot_image) {
            screenshot_image =
                BASE_URL + "/storage/" + screenshot.screenshot_image;
        }
        form.querySelector("#screenshot_img").style.backgroundImage =
            "url(" + screenshot_image + ")";
        form.status.value = screenshot.status;
        form._method.value = "PUT";
        document.getElementById("screenshot-modal-title").innerText =
            "Edit Screenshot";
        document.getElementById("btn-text").innerHTML = "Update";
        form.action = BASE_URL + "/screenshots/" + screenshot.id;
        modal.show();
    };

    (i = document.querySelector("#ScreenshotModal")) &&
        (modal = new bootstrap.Modal(i)),
        (form = document.querySelector("#screenshotForm")),
        (submitBtn = document.getElementById("screenshot_submit")),
        (cancelBtn = document.getElementById("screenshot_cancel")),
        (validation = FormValidation.formValidation(form, {
            fields: {
                screenshot_name: {
                    validators: {
                        notEmpty: {
                            message: "Screenshot Name field is required",
                        },
                    },
                },
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
                                        form.reset(), modal.hide();
                                        dt.draw();
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

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector("[data-table-search]");
        filterSearch.addEventListener("keyup", function (e) {
            dt.search(e.target.value).draw();
        });
    };

    return {
        init: function () {
            initDatatable();
            handleDeleteRows();

            handleSearchDatatable();
            // handleFilterDatatable();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
