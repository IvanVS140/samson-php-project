<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

/**
 * There must be some description
 *
 * PHP version 7.3
 *
 * @index.php
 *
 * @category Lang
 * @package  Mixed
 * @author   Display Name <username@example.com>
 * @license  MIT License (https://www.opensource.org/licenses/)
 * @link     https://www.example.com
 */

/**
 * Implements hook_help().
 */

namespace TaskOne;

define("NEW_LINE", "<br/>");
define("EMPTY_LINE", "<br><br>");
echo "<pre>";

/**
 * Is prime
 *
 * @param int $num Comment here
 *
 * @return bool Comment here
 */
function isPrime(int $num): bool
{
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i === 0) {
            return false;
        }
    }
    return true;
}

/**
 * Find simple
 *
 * @param int $a Comment here
 * @param int $b Comment here
 *
 * @return array
 */
function findSimple(int $a = 2, int $b = 20): array
{
    if ($a == 1) {
        $a++;
    }
    $result = array();
    foreach (range($a, $b) as $num) {
        if (isPrime($num)) {
            array_push($result, $num);
        }
    }
    return $result;
}

print_r(findSimple());
echo EMPTY_LINE;

/**
 * Create trapeze
 *
 * @param array $a Comment here
 *
 * @return array
 */
function createTrapeze(
    array $a = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
    18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30)
): array {
    $a_split = array_chunk($a, 3);
    foreach ($a_split as $sub_array) {
        array_push($a_split, array_combine(array("a", "b", "c"), $sub_array));
    }
    return array_slice($a_split, count($a_split) / 2);
}

print_r(createTrapeze());
echo EMPTY_LINE;

/**
 * Square trapeze
 *
 * @param array $a Comment here
 *
 * @return void
 */
function squareTrapeze(array &$a)
{
    array_walk(
        $a,
        function (&$i) {
            $i["s"] = 0.5 * (reset($i) + array_values($i)[1]) * end($i);
        }
    );
}

$my_trapeze = createTrapeze();
squareTrapeze($my_trapeze);
print_r($my_trapeze);
echo EMPTY_LINE;

/**
 * Get size for limit
 *
 * @param array $a Comment here
 * @param mixed $b (float & int types acceptable) Comment here
 *
 * @return array
 */
function getSizeForLimit(array $a, $b): array
{
    foreach (array_reverse($a) as $trapeze) {
        if (end($trapeze) > $b) {
            continue;
        }
        return $trapeze;
    }
}

$test_limits = array(201, 202, 202.4, 202.5, 202.7, 203, 100500);
foreach ($test_limits as $i) {
    $square = end(getSizeForLimit($my_trapeze, $i));
    $passed = "Expected [s] => $square\nTest passed!\n";
    echo "Square limit: <b>" . $i . "</b>\n";
    if ($i <= 202.4 && $square == 126) {
        echo $passed;
    } elseif ($i >= 202.5 && $i <= 203 && $square == 202.5) {
        echo $passed;
    } elseif ($i == 100500 && $square == 855) {
        echo $passed;
    } else {
        echo "Test failure\n";
    }
    print_r(getSizeForLimit($my_trapeze, $i));
    echo "\n";
}
echo NEW_LINE;

/**
 * Get minimum
 *
 * @param array $a Comment here
 *
 * @return mixed int or float
 */
function getMin(
    array $a = array(
        53 => 66,
        "qwe" => 183,
        109 => 47,
        "asd" => 48,
        38 => 161,
        "zxc" => 30.999,
        129 => "qux",
        104 => "quux",
        29 => "quuux",
        117 => 66.18,
        69 => 29.001,
        132 => 133.3,
    )
) {
    $a = array_merge(array_keys($a), array_values($a));
    sort($a);
    foreach ($a as $i) {
        if (gettype($i) != "integer" && gettype($i) != "double") {
            continue;
        }
        return $i;
    }
}

echo "Minimum number is: <b>" . getMin() . "</b>";
echo EMPTY_LINE;

/**
 * Print trapeze
 *
 * @param array $a Comment here
 *
 * @return void
 */
function printTrapeze(array $a): void
{
    echo "
    <table width=200 border=1 bordercolor=darkgrey cellspacing=0 cellpadding=5>
    <th>#<th>";
    echo implode('<th>', array_keys(current($a)));
    foreach ($a as $key => $val) {
        echo "<tr><td>";
        if (end($val) != intval(end($val)) || end($val) % 2 != 0) {
            echo "> <i>" . $key = $key + 1 . "<td><i><b>" .
            implode('</td><td><i><b>', $val);
        } else {
            echo "&nbsp;&nbsp;" . $key = $key + 1 . "<td><sub>" .
            implode('</td><td><sub>', $val);
        }
    }
    echo "</table>";
}

printTrapeze($my_trapeze);
echo EMPTY_LINE;

/**
 * Base math
 *
 * @category Tag_In_Class_Comment
 * @package  Tag_In_Class_Comment
 * @author   Display Name <username@example.com>
 * @license  http://www.opensource.org/licenses/ Test
 * @link     http://www.example.com
 */
abstract class BaseMath /* phpcs:ignore
PSR1.Classes.ClassDeclaration.MultipleClasses */
{
    /**
     * Expression №1
     *
     * @return mixed Comment here
     */
    public function exp1()
    {
        return $this->a * ($this->b ^ $this->c);
    }
    /**
     * Expression №2
     *
     * @return mixed Comment here
     */
    public function exp2()
    {
        return ($this->a / $this->b) ^ $this->c;
    }
    /**
     * Expression №1
     *
     * @return void Comment here
     */
    abstract protected function getValue();
}

/**
 * Function №1
 *
 * @category Tag_In_Class_Comment
 * @package  Tag_In_Class_Comment
 * @author   Display Name <username@example.com>
 * @license  http://www.opensource.org/licenses/ Test
 * @link     http://www.example.com
 */
class F1 extends BaseMath /* phpcs:ignore
PSR1.Classes.ClassDeclaration.MultipleClasses */
{
    protected $a;
    protected $b;
    protected $c;
    /**
     * Constructor
     *
     * @param mixed $a Comment here
     * @param mixed $b Comment here
     * @param mixed $c Comment here
     *
     * @return mixed
     */
    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return
        ($this->a *
            ($this->b ^ $this->c) + ((($this->a / $this->c) ^ $this->b) % 3) ^
            min($this->a, $this->b, $this->c)
        );
    }
}

$nums = new F1(6, 4, 2);
echo $nums->exp1() . "\n";
echo $nums->exp2() . "\n";
echo $nums->getValue() . "\n";

// phpcs:ignore PSR2.Files.ClosingTag.NotAllowed
?>
