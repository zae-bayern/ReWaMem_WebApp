document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('dark-mode-toggle');

    button.addEventListener('click', function() {
        if (document.documentElement.getAttribute('data-theme') === 'dark') {
            document.documentElement.removeAttribute('data-theme');
            localStorage.removeItem('theme');
            if (window.location.pathname.includes('data-visualization.php')) {
                window.switchPlotlyTheme('light');
            }
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            if (window.location.pathname.includes('data-visualization.php')) {
                window.switchPlotlyTheme('dark');
            }
        }
    });

    // Load the saved theme preference on page load
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        if (window.location.pathname.includes('data-visualization.php')) {
            window.switchPlotlyTheme('dark');
        }
    } else {
        if (window.location.pathname.includes('data-visualization.php')) {
            window.switchPlotlyTheme('light');
        }
    }
});