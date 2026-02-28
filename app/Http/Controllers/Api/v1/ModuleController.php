<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\ModuleCollection;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = Module::paginate(10);
        return new ModuleCollection($module);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function activate($id)
    {
        $module = Module::find($id);
        if (!$module) {
            return response()->json([
                'error' => 'Module not found'
            ], 404);
        }
        $module->active = true;
        $module->save();
        return response()->json([
            'message' => 'Module activated'
        ], 200);
    }
    public function deactivate($id)
    {
        $module = Module::find($id);
        if (!$module) {
            return response()->json([
                'error' => 'Module not found'
            ], 404);
        }
        $module->active = false;
        $module->save();
        return response()->json([
            'message' => 'Module deactivated'
        ], 200);
    }
}
