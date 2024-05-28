document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('entryForm');
  const name = document.getElementById('name');

  form.addEventListener('submit', function(event) {
      // Clear previous error messages
      clearErrors();

      let valid = true;

      // Check if name is entered
      //if (name.value.trim() === '') {
      //    showError(name, 'Name is required.');
      //    valid = false;
      //}

      // Prevent form submission if any field is invalid
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