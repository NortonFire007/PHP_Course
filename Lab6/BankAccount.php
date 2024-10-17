<?php

require_once 'AccountInterface.php';
require_once 'Exceptions.php';

class BankAccount implements AccountInterface
{
    const MIN_BALANCE = 0;

    protected $balance;
    protected $currency;

    public function __construct($currency, $balance = 0)
    {
        try {
            if ($balance < self::MIN_BALANCE) {
                throw new InitialBalanceException("Початковий баланс не може бути меншим за " . self::MIN_BALANCE);
            }
            $this->currency = $currency;
            $this->balance = $balance;
        } catch (InitialBalanceException $e) {
            echo "Помилка ініціалізації рахунку: " . $e->getMessage() . "<br>";
        }
    }

    public function deposit($amount)
    {
        try {
            if ($amount <= 0) {
                throw new InvalidAmountException("Сума для поповнення повинна бути більшою за нуль.");
            }
            $this->balance += $amount;
            echo "Поповнення на суму $amount $this->currency успішне. Новий баланс: " . $this->getBalance() . " $this->currency" . "<br>";
        } catch (InvalidAmountException $e) {
            echo "Помилка при поповненні: " . $e->getMessage() . "<br>";
        }
    }

    public function withdraw($amount)
    {
        try {
            if ($amount <= 0) {
                throw new InvalidAmountException("Сума для зняття повинна бути більшою за нуль.");
            }
            if ($amount > $this->balance) {
                throw new InsufficientFundsException();
            }
            $this->balance -= $amount;
            echo "Зняття на суму $amount $this->currency успішне. Новий баланс: " . $this->getBalance() . " $this->currency" . "<br>";
        } catch (InvalidAmountException $e) {
            echo "Помилка при знятті: " . $e->getMessage() . "<br>";
        } catch (InsufficientFundsException $e) {
            echo "Недостатньо коштів для зняття: " . $e->getMessage() . "<br>";
        }
    }

    public function getBalance()
    {
        return $this->balance;
    }
}
