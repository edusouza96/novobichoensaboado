<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Services\DiaryCreateService;
use BichoEnsaboado\Repositories\DiaryRepository;
use BichoEnsaboado\Presenters\BlacklistPresenter;

class DiaryController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    /** @var DiaryCreateService */
    private $diaryService;

    public function __construct(DiaryRepository $diaryRepository, DiaryCreateService $diaryService)
    {
        $this->diaryRepository = $diaryRepository;
        $this->diaryService = $diaryService;
    }

    public function index($date = null, $msg = null)
    {
        try {
            if (is_null($date)) {
                $date = Carbon::today();
            } else {
                $date = Carbon::createFromFormat('Y-m-d', $date);
            }

            $storeId = auth()->user()->getStore()->getId();
            $diaries = $this->diaryRepository->findByDate($date, $storeId);
            return view('diary.index', compact('date', 'diaries', 'msg'));
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', 'Data Invalida!');
        }
    }


    public function store(Request $request)
    {
        try {
            $store = auth()->user()->getStore()->getId();
            $diary = $this->diaryService->create($request->all(), auth()->user(), $store);
            return response()->json($diary);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }

    }
    
    public function checkin(Request $request)
    {
        try {
            $diary = $this->diaryRepository->checkin($request->id);
            return response()->json($diary);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }

    }

    public function blacklist()
    {
        $storeId = auth()->user()->getStore()->getId();
        $diary = $this->diaryRepository->blacklist($storeId);
        $diary = $diary->map(function($item){
           $debitor = new BlacklistPresenter($item);
           return $debitor->toArray();
        });
        return response()->json($diary);
    }

    public function destroy(Request $request)
    {
        try {
            $response = $this->diaryRepository->delete($request->id);
            return response()->json($response);
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', $ex->getMessage());
        }
    }

    public function historic(Request $request, $client_id)
    {
        $attributes = $request->all();
        $attributes['client_id'] = $client_id;
        $historic = $this->diaryRepository->findByFilter($attributes, true);
        return view('client.historic', compact('historic', 'client_id'));
    }

}
