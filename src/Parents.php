<?php

/**
 * Classe représentant un parent qui gère plusieurs adolescents
 */
class Parents implements Countable
{
    /** @var Teenager[] Liste des adolescents gérés par ce parent */
    private array $teenagers = [];

    /**
     * Constructeur
     * 
     * @param array $teenagers Liste initiale d'adolescents (optionnel)
     */
    public function __construct(array $teenagers = [])
    {
        $this->teenagers = $teenagers;
    }
        
    /**
     * Ajoute un adolescent à la liste
     * 
     * @param string $name Nom de l'adolescent
     * @param Account $account Compte bancaire de l'adolescent
     * @return Teenager L'adolescent créé
     */
    public function addTeenager(string $name, Account $account): Teenager
    {
        $teenager = new Teenager($name, $account);
        $this->teenagers[$name] = $teenager;
        return $teenager;
    }
    
    /**
     * Retire un adolescent de la liste
     * 
     * @param string $name Nom de l'adolescent à retirer
     * @return Teenager L'adolescent retiré
     * @throws Exception Si l'adolescent n'existe pas
     */
    public function removeTeenager(string $name): Teenager
    {
        if (!isset($this->teenagers[$name])) {
            throw new Exception("Teenager '$name' not found");
        }
        
        $teenager = $this->teenagers[$name];
        unset($this->teenagers[$name]);
        return $teenager;
    }
    
    /**
     * Modifie l'allocation hebdomadaire d'un adolescent
     * 
     * @param string $name Nom de l'adolescent
     * @param float $amount Montant de l'allocation
     * @param string $day Jour de la semaine
     * @return float Montant de l'allocation définie
     * @throws Exception Si l'adolescent n'existe pas
     */
    public function editWeeklyAllowance(string $name, float $amount, string $day): float
    {
        if (!isset($this->teenagers[$name])) {
            throw new Exception("Teenager '$name' not found");
        }
        
        $this->teenagers[$name]->setWeeklyAllowance($amount, $day);
        return $amount;
    }
    
    /**
     * Dépose de l'argent sur le compte d'un adolescent
     * 
     * @param Teenager $teenager L'adolescent concerné
     * @param float $amount Montant à déposer
     * @return float Nouveau solde du compte
     * @throws Exception Si le montant est négatif
     */
    public function depositMoney(Teenager $teenager, float $amount): float
    {
        $teenager->getAccount()->deposit($amount);
        return $teenager->getAccount()->getBalance();
    }
    
    /**
     * Retire de l'argent du compte d'un adolescent
     * 
     * @param Teenager $teenager L'adolescent concerné
     * @param float $amount Montant à retirer
     * @return float Nouveau solde du compte
     * @throws Exception Si le montant est insuffisant ou négatif
     */
    public function withdrawMoney(Teenager $teenager, float $amount): float
    {
        $teenager->getAccount()->withdraw($amount);
        return $teenager->getAccount()->getBalance();
    }
    
    /**
     * Retourne le rapport des dépenses d'un adolescent
     * 
     * @param Teenager $teenager L'adolescent concerné
     * @return array Liste des dépenses avec montant et date
     */
    public function getExpensesReport(Teenager $teenager): array
    {
        return $teenager->getExpenses();
    }
    
    /**
     * Compte le nombre d'adolescents gérés
     * 
     * @return int Nombre d'adolescents
     */
    public function count(): int
    {
        return count($this->teenagers);
    }
    }