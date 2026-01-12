<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Template;
use Illuminate\Http\Request;

class TempelateController extends Controller
{
    public function index(Request $request)
    {
      $tempelate = Template::all();
       $musics = Music::where('is_active', true)->get();
      return view('dashboard.tempelate.index', compact('tempelate','musics'));
    }
}
