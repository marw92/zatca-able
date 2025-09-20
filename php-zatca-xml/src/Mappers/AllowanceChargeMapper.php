<?php
namespace Saleh7\Zatca\Mappers;

use Saleh7\Zatca\AllowanceCharge;
use Saleh7\Zatca\TaxCategory;
use Saleh7\Zatca\TaxScheme;

class AllowanceChargeMapper
{


    /**
     * Map AllowanceCharge data to an array of AllowanceCharge objects.
     *
     * @param  array  $data  The invoice data containing allowance charges.
     * @return AllowanceCharge[] Array of mapped AllowanceCharge objects.
     */

    public function map(array $data): array
    {
        $allowanceCharges = [];
        // Check if allowanceCharges is an array.
        // if (!isset($data['allowanceCharges']) || !is_array($data['allowanceCharges'])) {
        //     return $allowanceCharges;
        // }
        // Iterate over each allowance charge in the data.
        // dd($data);
        foreach ($data as $allowanceCharge) {
            $taxCategories = [];

            // Check if taxCategories is an array and iterate over it.
            if (isset($allowanceCharge['taxCategories']) && is_array($allowanceCharge['taxCategories'])) {
                foreach ($allowanceCharge['taxCategories'] as $taxCatData) {
                    $taxCategories[] = (new TaxCategory)
                        ->setPercent($taxCatData['percent'] ?? 15)
                        ->setTaxScheme(
                            (new TaxScheme)->setId($taxCatData['taxScheme']['id'] ?? 'VAT')
                        );
                }
            }

            // Create the AllowanceCharge object with its tax categories.
            $allowanceCharges[] = (new AllowanceCharge)
                ->setChargeIndicator($allowanceCharge['isCharge'] ?? false)
                ->setAllowanceChargeReasonCode($allowanceCharge['reasonCode'] ?? 'disable')
                ->setAllowanceChargeReason($allowanceCharge['reason'] ?? 'discount')
                ->setAmount($allowanceCharge['amount'] ?? 0.00)
                ->setTaxCategory($taxCategories);
        }

        return $allowanceCharges;
    }

}

