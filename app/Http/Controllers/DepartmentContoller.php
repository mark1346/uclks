<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ModuleController;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Department::orderBy("name")->get();
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
        $department = Department::find($id);
        $modules = $department->modules;
        $module_controller = new ModuleController;

        $moduleAverages = $modules->map(function ($module) use ($module_controller) {
            $id = $module->id;
            return [$id => $module_controller->average($id)->original];
        });

        return array_merge(json_decode($department, true), ["modules" => json_decode($department->modules()->get(), true), "averages" => $moduleAverages]);
    }

    public function search(Request $request)
    {
        $descending = json_decode($request->query("descending"));
        if ($descending === true) {
            return Department::where('name', 'like', '%' . $request->query("keyword") . '%')->orderBy("name", 'DESC')->get();
        } else {
            return Department::where('name', 'like', '%' . $request->query("keyword") . '%')->orderBy("name")->get();
        }

        // No direction variable
        // There is a direction variable but invalid
        // There is a variabel and invalid

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
