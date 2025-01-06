"use strict";
var KTDatatablesServerSide = (function () {
    var table;
    var dt;

    var initDatatable = function () {
        dt = $("#brandTable").DataTable({
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
            ajax: {
                url: BASE_URL + "/payments",
            },
            columns: [
                { data: "id" },
                { data: "order_id" },
                { data: "is_refund" },
                { data: "paid" },
                { data: "balance" },
                { data: "payment_id" },
                { data: "payment_mode" },
                { data: "remarks" },
                { data: "date" },
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
                        <button type="button" class="delete-vendor btn btn-sm btn-icon btn-info me-2" data-kt-docs-table-filter="delete_row"  data-id="${data}">
                        <i class="fa-solid fa-eye"></i>
                        </button>
                        </div>
                    </div>
                        `;
                    },
                },
            ],
        });

        table = dt.$;

        dt.on("draw", function () {
            KTMenu.createInstances();
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

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
