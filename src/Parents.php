<?php
    class Parents implements Countable
    {
        
        private Account $account;
        /** @var Teenager[] */
        private array $teenagers = [];

        public function __construct(Account $account, array $teenagers = [])
        {
            $this->account = $account;
            $this->teenagers = $teenagers;
        }
        
        public function addTeenager(string $name, Account $account): Teenager
        {
            $teenager = new Teenager($name, $account);
            $this->teenagers[$name] = $teenager;
            return $teenager;
        }
        
        public function removeTeenager(string $name): Teenager
        {
            if (!isset($this->teenagers[$name])) {
                throw new Exception("Teenager '$name' not found");
            }
            
            $teenager = $this->teenagers[$name];
            unset($this->teenagers[$name]);
            return $teenager;
        }
        
        public function editWeeklyAllowance(string $name, float $amount, string $day): float
        {
            if (!isset($this->teenagers[$name])) {
                throw new Exception("Teenager '$name' not found");
            }
            
            $teenager = $this->teenagers[$name];
            $teenager->setWeeklyAllowance($amount, $day);
            return $amount;
        }
        
        public function depositMoney(Teenager $teenager, float $amount): float
        {
            $teenager->getAccount()->deposit($amount);
            return $teenager->getAccount()->getBalance();
        }
        
        public function withdrawMoney(Teenager $teenager, float $amount): float
        {
            $teenager->getAccount()->withdraw($amount);
            return $teenager->getAccount()->getBalance();
        }
        
        public function getExpensesReport(Teenager $teenager): array
        {
            return $teenager->getAccount()->getExpenses();
        }
        
        public function count(): int
        {
            return count($this->teenagers);
        }
    }