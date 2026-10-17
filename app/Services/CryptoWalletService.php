<?php

namespace App\Services;

use BitWasp\Bitcoin\Key\Deterministic\HdPrefix;
use BitWasp\Bitcoin\Mnemonic\MnemonicFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;

class CryptoWalletService
{
    public function isMnemonicValid(string $mnemonic): bool
    {
        try {
            // Create a MnemonicFactory instance
            $mnemonicFactory = MnemonicFactory::bip39();

            // Validate the mnemonic phrase
            $mnemonicFactory->mnemonicToEntropy($mnemonic);

            // If no exception is thrown, the mnemonic is valid
            return true;
        } catch (\Exception $e) {
            // If an exception is thrown, the mnemonic is invalid
            return false;
        }
    }
}
