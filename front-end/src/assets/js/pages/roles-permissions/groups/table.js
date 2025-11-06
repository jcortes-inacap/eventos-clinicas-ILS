import { getPathPrefix } from "../../../path-utils.js";

// Class definition
var GroupsDatatable = (function () {
  // Shared variables
  var dt;

  // Private functiones
  var initDatatable = function () {
    dt = $("#table_carreras").DataTable({
      searchDelay: 500,
      processing: false,
      order: [1, "asc"],
      lengthMenu: [5, 10, 50, 100],
      iDisplayLength: 5,
      select: {
        style: "multi",
        selector: 'td:first-child input[type="checkbox"]',
        className: "row-selected",
      },
      columnDefs: [
        {
          targets: 0,
          orderable: false,
          searchable: false,
          className: "select-checkbox",
        },
        {
          targets: 1,
          },
        {
          targets: 2,
        },
        {
          targets: 3,
        },
        {
          targets: -1,
        },
      ],
    });

    // Re-init functions on every table re-draw
    dt.on("draw", function () {
      initToggleToolbar();
      toggleToolbars();
      handleFilterData();
      initRowDelete();
    });
  };

  // Search Datatable
  var handleSearchDatatable = function () {
    const filterSearch = document.querySelector('[data-table-filter="search"]');
    filterSearch.addEventListener("keyup", function () {
      if (this.value != "") {
        $(".search-clear").show();
      } else {
        $(".search-clear").hide();
      }
      dt.search(this.value).draw();
    });

    const filterSearchClear = document.querySelector(".search-clear");
    filterSearchClear.addEventListener("click", function () {
      $(this).hide();
      $(this).closest("div").find('[data-table-filter="search"]').val("");
      dt.search("").draw();
    });
  };

  // Filter Datatable
  var handleFilterDatatable = () => {
    const filterButton = document.querySelector(
      '[data-table-filter-btn="filter"]',
    );

    // Filter datatable on submit
    filterButton.addEventListener("click", function () {
      $(".dataTables_wrapper").addClass("processing");
      $(".dataTables_processing").css("display", "block");
      $.fn.dataTable.ext.search = [];
      dt.draw();
      handleFilterDataRows();

      // Trigger the dismiss click on the close button
      document
        .querySelector('#filterDrawer [data-bs-dismiss="offcanvas"]')
        .click();
    });
  };

var handleFilterData = () => {
  const filterDataView = document.querySelector("[data-filters]");
  const filterData = document.querySelector("[data-filters-data]");
  let search_html = "";

  // Búsqueda
  const searchval = $('[data-table-filter="search"]').val();
  if (searchval) {
    search_html += `
      <span class="badge text-bg-primary d-flex justify-content-between fs-7 me-2 fw-bold align-items-center">
        Búsqueda: ${searchval}
        <span class="ri-close-line cursor-pointer fs-7 fw-bold ms-2 text-inverse clear-filter"
              data-type="input" data-filter="search"></span>
      </span>`;
  }

  // Estado
  $('input[name="estado"]:checked').each(function () {
    const val = $(this).val();
    const label = $(this).next("label").text().trim();
    search_html += `
      <span class="badge text-bg-primary d-flex justify-content-between fs-7 me-2 fw-bold align-items-center">
        Estado: ${label}
        <span class="ri-close-line cursor-pointer fs-7 fw-bold ms-2 text-inverse clear-filter"
              data-val="${val}" data-type="checkbox" data-filter="estado"></span>
      </span>`;
  });

  // Área
  const areaVal = $('#id_area').val();
  if (areaVal) {
    const areaLabel = $('#id_area option:selected').text().trim();
    search_html += `
      <span class="badge text-bg-primary d-flex justify-content-between fs-7 me-2 fw-bold align-items-center">
        Área: ${areaLabel}
        <span class="ri-close-line cursor-pointer fs-7 fw-bold ms-2 text-inverse clear-filter"
              data-val="${areaVal}" data-type="select" data-filter="id_area"></span>
      </span>`;
  }

  // Mostrar o limpiar
  if (search_html !== "") {
    const clearAllButton = document.createElement("span");
    clearAllButton.className =
      "badge text-bg-danger fs-7 me-2 d-flex align-items-center fw-semibold cursor-pointer clear-filter";
    clearAllButton.setAttribute("data-filter", "all");
    clearAllButton.textContent = "Limpiar todo";

    filterData.innerHTML = search_html;
    filterData.appendChild(clearAllButton);

    filterDataView.classList.remove("d-none");
    filterDataView.classList.add("d-flex");

    clearFilters();
  } else {
    filterDataView.classList.remove("d-flex");
    filterDataView.classList.add("d-none");
  }


    // Get checked status from filter drawer
    $('input[name="estado"]:checked').each(function () {
      statusFilters.push($(this).val());
    });


    // Add custom filtering
    $.fn.dataTable.ext.search.push(function (_settings, data) {
      let rowStatus = data[3].toLowerCase(); // columna ESTADO
      let statusMatch =
        statusFilters.length === 0 ||
        statusFilters.some((status) => rowStatus.includes(status === "1" ? "activo" : "inactivo"));

      return statusMatch;
    });

    // Simulate loading delay
    setTimeout(function () {
      dt.draw();
      $(".dataTables_wrapper").removeClass("processing");
      $(".dataTables_processing").css("display", "none");
    }, 500);
  };

  // Reset Filter
  var handleResetForm = () => {
    // Select reset button
    const resetButton = document.querySelector(
      '[data-table-filter-btn="reset"]',
    );

    // Reset datatable
    resetButton.addEventListener("click", function () {
      $(".dataTables_wrapper").addClass("processing");
      $(".dataTables_processing").css("display", "block");

      if ($(".form-check-input:checked").length > 0) {
        $(".form-check-input").prop("checked", false);
      }
      if ($("#filterDrawer .form-select").length > 0) {
        $("#filterDrawer .form-select").val("");
      }

      $('[data-table-filter="search"]').val("");
      $(".search-clear").hide();

      $.fn.dataTable.ext.search = []; // Remove all custom filters

      // Simulate loading delay
      setTimeout(function () {
        dt.draw();
        $(".dataTables_wrapper").removeClass("processing");
        $(".dataTables_processing").css("display", "none");
      }, 500);

      // Trigger the dismiss click on the close button
      document
        .querySelector('#filterDrawer [data-bs-dismiss="offcanvas"]')
        .click();
    });
  };

  // Handle filter data display
  var handleFilterData = () => {
    const filterDataView = document.querySelector("[data-filters]");
    const filterData = document.querySelector("[data-filters-data]");
    var search_html = "";

    const filterSearch = document.querySelector('[data-table-filter="search"]');
    var searchval = filterSearch.value;
    if (searchval != "") {
      search_html +=
        '<span class="badge text-bg-primary d-flex justify-content-between fs-7 me-2 fw-bold align-items-center">Search: ' +
        searchval +
        ' <span class="ri-close-line cursor-pointer fs-7 fw-bold ms-2 text-inverse clear-filter" data-type="input" data-filter="search"></span></span>';
    }

    // Add status filters
    $('input[name="status"]:checked').each(function () {
      var title = $(this).attr("data-title");
      var val = $(this).val();
      search_html +=
        '<span class="badge text-bg-primary d-flex justify-content-between fs-7 me-2 fw-bold align-items-center">Status: ' +
        title +
        ' <span class="ri-close-line cursor-pointer fs-7 fw-bold ms-2 text-inverse clear-filter" data-val="' +
        val +
        '" data-type="checkbox" data-filter="status"></span></span>';
    });

    if (search_html != "") {
      // Create clear all button element
      const clearAllButton = document.createElement("span");
      clearAllButton.className =
        "badge text-bg-danger fs-7 me-2 d-flex align-items-center fw-semibold cursor-pointer clear-filter";
      clearAllButton.setAttribute("data-filter", "all");
      clearAllButton.textContent = "Clear All";

      // Clear existing content
      filterData.textContent = "";

      // Add the search HTML content safely
      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = search_html;
      while (tempDiv.firstChild) {
        filterData.appendChild(tempDiv.firstChild);
      }

      // Add the clear all button
      filterData.appendChild(clearAllButton);

      filterDataView.classList.remove("d-none");
      filterDataView.classList.add("d-flex");
      clearFilters();
    } else {
      filterDataView.classList.remove("d-flex");
      filterDataView.classList.add("d-none");
    }
  };

  // Clear filters
  var clearFilters = function () {
  if ($(".clear-filter").length > 0) {
    $(".clear-filter").on("click", function () {
      const filter = $(this).attr("data-filter");
      const type = $(this).attr("data-type");
      const val = $(this).attr("data-val");

      if (filter === "all") {
        // Limpiar búsqueda
        $('[data-table-filter="search"]').val("");
        $(".search-clear").hide();

        // Limpiar checkboxes de estado
        $('input[name="estado"]').prop("checked", false);

        // Limpiar select de área
        $('#id_area').val("");
      } else {
        if (type === "checkbox" && filter === "estado") {
          $('input[name="estado"]:checked').each(function () {
            if ($(this).val() === val) {
              $(this).prop("checked", false);
            }
          });
        }

        if (filter === "search") {
          $('[data-table-filter="search"]').val("");
          $(".search-clear").hide();
        }

        if (filter === "id_area") {
          $('#id_area').val("");
        }
      }

      $(".dataTables_wrapper").addClass("processing");
      $(".dataTables_processing").css("display", "block");

      $.fn.dataTable.ext.search = [];

      setTimeout(function () {
        handleFilterDataRows();
        dt.draw();
        $(".dataTables_wrapper").removeClass("processing");
        $(".dataTables_processing").css("display", "none");
      }, 500);
    });
  }
};


  // Init toggle toolbar
  var initToggleToolbar = function () {
    // Toggle selected action toolbar
    const container = document.querySelector("#table_groups");
    const checkboxes = container.querySelectorAll('[type="checkbox"]');

    // Select all checkboxes
    const selectAll = document.querySelector(
      '[data-table-select="select_all"]',
    );
    selectAll.addEventListener("change", function (e) {
      const checkboxes = container.querySelectorAll('[type="checkbox"]');
      checkboxes.forEach((c) => {
        c.checked = e.target.checked;
      });
      toggleToolbars();
    });

    // Select elements
    const deleteSelected = document.querySelector(
      '[data-table-select="delete_selected"]',
    );

    // Toggle delete selected toolbar
    checkboxes.forEach((c) => {
      // Checkbox on click event
      c.addEventListener("change", function () {
        setTimeout(function () {
          toggleToolbars();
        }, 50);
      });
    });

    // Deleted selected rows
    deleteSelected.addEventListener("click", function () {
      const selectedIds = [];
      let modalTitleText = "Delete Groups";
      let modalMsgText = "Are you sure you want to delete selected groups?";
      let modalConfirmTextVal = "Yes, delete it!";
      let modalLoaderTextVal = "Deleting...";

      var selectedcheckboxes = container.querySelectorAll(
        '[type="checkbox"]:checked',
      );
      selectedcheckboxes.forEach((sc) => {
        selectedIds.push(sc.value);
      });

      $("#confirmationModal").on("show.bs.modal", function () {
        var modal = $("#confirmationModal");
        modal.find(".modal-body #confirm-yes").text(modalConfirmTextVal);
        modal.find(".modal-body #modal-help-title").text(modalTitleText);
        modal.find(".modal-body #modal-help-text").text(modalMsgText);
        modal.find(".modal-help-content").find(".modal-help-icon").show();
      });

      $("#confirmationModal").modal("show");

      $("#confirmationModal button#confirm-yes")
        .off()
        .on("click", function () {
          var modal = $("#confirmationModal");
          $(this).text(modalLoaderTextVal);

          setTimeout(function () {
            modal.find(".modal-body #modal-buttons").removeClass("d-flex");
            modal.find(".modal-body #modal-buttons").addClass("d-none");
            modal
              .find(".modal-body #modal-help-title")
              .addClass("text-success")
              .text("Success");
            modal
              .find(".modal-body #modal-help-text")
              .text("Groups have been deleted successfully.");
            modal
              .find(".modal-help-content")
              .find(".modal-help-icon")
              .html(
                '<span class="ri-checkbox-circle-line text-success"></span>',
              );
            modal.find(".modal-help-content").find(".modal-help-icon").show();
          }, 1000);

          setTimeout(function () {
            $("#confirmationModal").modal("hide");
            modal.find(".modal-body #modal-buttons").removeClass("d-none");
            modal.find(".modal-body #modal-buttons").addClass("d-flex");
          }, 3000);
        });

      $("#confirmationModal button#confirm-no")
        .off()
        .on("click", function () {
          $("#confirmationModal").modal("hide");
        });
    });
  };

  // Toggle toolbars
  var toggleToolbars = function () {
    // Define variables
    const container = document.querySelector("#table_groups");
    const toolbarBase = document.querySelector('[data-table-toolbar="filter"]');
    const toolbarSelected = document.querySelector(
      '[data-table-toolbar="bulk_selected"]',
    );
    const selectedCount = document.querySelector(
      '[data-table-select="selected_count"]',
    );

    // Select refreshed checkbox DOM elements
    const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

    // Detect checkboxes state & count
    let checkedState = false;
    let count = 0;

    // Count checked boxes
    allCheckboxes.forEach((c) => {
      if (c.checked) {
        checkedState = true;
        count++;
      }
    });

    const selectAll = document.querySelector(
      '[data-table-select="select_all"]',
    );
    if (allCheckboxes.length == count) {
      selectAll.checked = true;
    } else {
      selectAll.checked = false;
    }

    // Toggle toolbars
    if (checkedState) {
      selectedCount.innerHTML = count;
      toolbarBase.classList.add("d-none");
      toolbarSelected.classList.remove("d-none");
    } else {
      toolbarBase.classList.remove("d-none");
      toolbarSelected.classList.add("d-none");
    }
  };

  // Init single delete button
  var initRowDelete = function () {
    if ($(".delete-button").length > 0) {
      $(".delete-button").on("click", function (e) {
        e.preventDefault();
        const $title = "Delete Group";
        const $msg = "Are you sure you want to delete this group?";
        const $confirmButtonText = "Yes, delete it!";
        const $loaderButtonText = "Deleting...";

        $("#confirmationModal").on("show.bs.modal", function () {
          var modal = $("#confirmationModal");
          modal.find(".modal-body #confirm-yes").text($confirmButtonText);
          modal.find(".modal-body #modal-help-title").text($title);
          modal.find(".modal-body #modal-help-text").text($msg);
          modal.find(".modal-help-content").find(".modal-help-icon").show();
        });

        $("#confirmationModal").modal("show");

        $("#confirmationModal button#confirm-yes")
          .off()
          .on("click", function () {
            var modal = $("#confirmationModal");
            $(this).text($loaderButtonText);

            setTimeout(function () {
              modal.find(".modal-body #modal-buttons").removeClass("d-flex");
              modal.find(".modal-body #modal-buttons").addClass("d-none");
              modal
                .find(".modal-body #modal-help-title")
                .addClass("text-success")
                .text("Success");
              modal
                .find(".modal-body #modal-help-text")
                .text("Group has been deleted successfully.");
              modal
                .find(".modal-help-content")
                .find(".modal-help-icon")
                .html(
                  '<span class="ri-checkbox-circle-line text-success"></span>',
                );
              modal.find(".modal-help-content").find(".modal-help-icon").show();
            }, 1000);

            setTimeout(function () {
              $("#confirmationModal").modal("hide");
              modal.find(".modal-body #modal-buttons").removeClass("d-none");
              modal.find(".modal-body #modal-buttons").addClass("d-flex");
            }, 3000);
          });

        $("#confirmationModal button#confirm-no")
          .off()
          .on("click", function () {
            $("#confirmationModal").modal("hide");
          });
      });
    }
  };

  // Public methods
  return {
    init: function () {
      initDatatable();
      handleSearchDatatable();
      handleFilterDatatable();
      handleResetForm();
      initToggleToolbar();
    },
  };
})();

// On document ready
document.addEventListener("DOMContentLoaded", () => {
  GroupsDatatable.init();
});
