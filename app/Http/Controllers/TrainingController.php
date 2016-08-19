<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests;
use App\Training;
use App\Transformers\TrainingTransformer;
use Illuminate\Http\Request;
use Response;

class TrainingController extends Controller
{
    /*
    * @var App\Transformers\TrainingTransformer
    */
    protected $trainingTransformer;

    function __construct(TrainingTransformer $trainingTransformer)
    {
        $this->trainingTransformer = $trainingTransformer;
    }

    
    public function index(Club $club)
    {
        $trainings = $club->trainings;

        foreach ($trainings as $training) {
            $training->photos;
            $training->teachers;
        }

        return Response::json([
            'result' => $trainings,
        ], 200);
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
    public function store(Club $club, Request $request)
    {
        //
        $decode = json_decode($request->data);
        $data = $this->trainingTransformer->transform($decode);
        $training = new Training($data);
        $training->save();

        for ($i = 0; $i < count($decode->pictures); $i++) {
            $training->photos()->attach(intval($decode->pictures[$i]->id), ['pinned' => 'N']);
        }

        for ($i = 0; $i < count($decode->teachers); $i ++) { 
            $training->teachers()->attach(intval($decode->teachers[$i]->id));    
        }

        return $training;
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
