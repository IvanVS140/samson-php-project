<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

echo "<pre>";

$haystack = array(  '01qweabc234567defgqwe8910qwexyz',
                    '01abc234567defgqwe8910qwexyz',
                    '01abc234567defg8910qwexyz',
                    '01abc234567defg8910xyz');
$needle = 'qwe';

/**
 * Converts second occurrence substring into reverse
 *
 * @param mixed $a Source string
 * @param mixed $b Substring needle
 *
 * @return Source string with converted second occurrence substring
 */
function convertString($a, $b)
{
    if (substr_count($a, $b) > 1) {
        $i = strpos($a, $b, strpos($a, $b) + strlen($b)); // second occur index
        return substr_replace($a, strrev($b), $i, strlen($b));
    } else {
        return "Less than two occurrences (" . substr_count($a, $b) . ")";
    }
}

echo "Substring: " . $needle  . str_repeat(PHP_EOL, 2);
foreach ($haystack as $str) {
    echo $str . PHP_EOL . convertString($str, $needle) . str_repeat(PHP_EOL, 2);
}

/**
 * Checks key existence and throws exception if it doesn't
 *
 * @param mixed $key Key to check
 * @param array $arr Array to be checked
 *
 * @return void
 */
function keyExistence($key, $arr)
{
    if (!array_key_exists($key, $arr)) {
        throw new OutOfRangeException("key [$key] is missing");
    }
}

/**
 * Sorting an array in ascending order of values for user key
 *
 * @param array $a Array to sort
 * @param mixed $b User key
 *
 * @return array An array, sorted in ascending order of values for the user key
 */
function mySortForKey($a, $b)
{
    $error_count = 0;
    foreach ($a as $key => $value) {
        try {
            keyExistence($b, $value);
        } catch (OutOfRangeException $e) {
            echo "Warning! The " . $e->getMessage() . " at index [$key]" .
            PHP_EOL;
            $error_count++;
        }
    }
    if ($error_count == 0) {
        $sort_arr = array();
        foreach ($a as $key => $value) {
            $sort_arr[$key] = $value[$b];
        }
        array_multisort($sort_arr, $a);
        return $a;
    } else {
        echo "Total errors: $error_count";
    }
}

$test_array = array(
    [['a' => 0, 'b' => 3], ['b' => 1, 'a' => 5.4], ['a' => 5.3, 'b' => 2]],
    [['a' => 0, 'b' => 3], ['c' => 1, 'a' => 5.4], ['a' => 5.3, 'b' => 2]],
    [['a' => 0, 'c' => 3], ['b' => 1, 'a' => 5.4], ['a' => 5.3, 'c' => 2]],
    [['a' => 0, 'c' => 3], ['c' => 1, 'a' => 5.4], ['a' => 5.3, 'c' => 2]]
);

$user_key = 'b';

foreach ($test_array as $arr) {
    print_r(mySortForKey($arr, $user_key));
    echo str_repeat(PHP_EOL, 2);
}

// MySQL
echo PHP_EOL;

$xml = simplexml_load_file("products.xml");

$mysqli = new mysqli('localhost', 'ivanvs140', 'EBGDAE', 'test_samson');
$mysqli->set_charset('utf8');

// $recent_row = $mysqli->query(
//     "SELECT product_id FROM a_product ORDER BY product_id DESC LIMIT 1"
// );

// foreach ($recent_row as $row) {
//     $ex_product_id = $row['product_id'];
// }
// echo $current_product_id = $ex_product_id + 1 . PHP_EOL;

// $property_query = "INSERT INTO a_property VALUES(6, 'wewewewe')";
// $mysqli->query($property_query);

foreach ($xml as $product_key => $product) {
     // код продукта
    echo $product_code = $product->attributes()["Код"] . " ";
     // название продукта
    echo $product_name = $product->attributes()["Название"] . " ";
    $product_query = "INSERT INTO a_product VALUES(
        null,
        '$product_code',
        '$product_name')";
        $mysqli->query($product_query);
    // текущий id продукта
    $recent_row = $mysqli->query(
        "SELECT product_id FROM a_product ORDER BY product_id DESC LIMIT 1"
    );
    foreach ($recent_row as $row) {
        echo $current_product_id = $row['product_id'];
    }

    // ищем цену
    foreach ($product->Цена as $price) {
        foreach ($price->attributes() as $price_type) {
            echo $price_type->__toString() . " "; // тип цены
        }
        echo (float) $price->__toString() . " "; // цена
    }
    foreach ($product->Свойства->children() as $property) {
        $property_name = $property->getName(); // название свойства
        $attr_mame = null;
        $attr_value = null;
        $product_property  = null;
        if ($property->attributes()->count() > 0) {
            $attr_mame = $property->attributes()->getName(); // название атрибута
            $attr_value = $property->attributes(); // значение атрибута
            echo $product_property = $property_name . "(" . $attr_mame . " " . $attr_value . "):" . $property;
        } else {
            echo $product_property = $property_name . ":" . $property . ";"; // значение свойства
        };

        // $property_query = "INSERT INTO a_property VALUES(
        //     '$current_product_id',
        //     '$product_property')";
        // $mysqli->query($property_query);
    }
    foreach ($product->Разделы->children() as $category) {
        echo $category->__toString() . " "; // категория
    }
    echo PHP_EOL . PHP_EOL;
}

// $mysqli = new mysqli('localhost', 'ivanvs140', 'EBGDAE', 'test_samson');
// $mysqli->set_charset('utf8');
// $query = "INSERT INTO a_product VALUES(null, 234,'test_name_5')";
// $mysqli->query($query);

$mysqli->close();

echo "query done";

// phpcs:ignore PSR2.Files.ClosingTag.NotAllowed
?>
