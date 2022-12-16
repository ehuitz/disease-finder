<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class SearchController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'search_text' => ['required', 'string', 'max:255'],

        ]);

        $search = Search::create([
            'user_id' => auth()->user()->id,
            'search_text' => $request->name,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
