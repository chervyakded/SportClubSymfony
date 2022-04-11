<?php

namespace EfTech\SportClub\Exception;

/**
 * Создаётся исключение если значение не соответствует определённой допустимой области данных
 */
class DomainException extends \DomainException implements ExceptionInterface
{
}
