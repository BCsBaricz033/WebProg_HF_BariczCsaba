<?php
include "ArrayManipulator.php";
$obj = new ArrayManipulator(['a' => 1, 'b' => 2, 'c' => 3]);

echo $obj->a." A értéke<br>"; // Should print 1

$obj->b = 42;

echo isset($obj->c)." Isset<br>"; // Should print true

unset($obj->a);

echo $obj." Object unset után<br>"; // Should print "b: 42, c: 3"

$cloneObj = clone $obj;
echo $cloneObj." Clone object ";
