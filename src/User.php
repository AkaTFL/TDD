<?php

interface User
{
    public function getExpenses(): array;
    public function connect(): bool;
}

