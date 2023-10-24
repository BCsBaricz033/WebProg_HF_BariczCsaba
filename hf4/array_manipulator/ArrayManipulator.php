<?php
class ArrayManipulator {
    private $data = [];

    public function __construct($initialData = []) {
        $this->data = $initialData;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            // Handle error or return default value
            return null;
        }
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __isset($name) {
        return isset($this->data[$name]);
    }

    public function __unset($name) {
        unset($this->data[$name]);
    }

    public function __toString() {
        return implode(', ', $this->data);
    }

    public function __clone() {
        $this->data = array_map(function($item) {
            if (is_object($item) || is_array($item)) {
                return clone $item;
            } else {
                return $item;
            }
        }, $this->data);
    }
}


