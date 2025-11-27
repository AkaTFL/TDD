<?php

/**
 * Interface représentant un utilisateur du système
 */
interface User
{
    /**
     * Retourne l'historique des dépenses de l'utilisateur
     * 
     * @return array Liste des dépenses
     */
    public function getExpenses(): array;
    
    /**
     * Connecte l'utilisateur au système
     * 
     * @return bool True si la connexion réussit
     */
    public function connect(): bool;
}

