<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

namespace Test3;

class newBase
{
    static private $count = 0;
    static private $arSetName = [];
    /**
     * @param string $name
     */
    function __construct(int $name = 0)
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
    private $name;
    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }
    protected $value;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    /**
     * @return string
     */
    public function getSize()
    {
        $size = strlen(serialize($this->value));
        return strlen($size) + $size;
    }
    public function __sleep()
    {
        return ['value'];
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
        $value = serialize($this->value);
        return $this->name . ':' . strlen($value) . ':' . $value;
    }
    /**
     * @return newBase
     */
    public static function load(string $value)
    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1), $arValue));
    }
}
class newView extends newBase
{
    private $type = null;
    private $size = 0;
    private $property = null;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->setType();
        $this->setSize();
    }
    public function setProperty($value)
    {
        $this->property = $value;
        return $this;
    }
    private function setType()
    {
        $this->type = gettype($this->value);
    }
    private function setSize()
    {
        if (is_subclass_of($this->value, "Test3\newView")) {
            $this->size = parent::getSize() + 1 + strlen($this->property);
        } elseif ($this->type == 'test') {
            $this->size = parent::getSize();
        } else {
            $this->size = 1;
        }
    }
    /**
     * @return string
     */
    public function __sleep()
    {
        return ['property'];
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        try {
            if (empty($this->name)) {
                throw new \Exception('The object doesn\'t have name');
            }
        } catch (\Exception $e) {
            return '"' . "no-object-name"  . '": ';
        }

    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return ' type ' . $this->type  . ';';
    }
    /**
     * @return string
     */
    public function getSize(): string
    {
        return ' size ' . $this->size . ';';
    }
    public function getInfo()
    {
        try {
            echo $this->getName()
                . $this->getType()
                . $this->getSize()
                . "\r\n";
        } catch (Exception $exc) {
            echo 'Error: ' . $exc->getMessage();
        }
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
        if ($this->type == 'test') {
            $this->value = $this->value->getSave();
        }
        return parent::getSave() . serialize($this->property);
    }

    /**
     * @return newView
     */
    public static function load(string $value)
    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1), $arValue))
            ->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1 + $arValue[1])));
    }
}

function gettype($value): string
{
    if (is_object($value)) {
        return get_class($value);
    }
    return gettype($value);
}


$obj = new newBase('12345');
$obj->setValue('text');

$obj2 = new newView('9876');
$obj2->setValue($obj);
$obj2->setProperty('field');
$obj2->getInfo();

$save = $obj2->getSave();

$obj3 = newView::load($save);

var_dump($obj2->getSave() == $obj3->getSave());
