<?php

namespace BichoEnsaboado\Http\Controllers;

use BichoEnsaboado\Repositories\TreasureRepository;

class TreasureController extends Controller
{
    private $treasureRepository;

    public function __construct(TreasureRepository $treasureRepository)
    {
        $this->treasureRepository = $treasureRepository;
    }

    public function findByStore($storeId)
    {
        try {
            $treasure = $this->treasureRepository->findByStore($storeId);
            return response()->json($treasure);
        } catch (\InvalidArgumentException $e) {
        }
    }
    
    public function findOptionsCardMachineByStore($storeId)
    {
        try {
            $treasure = $this->treasureRepository->findOptionsCardMachineByStore($storeId);
            return response()->json($treasure);
        } catch (\InvalidArgumentException $e) {
        }
    }
}
