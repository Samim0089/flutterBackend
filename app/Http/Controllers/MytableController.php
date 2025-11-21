<?php

namespace App\Http\Controllers;

use App\Models\Mytable;
use Illuminate\Http\Request;

class MytableController extends Controller
{
    // Get all rows
    public function index(Request $request)
    {
        // If request has ?phonenumber=xxxx
        if ($request->has('phonenumber')) {

            $phone = $request->phonenumber;

            $data = Mytable::where('phonenumber', $phone)->get();

            return response()->json([
                'status' => 'success',
                'count' => $data->count(),
                'data' => $data
            ]);
        }

        // Default: return all
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
        $request->validate([
            'name' => 'required|string',
            'phonenumber' => 'required|string|unique:mytable,phonenumber',
            'bloodGroup' => 'required|string',
            'location' => 'required|string',
        ]);

        $row = Mytable::create($request->all());

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
