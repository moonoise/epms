<?php
$tests = array(
    "",
    1337,
    0x539,
    02471,
    0b10100111001,
    1337e0,
    "not numeric",
    array(),
    9.1,
    null
);

foreach ($tests as $element) {
    if (is_numeric($element)) {
        echo var_export($element, true) . " is numeric <br>", PHP_EOL;
    } else {
        echo var_export($element, true) . " is NOT numeric <br>", PHP_EOL;
    }
}
?>
