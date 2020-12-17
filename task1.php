<?php
/** Стороковой калькулятор.
 * Дана строка $expression, описывающая простое математическое выражение.
 * В строке могут встречаться только целые числа и знаки "+" и "-" (пробелы и другие знаки отсутствуют).
 * Необходимо написать функцию calculate ($expression), которая возвращает результат математического выражения.
 *
 * Важно именно написать алгоритм, использовать eval() не допускается.
 *
 * Пример:
 * $expression = '1+2'  = 3
 * $expression = '10-15' = -5

 * Описание алгоритма:
	1. Разбиваем строку на массив, используя, как разделитель "+"
	2. Делаем обход массива, при необходимости разбиваем слагаемые на 
		подмассивы, используя "-", как разделитель
	3. Всё складываем 
 *
 * ЗАТРАЧЕНО: 15 минут.
 */

$expression1 = '100+5'; // 105
$expression2 = '5-5'; // 0
$expression3 = '10+6-12'; // 4

function calculate(string $expression):int 
{
    $result = 0;
    $sum = explode("+", $expression);

    foreach ($sum as $term) 
    {
    	$diff = explode("-", $term);
    	$result += $diff[0];

    	for($i = 1; $i < count($diff); $i++) 
    	{
    		$result -= $diff[$i];
    	}
    }

    return $result;
}

echo calculate($expression1);
echo calculate($expression2);
echo calculate($expression3);