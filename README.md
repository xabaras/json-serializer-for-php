# json-serializer-for-php

Implements methods to simply serialize/deserialize a PHP object/array from/to JSON

## Usage ##
JSONSerializer provides a simple API for Object Oriented PHP to serialize/deserialize objects to/from their JSON representation.

#### serialize($objectInstance) ###
Takes a PHP object and returns a string containing its JSON representation.

#### deserialize($json, $className = NULL) ###
Takes a JSON string and a class name and returns a PHP object
