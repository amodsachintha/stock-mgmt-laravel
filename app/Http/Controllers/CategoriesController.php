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
        return view('pages.categories', [
            'counts' => $this->getCounts($this->getCategories()),
            'totals' => $this->getCategoryValues()
        ]);
    }

    private function getCategories()
    {
        return DB::table('categories')
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function getCategoryValues()
    {
        $values = [];
        $tots = DB::table('items')
            ->select(DB::raw('SUM(unit_price * quantity) as sum'), 'id_category')
            ->groupBy('id_category')
            ->get();

        foreach ($tots as $tot) {
            array_push($values, ['cat_id' => $tot->id_category, 'total' => $tot->sum]);
        }

        return $values;

    }

    public function getCounts($categories)
    {
        $counts = [];
        foreach ($categories as $category) {
            $c = DB::table('items')
                ->where('id_category', $category->id)
                ->where('deleted', false)
                ->count();
            array_push($counts, ['cat' => $category->name, 'cat_id' => $category->id, 'count' => $c]);
        }
        return $counts;
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

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'fail']);
    }


}
