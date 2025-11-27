<?php

class Account
{
    private float $money = 0.0;
    private array $expenses = [];

    public function getMoney(): float
    {
        return $this->money;
    }

    public function deposit(float $amount): void
    {
        if ($amount < 0) {
            throw new Exception("Cannot deposit negative amount");
        }
        $this->money += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount < 0) {
            throw new Exception("Cannot withdraw negative amount");
        }
        if ($amount > $this->money) {
            throw new Exception("Insufficient funds");
        }
        $this->money -= $amount;
        $this->expenses[] = [
            'amount' => $amount,
            'date' => date('Y-m-d H:i:s')
        ];
    }

    public function getBalance(): float
    {
        return $this->money;
    }

    public function getExpenses(): array
    {
        return $this->expenses;
    }
}
