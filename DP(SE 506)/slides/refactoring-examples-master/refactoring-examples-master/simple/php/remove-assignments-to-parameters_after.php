<?php
function discount($inputVal, $quantity) {
  $result = $inputVal;
  if ($inputVal > 50)
    $result -= 2;
  ...