document.addEventListener('DOMContentLoaded', function() {
    fetchSites();
});

document.getElementById('create-site-form').addEventListener('submit', function(e) {
    e.preventDefault();
    createSite();
});

function fetchSites() {
    // Example fetch request; adjust the URL as needed.
    fetch('get_sites.php')
    .then(response => response.json())
    .then(sites => {
        const sitesList = document.getElementById('sites-list');
        sitesList.innerHTML = ''; // Clear current sites
        sites.forEach(site => {
            const div = document.createElement('div');
            div.className = 'site';
            div.innerHTML = `<strong>${site.site_name}</strong><p>${site.site_data}</p>`;
            sitesList.appendChild(div);
        });
    })
    .catch(error => console.error('Error fetching sites:', error));
}

function createSite() {
    const siteName = document.getElementById('site-name').value;
    const siteData = document.getElementById('site-data').value;

    // Example fetch request; adjust the URL and method as needed.
    fetch('create_site.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
        body: `site_name=${encodeURIComponent(siteName)}&site_data=${encodeURIComponent(siteData)}`
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        fetchSites(); // Refresh the list of sites
    })
    .catch(error => console.error('Error creating site:', error));
}
