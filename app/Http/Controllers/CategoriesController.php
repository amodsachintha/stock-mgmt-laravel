<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $cats = DB::table('categories')
            ->get();

        $counts = [];
        foreach ($cats as $cat) {
            $val = DB::table('items')
                ->where('id_category', $cat->id)
                ->count();
            array_push($counts, [
                'category' => $cat->name,
                'count' => $val
            ]);
        }

        return view('pages.categories', [
            'counts' => $counts,
        ]);
    }


    public function add(Request $request)
    {

        $c = DB::table('categories')
            ->where('name', $request->get('cat'))
            ->count();

        if ($c == 0) {
            DB::table('categories')
                ->insert([
                    'name' => $request->get('cat'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            return response()->json(['status'=>'ok']);
        }

        return response()->json(['status'=>'fail']);
    }


}
