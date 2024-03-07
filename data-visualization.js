document.addEventListener('DOMContentLoaded', function() {
    fetchDataAndDisplay();
});

function fetchDataAndDisplay() {
    fetch('path/to/your/data.json') // Adjust the path to where your JSON data is located
    // TODO: change to fetch json from SQL
        .then(response => response.json())
        .then(data => {
            const numericalData = extractNumericalData(data);
            displayData(numericalData);
            plotDataWithPlotly(numericalData);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function extractNumericalData(data) {
    // TODO Adjust based on JSON structure
    return data.map(item => ({ label: item.label, value: item.value }));
}

function displayData(numericalData) {
    const dataDisplay = document.getElementById('data-display');
    numericalData.forEach(item => {
        dataDisplay.innerHTML += `<p>${item.label}: ${item.value}</p>`;
    });
}

function plotDataWithPlotly(numericalData) {
    const labels = numericalData.map(item => item.label);
    const values = numericalData.map(item => item.value);

    const data = [{
        x: labels,
        y: values,
        type: 'bar',
    }];

    const layout = {
        title: 'Site Data Visualization',
        xaxis: {
            title: 'Site'
        },
        yaxis: {
            title: 'Value'
        }
    };

    Plotly.newPlot('plotly-chart', data, layout);
}
