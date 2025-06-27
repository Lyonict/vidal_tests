<?php

include("test/func.assert.php");

function maxChars($pString){

}

test_assert("maxChars test 1", "o", maxChars("woot"));
test_assert("maxChars test 2", "1", maxChars("123456781"));
test_assert("maxChars test 3", "a", maxChars("bbaaaa"));
test_assert("maxChars test 4", "b", maxChars("bbbbaaaa"));