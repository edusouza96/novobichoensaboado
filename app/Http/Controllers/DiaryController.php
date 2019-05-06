<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\UserRepository;
use BichoEnsaboado\Services\DiaryCreateService;
use BichoEnsaboado\Repositories\DiaryRepository;

class DiaryController extends Controller
{
    /** @var DiaryRepository */
    private $diaryRepository;

    /** @var DiaryCreateService */
    private $diaryService;

    /** @var UserRepository */
    private $userRepository;
    private $user;
    private $store = 1;


    public function __construct(DiaryRepository $diaryRepository, DiaryCreateService $diaryService, UserRepository $userRepository)
    {
        $this->diaryRepository = $diaryRepository;
        $this->diaryService = $diaryService;
        $this->userRepository = $userRepository;
        $this->user = $this->userRepository->find(1);
    }

    public function index($date = null)
    {
        try {
            if (is_null($date)) {
                $date = Carbon::today();
            } else {
                $date = Carbon::createFromFormat('Y-m-d', $date);
            }

            $diaries = $this->diaryRepository->findByDate($date);
            return view('diary.index', compact('date', 'diaries'));
        } catch (\InvalidArgumentException $ex) {
            return back()->with('alertType', 'danger')->with('message', 'Data Invalida!');
        }
    }


    public function store(Request $request)
    {
        try {
            $diary = $this->diaryService->create($request->all(), $this->user, $this->store);
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

    public function update(Request $request, $id)
    {
        //
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
}
