<?php
namespace BichoEnsaboado\Presenters;

use BichoEnsaboado\Models\Diary;

class BlacklistPresenter
{
    private $diary;

    public function __construct(Diary $diary)
    {
        $this->diary = $diary;
    }

    public function toArray()
    {
        return [
            'id' => $this->diary->getId(),
            'owner' => $this->diary->getClient()->getOwner()->getName(),
            'pet' => $this->diary->getClient()->getName(),
            'phone' => $this->diary->getClient()->getPhone1(),
            'value' => $this->diary->getGross(),
            'date' => $this->diary->getDateHour(),
        ];
    }
        
}