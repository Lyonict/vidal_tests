<?php

function test_assert($pName, $pAwaitedValue, $pValue)
{
    $result = $pAwaitedValue === $pValue;
    $message = "incorrect";
    if($result){
        $message = "correct";
    }
    echo("func.assert.php : ".$pName." ".$message.PHP_EOL);
    if(!$result){
        echo(" Valeur attendue ".$pAwaitedValue.PHP_EOL);
        echo(" Valeur proposée ".$pValue.PHP_EOL);
    }
}