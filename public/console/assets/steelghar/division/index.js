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
        dt = $("#divisionTable").DataTable({
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
                url: BASE_URL + "/divisions",
            },
            columns: [
                { data: "id" },
                { data: "category_id" },
                { data: "subcategory_id" },
                { data: "division_image" },
                { data: "division_name" },
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
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row)
                    .find("td:eq(4)")
                    .attr("data-filter", data.CreditCardType);
            },
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
                const divisionName = parent.querySelectorAll("td")[3].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to delete " +
                        divisionName +
                        " division?",
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
                            .delete(BASE_URL + "/divisions/" + id)
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
                const divisionName = parent.querySelectorAll("td")[3].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to Edit this " +
                        divisionName +
                        " division?",
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
                            .get(BASE_URL + "/divisions/" + id + "/edit")
                            .then(function (response) {
                                console.log(response.data);
                                setupEditModal(response.data.division);
                            })
                            .catch(function (error) {})
                            .finally(function () {});
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                });
            });
        });
    };

    const handleCategory = () => {
        document
            .querySelector('select[name="category_id"]')
            .addEventListener("change", function (e) {
                form.subcategory_id.innerHTML = "";
                const option = document.createElement("option");
                option.value = "";
                option.innerText = "Loding......";
                form.subcategory_id.appendChild(option);
                const categoryId = this.value;
                axios
                    .get(
                        BASE_URL + "/get-subcategory-by-category/" + categoryId
                    )
                    .then(function (response) {
                        console.log(response);
                        if (response.data.status == "success") {
                            let subcategories = response.data.subcategories;
                            console.log(subcategories);
                            if (subcategories.length) {
                                form.subcategory_id.innerHTML = "";
                                const option = document.createElement("option");
                                option.value = "";
                                option.innerText = "Select Sub Category";
                                form.subcategory_id.appendChild(option);
                                subcategories.forEach((subcategory) => {
                                    const option =
                                        document.createElement("option");
                                    option.value = subcategory.id;
                                    option.innerText =
                                        subcategory.subcategory_name;
                                    form.subcategory_id.appendChild(option);
                                });
                                categoryStatus = response.data.categoryStatus;
                            } else {
                                Swal.fire({
                                    title: "No subcategories",
                                    text: "No sub categories found under selected category",
                                    icon: "info",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                    footer: `<span class="fst-italic fw-medium text-center">
                                        With out sub category you cannot create a new division 👉
                                        <a href="${BASE_URL}/subcategories" class="badge badge-light-primary">View subcategories</a>
                                        </span>`,
                                });
                            }
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
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        }
                    })
                    .catch(function (error) {})
                    .then(function () {
                        // btn.removeAttribute('data-kt-indicator');
                        // btn.disabled = false;
                    });
            });
    };

    var setupEditModal = (division) => {
        form.category_id.value = division.category_id;
        form.subcategory_id.value = division.subcategory_id;
        form.division_name.value = division.division_name;
        let division_image = "/assets/media/svg/files/blank-image.svg";
        if (division.division_image) {
            division_image = BASE_URL + "/public/storage/" + division.division_image;
        }
        form.querySelector("#division_img").style.backgroundImage =
            "url(" + division_image + ")";
        form.status.value = division.status;
        form._method.value = "PUT";
        document.getElementById("division-modal-title").innerText =
            "Edit Division";
        document.getElementById("btn-text").innerHTML = "Update";
        form.action = BASE_URL + "/divisions/" + division.id;
        modal.show();
    };

    (i = document.querySelector("#DivisionModal")) &&
        (modal = new bootstrap.Modal(i)),
        (form = document.querySelector("#divisionForm")),
        (submitBtn = document.getElementById("division_submit")),
        (cancelBtn = document.getElementById("division_cancel")),
        (validation = FormValidation.formValidation(form, {
            fields: {
                division_name: {
                    validators: {
                        notEmpty: {
                            message: "Division Name field is required",
                        },
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
            handleCategory();
            handleSearchDatatable();
            // handleFilterDatatable();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
