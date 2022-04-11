<?php

namespace EfTech\SportClub\Exception;

/**
 * Исключение бросается, если значение не совпадает с набором значений.
 * Обычно это происходит, когда функция
 */
class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
}
