<?php
require_once 'BankAccount.php';

class SavingsAccount extends BankAccount
{
    protected static $interestRate = 0.05;

    public static function setInterestRate($rate)
    {
        self::$interestRate = $rate;
    }

    public static function getInterestRate()
    {
        return self::$interestRate;
    }

    public function applyInterest()
    {
        $interest = $this->balance * self::$interestRate;
        $this->balance += $interest;

        echo "Відсотки в розмірі " . round($interest, 2) . " $this->currency були додані до вашого балансу. 
         Новий баланс: " . $this->getBalance() . " $this->currency" . "<br>";
    }
}