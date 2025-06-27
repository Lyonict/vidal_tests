<?php

include("test/func.assert.php");

$data = array(
    "test" => "bouboup",
    "foo" => array(
        "bar" => "test",
        "deep" => array(
            "key" => "value",
        )
    )
);

/*
Though process :

The problem doesn't seem that hard at face value : we only have to explode the input and then return the path of the $data array corresponding to result of the explosion

However, just doing so would certainly work, but what if the input isn't correctly formated ? Or if the path doesn't exist ? We need to account for those possibilities
*/

function stack($pId)
{
    if (!is_string($pId)) {
        throw new InvalidArgumentException("Input must be a string");
    }
    // Regex : accept a string made up of 1 or more words (letters only), that can be separated by dots
    if (!preg_match('/^[a-zA-Z]+(\.[a-zA-Z]+)*$/', $pId)) {
        throw new InvalidArgumentException("The input must be a string made up of only letters and . (ex: \"foo.bar\")");
    }

    // Not best practice ,I think. It'd be better to pass it as a parameter
    global $data;
    $keys = explode(".", $pId);
    $current = $data;
    foreach ($keys as $key) {
        if (!isset($current[$key])) {
            throw new OutOfBoundsException("Path does not exist in \$data array");
        }
        $current = $current[$key];
    }
    return $current;
}

test_assert("stack test 1", "bouboup", stack("test"));
test_assert("stack test 2", "test", stack("foo.bar"));
test_assert("stack test 3", "value", stack("foo.deep.key"));

// Additional test cases, to check that exeptions are correctly triggered
try {
    test_assert("stack test InvalidArgumentException non string imput", "Exception expected", stack(123));
} catch (InvalidArgumentException $e) {
    test_assert("stack test InvalidArgumentException non string imput", "Input must be a string", $e->getMessage());
}

try {
    test_assert("stack test InvalidArgumentException non conform input", "Exception expected", stack("foo bar"));
} catch (InvalidArgumentException $e) {
    test_assert("stack test InvalidArgumentException non conform input", "The input must be a string made up of only letters and . (ex: \"foo.bar\")", $e->getMessage());
}

try {
    test_assert("stack test OutOfBoundsException", "Exception expected", stack("foo.bar.baz"));
} catch (OutOfBoundsException $e) {
    test_assert("stack test OutOfBoundsException", "Path does not exist in \$data array", $e->getMessage());
}