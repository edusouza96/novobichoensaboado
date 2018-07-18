<?php

namespace BichoEnsaboado\Http\Controllers;

use Carbon\Carbon;
use BichoEnsaboado\Http\Requests;
use Illuminate\Http\Request;
use BichoEnsaboado\Http\Controllers\Controller;
use BichoEnsaboado\Repositories\DiaryRepository;
use Illuminate\Database\Eloquent\Collection;

class DiaryController extends Controller
{
    private $diaryRepository;

    public function __construct(DiaryRepository $diaryRepository)
    {
        $this->diaryRepository = $diaryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = null)
    {
        try{
            if(is_null($date)){
                $date = Carbon::today();
            }else{
                $date = Carbon::createFromFormat('Y-m-d', $date);
            }

            $diaries = new Collection();// = $this->diaryRepository->findByDate($date);
            // $diaries->add('08:00')->add('09:00');
            return view('diary.index', compact('date', 'diaries'));
        }catch(\InvalidArgumentException  $e){
            return back()->with('alertType', 'alert-danger')->with('message', 'Data Invalida!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
