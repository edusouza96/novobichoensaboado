<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Repositories\OwnerRepository;

class OwnerController extends Controller
{

    /** @var OwnerRepository */
    private $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function myPets($id)
    {
        try{
            $pets = $this->ownerRepository->myPets($id);
            return response()->json($pets);
        }catch(\InvalidArgumentException  $e){
        }
    }
}
