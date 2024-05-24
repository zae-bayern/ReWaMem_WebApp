function performCalculation(type, variables) {
  fetch('/backend/calculate.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ type: type, variables: variables })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById('result').textContent = 'Result: ' + data.result;
      } else {
        document.getElementById('result').textContent = 'Error: ' + data.message;
      }
    })
    .catch(error => {
      document.getElementById('result').textContent = 'Network error: ' + error;
    });
}

// performCalulation('test', [10.0, 20.5, 5.667])