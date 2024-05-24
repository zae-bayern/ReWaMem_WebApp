document.addEventListener('DOMContentLoaded', function() {
  var button = document.getElementById('dark-mode-toggle');
  
  button.addEventListener('click', function() {
      document.body.classList.toggle('dark-theme');
      // Optionally, save the theme preference to localStorage
      if (document.body.classList.contains('dark-theme')) {
          localStorage.setItem('theme', 'dark');
      } else {
          localStorage.removeItem('theme');
      }
  });

  // Optionally, load the saved theme preference on page load
  if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark-theme');
  }
});
