<?php

include("test/func.assert.php");

$data = array(
    "test"=>"bouboup",
    "foo"=>array(
        "bar"=>"test",
        "deep"=>array(
            "key"=>"value"
        )
    )
);

function stack($pId){

}

test_assert("stack test 1", "bouboup", stack("test"));
test_assert("stack test 2", "test", stack("foo.bar"));
test_assert("stack test 3", "value", stack("foo.deep.key"));