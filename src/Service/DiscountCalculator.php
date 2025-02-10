<?php

namespace App\Service;

class DiscountCalculator
{
    private const BASE_DISCOUNT_RATE = 0.10; // 10%
    private const VIP_DISCOUNT_RATE = 0.05;   // 5%
    private const MAX_DISCOUNT_RATE = 0.20;    // 20%
    private const DISCOUNT_THRESHOLD = 100.0;   // 100 €

    public function calculateDiscount(float $totalAmount, bool $isVipCustomer): float
    {
        // Pas de remise si le montant est exactement 100 € pour un client non VIP
        if ($totalAmount == self::DISCOUNT_THRESHOLD && !$isVipCustomer) {
            return 0.0;
        }

        $discount = 0.0;

        // Appliquer la remise de base si le montant est supérieur au seuil
        if ($totalAmount > self::DISCOUNT_THRESHOLD) {
            $discount += $totalAmount * self::BASE_DISCOUNT_RATE;
        }

        // Ajouter la remise VIP si applicable
        if ($isVipCustomer) {
            $discount += $totalAmount * self::VIP_DISCOUNT_RATE;
        }

        // Calculer la remise maximale autorisée
        $maxDiscount = $totalAmount * self::MAX_DISCOUNT_RATE;

        // Retourner la remise minimale entre la remise calculée et la remise maximale
        return min($discount, $maxDiscount);
    }
}
