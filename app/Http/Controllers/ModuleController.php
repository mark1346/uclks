<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function show(Request $request, $id)
    {
        $module = Module::find($id);
        $recent = json_decode($request->query("recent"));

        if ($recent === false) {
            $feedbacks = $module->feedbacks()->orderBy("updated_at", "DESC")->get();
        } else {
            $feedbacks = $module->feedbacks()->orderBy("updated_at")->get();
        }
        return array_merge(json_decode($module, true), ["feedback" => json_decode($feedbacks, true)]);
    }

    public function average($id)
    {
        $feedbacks = Module::find($id)->feedbacks;
        $module_difficulty = round($feedbacks->average(function ($feedback) {
            return $feedback["module_difficulty"];
        }), 1);
        $amount_of_assignments = round($feedbacks->average(function ($feedback) {
            return $feedback["amount_of_assignments"];
        }), 1);
        $exam_difficulty = round($feedbacks->average(function ($feedback) {
            return $feedback["exam_difficulty"];
        }), 1);
        $evaluation = round($feedbacks->average(function ($feedback) {
            return $feedback["evaluation"];
        }), 1);
        return response()->json(["module_difficulty" => $module_difficulty, "amount_of_assignments" => $amount_of_assignments, "exam_difficulty" => $exam_difficulty, "evaluation" => $evaluation], 200);
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
