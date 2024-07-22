<?php require_once('header.php');?>

<?php
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page:
    header("Location: login.php");
    exit;
}
?>

<script src="3rdparty/plotly.min.js"></script>
<link rel="stylesheet" href="daterangepicker.css" />
<script src="3rdparty/jquery.min.js"></script>
<script src="3rdparty/moment.min.js"></script>
<script src="3rdparty/daterangepicker.min.js"></script>

<style>
        .form-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        .input-row, .saved-row {
            display: flex;
            margin-bottom: 10px;
        }
        .input-row input, .saved-row input {
            flex: 1;
            margin-right: 10px;
        }
        .input-row button, .saved-row button {
            flex: 0;
        }
        .saved-row input {
            background-color: #f0f0f0;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>


<div class="container">
        <label for="plotSelect">Betrieb wählen:</label>
        <select id="plotSelect">
            <option value="plot1">Testsite 1</option>
            <option value="plot2">Testbetrieb Timespan II</option>
            <option value="plot3">Testbetrieb Timespan</option>
        </select>
    </div>

    <div id="plotContainer" style="width: 100%; height: 500px;"></div>

    <script>
        // Fixed data for the time series
        const timeSeriesData = {
            plot1: [
                {x: '2023-01-01', y: 10},
                {x: '2023-01-02', y: 15},
                {x: '2023-01-03', y: 13},
                {x: '2023-01-04', y: 17},
                {x: '2023-01-05', y: 21},
                {x: '2023-01-06', y: 25},
                {x: '2023-01-07', y: 20},
                {x: '2023-01-08', y: 15},
                {x: '2023-01-09', y: 18},
                {x: '2023-01-10', y: 22}
            ],
            plot2: [
                {x: '2023-01-01', y: 30},
                {x: '2023-01-02', y: 35},
                {x: '2023-01-03', y: 33},
                {x: '2023-01-04', y: 37},
                {x: '2023-01-05', y: 31},
                {x: '2023-01-06', y: 28},
                {x: '2023-01-07', y: 34},
                {x: '2023-01-08', y: 29},
                {x: '2023-01-09', y: 36},
                {x: '2023-01-10', y: 32},
                {x: '2023-01-11', y: 38},
                {x: '2023-01-12', y: 40},
                {x: '2023-01-13', y: 45},
                {x: '2023-01-14', y: 43},
                {x: '2023-01-15', y: 42},
                {x: '2023-01-16', y: 39},
                {x: '2023-01-17', y: 41},
                {x: '2023-01-18', y: 44},
                {x: '2023-01-19', y: 47},
                {x: '2023-01-20', y: 49}
            ],
            plot3: [
                {x: '2023-01-01', y: 50},
                {x: '2023-01-02', y: 55},
                {x: '2023-01-03', y: 53},
                {x: '2023-01-04', y: 57},
                {x: '2023-01-05', y: 52},
                {x: '2023-01-06', y: 51},
                {x: '2023-01-07', y: 56},
                {x: '2023-01-08', y: 58},
                {x: '2023-01-09', y: 59},
                {x: '2023-01-10', y: 54},
                {x: '2023-01-11', y: 60},
                {x: '2023-01-12', y: 62},
                {x: '2023-01-13', y: 65},
                {x: '2023-01-14', y: 63},
                {x: '2023-01-15', y: 61},
                {x: '2023-01-16', y: 64},
                {x: '2023-01-17', y: 66},
                {x: '2023-01-18', y: 67},
                {x: '2023-01-19', y: 68},
                {x: '2023-01-20', y: 70},
                {x: '2023-01-21', y: 72},
                {x: '2023-01-22', y: 71},
                {x: '2023-01-23', y: 74},
                {x: '2023-01-24', y: 75},
                {x: '2023-01-25', y: 73},
                {x: '2023-01-26', y: 69},
                {x: '2023-01-27', y: 76},
                {x: '2023-01-28', y: 77},
                {x: '2023-01-29', y: 78},
                {x: '2023-01-30', y: 79},
                {x: '2023-01-31', y: 80}
            ]
        };

        function createTrace(data, name) {
            return {
                x: data.map(point => point.x),
                y: data.map(point => point.y),
                mode: 'lines+markers',
                name: name
            };
        }

        function updatePlot(plotId) {
            const data = [createTrace(timeSeriesData[plotId], plotId)];
            const layout = {
                title: `Time Series Plot: ${plotId}`,
                xaxis: { title: 'Date' },
                yaxis: { title: 'Value' }
            };
            Plotly.newPlot('plotContainer', data, layout);
        }

        // Initialize with the first plot
        document.addEventListener('DOMContentLoaded', () => {
            const plotSelect = document.getElementById('plotSelect');
            plotSelect.addEventListener('change', (event) => {
                updatePlot(event.target.value);
            });
            updatePlot(plotSelect.value); // Initial plot
        });
    </script>


<div class="form-container">
        <div class="input-row">
            <div class="daterangepicker-container">
                <input type="text" id="daterange" class="daterangepicker" placeholder="Select timespan" />
            </div>
            <input type="number" id="input1" placeholder="Consumption 1">
            <input type="number" id="input2" placeholder="Consumption 2">
            <input type="number" id="input3" placeholder="Consumption 3">
            <button id="addButton">+</button>
        </div>
        <div id="savedRows"></div>
        <div id="errorMessage" class="error"></div>
    </div>

    <script>
        // Initialize date range picker
        $(function() {
            $('#daterange').daterangepicker({
                locale: {
                    format: 'DD.MM.YYYY',
                    applyLabel: 'Anwenden',
                    cancelLabel: 'Abbrechen',
                    fromLabel: 'Von',
                    toLabel: 'Bis',
                    customRangeLabel: 'Benutzerdefiniert',
                    weekLabel: 'W',
                    daysOfWeek: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
                    monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                    firstDay: 1 //Mo
                },
                drops: 'down',
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
        /* Use moment to check if a date is in a range:
            var dateRangePicker = $('#daterange').data('daterangepicker');
            var startDate = dateRangePicker.startDate;
            var endDate = dateRangePicker.endDate;
            var checkDate = moment($('#checkdate').val());

            if (checkDate.isBetween(startDate, endDate, 'days', '[]')) {
                $('#result').text('The date is within the range.');
            } else {
                $('#result').text('The date is outside the range.');
            }
         */

        document.getElementById('addButton').addEventListener('click', function() {
            const daterange = document.getElementById('daterange').value;
            const input1 = document.getElementById('input1').value;
            const input2 = document.getElementById('input2').value;
            const input3 = document.getElementById('input3').value;
            const errorMessage = document.getElementById('errorMessage');

            // Basic sanity check: ensure all fields are filled
            if (!daterange || !input1 || !input2 || !input3) {
                errorMessage.textContent = 'All fields must be filled.';
                return;
            }

            // Create a new saved row
            const savedRow = document.createElement('div');
            savedRow.className = 'saved-row';
            savedRow.innerHTML = `
                <input type="text" value="${daterange}" readonly>
                <input type="number" value="${input1}" readonly>
                <input type="number" value="${input2}" readonly>
                <input type="number" value="${input3}" readonly>
                <button onclick="deleteRow(this)">x</button>
            `;
            document.getElementById('savedRows').appendChild(savedRow);

            // Clear the input fields
            document.getElementById('daterange').value = '';
            document.getElementById('input1').value = '';
            document.getElementById('input2').value = '';
            document.getElementById('input3').value = '';
            errorMessage.textContent = ''; // Clear any error messages
        });

        function deleteRow(button) {
            const row = button.parentElement;
            document.getElementById('savedRows').removeChild(row);
        }
    </script>

<?php require_once('footer.php');?>