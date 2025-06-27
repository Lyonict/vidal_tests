<?php

include("test/func.assert.php");

function toDigit($pString){

}

test_assert("toDigit test 1", 1, toDigit("un"));
test_assert("toDigit test 2", 12, toDigit("un;deux"));
test_assert("toDigit test 3", 54321, toDigit("cinq;quatre;trois;deux;un"));