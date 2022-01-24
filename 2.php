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

// Запрос уже существующих категорий товаров
$prev_cat_query = "SELECT category_name FROM a_category ORDER BY category_id ";
$prev_cat_list = $mysqli->query($prev_cat_query);
$cat_vault = array();
// vscode: intelephense.diagnostics.undefinedMethods: false
while ($prev_cat = $prev_cat_list->fetch_column(0)) {
    array_push($cat_vault, $prev_cat);
}

$switch = 1; // Выключатель для запроса текущего product_id

foreach ($xml as $prod) {
    $prod_code = $prod->attributes()["Код"]; // Код продукта
    $prod_name = $prod->attributes()["Название"]; // Название продукта
    $prod_query = "INSERT INTO a_product VALUES(
        null,
        '$prod_code',
        '$prod_name')";
        $mysqli->query($prod_query);
    // id продукта
    if ($switch == 1) {
        $rec_row_query
            = "SELECT product_id FROM a_product ORDER BY product_id DESC LIMIT
            1";
        $rec_row = $mysqli->query($rec_row_query);
        foreach ($rec_row as $row) {
            $curr_prod_id = $row['product_id'];
        }
        $switch = 0;
    }
    // Цена продукта
    foreach ($prod->Цена as $price) {
        foreach ($price->attributes() as $price_attr) {
            $price_type = $price_attr->__toString(); // Тип цены
        }
        $price_val = (float) $price->__toString(); // Значение цены
        $price_query = "INSERT INTO a_price VALUES(
            '$curr_prod_id',
            '$price_type',
            '$price_val')";
            $mysqli->query($price_query);
    }
    // Свойства продукта
    foreach ($prod->Свойства->children() as $prop) {
        $prop_name = $prop->getName(); // Название свойства
        if ($prop->attributes()->count() > 0) {
            $prop_attr_mame = $prop->attributes()->getName();
            $prop_attr_val = $prop->attributes();
            $prod_prop
                = $prop_name
                . "("
                . $prop_attr_mame
                . " "
                . $prop_attr_val
                . "):"
                . $prop;
        } else {
            $prod_prop
                = $prop_name
                . ":"
                . $prop
                . ";";
        };
        $prop_query = "INSERT INTO a_property VALUES(
            '$curr_prod_id',
            '$prod_prop')";
        $mysqli->query($prop_query);
    }
    // Категории продукта
    foreach ($prod->Разделы->children() as $cat) {
        $prod_cat = $cat->__toString(); // Название категории
        if (!in_array($prod_cat, $cat_vault)) {
            array_push($cat_vault, $prod_cat);
            $cat_code = rand(1111, 9999); // Случайный код для категории
            $cat_query = "INSERT INTO a_category VALUES(
                null,
                '$cat_code',
                '$prod_cat')";
            $mysqli->query($cat_query);
        }
    };
    $curr_prod_id++;
}

$mysqli->close();

echo "query done";

// phpcs:ignore PSR2.Files.ClosingTag.NotAllowed
?>
