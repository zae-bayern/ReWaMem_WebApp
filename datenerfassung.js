document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('entryForm');
  const company = document.getElementsByName("company")[0];
  const site = document.getElementsByName("name")[0];

  form.addEventListener('submit', function(event) {
      // Clear previous error messages
      clearErrors();

      let valid = true;

      if (company.value.trim() === '') {
          showError(company, 'Company name is required.');
          valid = false;
      }

      if (site.value.trim() === '') {
          showError(site, 'Site name is required.');
          valid = false;
      }

      if (!valid) {
          event.preventDefault();
      }
  });

  function showError(input, message) {
      const formGroup = input.parentElement;
      const error = document.createElement('div');
      error.className = 'error-message';
      error.textContent = message;
      formGroup.appendChild(error);
  }

  function clearErrors() {
      const errors = document.querySelectorAll('.error-message');
      errors.forEach(function(error) {
          error.remove();
      });
  }
});

(function () {
  function upddisplay() {
    var found = false;
    for (var i = 1; i <= 3; i++) {
      var r = document.getElementById("type-" + i);
      var e = document.getElementById("for-type-" + i);
      if (!r || !e)
        continue;
      if (r.checked) {
        e.style.display = '';
        found = true;
      } else
        e.style.display = 'none';
    }
    e = document.getElementById("worklabel");
    if (e)
      e.style.display = found ? '' : 'none';
  }

  function setonchange(r) {
    var old = r.onchange;
    r.onchange = function () {
      if (old)
        old();
      upddisplay();
    };
  }

  for (var i = 1; i <= 3; i++) {
    var r = document.getElementById("type-" + i);
    if (!r)
      continue;
    setonchange(r);
  }

  upddisplay();
})();

(function () {
  var e = document.getElementById('mydataorg');
  if (!e)
    return;
  var boxes = e.getElementsByTagName('INPUT');
  for (var i = 0; i < boxes.length; i++) {
    var box = boxes[i];
    box.onchange = box.onclick = (function (box) {
      return function () {
        setTimeout(function () {
          if (boxes[0] == box && box.checked) {
            for (var i = 1; i < boxes.length; i++)
              boxes[i].checked = false;
            return;
          }
          var num = 0;
          for (var i = 1; i < boxes.length; i++)
            if (boxes[i].checked)
              num++;
          boxes[0].checked = num == 0;
        }, 100);
        box.blur();
        return true;
      };
    })(box);
  }
})();

// Function to update form fields based on selection
    function updateFormFields(selectedSiteId = null) {
        var select = document.getElementById('siteSelect');

        // If a specific site ID is provided, use it
        if (selectedSiteId !== null) {
            select.value = selectedSiteId;
        }

        selectedSiteId = select.value;

        if (selectedSiteId === "new") {
            // Clear all form fields for new site
            document.getElementById('company').value = "";
            document.getElementById('name').value = "";
            // Clear checkboxes
            document.querySelectorAll('input[type=checkbox]').forEach(checkbox => checkbox.checked = false);
            // Add other fields as needed
        } else {
            // Find the selected site data
            var selectedSite = sitesData.find(site => site.id == selectedSiteId);
            console.log('Selected Site:', selectedSite); // Debugging

            if (selectedSite) {
                // Populate form fields with selected site data, use empty string as default if undefined
                document.getElementById('company').value = selectedSite.site_data.company || "";
                document.getElementById('name').value = selectedSite.site_name || "";

                // Clear checkboxes
                document.querySelectorAll('input[type=checkbox]').forEach(checkbox => checkbox.checked = false);

                //set type radio select
                if (selectedSite.site_data.type == "1") {
                    document.getElementById('type-1').checked = true;
                }
                if (selectedSite.site_data.type == "2") {
                    document.getElementById('type-2').checked = true;
                }
                if (selectedSite.site_data.type == "3") {
                    document.getElementById('type-3').checked = true;
                }

                //set org checkboxes
                if (0 in selectedSite.site_data.org) {
                    document.getElementById('org-0').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("servitex") !== -1) {
                    document.getElementById('org-servitex').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("sitex") !== -1) {
                    document.getElementById('org-sitex').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("dressline") !== -1) {
                    document.getElementById('org-dressline').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("nwdzentratex") !== -1) {
                    document.getElementById('org-nwdzentratex').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("lavantex") !== -1) {
                    document.getElementById('org-lavantex').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("tsa") !== -1) {
                    document.getElementById('org-tsa').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("leosystem") !== -1) {
                    document.getElementById('org-leosystem').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("dbl") !== -1) {
                    document.getElementById('org-dbl').checked = true;
                }
                if (selectedSite.site_data.org.indexOf("diemietwaesche.de") !== -1) {
                    document.getElementById('org-diemietwaesche.de').checked = true;
                }

                // set work checkboxes
                if (selectedSite.site_data.work.indexOf("wtabwasserfrisch") !== -1) {
                    document.getElementById('work1-wtabwasserfrisch').checked = true;
                    document.getElementById('work3-wtabwasserfrisch').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("wrabluftzufrisch") !== -1) {
                    document.getElementById('work1-wrabluftzufrisch').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("wrabluftzuwasser") !== -1) {
                    document.getElementById('work1-wrabluftzuwasser').checked = true;
                    document.getElementById('work3-wrabluftzuwasser').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("wasserrueck") !== -1) {
                    document.getElementById('work1-wasserrueck').checked = true;
                    document.getElementById('work2-wasserrueck').checked = true;
                    document.getElementById('work3-wasserrueck').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("wassermehrfach") !== -1) {
                    document.getElementById('work1-wassermehrfach').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("abwassersiebfilter") !== -1) {
                    document.getElementById('work1-abwassersiebfilter').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("abwasserfaellung") !== -1) {
                    document.getElementById('work1-abwasserfaellung').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("abwassermikrofiltration") !== -1) {
                    document.getElementById('work1-abwassermikrofiltration').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("abwasserneutralis") !== -1) {
                    document.getElementById('work1-abwasserneutralis').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("abwasserbiologie") !== -1) {
                    document.getElementById('work1-abwasserbiologie').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("dampfkessel") !== -1) {
                    document.getElementById('work1-dampfkessel').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("dampfsystem") !== -1) {
                    document.getElementById('work1-dampfsystem').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("kontakt") !== -1) {
                    document.getElementById('work2-kontakt').checked = true;
                    document.getElementById('work3-kontakt').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("kuehl") !== -1) {
                    document.getElementById('work2-kuehl').checked = true;
                    document.getElementById('work3-kuehl').checked = true;
                }
                if (selectedSite.site_data.work.indexOf("wrabluftzufluft") !== -1) {
                    document.getElementById('work3-wrabluftzufluft').checked = true;
                }


                }
            }
        }
    

    window.onload = function() {

            // Extract site_id from the URL, if available
            var urlParams = new URLSearchParams(window.location.search);
            var siteIdFromUrl = urlParams.has('site_id') ? urlParams.get('site_id') : null;

            // Populate the dropdown and select the appropriate site if siteIdFromUrl is provided
            populateDropdown(siteIdFromUrl);

            document.getElementById('siteSelect').addEventListener('change', function() {
                updateFormFields();
            });

            document.getElementById('siteSelect').style.visibility = "hidden";

        document.getElementById('deleteSite').addEventListener('click', function() {

        event.preventDefault(); // dont transmit form

        var select = document.getElementById('siteSelect');
        var selectedSiteId = select.value;

        if (selectedSiteId === "new") {
            alert("Bitte wählen Sie eine vorhandene Seite aus, um sie zu löschen.");
            return;
        }

        if (confirm("Sind Sie sicher, dass Sie diese Seite löschen möchten?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "backend/delete_site.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Remove the deleted entry from the dropdown and select the previous one
                    var optionToRemove = select.querySelector('option[value="' + selectedSiteId + '"]');
                    if (optionToRemove) {
                        var previousOption = optionToRemove.previousElementSibling;
                        optionToRemove.remove();
                        if (previousOption) {
                            previousOption.selected = true;
                        } else {
                            select.value = "new";
                        }
                        updateFormFields();
                    }
                    // Redirect to dashboard.php after deletion
                    window.location.href = 'dashboard.php';
                }
            };
            xhr.send("id=" + selectedSiteId);
        }
        });

        // If a site ID is provided in the URL, update the form fields
        if (siteIdFromUrl !== null) {
            updateFormFields(siteIdFromUrl);
        }
    }