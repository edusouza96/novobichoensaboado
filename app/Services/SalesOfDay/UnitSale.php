<?php

namespace BichoEnsaboado\Services\SalesOfDay;

class UnitSale
{
    private $idSale;
    private $id;
    private $name;
    private $value;
    private $date;
    private $store;
    private $type;

    public function __construct($idSale, $id, $name, $value, $date, $store, $type)
    {
        $this->idSale = $idSale;
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->date = $date;
        $this->store = $store;
        $this->type = $type;
    }

    public function getIdSale()
    {
        return $this->idSale;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function getType()
    {
        return $this->type;
    }
}