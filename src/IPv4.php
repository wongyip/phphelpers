<?php

namespace Wongyip\PHPHelpers;

class IPv4
{
    /**
     * Whether the input is a valid IPv4 address, e.g. "192.168.0.1".
     *
     * @param string $input
     * @return bool
     */
    public static function validAddress(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Whether the input is a valid CIDR notation, e.g. "192.168.0.1/24".
     *
     * @param mixed $input Untyped input, so that this also validate the type.
     * @return bool
     */
    public static function validICIDR(mixed $input): bool
    {
        if (is_string($input)) {
            $cidr = explode('/', $input);
            if (count($cidr) === 2) {
                [$addr, $prefix] = $cidr;
                return
                    filter_var($addr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) &&
                    is_numeric($prefix) &&
                    $prefix >= 0 &&
                    $prefix <= 32;
            }
        }
        return false;
    }

    /**
     * Whether the input is a valid IPv4 address in the given CIDR block, array
     * or CSV of addresses, or a range between two IP addresses (inclusive) like
     * '10.0.1.23-10.0.2.34'.
     *
     * @param string $input
     * @param string|array $range
     * @return bool
     */
    public static function addressIn(string $input, string|array $range): bool
    {
        if (self::validAddress($input)) {

            // Array of addresses.
            if (is_array($range)) {
                return in_array($input, $range);
            }

            /**
             * Range is CIDR.
             *
             * @see https://stackoverflow.com/questions/594112/check-whether-or-not-a-cidr-subnet-contains-an-ip-address
             */
            if (self::validICIDR($range)) {
                list ($addr, $prefix) = explode('/', $range);
                $ip = ip2long($input);
                $addr = ip2long($addr);
                $mask = -1 << (32 - $prefix);
                $addr &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
                return ($ip & $mask) == $addr;
            }

            /**
             * Range between is two addresses.
             */
            if (str_contains($range, '-')) {
                $range = array_map('trim', explode('-', $range));
                if (count($range) === 2) {
                    [$from, $to] = $range;
                    if (self::validAddress($from) && self::validAddress($to)) {
                        $from = ip2long($from);
                        $to = ip2long($to);
                        $ip = ip2long($input);
                        return $ip >= $from && $ip <= $to;
                    }
                }
            }

            // CSV of address
            if (str_contains($range, ',')) {
                $range = array_map('trim', explode(',', $range));
                return in_array($input, $range);
            }
        }
        return false;
    }
}