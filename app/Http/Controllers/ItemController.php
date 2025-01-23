<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Checklist;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    function __construct()
    {
        $this->checklist = new Checklist();
        $this->item = new Item();
    }

    public function store(Request $request, string $idChecklist)
    {
        // check id
        $checklist = $this->checklist->getId($idChecklist);
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'Checklist not found'
            ], 404);
        }

        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // create database
        $params = [
            'idChecklist' => $idChecklist,
            'name' => $request->input('name'),
            'status' => 0,
        ];
        $this->item->createItem($params);
        return response()->json([
            'code' => 200,
            'message' => 'Item created successfully',
        ], 200);
    }

    public function show(string $id)
    {
        $data = $this->item->where('id', $id)->first();
        return response()->json([
            'code' => 200,
            'message' => 'Successfully',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idChecklist, string $id)
    {
        // check checklist by id
        $checklist =  $this->checklist->where('id', $idChecklist)->first();
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'Checklist not found'
            ], 404);
        }
        // check item by id
        $checklist =  $this->item->where('id', $id)->first();
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'item not found'
            ], 404);
        }

        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'status' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // update database
        $params = [
            'name' => $request->input('name'),
            'status' => $request->input('status')
        ];
        $this->item->updateItem($params, $id);
        return response()->json([
            'code' => 200,
            'message' => 'Item updated successfully',
            'data' => $params
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // check item by id
        $checklist =  $this->item->where('id', $id)->first();
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'item not found'
            ], 404);
        }

        $this->item->deleteItem($id);
        return response()->json([
            'code' => 200,
            'message' => 'Item delete successfully',
        ], 200); 
    }
}
