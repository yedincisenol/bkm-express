<?php
namespace Bex\enums;

use Bex\exceptions\BexException;

class Banks
{
    const  ALBARAKA = "0203";
    const  AKBANK = "0046";
    const BANKASYA = "0208";
    const DENIZBANK = "0134";
    const FINANSBANK = "0111";
    const GARANTI = "0062";
    const HALKBANK = "0012";
    const  HSBC = "0123";
    const ISBANK = "0064";
    const  ING = "0099";
    const  KUVEYTTURK = "0205";
    const ODEABANK = "0146";
    const  SEKERBANK = "0059";
    const TEBBANK = "0032";
    const TFKB = "0206";
    const  VAKIFBANK = "0015";
    const  YKB = "0067";
    const ZIRAATBANK = "0010";


    public static function returnBanksCode($bankCode)
    {
        if (isset($bankCode) && !empty($bankCode)) {
            switch ($bankCode) {
                case self::ALBARAKA :
                    return self::ALBARAKA;
                    break;
                case self::AKBANK :
                    return self::AKBANK;
                    break;
                case self::BANKASYA :
                    return self::BANKASYA;
                    break;
                case self::DENIZBANK :
                    return self::DENIZBANK;
                    break;
                case self::FINANSBANK :
                    return self::FINANSBANK;
                    break;
                case self::GARANTI :
                    return self::GARANTI;
                    break;
                case self::HALKBANK :
                    return self::HALKBANK;
                    break;
                case self::HSBC :
                    return self::HSBC;
                    break;
                case self::ISBANK :
                    return self::ISBANK;
                    break;
                case self::ING :
                    return self::ING;
                    break;
                case self::KUVEYTTURK :
                    return self::KUVEYTTURK;
                    break;
                case self::ODEABANK :
                    return self::ODEABANK;
                    break;
                case self::SEKERBANK :
                    return self::SEKERBANK;
                    break;
                case self::TEBBANK :
                    return self::TEBBANK;
                    break;
                case self::TFKB :
                    return self::TFKB;
                    break;
                case self::VAKIFBANK :
                    return self::VAKIFBANK;
                    break;
                case self::YKB :
                    return self::YKB;
                    break;
                case self::ZIRAATBANK :
                    return self::ZIRAATBANK;
                    break;
                default:
                    throw  new BexException("Please check your bank code!");

            }
        }
    }
}
