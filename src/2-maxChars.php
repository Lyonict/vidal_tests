<?php

include("test/func.assert.php");

/*
Though process :

Seem somewhat easier at first glance than the first, as there are less ways for it to go wrong.

I can see two solution to the problem : eitheir the "brute force" method, or the "hashmap" method
I don't think PHP really has hashmaps, rather it has associative arrays, but we could use a similar logic

Then there is also another issue : if we have multiple characters in a tie, should we return the first character that reaches the max number, or the first character that appears and happens to reach the max number ?
ex : abbbaa -> both "a" and "b" have 3 occurences, but should we return "b" because it's the first to reach the max number, or "a" because it's the first "in order" ?

Maybe the 2nd would be easier with an "hashmap" method ?

Actually, by improving the code and tracking the biggest occurence in a single loop, it's easier to track the one that reaches the threeshold first

But we can still achieve the other outcome by having a second loop. Let's make an alt solution

*/

function maxChars($pString)
{
    if (!is_string($pString)) {
        throw new InvalidArgumentException("Input must be a string");
    }
    $charMap = [];
    $maxChar = '';
    $maxCount = 0;
    for ($i = 0; $i < strlen($pString); $i++) {
        $current = $pString[$i];
        if (isset($charMap[$current])) {
            $charMap[$current]++;
        } else {
            $charMap[$current] = 1;
        }
        if ($charMap[$current] > $maxCount) {
            $maxCount = $charMap[$current];
            $maxChar = $current;
        }
    }
    return $maxChar;
}

test_assert("maxChars test 1", "o", maxChars("woot"));
test_assert("maxChars test 2", "1", maxChars("123456781"));
test_assert("maxChars test 3", "a", maxChars("bbaaaa"));
test_assert("maxChars test 4", "b", maxChars("bbbbaaaa"));

// Additional test cases
test_assert("maxChars test 5", "b", maxChars("abbbaa"));
test_assert("maxChars test 6", ".", maxChars(".gdp7'HgP/f.a*lf.Hç`d."));
try {
    test_assert("maxChars test InvalidArgumentException", "Exception expected", maxChars(123));
} catch (InvalidArgumentException $e) {
    test_assert("maxChars test InvalidArgumentException", "Input must be a string", $e->getMessage());
}


// Alternative version of the solution, which this time uses 2 loops instead of one, but can output a different result depending on what we want
function maxCharsAlt($pString)
{
    if (!is_string($pString)) {
        throw new InvalidArgumentException("Input must be a string");
    }
    $charMap = [];
    for ($i = 0; $i < strlen($pString); $i++) {
        $current = $pString[$i];
        if (isset($charMap[$current])) {
            $charMap[$current]++;
        } else {
            $charMap[$current] = 1;
        }
    }

    $maxChar = '';
    $maxCount = 0;
    foreach ($charMap as $char => $count) {
        if ($count > $maxCount) {
            $maxCount = $count;
            $maxChar = $char;
        }
    }
    return $maxChar;
}

// Same test as maxCharsAlt test 4, but this time the output is a, not b, due to the way we track the maxCount
test_assert("maxCharsAlt test 4", "a", maxCharsAlt("abbbaa"));