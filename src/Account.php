<?php

/**
 * Classe représentant un compte bancaire avec gestion des dépenses
 */
class Account
{
    /** @var float Solde du compte */
    private float $money = 0.0;
    
    /** @var array Historique des dépenses */
    private array $expenses = [];

    /**
     * Retourne le solde du compte (alias de getBalance pour compatibilité)
     * 
     * @return float Solde actuel
     */
    public function getMoney(): float
    {
        return $this->money;
    }

    /**
     * Dépose de l'argent sur le compte
     * 
     * @param float $amount Montant à déposer
     * @return void
     * @throws Exception Si le montant est négatif
     */
    public function deposit(float $amount): void
    {
        if ($amount < 0) {
            throw new Exception("Cannot deposit negative amount");
        }
        $this->money += $amount;
    }

    /**
     * Retire de l'argent du compte et enregistre la dépense
     * 
     * @param float $amount Montant à retirer
     * @return void
     * @throws Exception Si le montant est négatif ou insuffisant
     */
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

    /**
     * Retourne le solde actuel du compte
     * 
     * @return float Solde du compte
     */
    public function getBalance(): float
    {
        return $this->money;
    }

    /**
     * Retourne l'historique des dépenses
     * 
     * @return array Liste des dépenses avec 'amount' et 'date'
     */
    public function getExpenses(): array
    {
        return $this->expenses;
    }
}
