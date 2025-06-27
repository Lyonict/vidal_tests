<?php

include("test/func.assert.php");

/*
Though process :

At first glance, this doesn't seem too hard : we only need to create an associative array with the key being the string and the value being the int equivalent, and proceed from there
(actually let's do it the other way around, looks nicer)
(actually it's more efficient to search by key than by value, so nevermind)

We can reuse part of the logic we created in 1-stack, it's kind of similar

It'd probably be easier for concat purposes to create the result as a string, and then convert it into int

It works well, but I wonder... maybe we could go even further ?

*/

$numberDict = [
    "un" => 1,
    "deux" => 2,
    "trois" => 3,
    "quatre" => 4,
    "cinq" => 5,
    "six" => 6,
    "sept" => 7,
    "huit" => 8,
    "neuf" => 9
];

function toDigit($pString)
{
    if (!is_string($pString)) {
        throw new InvalidArgumentException("Input must be a string");
    }

    $numbers = explode(";", $pString);
    global $numberDict;
    $current = $numberDict;
    $intString = "";
    foreach ($numbers as $number) {
        if (!isset($current[$number])) {
            throw new OutOfBoundsException("Path does not exist in \$numberDict array");
        }
        $intString .= $current[$number];
    }
    return intval($intString);
}

test_assert("toDigit test 1", 1, toDigit("un"));
test_assert("toDigit test 2", 12, toDigit("un;deux"));
test_assert("toDigit test 3", 54321, toDigit("cinq;quatre;trois;deux;un"));

// Additional test cases
try {
    test_assert("toDigit test InvalidArgumentException", "Exception expected", toDigit(123));
} catch (InvalidArgumentException $e) {
    test_assert("toDigit test InvalidArgumentException", "Input must be a string", $e->getMessage());
}
try {
    test_assert("toDigit test OutOfBoundsException", "Exception expected", toDigit("foo.bar.baz"));
} catch (OutOfBoundsException $e) {
    test_assert("toDigit test OutOfBoundsException", "Path does not exist in \$numberDict array", $e->getMessage());
}