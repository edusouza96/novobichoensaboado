<?php 
namespace BichoEnsaboado\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisplayName()
    {
        return $this->display_name;
    }

    public function getDescription()
    {
        return $this->description;
    }
}