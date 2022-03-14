<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

namespace Test3;

echo "<pre>";

// добавлен док комент для класса
/**
 * NewBase
 *
 * @category Test3
 * @package  Test3
 * @author   Ivan Shevyrev <ivanvs140@mail.ru>
 * @license  http://www.opensource.org Test3
 * @link     https://github.com
 */
class NewBase // переименован класс
{
    // phpcs:ignore PEAR.NamingConventions
    private static $count = 0; // поменял местами private и static
    // phpcs:ignore PEAR.NamingConventions
    private static $arSetName = []; // поменял местами private и static

    // исправил док комент
    /**
     * __construct
     *
     * @param string $name comment here
     *
     * @return void
     */
    public function __construct(int $name = 0) // добавил public
    {
        if (empty($name)) {
            while (array_search(self::$count, self::$arSetName) != false) {
                ++self::$count;
            }
            $name = self::$count;
        }
        $this->name = $name;
        self::$arSetName[] = $this->name;
    }

    private $name; // phpcs:ignore PEAR.NamingConventions
    // исправил док комент
    /**
     * GetName
     *
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }

    protected $value;
    // исправил док коммент
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
    }

    // добавил док комент. У становлен до всех serialize()
    /**
     * __sleep() - Магический метод для serialize()
     *
     * @return $value
     */
    public function __sleep()
    {
        return array("value"); // исправлено на функцию
    }

    // исправил док коммент
    /**
     * GetSize
     *
     * @return void
     */
    public function getSize()
    {
        $size = strlen(serialize($this->value));
        return strlen($size) + $size;
    }

    // добавил док комент
    /**
     * GetSave
     *
     * @return string
     */
    public function getSave(): string
    {
        $value = serialize($value);
        return $this->name . ':' . sizeof($value) . ':' . $value;
    }

    // Вызов метода класса без создания экземпляра
    /**
     * Load
     *
     * @param mixed $value comment here
     *
     * @return NewBase
     */
    public static function load(string $value): NewBase // static <-> public
    {
        $arValue = explode(':', $value);
        return (new NewBase($arValue[0]))->setValue(unserialize(substr($value, strlen($arValue[0]) + 1 + strlen($arValue[1]) + 1), $arValue[1]));
    }
}
