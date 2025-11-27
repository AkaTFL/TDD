<?php

require_once 'User.php';
require_once 'Account.php';

class Teenager implements User
{
    private string $name;
    private int $age;
    private Account $account;
    private ?float $weeklyAllowance = null;
    private ?string $allowanceDay = null;

    public function __construct(string $name, Account $account, int $age = 0)
    {
        $this->name = $name;
        $this->account = $account;
        $this->age = $age;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setWeeklyAllowance(float $amount, string $day): void
    {
        $this->weeklyAllowance = $amount;
        $this->allowanceDay = $day;
    }

    public function getWeeklyAllowance(): ?float
    {
        return $this->weeklyAllowance;
    }

    public function getAllowanceDay(): ?string
    {
        return $this->allowanceDay;
    }

    public function withdrawCash(float $amount): float
    {
        $this->account->withdraw($amount);
        return $this->account->getBalance();
    }

    public function withdrawMoney(float $amount): float
    {
        return $this->withdrawCash($amount);
    }

    public function getExpenses(): array
    {
        return $this->account->getExpenses();
    }

    public function connect(): bool
    {
        return true;
    }
}

