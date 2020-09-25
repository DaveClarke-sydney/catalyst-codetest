<?php

$div = ", ";
for($i = 1; $i < 101; $i++){

	if(divisibleByFiveAndThree($i)){
		echo "foobar";
		echo $div;
	} elseif (divisibleByFive($i)){
		echo "bar";
		echo $div;	
	} elseif (divisibleByThree($i)){
		echo "foo";
		echo $div;
	} else {
		echo $i;
		echo $div;
	}
}

function divisibleByFiveAndThree($i)
{
	return divisibleByFive($i) && divisibleByThree($i);
}

function divisibleByFive($i)
{
	return $i % 5 == 0;
}

function divisibleByThree($i)
{
	return $i % 3 == 0;
}


?>
