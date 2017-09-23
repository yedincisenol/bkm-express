<?php
namespace Bex\merchant\security;

use Bex\exceptions\EncryptionException;

class EncryptionUtil
{

    const FORMATTED_PUBLIC_KEY = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuZj/TQ9ZRY5KnsA3HMPqbNwI32J+Bisyv7KX7IRJh5rN5LW3g7t6pulArLIEU3sn28ZQEQ+GCb9yvk6zIUoqKBqH0H+gvxOtsklOUkFRgh+/FghNDoe0OzkXTLjQKhh6MRMBR9l3cws9nA2cu+M5kw67F8j0+4SogHJ+VS1wA2kfWx58PNDIg9DtAVwmD1JbjAziPONv0wHSa8oNgia9Tx6ia6FS4nfjRNqpVqI0m2jIcG8yXt1OaBSazkuRlRepMtDVwMGF4xOWXuRVv+G5oiTsbOez9tQAcx+KH0W1Pn9Q9/zzOJyF9AS8J1UDE7c7rKwXGDnuTBU1BwdAGyB87QIDAQAB";

    public static function sign($data, $privateKey)
    {
        $result = openssl_sign($data, $signature, self::getPrivateKeyFromString($privateKey), "sha256WithRSAEncryption");

        if (!$result) {
            throw new EncryptionException("Sign error");
        }

        return base64_encode($signature);
    }

    public static function verifyBexSign($ticketId, $signature)
    {
        $result = openssl_verify($ticketId, base64_decode($signature), self::getPublicKeyFromString(self::FORMATTED_PUBLIC_KEY), "sha256WithRSAEncryption");

        if ($result == 1) {
            return true;
        } else if ($result == 0) {
            return false;
        } else {
            throw new EncryptionException(openssl_error_string());
        }

        return true;

    }


    private static function getPrivateKeyFromString($privateKey, $passphrase = "")
    {
        $result = openssl_pkey_get_private(self::formatKey($privateKey, "private"), $passphrase);

        if (!$result) {
            throw new EncryptionException("Invalid key specification");
        }

        return $result;
    }

    private static function getPublicKeyFromString($publicKey)
    {
        $result = openssl_pkey_get_public(self::formatKey($publicKey, "public"));
        if (!$result) {
            throw new EncryptionException("Invalid key specification");
        }

        return $result;
    }

    private static function formatKey($unformattedKey, $keyType)
    {
        $result = "";
        $lineCharacter = 0;

        if ($keyType == "public") {
            $lineCharacter = 64;
            $result = wordwrap($unformattedKey, $lineCharacter, "\n", true);
            $result = "-----BEGIN PUBLIC KEY-----\n" . $result . "\n-----END PUBLIC KEY-----";
        } else {
            $lineCharacter = 65;
            $result = wordwrap($unformattedKey, $lineCharacter, "\n", true);
            $result = "-----BEGIN RSA PRIVATE KEY-----\n" . $result . "\n-----END RSA PRIVATE KEY-----";
        }
        return $result;

    }


    public static function encryptWithBex($vposConfig)
    {
        $appendedString = '';
        for ($i = 0; $i < (strlen($vposConfig) / 245); $i++) {
            $subData = substr($vposConfig, $i * 245, ($i + 1) * 245);
            if (openssl_public_encrypt($subData, $encrypted, self::getPublicKeyFromString(self::FORMATTED_PUBLIC_KEY))) {
                $data = base64_encode($encrypted);
                $appendedString .= $data . "|:*:|";
            } else {
                throw new EncryptionException("Invalid key specification");
            }
        }

        return $appendedString;
    }

    public static function encryptBex($parameter)
    {
        if (openssl_public_encrypt($parameter, $encrypted, self::getPublicKeyFromString(self::FORMATTED_PUBLIC_KEY))) {
            $data = base64_encode($encrypted);
        } else {
            throw new EncryptionException("Invalid key specification");
        }
        return $data;
    }


}