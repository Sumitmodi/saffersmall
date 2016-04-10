<?php

// If in testing mode use the sandbox domain ?  sandbox.payfast.co.za else www.payfast.co.za

$testingMode = true;

$pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';

$htmlForm = '<form action="https://' . $pfHost . '/eng/process" method="post">';

foreach ($data as $name => $value) {

    $htmlForm .= '<input type="hidden" name="' . $name . '" value="' . $value . '">';
}

$htmlForm .= '<input type="submit" value="Pay Now"></form>';



echo $htmlForm;
