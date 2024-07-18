function showContent(contentId) {
    var contents = document.querySelectorAll('.content-datavis');
    contents.forEach(function(content) {
        content.style.display = 'none';
    });
    document.getElementById(contentId).style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function() {
    function switchPlotlyTheme(theme) {
        var newLayout = {
            paper_bgcolor: theme === 'dark' ? '#2c2c2c' : 'white',
            plot_bgcolor: theme === 'dark' ? '#2c2c2c' : 'white',
            font: { color: theme === 'dark' ? 'white' : 'black' }
        };

        Plotly.relayout('plot2', newLayout);
        Plotly.relayout('plot4', newLayout);
    }

// Expose switchPlotTheme to the global scope
window.switchPlotlyTheme = switchPlotlyTheme;
});

function extractNumericalData(data) {
    // TODO Adjust based on JSON structure
    return data.map(item => ({ label: item.label, value: item.value }));
}

//** Extract (id, fieldname) as tuple from json data*/
function extractNumericalDataFromJSON(jsonData, fieldName) {
    const dataPoints = JSON.parse(jsonData);

    // Sort
    dataPoints.sort((a,b) => a.data[fieldName] - b.data[fieldName]);

    // Extract labels + num values by fieldName
    const formattedData = dataPoints.map(point => {
        return {x: point.label, y: point.data[fieldName]};
    });

    return formattedData;
}
