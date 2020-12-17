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
    Время выполнения: 1 час
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

        /*довольно неочевидное решение. прямо костыль
        я бы сделал в родительском методе именованный массив
        [
            'link' => 'example.com',
            'type' => 'action',
            'name' => 'novogodnyaya_elka',
            'action_id' => 0,
            '#' => 'description'
        ]
        а здесь 
        $urlParts = parent::getUrl();
        $urlParts['action_id'] = $this->id;

        еще, как вариант, не передават ьмассив, а сделать эти переменные параметрами родительского класса
        */
        $urlParts = parent::getUrl() + $urlParts;

        if (isset($urlParts['#']))  {
            $sharp = $urlParts['#'];
            unset($urlParts['#']);
            $urlParts['#'] = $sharp;
        }

        return $urlParts;
    }

    //конструктор не первый метод в классе - это плохо для читаемости кода
    public function __construct(int $id, float $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    //можно было использовать $this->sectors внутри метода, а вообще я бы сделал sectors отдельным классом
    public static function filterActiveSectors(&$sectors)
    {
        //ну и тут ссылка непонятно для чего
        foreach ($sectors as $key => &$sector) {
            //это не объект, а массив. должно быть "if (!$sector['active'])", чтобы работало корректно
            //сейчас просто удаляет всё
            if (!$sector->active)
                unset($sectors[$key]);
        }
        //метод ничего не возвращает. а должен, видимо, sectors
        //либо использовать и менять this->sectors
        return $sectors;
    }

    //нет смысла делать методы get и set для свойства с доступом public
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
        // можно написать короче
        // return $this->price * (1 + self::getServiceFeeRate());
        return $this->price * Action::getServiceFeeRate() + $this->price;
    }
}

$event = new Event(1, 100.18);
//в массиве пара скобок вокруг второй пары ключ-значение, еще запятая - ошибка синтаксиса
//$event->setSectors([1 => ['name' => 'Партер', 'quantity' => 200, 'active' => true], [2 => ['name' => 'Балкон', 'quantity' => 100, , 'active' => false]]]);
//исправил, чтобы работало                          
$event->setSectors([1 => ['name' => 'Партер', 'quantity' => 200, 'active' => true], 2 => ['name' => 'Балкон', 'quantity' => 100, 'active' => false]]);
$sectors = Event::filterActiveSectors($event->getSectors());

var_dump($sectors);
echo (int) $event->getTotal(); //а выгодно ли округлять цену в меньшую сторону? =)
echo implode('/', $event->getUrl());