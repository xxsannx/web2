<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Room::query();

        // Filter berdasarkan type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan harga
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter available
        $query->where('available', true);

        $rooms = $query->get();

        return view('home', compact('rooms'));
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('room-detail', compact('room'));
    }
}