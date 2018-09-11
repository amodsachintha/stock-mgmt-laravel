<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.items', ['items' => $this->getItemsFromDB(), 'cats' => $this->getCategories()]);
    }

    private function getItemsFromDB()
    {
        return DB::table('items')
            ->join('categories', 'items.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('items.*', 'categories.name as cat', 'uom.name as uom')
            ->where('deleted', false)
            ->orderBy('items.id', 'ASC')
            ->paginate(18);
    }

    private function getCategories()
    {
        return DB::table('categories')
            ->select('name')
            ->get();
    }

    public function showItem($id)
    {

        $id = intval($id);
        $item = DB::table('items')
            ->join('categories', 'items.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('items.*', 'categories.name as cat', 'uom.name as uom')
            ->where('items.id', $id)
            ->where('deleted', false)
            ->first();

        $ledgerRecords = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*', 'items.name as item_name', 'categories.name as cat_name', 'uom.name as uom')
            ->where('id_item', $id)
            ->where('deleted', false)
            ->get();

//        return response()->json($ledgerRecords);

        return view('pages.item', ['item' => $item, 'ledgerRecs' => $ledgerRecords]);
    }


    public function updateItem(Request $request)
    {
        $low = $request->get('low');
        $med = $request->get('med');
        $item_id = $request->get('item_id');

        try {
            DB::table('items')
                ->where('id', intval($item_id))
                ->update([
                    'low' => intval($low),
                    'medium' => intval($med),
                ]);
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail']);
        }


    }

    public function deleteItem(Request $request)
    {
        $item_id = $request->get('item_id');

        try {
            DB::table('items')
                ->where('id', intval($item_id))
                ->update([
                    'deleted' => true,
                ]);

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail']);
        }

    }


    public function showAdd()
    {
        $cats = DB::table('categories')
            ->get();

        $uoms = DB::table('uom')
            ->get();

        return view('pages.add_item', ['cats' => $cats, 'uoms' => $uoms]);
    }

    public function addItem(Request $request)
    {
//        return response()->json($request->all());
        $name = $request->get('name');
        $id_category = $request->get('id_category');
        $id_uom = $request->get('id_uom');
        $unit_price = $request->get('unit_price');
        $low = $request->get('low');
        $medium = $request->get('medium');
        $description = $request->get('description');

        try {
            DB::table('items')
                ->insert([
                    'name' => $name,
                    'id_category' => intval($id_category),
                    'id_uom' => intval($id_uom),
                    'unit_price' => floatval($unit_price),
                    'low' => intval($low),
                    'medium' => intval($medium),
                    'quantity' => 0,
                    'description' => $description,
                ]);

            $id = DB::table('items')
                ->orderBy('id', 'DESC')
                ->first();

            return redirect('/item/show/' . $id->id);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        if ($search == "" || $search == null) {
            $items = DB::table('items')
                ->join('categories', 'items.id_category', '=', 'categories.id')
                ->join('uom', 'items.id_uom', '=', 'uom.id')
                ->select('items.*', 'categories.name as cat', 'uom.name as uom')
                ->where('deleted', false)
                ->where('categories.name', $category)
                ->orderBy('items.id', 'ASC')
                ->get();
        } else {
            $items = DB::table('items')
                ->join('categories', 'items.id_category', '=', 'categories.id')
                ->join('uom', 'items.id_uom', '=', 'uom.id')
                ->select('items.*', 'categories.name as cat', 'uom.name as uom')
                ->where('deleted', false)
                ->where('items.name', 'like', '%' . $search . '%')
                ->where('categories.name', $category)
                ->orderBy('items.id', 'ASC')
                ->get();
        }

        return view('pages.items', ['items' => $items, 'cats' => $this->getCategories()]);

    }


}
