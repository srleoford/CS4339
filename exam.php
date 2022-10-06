<html xmlns="http://www.w3.org/1999/html">
<head>
    <h1> Exam Test!</h1>
</head>
<body>
<form action="exam.php" method="post">
    <label for="x">x:</label>
    <input id="x" type="text" name="x">
    <label for="y">y:</label>
    <input id="y" type="text" name="y">
    <label for="op">op:</label>
    <input id="op" type="text" name="op">
    <input type="submit" value="Compute">
</form>

<?php


$number = 12345 * 67890;
echo substr($number, 3, 4);
echo "\n";

function longdate($timestamp)
{
    $temp = date("l F jS Y", $timestamp);
    return "The date is $temp";
}
echo longdate(mktime(13, 45, 11, 7, 28, 1989));
//if (isset($_POST['x']) and isset($_POST['y']) and isset($_POST['op'])) {
//    print("This is the \$op: {$_POST['op']}");
//
//    if ($_POST['op'] != '-' or $_POST['op'] != '*' or
//        $_POST['op'] != '/' or $_POST['op'] != '+') {
//        echo "Invalid operand inputted into to 'op'\n";
//    }
//    else if (!ctype_digit($_POST['x'])) {
//        echo "Invalid digit for 'x'.\n";
//    }
//    else if (!ctype_digit($_POST['y'])) {
//        echo "Invlaid digit for 'y'.\n";
//    }
//    else {
//        $x = (int) $_POST['x'];
//        $y = (int) $_POST['y'];
//        $op = $_POST['op'];
//        $result = 0;
//        switch ($op) {
//            case "/":
//                $result = $x / $y;
//                break;
//            case "*":
//                $result = $x * $y;
//                break;
//            case "-":
//                $result = $x - $y;
//                break;
//            case "+":
//                $result = $x + $y;
//                break;
//        }
//        print("$x $op $y = $result");
//    }
//}

?>

<table border="2">
    <tr>
        <th>Professor</th>
        <th colspan="2">Phone Number</th>
    </tr>
    <tr>
        <td rowspan="2">Kreinovich</td>
        <td>555-393498</td>
        <td>home</td>
    </tr>
    <tr>
        <td>398-3983</td>
        <td>work</td>
    </tr>

</table>

</body>
</html>