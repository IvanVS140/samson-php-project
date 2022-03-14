<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

namespace OOP_Sample;

echo "<pre>";

/**
 * WeatherEntry
 *
 * @category OOP_Sample
 * @package  OOP_Sample
 * @author   Ivan Shevyrev <ivanvs140@mail.ru>
 * @license  http://www.opensource.org Test3
 * @link     https://github.com
 */
class WeatherEntry
{
    private $date; // phpcs:ignore PEAR.NamingConventions
    private $comment = ""; // phpcs:ignore PEAR.NamingConventions
    private $temperature = 0; // phpcs:ignore PEAR.NamingConventions

    private $isRainy = false; // phpcs:ignore PEAR.NamingConventions

    /**
     * __construct
     *
     * @param mixed $date        comment here
     * @param mixed $comment     comment here
     * @param mixed $temperature comment here
     *
     * @return void
     */
    public function __construct($date, string $comment, int $temperature)
    {
        $this->date = $date;
        $this->comment = $comment;
        $this->temperature = $temperature;
    }

    /**
     * Is Cold?
     *
     * @return void
     */
    public function isCold()
    {
        return $this->temperature < 0;
    }

    /**
     * Set rain status
     *
     * @param mixed $rain_status comment here
     *
     * @return void
     */
    public function setRainStatus($rain_status)
    {
        $this->isRainy = $rain_status;
    }

    /**
     * Get day description
     *
     * @return void
     */
    public function getDayDescription()
    {
        $dt = strtotime($this->date);
        $delta = time() - $dt;
        $days = ceil($delta / 86400);

        $add_comment = $this->comment;

        $res = "Это было $days дней назад. $add_comment. В тот день было ";

        if ($this->isCold()) {
            $res .= "холодно. ";
        } else {
            $res .= "довольно тепло. ";
        }

        if ($this->isRainy) {
            $res .= "Семенил дождь.";
        } else {
            $res .= "На небе не было ни облачка.";
        }

        return $res;
    }
}

$firstSeptember = new WeatherEntry("2018-09-01", "День знаний", 14);
$firstSeptember->setRainStatus(false);

print($firstSeptember->getDayDescription());

echo PHP_EOL;

$foo = "qwerty";

echo strlen(serialize($foo));

$foo = serialize($foo);
echo strlen($foo);

$bar = [1, 3, 6, 0, 23];
echo sizeof($bar);
