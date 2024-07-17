document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('dark-mode-toggle');

    button.addEventListener('click', function() {
        if (document.documentElement.getAttribute('data-theme') === 'dark') {
            document.documentElement.removeAttribute('data-theme');
            localStorage.removeItem('theme');
            window.switchPlotlyTheme('light'); // Update plot theme
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            window.switchPlotlyTheme('dark'); // Update plot theme
        }
    });

    // Load the saved theme preference on page load
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        window.switchPlotlyTheme('dark'); // Update plot theme
    } else {
        window.switchPlotlyTheme('light'); // Update plot theme
    }
});