"use strict";

$(function() {
  $("form").on("submit", function(e) {
    e.preventDefault();
    const jsmail = $("#mail").val();
    const subject = $("#subject").val();
    const message = $("#message").val();
    const captchaG = grecaptcha.getResponse();
    const rePlace = $("#resultPlace");
    $.ajax({
      type: $("form").attr("method"),
      url: "./php/contact.php",
      dataType: "json",
      data: {
        mail: jsmail,
        subject: subject,
        message: message,
        captchaG: captchaG
      },
      success: function(response) {
       console.log(response);
        $("label").removeClass();
        const labelOne = $("label:eq(0)");
        const labelTwo = $("label:eq(1)");
        const labelThr = $("label:eq(2)");
        const labelFhr = $("label:eq(3)");

        labelOne.html("Twój e-mail:");
        labelTwo.html("Temat wiadomości:");
        labelThr.html("Treść wiadomości:");
        labelFhr.empty();

        if ("success" in response) {
          $("form").hide();
          rePlace.removeClass();
          rePlace.addClass("alert alert-success");
          $("#mail").val("");
          $("#subject").val("");
          $("#message").val("");
          rePlace
            .html(response.success)
            .fadeIn(500)
            .delay(400)
            .fadeOut(500);
        } else {
          if ("mail" in response) {
            labelOne
              .hide()
              .addClass("alert alert-danger")
              .fadeIn(500);
            $("label:eq(0)").html(response["mail"]);
          }
          if ("subject" in response) {
            labelTwo
              .hide()
              .addClass("alert alert-danger")
              .fadeIn(500);
            $("label:eq(1)").html(response["subject"]);
          }
          if ("message" in response) {
            labelThr
              .hide()
              .addClass("alert alert-danger")
              .fadeIn(500);
            $("label:eq(2)").html(response["message"]);
          }
          if ("Captched" in response) {
            labelFhr
              .hide()
              .addClass("alert alert-danger")
              .fadeIn(500);
            $("label:eq(3)").html(response["Captched"]);
          }
        }
      },
      error: function(xhr) {
        console.log(xhr);
      }
    });
  });
});
