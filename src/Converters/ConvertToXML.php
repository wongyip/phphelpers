<?php namespace Wongyip\PHPHelpers\Converters;

class ConvertToXML
{
    /**
     * Convert the input object to XML string.
     * 
     * @param mixed $object
     * @return string
     */
    static function fromObject($object)
    {
        $xml = new \DOMDocument();
        $child = $xml->createElement("root");
        $xml->appendChild($child);
        self::work($xml, $child, $object, self::getType($object) == 'array');
        return $xml->saveXML($xml->documentElement);
    }
    
    /**
     * @param \DOMDocument         $xml
     * @param \DOMElement|\DOMNode $child
     * @param mixed                $object
     * @param boolean              $isArray
     */
    static function work(\DOMDocument &$xml, $child, $object, $isArray = false)
    {
        $child->setAttribute('type', self::getType($object));
        
        // It's a simple node
        if (self::getType($object) != 'array' && self::getType($object) != 'object') {
            if (self::getType($object) == 'boolean') {
                $child->appendChild($xml->createTextNode($object ? 'true' : 'false'));
            }
            else {
                $child->appendChild($xml->createTextNode($object));
            }
        }
        // It's an Array or an Object node
        else {
            foreach ($object as $key => $val) {
                if ($key == '__type' && self::getType($object) == 'object') {
                    $child->setAttribute('__type', $val);
                }
                else {
                    if (self::getType($val) == 'object') {
                        $grandChild = $child->appendChild($xml->createElementNS(null, $isArray ? 'item' : $key));
                        self::work($xml, $grandChild, $val);
                    }
                    elseif (self::getType($val) == 'array') {
                        $grandChild = $child->appendChild($xml->createElementNS(null, $isArray ? 'item' : $key));
                        self::work($xml, $grandChild, $val, true);
                    }
                    else {
                        $value = $xml->createElementNS(null, $isArray ? 'item' : $key);
                        if (self::getType($val) == 'boolean') {
                            $value->appendChild($xml->createTextNode($val ? 'true' : 'false'));
                        }
                        else {
                            $value->appendChild($xml->createTextNode($val));
                        }
                        $grandChild = $child->appendChild($value);
                        $grandChild->setAttribute('type', self::getType($val));
                    }
                }
            }
        }
    }
    
    /**
     * @param mixed $var
     * @return string
     */
    static function getType($var)
    {
        $type = gettype($var);
        return in_array($type, ['integer', 'double']) ? 'number' : strtolower($type);
    }
}