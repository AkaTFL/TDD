<?php

require_once 'User.php';
require_once 'Account.php';

/**
 * Classe représentant un adolescent avec son compte d'argent de poche
 */
class Teenager implements User
{
    private string $name;
    private int $age;
    private Account $account;
    private ?float $weeklyAllowance = null;
    private ?string $allowanceDay = null;

    /**
     * Constructeur
     * 
     * @param string $name Nom de l'adolescent
     * @param Account $account Compte bancaire de l'adolescent
     * @param int $age Âge de l'adolescent (par défaut 0)
     */
    public function __construct(string $name, Account $account, int $age = 0)
    {
        $this->name = $name;
        $this->account = $account;
        $this->age = $age;
    }

    /**
     * Retourne le nom de l'adolescent
     * 
     * @return string Nom de l'adolescent
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retourne l'âge de l'adolescent
     * 
     * @return int Âge de l'adolescent
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Retourne le compte bancaire de l'adolescent
     * 
     * @return Account Compte bancaire
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * Définit l'allocation hebdomadaire
     * 
     * @param float $amount Montant de l'allocation
     * @param string $day Jour de la semaine (Monday, Tuesday, etc.)
     * @return void
     */
    public function setWeeklyAllowance(float $amount, string $day): void
    {
        $this->weeklyAllowance = $amount;
        $this->allowanceDay = $day;
    }

    /**
     * Retourne le montant de l'allocation hebdomadaire
     * 
     * @return float|null Montant de l'allocation ou null si non défini
     */
    public function getWeeklyAllowance(): ?float
    {
        return $this->weeklyAllowance;
    }

    /**
     * Retourne le jour de l'allocation hebdomadaire
     * 
     * @return string|null Jour de l'allocation ou null si non défini
     */
    public function getAllowanceDay(): ?string
    {
        return $this->allowanceDay;
    }

    /**
     * Retire de l'argent du compte de l'adolescent
     * 
     * @param float $amount Montant à retirer
     * @return float Solde restant après le retrait
     * @throws Exception Si le montant est insuffisant
     */
    public function withdrawMoney(float $amount): float
    {
        $this->account->withdraw($amount);
        return $this->account->getBalance();
    }

    /**
     * Alias de withdrawMoney pour compatibilité
     * 
     * @param float $amount Montant à retirer
     * @return float Solde restant après le retrait
     * @throws Exception Si le montant est insuffisant
     */
    public function withdrawCash(float $amount): float
    {
        return $this->withdrawMoney($amount);
    }

    /**
     * Retourne l'historique des dépenses
     * 
     * @return array Liste des dépenses avec montant et date
     */
    public function getExpenses(): array
    {
        return $this->account->getExpenses();
    }

    /**
     * Connecte l'adolescent (méthode de l'interface User)
     * 
     * @return bool Toujours true
     */
    public function connect(): bool
    {
        return true;
    }
}

