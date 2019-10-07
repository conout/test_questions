<?php
/** КОД-РЕВЬЮ
 * Приведёт фрагмент кода классов мероприятий и событий.
 * Событие - это каое-либо публичное действие (спектакль, киносеанс, и т.п.), у каждого события есть своя собственная ссылка на сайте, список секторов (партер, балкон) и цена.
 * Мероприятие - аггрегирующая сощность для несольких событий. Например, балет Лебединое озеро может идти целый месяц, но каждое конкретное представление - отедльное событие.
 *
 * Пожалуйста, проверите код-ревью приведённого фрагмента.
 * Пишите свои комментарии справа, либо сверху от фрагмента, который хотите прокомментировать.
 * Укажите почему фрагмент написал плохо(или хорошо), как можно улучшить решение.
 *
 * Class Action
 */

class Action
{
    public static function getServiceFeeRate()
    {
        return 0.01;
    }

    public function getUrl() {
        return ['example.com', 'action', 'novogodnyaya_elka', '#' => 'description'];
    }
}

class Event extends Action
{
    private $id;
    private $price;
    public $sectors;

    public function getUrl()
    {
        $urlParts = ['id' => $this->id];

        $urlParts = parent::getUrl() + $urlParts;

        if (isset($urlParts['#']))  {
            $sharp = $urlParts['#'];
            unset($urlParts['#']);
            $urlParts['#'] = $sharp;
        }

        return $urlParts;
    }

    public function __construct(int $id, float $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    public static function filterActiveSectors(&$sectors)
    {
        foreach ($sectors as $key => &$sector) {
            if (!$sector->active)
                unset($sectors[$key]);
        }
    }

    public function getSectors()
    {
        return $this->sectors;
    }

    public function setSectors(array $sectors)
    {
        $this->sectors = $sectors;
    }

    public function getTotal()
    {
        return $this->price * Action::getServiceFeeRate() + $this->price;
    }
}

$event = new Event(1, 100.18);
$event->setSectors([1 => ['name' => 'Партер', 'quantity' => 200, 'active' => true], [2 => ['name' => 'Балкон', 'quantity' => 100, , 'active' => false]]]);
$sectors = Event::filterActiveSectors($event->getSectors());

var_dump($sectors);
echo (int) $event->getTotal();
echo implode('/', $event->getUrl());