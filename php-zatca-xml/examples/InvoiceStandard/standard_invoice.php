<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Saleh7\Zatca\GeneratorInvoice;
use Saleh7\Zatca\Helpers\Certificate;
use Saleh7\Zatca\InvoiceSigner;
use Saleh7\Zatca\Mappers\InvoiceMapper;

$invoiceData = [
    'uuid' => 'b51bd500-9081-4acf-9ae4-c266d569cb77',
    'id' => '444555666',
    'issueDate' => date('Y-m-d H:i:s'),
    'issueTime' => date('Y-m-d H:i:s'),
    'delivery' => [
        'actualDeliveryDate' => date('Y-m-d H:i:s'),
    ],
    'currencyCode' => 'SAR',
    'taxCurrencyCode' => 'SAR',
    'note' => 'Tax ID is 333333333333333 because a customer didnt provide it.',
    'languageID' => 'en',
    'invoiceType' => [
        'invoice' => 'standard',
        'type' => 'invoice',
        'isThirdParty' => false,
        'isNominal' => false,
        'isExport' => false,
        'isSummary' => false,
        'isSelfBilled' => false,
    ],
    'additionalDocuments' => [
        [
            'id' => 'ICV',
            'uuid' => '1', // counter value
        ],
        [
            'id' => 'PIH',
            'attachment' => [
                'content' => 'MA==', // previous hash
            ],
        ],
    ],
    'supplier' => [
        'registrationName' => 'My company name',
        'taxId' => '311111111111113',
        'identificationId' => '1111111111', // my company CRN
        'identificationType' => 'CRN',
        'address' => [
            'street' => 'company street name',
            'buildingNumber' => '8008',
            'subdivision' => 'sub',
            'city' => 'Riyadh',
            'postalZone' => '12345',
            'country' => 'SA',
        ],
    ],
    'customer' => [
        'identificationId' => '1010010000',
        'identificationType' => 'CRN',
        'registrationName' => 'Naruto Uzumaki',
        'taxId' => '333333333333333',
        'address' => [
            'street' => 'Al Urubah Road',
            'buildingNumber' => '7176',
            'subdivision' => 'Al Olaya',
            'city' => 'Riyadh',
            'postalZone' => '12251',
            'country' => 'SA',
        ],
    ],
    'paymentMeans' => [
        'code' => '10', // cash
    ],
    'allowanceCharges' => [
        [
            'isCharge' => false,
            'reason' => 'discount',
            'amount' => 0.0,
            'taxCategories' => [
                0 => [
                    'percent' => 15,
                    'taxScheme' => [
                        'id' => 'VAT',
                    ],
                ],
            ],
        ],
    ],
    'taxTotal' => [
        'taxAmount' => 6.86,
        'subTotals' => [
            0 => [
                'taxableAmount' => 45.75,
                'taxAmount' => 6.86,
                'taxCategory' => [
                    'percent' => 15,
                    'taxScheme' => [
                        'id' => 'VAT',
                    ],
                ],
            ],
        ],
    ],
    'legalMonetaryTotal' => [
        'lineExtensionAmount' => 45.75,
        'taxExclusiveAmount' => 45.75,
        'taxInclusiveAmount' => 52.61,
        'prepaidAmount' => 0,
        'payableAmount' => 52.61,
        'allowanceTotalAmount' => 0.0,
    ],
    'invoiceLines' => [
        [
            'id' => 1,
            'unitCode' => 'PCE',
            'quantity' => 1,
            'lineExtensionAmount' => 20.75,
            'item' => [
                'name' => 'My product',
                'classifiedTaxCategory' => [
                    0 => [
                        'percent' => 15.0,
                        'taxScheme' => [
                            'id' => 'VAT',
                        ],
                    ],
                ],
            ],
            'price' => [
                'amount' => 20.75,
                'unitCode' => 'UNIT',
                'allowanceCharges' => [
                    0 => [
                        'isCharge' => false,
                        'reason' => 'discount',
                        'amount' => 0.0,
                    ],
                ],
            ],
            'taxTotal' => [
                'taxAmount' => 3.11,
                'roundingAmount' => 23.86,
            ],
        ],
        [
            'id' => 2,
            'unitCode' => 'C62',
            'quantity' => 1,
            'lineExtensionAmount' => 25.0,
            'item' => [
                'name' => 'My another product',
                'classifiedTaxCategory' => [
                    0 => [
                        'percent' => 15.0,
                        'taxScheme' => [
                            'id' => 'VAT',
                        ],
                    ],
                ],
            ],
            'price' => [
                'amount' => '25.00',
                'unitCode' => 'UNIT',
                'allowanceCharges' => [
                    0 => [
                        'isCharge' => false,
                        'reason' => 'discount',
                        'amount' => 0.0,
                    ],
                ],
            ],
            'taxTotal' => [
                'taxAmount' => 3.75,
                'roundingAmount' => 28.75,
            ],
        ],
    ],
];

// Map the data to an Invoice object
$invoiceMapper = new InvoiceMapper;
$invoice = $invoiceMapper->mapToInvoice($invoiceData);

// Generate the invoice XML
$generatorInvoice = GeneratorInvoice::invoice($invoice);

// get invoice.xml
$certificate = (new Certificate(
    'MIID3jCCA4SgAwIBAgITEQAAOAPF90Ajs/xcXwABAAA4AzAKBggqhkjOPQQDAjBiMRUwEwYKCZImiZPyLGQBGRYFbG9jYWwxEzARBgoJkiaJk/IsZAEZFgNnb3YxFzAVBgoJkiaJk/IsZAEZFgdleHRnYXp0MRswGQYDVQQDExJQUlpFSU5WT0lDRVNDQTQtQ0EwHhcNMjQwMTExMDkxOTMwWhcNMjkwMTA5MDkxOTMwWjB1MQswCQYDVQQGEwJTQTEmMCQGA1UEChMdTWF4aW11bSBTcGVlZCBUZWNoIFN1cHBseSBMVEQxFjAUBgNVBAsTDVJpeWFkaCBCcmFuY2gxJjAkBgNVBAMTHVRTVC04ODY0MzExNDUtMzk5OTk5OTk5OTAwMDAzMFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAEoWCKa0Sa9FIErTOv0uAkC1VIKXxU9nPpx2vlf4yhMejy8c02XJblDq7tPydo8mq0ahOMmNo8gwni7Xt1KT9UeKOCAgcwggIDMIGtBgNVHREEgaUwgaKkgZ8wgZwxOzA5BgNVBAQMMjEtVFNUfDItVFNUfDMtZWQyMmYxZDgtZTZhMi0xMTE4LTliNTgtZDlhOGYxMWU0NDVmMR8wHQYKCZImiZPyLGQBAQwPMzk5OTk5OTk5OTAwMDAzMQ0wCwYDVQQMDAQxMTAwMREwDwYDVQQaDAhSUlJEMjkyOTEaMBgGA1UEDwwRU3VwcGx5IGFjdGl2aXRpZXMwHQYDVR0OBBYEFEX+YvmmtnYoDf9BGbKo7ocTKYK1MB8GA1UdIwQYMBaAFJvKqqLtmqwskIFzVvpP2PxT+9NnMHsGCCsGAQUFBwEBBG8wbTBrBggrBgEFBQcwAoZfaHR0cDovL2FpYTQuemF0Y2EuZ292LnNhL0NlcnRFbnJvbGwvUFJaRUludm9pY2VTQ0E0LmV4dGdhenQuZ292LmxvY2FsX1BSWkVJTlZPSUNFU0NBNC1DQSgxKS5jcnQwDgYDVR0PAQH/BAQDAgeAMDwGCSsGAQQBgjcVBwQvMC0GJSsGAQQBgjcVCIGGqB2E0PsShu2dJIfO+xnTwFVmh/qlZYXZhD4CAWQCARIwHQYDVR0lBBYwFAYIKwYBBQUHAwMGCCsGAQUFBwMCMCcGCSsGAQQBgjcVCgQaMBgwCgYIKwYBBQUHAwMwCgYIKwYBBQUHAwIwCgYIKoZIzj0EAwIDSAAwRQIhALE/ichmnWXCUKUbca3yci8oqwaLvFdHVjQrveI9uqAbAiA9hC4M8jgMBADPSzmd2uiPJA6gKR3LE03U75eqbC/rXA==',
    'MHQCAQEEIL14JV+5nr/sE8Sppaf2IySovrhVBtt8+yz+g4NRKyz8oAcGBSuBBAAKoUQDQgAEoWCKa0Sa9FIErTOv0uAkC1VIKXxU9nPpx2vlf4yhMejy8c02XJblDq7tPydo8mq0ahOMmNo8gwni7Xt1KT9UeA==',
    'secret'
));
$signedInvoice = InvoiceSigner::signInvoice($generatorInvoice->getXML(), $certificate);

$generatorInvoice->saveXMLFile('Standard_Invoice.xml');
echo "Simplified Invoice Note Generated Successfully\n";

// sign the invoice XML with the certificate
$signedInvoice->saveXMLFile('Standard_Invoice_Signed.xml');
echo "Simplified Invoice Note Signed Successfully\n";
