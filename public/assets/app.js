const shortifyForm = $("#shortify-form");
const messageBox = $("#messages");
const linksListBox = $("#links-list");

$(function () {
  $.ajax({
    url: "links.php",
    type: "GET",
  }).then(function (response) {
    response.data.forEach((link) => {
      linksListBox.append(`
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ${link.id}. ${link.url} (${link.uuid})
            <span class="badge bg-primary rounded-pill">${link.views}</span>
        </li>
    `);
    });
  });
});

shortifyForm.on("submit", function (e) {
  e.preventDefault();

  const linkInput = $(this).find(`[name="link"]`);

  $.ajax({
    url: "create-link.php",
    type: "POST",
    data: {
      link: linkInput.val(),
    },
    success: function (res) {
      messageBox.removeClass("text-danger");
      messageBox.text(res.message);
      linkInput.val(res.data.url);
    },
    error: function (jqXHR) {
      const errors = jqXHR.responseJSON.data;
      Object.values(errors).forEach((error) => {
        Object.values(error).forEach((errorText) => {
          messageBox.text(errorText);
        });
      });
    },
  });
});
