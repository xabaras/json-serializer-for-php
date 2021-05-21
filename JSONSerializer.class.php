<?php
/*
 * This file is part of JSONSerializer.
 *
 * JSONSerializer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * JSONSerializer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with JSONSerializer.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * JSON Serializer 1.1.2
 * 
 * The class implements methods to simply serialize/deserialize a PHP object/array from/to JSON
 *
 * @author Paolo Montalto <webmaster[at]xabaras.it>
 *
 */

class JSONSerializer {
	
	/**
	 * 
	 * Takes a PHP object and returns a string containing its JSON representation 
	 * @param object $ObjectInstance
	 * @return a string containing the JSON representation of the input object 
	 */
	public static function serialize($ObjectInstance) {
		return json_encode($ObjectInstance);
	}


	/**
	 * 
	 * Takes a JSON string and a class name and returns a PHP object
	 * @param string $json JSON representation of an object / object array
	 * @param String $className The class name of the object to be deserialized
	 * @return an object instance of type $className
	 */
	public static function deserialize($json, $className = NULL) {
		$result=null;
		$counter=0;
		$decoded = json_decode($json);
		
		if (gettype($decoded) != "array") {
			$decoded = array($decoded);
		}
		
		foreach ($decoded as $member) {
			if ( is_object($member) ) {
				$instance = new ReflectionClass($className);
				$ins=$instance->newInstance();
					
				if ($member == "") {
					return null;
				}
					
				foreach ($member as $key => $value) {
					$prop = $instance->getProperty($key);
                    $prop->setValue($ins, $value);
				}	
			} else {
				$ins = $member;
			}
			
			if (count($decoded) == 1 ) {
				if ( gettype(json_decode($json)) == "array" ) {
					$ins = array($ins);
				}
				return $ins;
			}
			else {
				$result[$counter]=$ins;
				$counter++;
			}
			if ($counter == count($decoded)) {
				return $result;
			}
		}
	}
}
