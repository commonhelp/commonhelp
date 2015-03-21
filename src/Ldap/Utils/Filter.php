<?php

namespace Commonhelp\Ldap;

class Filter{
	
	
	public function toString(){
		
	}
	
	
	public function __toString() {
		return $this->toString();
	}
	
	public static function escapeValue($values = array()){
        if (!is_array($values)) $values = array($values);
        foreach ($values as $key => $val) {
            // Escaping of filter meta characters
            $val = str_replace(array('\\', '*', '(', ')'), array('\5c', '\2a', '\28', '\29'), $val);
            // ASCII < 32 escaping
            $val = Converter::ascToHex32($val);
            if (null === $val) $val = '\0';  // apply escaped "null" if string is empty
            $values[$key] = $val;
        }
        return (count($values) == 1) ? $values[0] : $values;
    }
	
	public static function unescapeValue($values = array()){
        if (!is_array($values)) $values = array($values);
        foreach ($values as $key => $value) {
            // Translate hex code into ascii
            $values[$key] = Converter::hex32ToAsc($value);
        }
        return (count($values) == 1) ? $values[0] : $values;
    }
}