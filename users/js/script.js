
$(document).ready(function () {
  $(".data-table").each(function (_, table) {
    $(table).DataTable({
      responsive: true,
      paging: true,
      info: true,
      searching: true,
      order: false
    });
  
  });
});


