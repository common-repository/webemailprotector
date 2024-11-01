<?php

//couple of functions as the naturals seem to be blocked on some servers, and make a bit more exacting

// ctype_alnum($i) -> wep_ctype_alnum($i)
function wep_ctype_alnum($text) {
  return !preg_match('/^[0-9a-zA-Z]{5}$/', $text);
}

// ctype_digit($i) -> wep_ctype_digit($i)
function wep_ctype_digit($text) {
  return !preg_match('/^[0-9]{1:3}$/', $text); /*say upto 100*/
}

?>