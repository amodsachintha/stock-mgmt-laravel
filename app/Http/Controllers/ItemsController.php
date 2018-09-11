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
        return view('pages.items', ['items' => $this->getItemsFromDB()]);
    }

    private function getItemsFromDB()
    {
        return DB::table('items')
            ->join('categories', 'items.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('items.*', 'categories.name as cat', 'uom.name as uom')
            ->where('deleted',false)
            ->orderBy('items.id', 'ASC')
            ->paginate(18);
    }

    public function showItem($id)
    {

        $id = intval($id);
        $item = DB::table('items')
            ->join('categories', 'items.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('items.*', 'categories.name as cat', 'uom.name as uom')
            ->where('items.id', $id)
            ->where('deleted',false)
            ->first();

        $ledgerRecords = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*', 'items.name as item_name', 'categories.name as cat_name', 'uom.name as uom')
            ->where('id_item', $id)
            ->where('deleted',false)
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


}
