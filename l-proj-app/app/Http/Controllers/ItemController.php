<?php

namespace App\Http\Controllers;

use App\Models\YourTable;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $data = Item::all(); // Fetch all records
        return response()->json($data);
    }
}

Route::get('/item-data', [ItemController::class, 'index']);