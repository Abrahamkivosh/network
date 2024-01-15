$(document).ready(function () {});

$(document).ready(function () {
  $("select").select2();

  $("#characterLeft").text("1000 characters left");
  $("#message").keyup(function () {
    var max = 1000;
    var len = $(this).val().length;
    if (len >= max) {
      $("#characterLeft")
        .text("You have reached the limit")
        .css("color", "red");
      $("#message").removeClass("success").addClass("error");
      $("#btnSubmit")
        .addClass("animated shake")
        .prop("disabled", true)
        .css("background-color", "red");
    } else {
      var ch = max - len;
      $("#characterLeft")
        .text(ch + " characters left")
        .css("color", "green");
      $("#message").removeClass("error").addClass("success");
      $("#btnSubmit")
        .removeClass("animated shake")
        .prop("disabled", false)
        .css("background-color", "green");
    }
  });
});
