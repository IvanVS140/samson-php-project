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
    // phpcs:ignore PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore
    private static $count = 0; // поменял местами private и static
    // phpcs:ignore PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore
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

    // phpcs:ignore PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore
    private $name;
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
    // исправил док комент
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

    // исправил док комент
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
     * __sleep
     *
     * @return void
     */
    public function __sleep()
    {
        return ['value'];
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
    /**
     * @return newBase
     */
    static public function load(string $value): newBase
    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1), $arValue[1]));
    }
}