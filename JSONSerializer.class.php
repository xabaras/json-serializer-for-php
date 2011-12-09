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
 *
 * The class implements methods to simply serialize/deserialize a PHP object/array from/to JSON
 *
 * @author Paolo Montalto <webmaster[at]xabaras.it>
 *
 */

class JSONSerializer {

	public function serialize($ObjectInstance) {
		return json_encode($ObjectInstance);
	}


	public function deserialize($json, $className) {
		$result=null;
		$counter=0;
		$decoded = json_decode($json);
		
		if (gettype($decoded) != "array") {
			$decoded = array($decoded);
		}
		
		foreach ($decoded as $member) {
			$instance = new ReflectionClass($className);
			$ins=$instance->newInstance();
			
			if ($member == "") {
				return null;
			}
			
			foreach ($member as $key => $value) {
				$prop = $instance->getProperty($key);
				if (gettype($value) != "array") {
					$prop->setValue($ins, $value);
				}
				else {
					$memberClass = get_class($value[0]);
					$prop->setValue($ins, $this->deserialize($value, $memberClass));
				}
			}
			if (count($decoded)==1) {
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

?>