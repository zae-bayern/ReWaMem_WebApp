<?php

function testCalc($variables) {
  // Validate all necessary variables are there, return NaN otherwise
  if (!isset($variables['var1'], $variables['var2'])) {
    return NaN;
  }

  //Perform calculation here
  $var1 = $variables['var1']; $var2 = $variables['var2'];
  return ($var1+$var2)/($var1*$var2);
}

/****************************************************************************************/

// Expect data to be passed as JSON in a POST req
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);   // decode to array

// Validate requested calculation type 'type' and variables 'variables'
if (isset($input['type']) && isset($input['variables'])) {
  $type = $input['type'];
  $variables = $input['variables'];

  $result = ['success' => false, 'result' => 0, 'message' => ''];

  switch ($type) {
    case 'test':
      $result['result'] = array_sum($variables);  // REPLACE WITH REAL CALCS
      $result['result'] = testCalc($variables);
      $result['success'] = true;  // optional: validate calculation results (i.e. not NaN)
      break;
    default:
      $result['message'] = 'Invalid calculation type requested.';
      break;
  }

} else {
  $result = ['success' => false, 'message' => 'Missing calculation type or variables.'];
}

// Result as JSON
header('Content-Type: application/json');
echo json_encode($result);

/*
Call from JS with performCalculation(type, variables) in calculate.js
*/

?>