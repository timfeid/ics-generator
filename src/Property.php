<?php

namespace TimFeid\ICS;

class Property
{
    protected $name;
    protected $value;
    protected $attributes = [];

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    protected function beginning()
    {
        if (empty($this->attributes)) {
            return "{$this->name}:";
        }

        $attrs = implode(';', array_map(function ($key, $value) {
            return "$key=$value";
        }, array_keys($this->attributes), $this->attributes));

        return "{$this->name};{$attrs}:";
    }

    protected function value()
    {
        return $this->properLength($this->encode($this->value));
    }

    protected function properLength($value)
    {
        $beginning = $this->beginning();
        $total = $beginning . $value;
        if (strlen($total) <= 75) {
            return $value;
        } else {
            return substr(
                str_replace("\n", "\n ",
                    chunk_split(
                        str_repeat(' ', strlen($beginning)).$value, 75
                    )
                ), strlen($beginning));
        }
    }

    protected function encode($value)
    {
        return str_replace(["\n", ','], ['\\n', '\\,'], $value);
    }

    public function __toString()
    {
        return $this->beginning().$this->value();
    }
}
