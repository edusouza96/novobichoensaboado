<?php

namespace BichoEnsaboado\Http\Controllers;

use Illuminate\Http\Request;
use BichoEnsaboado\Http\Requests;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;

class PdvController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    public function __construct(DiaryRepository $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }

   
    public function index($id = null)
    {
        try {
            $diary = is_null($id) ? null : $this->diaryRepository->find($id);

            return view('pdv.index', compact('diary'));
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', 'Data Invalida!');
        }
    }

   
}
