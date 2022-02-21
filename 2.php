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

/**
 * Imports XML file into MySQL database
 *
 * @param string $a path to XML file to import
 *
 * @return void import only
 */
function importXml($a)
{
    $mysqli = new mysqli('localhost', 'ivanvs140', 'EBGDAE', 'test_samson');
    $mysqli->set_charset('utf8');

    // Query to already existing product categories
    $prev_cat_query
        = "SELECT category_name
        FROM a_category
        ORDER BY category_id";
    $prev_cat_list = $mysqli->query($prev_cat_query);
    $cat_vault = array(); // categories vault
    // vscode: intelephense.diagnostics.undefinedMethods: false
    while ($prev_cat = $prev_cat_list->fetch_column(0)) {
        array_push($cat_vault, $prev_cat);
    }

    $xml = simplexml_load_file($a);

    /*
    Current product_id query swich.
    Сreated to reduce the number of database calls by finding the last value of
    product_id in a_product table and then using auto-increment on it
    */
    $switch = 1;

    foreach ($xml as $prod) {
        $prod_code // product code
            = $mysqli->real_escape_string($prod->attributes()["Код"]);
        $prod_name // product name
            = $mysqli->real_escape_string($prod->attributes()["Название"]);
        $prod_query = "INSERT INTO a_product VALUES(
            null, /* AI in the database */
            '$prod_code',
            '$prod_name')";
        $mysqli->query($prod_query);
        // Product ID
        if ($switch == 1) {
            // query to last added product_id in a_product table
            $rec_row_query
                = "SELECT product_id
                FROM a_product
                ORDER BY product_id
                DESC LIMIT 1";
            $rec_row = $mysqli->query($rec_row_query);
            foreach ($rec_row as $row) {
                $curr_prod_id = $row['product_id']; // current product ID
            }
            $switch = 0;
        }
        // Product price
        foreach ($prod->Цена as $price) {
            foreach ($price->attributes() as $price_attr) {
                $price_type // price type
                    = $mysqli->real_escape_string($price_attr);
            }
            $price_val // price value
                = $mysqli->real_escape_string((float) $price);
            $price_query = "INSERT INTO a_price VALUES(
                '$curr_prod_id',
                '$price_type',
                '$price_val')";
            $mysqli->query($price_query);
        }
        // Product properties
        foreach ($prod->Свойства->children() as $prop) {
             // propety name
            $prop_name = $mysqli->real_escape_string($prop->getName());
            // if the property has an attribute(s)
            $prop_val = $mysqli->real_escape_string($prop); // property value
            if ($prop->attributes()->count() > 0) {
                $prop_attr_full = ""; // the sum of all property attributes
                foreach ($prop->attributes() as $prop_attr) {
                    $attr_name // attribute name
                        = $mysqli->real_escape_string($prop_attr->getName());
                    $attr_val // attribute value
                        = $mysqli->real_escape_string($prop_attr[0]);
                    $prop_attr_full .= $attr_name . " " . $attr_val . ", ";
                }
                // property value (data summary) if there are an attributes
                $prod_prop
                    = $prop_name
                    . ": (" .
                    substr($prop_attr_full, 0, -2)
                    . "): "
                    . $prop_val;
            } else {
                // property value (data summary) if there is no attributes
                $prod_prop
                    = $prop_name
                    . ": "
                    . $prop_val
                    . ";";
            };
            $prop_query = "INSERT INTO a_property VALUES(
                '$curr_prod_id',
                '$prod_prop')";
            $mysqli->query($prop_query);
        }
        // Product categories
        foreach ($prod->Разделы->children() as $cat) {
            // category name
            $prod_cat = $mysqli->real_escape_string($cat);
            if (!in_array($prod_cat, $cat_vault)) {
                array_push($cat_vault, $prod_cat);
                /* random category code (missing in the test XML) for sample
                upload */
                $cat_code = rand(1000, 9999);
                $cat_query = "INSERT INTO a_category VALUES(
                    null, /* AI in the database */
                    '$cat_code',
                    '$prod_cat')";
                $mysqli->query($cat_query);
            }
        };
        $curr_prod_id++; // auto-increment that declared on line 131
    }
    $mysqli->close();
}

$path_to_xml = "files/products.xml";

importXml($path_to_xml);

// phpcs:ignore PSR2.Files.ClosingTag.NotAllowed
?>
