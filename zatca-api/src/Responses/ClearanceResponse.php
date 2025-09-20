<?php

namespace Sevaske\ZatcaApi\Responses;

class ClearanceResponse extends ValidationResponse
{
    /**
     * Determines whether the clearance was successful.
     *
     * @return bool True if the clearanceStatus is 'CLEARED', false otherwise.
     */
    public function success(): bool
    {
        return $this->status() === 'CLEARED';
    }

    public function status(): ?string
    {
        return $this->getOptionalAttribute('clearanceStatus');
    }

    public function clearedInvoice(): ?string
    {
        return $this->getOptionalAttribute('clearedInvoice');
    }
}
