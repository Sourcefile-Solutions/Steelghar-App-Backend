"use strict";
// Class definition
var KTDatatablesServerSide = (function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;
    const addbtn = document.getElementById("addbtn");

    let submitBtn, cancelBtn, validation, form, modal, i;

    addbtn.addEventListener("click", () => {
        form.querySelector("#mob_banner_img").style.backgroundImage =
            "url(console/assets/media/svg/files/blank-image.svg)";
        form.querySelector("#banner_img").style.backgroundImage =
            "url(console/assets/media/svg/files/blank-image.svg)";

        form._method.value = "post";
        document.getElementById("banner-modal-title").innerText = "add Brand";
        document.getElementById("btn-text").innerHTML = "add";
        form.banner_name.value = "";
        form.status.value = 1;
        form.action = BASE_URL + "/banners";
        modal.show();
    });
    // Private functions
    var initDatatable = function () {
        dt = $("#bannerTable").DataTable({
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
                url: BASE_URL + "/banners",
            },
            columns: [
                { data: "id" },
                { data: "banner_name" },
                { data: "banner_image" },
                { data: "mobile_banner" },
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
                const bannerName = parent.querySelectorAll("td")[1].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to delete this " +
                        bannerName +
                        " banner?",
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
                            .delete(BASE_URL + "/banners/" + id)
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
                const bannerName = parent.querySelectorAll("td")[1].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to Edit this " +
                        bannerName +
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
                            .get(BASE_URL + "/banners/" + id + "/edit")
                            .then(function (response) {
                                console.log(response.data);
                                setupEditModal(response.data.banner);
                            })
                            .catch(function (error) {})
                            .finally(function () {});
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                });
            });
        });
    };

    var setupEditModal = (banner) => {
        // console.log(banner)
        form.banner_name.value = banner.banner_name;
        let banner_image = "/assets/media/svg/files/blank-image.svg";
        if (banner.banner_image) {
            banner_image = BASE_URL + "/storage/" + banner.banner_image;
        }
        form.querySelector("#banner_img").style.backgroundImage =
            "url(" + banner_image + ")";

        let mobile_banner = "/assets/media/svg/files/blank-image.svg";
        if (banner.mobile_banner) {
            mobile_banner = BASE_URL + "/storage/" + banner.mobile_banner;
        }
        form.querySelector("#mob_banner_img").style.backgroundImage =
            "url(" + mobile_banner + ")";
        form.status.value = banner.status;
        form._method.value = "PUT";
        document.getElementById("banner-modal-title").innerText = "Edit Brand";
        document.getElementById("btn-text").innerHTML = "Update";
        form.action = BASE_URL + "/banners/" + banner.id;
        modal.show();
    };

    (i = document.querySelector("#BannerModal")) &&
        (modal = new bootstrap.Modal(i)),
        (form = document.querySelector("#bannerForm")),
        (submitBtn = document.getElementById("banner_submit")),
        (cancelBtn = document.getElementById("banner_cancel")),
        (validation = FormValidation.formValidation(form, {
            fields: {
                banner_name: {
                    validators: {
                        notEmpty: { message: "Banner Name field is required" },
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
