document.addEventListener('DOMContentLoaded', function() {
    fetchSites();
});

document.getElementById('create-site-form').addEventListener('submit', function(e) {
    e.preventDefault();
    createSite();
});

function fetchSites() {
    fetch('backend/get_sites.php')
    .then(response => response.json())
    .then(sites => {
        const sitesList = document.getElementById('sites-list');
        if (sites.length === 0 ) {
        }
        else {
            sitesList.innerHTML = ''; // Clear current sites
            sites.forEach(site => {
                const div = document.createElement('div');
                div.className = 'site';
                div.innerHTML = `<strong>${site.site_name}</strong><p>${site.site_data.timespans}</p>`;
                div.addEventListener('click', () => {
                    window.location.href = `datenerfassung.php?site_id=${site.id}`;
                });
                sitesList.appendChild(div);
            });
        }
    })
    .catch(error => console.error('Error fetching sites:', error));
}

function createSite() {
    const siteName = document.getElementById('site-name').value;
    const siteData = document.getElementById('site-data').value;

    // Example fetch request; adjust the URL and method as needed.
    fetch('backend/create_site.php', {
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
