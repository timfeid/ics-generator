<?php

namespace TimFeid\ICS;

class Product
{
    protected $company;
    protected $version;
    protected $language;

    public function __construct($company = null, $version = null, $language = null)
    {
        $this->company = $company;
        $this->version = $version;
        $this->language = $language;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function __toString()
    {
        return sprintf('-//%s//%s//%s', $this->company, $this->version, $this->language);
    }
}
