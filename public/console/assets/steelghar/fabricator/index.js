var CompanyTables = (function () {
    var table;
    var datatable;

    // Private methods
    const initDatatable = () => {
        datatable = $("#fabricatorTable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: {
                url: BASE_URL + "/fabricators",
            },
            columns: [
                { data: "id" },
                { data: "company_name" },
                { data: "phone" },
                { data: "email" },
                { data: "approval_status" },
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
                            <button type="button" class="delete-client btn btn-sm btn-icon btn-youtube me-2" data-kt-docs-table-filter="delete_row" data-id="${data}">
                            <i class="fonticon-trash-bin"></i>
                            </button>
                        </div>
                        <div class="ms-2">
                        <a href="fabricators/${data}" class="btn btn-sm btn-icon btn-info me-2" >
                        <i class="fa-solid fa-eye"></i>
                        </a>
                        </div>
                    </div>
                        `;
                    },
                },
            ],
        });
        table = datatable.$;
        datatable.on("draw", function () {
            handleDeleteRows();
        });
    };

    var handleDeleteRows = () => {
        const deleteButtons = document.querySelectorAll(
            '[data-kt-docs-table-filter="delete_row"]'
        );
        let id;
        deleteButtons.forEach((d) => {
            d.addEventListener("click", function (e) {
                e.preventDefault();
                id = this.dataset.id;
                const parent = e.target.closest("tr");
                const productName = parent.querySelectorAll("td")[3].innerText;
                Swal.fire({
                    text:
                        "Are you sure you want to delete " + productName + "?",
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
                            .delete(BASE_URL + "/registered-fabricator/" + id)
                            .then(function (response) {
                                if (response.data.status == "success") {
                                    Swal.fire({
                                        icon: response.data.status,
                                        title: response.data.title,
                                        text: response.data.message,
                                    }).then(() => {
                                        window.location.reload();
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

    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector("[data-table-search]");
        filterSearch.addEventListener("keyup", function (e) {
            dt.search(e.target.value).draw();
        });
    };

    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    CompanyTables.init();
});
