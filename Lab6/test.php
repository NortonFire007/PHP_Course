<?php
require_once 'BankAccount.php';
require_once 'SavingsAccount.php';

$checkingAccount = new BankAccount('USD', 500);
$savingsAccount1 = new SavingsAccount('USD', 1000);
$savingsAccount2 = new SavingsAccount('EUR', 50);

$checkingAccount->deposit(-20);
$checkingAccount->withdraw(100);

$savingsAccount1->deposit(300);
$savingsAccount1->withdraw(150);

$savingsAccount1->applyInterest();

$savingsAccount2->deposit(100);
$savingsAccount2->withdraw(200);
$savingsAccount2::setInterestRate($savingsAccount2::getInterestRate() + 0.05);
$savingsAccount2->applyInterest();