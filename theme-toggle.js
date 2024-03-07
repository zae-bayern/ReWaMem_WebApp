// theme-toggle.js
document.addEventListener('DOMContentLoaded', function () {
  const toggleSwitch = document.getElementById('dark-mode-toggle');
  
  function switchTheme(e) {
    if (e.target.checked) {
      document.body.setAttribute('data-theme', 'dark');
      localStorage.setItem('theme', 'dark'); // Save theme preference
    } else {
      document.body.setAttribute('data-theme', 'light');
      localStorage.setItem('theme', 'light'); // Save theme preference
    }
  }

  toggleSwitch.addEventListener('change', switchTheme, false);

  // Check the saved theme preference, if any, when the page loads
  const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
  if (currentTheme) {
    document.body.setAttribute('data-theme', currentTheme);

    if (currentTheme === 'dark') {
      toggleSwitch.checked = true;
    }
  }
});
