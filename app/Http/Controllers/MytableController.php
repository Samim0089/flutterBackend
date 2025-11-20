<?php

namespace App\Http\Controllers;

use App\Models\Mytable;
use Illuminate\Http\Request;

class MytableController extends Controller
{
    // Get all rows
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'count' => Mytable::count(),
            'data' => Mytable::all()
        ]);
    }

    // Get single row
    public function show($id)
    {
        $row = Mytable::find($id);
        if (!$row) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }
        return response()->json($row);
    }

    // Add new row
    public function store(Request $request)
    {
        // Remove lastName requirement
        $request->validate([
            'name' => 'required|string',
            'bloodgroup' => 'required|string',
            'location' => 'required|string',
            'phonenumber' => 'required|string',
        ]);

        $row = Mytable::create($request->only(['name', 'bloodgroup', 'location', 'phonenumber']));
        return response()->json($row, 201);
    }

    // Update row
    public function update(Request $request, $id)
    {
        $row = Mytable::find($id);
        if (!$row) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }

        $row->update($request->only(['name', 'bloodgroup', 'location', 'phonenumber']));
        return response()->json($row);
    }

    // Delete row
    public function destroy($id)
    {
        $row = Mytable::find($id);
        if (!$row) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }
        $row->delete();
        return response()->json(['status' => 'success', 'message' => 'Record deleted']);
    }
}
