<?php

namespace BichoEnsaboado\Repositories;

use Carbon\Carbon;
use BichoEnsaboado\Models\Diary;

class DiaryRepository
{
    private $diary;

    public function __construct(Diary $diary)
    {
        $this->diary = $diary;
    }


    public function findByDate(Carbon $date)
    {
        return $this->diary->whereBetween('date_hour', [$date->startOfDay()->toDateTimeString(), $date->endOfDay()->toDateTimeString()])->get();
    }

    public function all()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
