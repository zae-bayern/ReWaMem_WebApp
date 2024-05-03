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
            //plotDataWithPlotly(numericalData);
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

/** Plot data of multiple sites as an ordered bar graph with the average value and that +/- as lines*/
function plotBarGraph(dataPoints) {
/* Data Points expected in this format:
    let dataPoints = [
        {x: "A", y: 20},
        {x: "B", y: 15},
        {x: "C", y: 30},
        {x: "D", y: 10},
        {x: "E", y: 25}
    ];
    */

    // Calculate average
    const total = dataPoints.reduce((acc, curr) => acc + curr.y, 0);
    const average = total / dataPoints.length;
    const averagePlus10 = average * 1.1;
    const averageMinus10 = average * 0.9;

    // Create arrays for Plotly
    const xValues = dataPoints.map(point => point.x);
    const yValues = dataPoints.map(point => point.y);
    const yValuesSecondary = yValues.map(y => y * Math.random()); // Secondary values between 0 and 1 of actual

    // Plot
    var trace1 = {
        x: xValues,
        y: yValues,
        type: 'bar',
        name: 'Primary Values',
        marker: {
            color: 'blue'
        }
    };

    var trace2 = {
        x: xValues,
        y: yValuesSecondary,
        type: 'bar',
        name: 'Secondary Values',
        marker: {
            color: 'lightblue'
        }
    };

    var averageLine = {
        x: xValues,
        y: Array(xValues.length).fill(average),
        type: 'scatter',
        mode: 'lines',
        name: 'Average',
        line: {
            color: 'red',
            dash: 'dash'
        }
    };

    var averageLinePlus10 = {
        x: xValues,
        y: Array(xValues.length).fill(averagePlus10),
        type: 'scatter',
        mode: 'lines',
        name: 'Average + 10%',
        line: {
            color: 'green',
            dash: 'dot'
        }
    };

    var averageLineMinus10 = {
        x: xValues,
        y: Array(xValues.length).fill(averageMinus10),
        type: 'scatter',
        mode: 'lines',
        name: 'Average - 10%',
        line: {
            color: 'orange',
            dash: 'dot'
        }
    };

    var layout = {
        title: 'Bar Graph with Average Lines',
        barmode: 'group'
    };

    var config = {
        responsive: true
    };

    Plotly.newPlot('bar-chart', [trace1, trace2, averageLine, averageLinePlus10, averageLineMinus10], layout, config);
}