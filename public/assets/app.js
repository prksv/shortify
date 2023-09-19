const shortifyForm = $("#shortify-form");
const messageBox = $("#messages");
const linksListBox = $("#links-list");

function appendLink(id, url, uuid, views) {
  linksListBox.append(`
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ${id}. ${url} (${uuid})
            <span class="badge bg-primary rounded-pill">${views}</span>
        </li>
    `);
}

$(function () {
  $.ajax({
    url: "links.php",
    type: "GET",
  }).then(function (response) {
    response.data.forEach((link) => {
      appendLink(link.id, link.url, link.uuid, link.views);
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
      const url = res.data.url;
      const link = res.data.link;

      messageBox.removeClass("text-danger");
      messageBox.text(res.message);

      linkInput.val(url);
      appendLink(link.id, link.url, link.uuid, link.views);
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
