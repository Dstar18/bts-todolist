<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    function __construct()
    {
        $this->checklist = new Checklist();
        $this->item = new Item();
    }

    public function index()
    {
        $data = $this->checklist->getList();
        return response()->json([
            'code' => 200,
            'message' => 'Successful',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // create database
        $params = [
            'title' => $request->input('title'),
            'is_completed' => 0,
        ];
        $this->checklist->createChecklist($params);
        return response()->json([
            'code' => 200,
            'message' => 'Checklist created successfully'
        ], 200);
    }

    public function show(string $id)
    {
        // check id
        $checklist = $this->checklist->getId($id);
        $items = $this->item->getByChecklistId($id);
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ], 404);
        }
       
        $checklist->items = [];
        foreach($items as $item){
            $checklist->items[] = [
                'name' => $item->name,
                'status' => $item->status,
            ];
        }
        return response()->json([
            'code' => 200,
            'message' => 'Successfully',
            'data' => $checklist,
        ], 200); 
    }

    public function update(Request $request, string $id)
    {
        // check id
        $checklist = $this->checklist->getId($id);
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ], 404);
        }

        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'is_completed' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // update database
        $params = [
            'title' => $request->input('title'),
            'is_completed' => $request->input('is_completed'),
        ];
        $this->checklist->updateChecklist($params, $id);
        $resultChecklits = $this->checklist->where('id', $id)->first();
        return response()->json([
            'code' => 200,
            'message' => 'Checklit updated successfully',
            'data' => $resultChecklits
        ], 200);
    }

    public function destroy(string $id)
    {
        // check id
        $checklist = $this->checklist->getId($id);
        if (!$checklist) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ], 404);
        }
        $this->checklist->deleteChecklistItem($id);
        return response()->json([
            'code' => 200,
            'message' => 'Delete successfully',
        ], 200);
    }
}
