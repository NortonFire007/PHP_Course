<?php

class BankException extends Exception
{
    protected $timestamp;

    public function __construct($message = "Банківська помилка.", $code = 0, Exception $previous = null)
    {
        $this->timestamp = date('Y-m-d H:i:s');
        parent::__construct($this->formatMessage($message), $code, $previous);
        $this->logError();
    }

    protected function formatMessage($message)
    {
        return "[$this->timestamp] Помилка: $message";
    }

    protected function logError()
    {
        $logMessage = $this->formatMessage($this->getMessage()) . "\n";
        file_put_contents('bank_errors.log', $logMessage, FILE_APPEND);
    }
}

class InsufficientFundsException extends BankException
{
    public function __construct($message = "Недостатньо коштів для зняття.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class InvalidAmountException extends BankException
{
    public function __construct($message = "Некоректна сума для операції.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class InitialBalanceException extends BankException
{
    public function __construct($message = "Початковий баланс не може бути меншим за 0.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
