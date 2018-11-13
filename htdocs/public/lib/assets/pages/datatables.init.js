var handleDataTableButtons = function() {
        "use strict";
        0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [{ extend: "copy", className: "btn-sm btn-info" }, { extend: "csv", className: "btn-sm btn-info" }, { extend: "excel", className: "btn-sm btn-info" },
                // {extend:"pdf",className:"btn-sm btn-info"},
                { extend: "print", className: "btn-sm btn-info" }
            ],
            responsive: !0
        })
        0 !== $("#datatable1").length && $("#datatable1").DataTable({
            dom: "Bfrtip",
            buttons: [{ extend: "copy", className: "btn-sm btn-info" }, { extend: "csv", className: "btn-sm btn-info" }, { extend: "excel", className: "btn-sm btn-info" },
                // {extend:"pdf",className:"btn-sm btn-info"},
                { extend: "print", className: "btn-sm btn-info" }
            ],
            responsive: !0
        })
    },
    TableManageButtons = function() { "use strict"; return { init: function() { handleDataTableButtons() } } }();