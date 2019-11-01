<?php

namespace BichoEnsaboado\Services;

use Carbon\Carbon;
use BichoEnsaboado\Models\User;
use BichoEnsaboado\Enums\SourceType;
use BichoEnsaboado\Enums\TypeMovesType;
use BichoEnsaboado\Repositories\OutlayRepository;
use BichoEnsaboado\Repositories\CashBookRepository;
use BichoEnsaboado\Repositories\TreasureRepository;
use BichoEnsaboado\Repositories\CashBookMoveRepository;

class OutlayCreateService
{
    private $outlayRepository;
    private $treasureRepository;
    private $cashBookRepository;
    private $cashBookMoveRepository;

    public function __construct(
        OutlayRepository $outlayRepository, 
        TreasureRepository $treasureRepository,
        CashBookRepository $cashBookRepository, 
        CashBookMoveRepository $cashBookMoveRepository
    )
    {
        $this->outlayRepository =  $outlayRepository;
        $this->treasureRepository =  $treasureRepository;
        $this->cashBookRepository = $cashBookRepository;
        $this->cashBookMoveRepository = $cashBookMoveRepository;
    }

    public function create(array $attributes, User $userLogged, $store)
    {
        $datePay = Carbon::createFromFormat('Y-m-d', $attributes['date_pay']);
        $value = str_replace(',', '.', $attributes['value']);

        $treasure = $this->treasureRepository->subValue($value, SourceType::getName($attributes['source']), $store);
        $cashBook = $this->cashBookRepository->getLast($store);
        $moves = $this->cashBookMoveRepository->save($value, $attributes['source'], TypeMovesType::OUT, $cashBook, $userLogged);
        
        $outlay = $this->outlayRepository->save(
            $attributes['description'], 
            $value, 
            $datePay, 
            $attributes['source'], 
            $attributes['cost_center'], 
            $moves,
            isset($attributes['paid']) ? $attributes['paid']: false, 
            $userLogged, 
            $store
        );

        return $outlay;
    }
    
    public function update($id, array $attributes, User $userLogged, $store)
    {
        $outlay = $this->outlayRepository->find($id);

        $datePay = Carbon::createFromFormat('Y-m-d', $attributes['date_pay']);
        $value = str_replace(',', '.', $attributes['value']);
        $treasure = $this->treasureRepository->addValue($outlay->getValue(), $outlay->getSource()->getName(), $store);
        $treasure = $this->treasureRepository->subValue($value, SourceType::getName($attributes['source']), $store);

        $outlay = $this->outlayRepository->update(
            $id,
            $attributes['description'], 
            $value, 
            $datePay, 
            $attributes['source'], 
            $attributes['cost_center'], 
            isset($attributes['paid']) ? $attributes['paid']: false, 
            $userLogged
        );

        $moves = $outlay->getCashBookMove();
        $moves = $this->cashBookMoveRepository->update($moves, $value, $attributes['source'], $moves->getType(), $moves->getCashBook(), $userLogged);

        return $outlay;
    }

    public function delete($id, $store)
    {
        $outlay = $this->outlayRepository->find($id);
        $this->treasureRepository->addValue($outlay->getValue(), $outlay->getSource()->getName(), $store);
        $moves = $outlay->getCashBookMove();
        $this->cashBookMoveRepository->delete($moves->getId());
        $this->outlayRepository->delete($id);
    }

}