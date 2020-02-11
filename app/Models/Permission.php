<?php 
namespace BichoEnsaboado\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
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