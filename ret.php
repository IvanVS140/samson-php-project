<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

namespace Test3;

echo "<pre>";

/**
 * NewBase
 *
 * @category Test3
 * @package  Test3
 * @author   Ivan Shevyrev <ivanvs140@mail.ru>
 * @license  http://www.opensource.org Test3
 * @link     https://github.com
 */
class NewBase
{
    private string $name; // phpcs:ignore PEAR.NamingConventions
    protected string $value;

    /**
     * __construct
     *
     * @param mixed $newBaseName comment here
     *
     * @return void
     */
    public function __construct($newBaseName)
    {
        $this->name = $newBaseName;
    }

    /**
     * SetName
     *
     * @param mixed $newName comment here
     *
     * @return string
     */
    public function setName(string $newName): string
    {
        $this->name = $newName;
        return  $this->name;
    }

    /**
     * GetName
     *
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }

    /**
     * SetValue
     *
     * @param mixed $value comment here
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $value;
    }

    /**
     * GetValue
     *
     * @return void
     */
    public function getValue()
    {
        return  '*' . $this->value . '*' ;
    }

    /**
     * Getsize
     *
     * @return void
     */
    public function getSize()
    {
        return strlen($this->value);
    }

    /**
     * Get save
     *
     * @return string
     */
    public function getSave(): string
    {
        return $this->name . ':' . strlen($this->value) . ':' . $this->value;
    }

    /**
     * Load
     *
     * @param mixed $arValue comment here
     *
     * @return void
     */
    public function load(&$arValue)
    {
        array_push($arValue, $this->value);
        return $arValue;
    }
}

$obj = new newBase('Base1');

echo "1) Вывод текущего имени: " . $obj->getName();
echo PHP_EOL;
echo PHP_EOL;

echo "2) Устанавливаем новое имя с помощью функции setName()";
$obj->setName('New_base');
echo PHP_EOL;
echo "   Вывод текущего имени: " . $obj->getName();
echo PHP_EOL;
echo PHP_EOL;

echo "3) Устанавливаем значение с помощью функции  setValue()";
$obj->setValue('Julia');
echo PHP_EOL;
echo "   Вывод установленного значения: " . $obj->getValue();
echo PHP_EOL;
echo PHP_EOL;

echo "4) Вывод длинны строки value c помощью функции getSize(): ";
echo $obj->getSize();
echo PHP_EOL;
echo PHP_EOL;

echo "5) Работа функции getSave(): " . $obj->getSave();
echo PHP_EOL;
echo PHP_EOL;

echo "6) Создаем массив.";
echo PHP_EOL;
echo PHP_EOL;

echo "7) Добавляем в массив значение value и выводим массив с помощью load(): ";
echo PHP_EOL;
echo "   ";
$arValue = [];
$obj->load($arValue);
print_r($arValue);
echo PHP_EOL;
echo PHP_EOL;

echo "Устанавливаем новое значение.";
$obj->setValue('Seraphima');
echo PHP_EOL;

echo "Опять выводим массив:";
echo PHP_EOL;
$obj->load($arValue);
print_r($arValue);
echo PHP_EOL;

echo "Работа функции getSave(): " . $obj->getSave();
