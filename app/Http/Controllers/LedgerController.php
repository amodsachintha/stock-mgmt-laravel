<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $month = $request->get('month');
        $date = strtotime(date('Y-' . intval($month) . '-1'));

        $months = [];
        for ($i = 1; $i <= intval(date('m')); $i++)
            array_push($months, strval(date('F', strtotime(date('Y-' . $i . '-1')))));

        if (isset($month))
            return view('pages.ledger', [
                'data' => $this->getLedgerForCurrentMonth(intval($month)),
                'totals' => $this->getTotals(intval($month)),
                'month' => date('F Y', $date),
                'months' => $months,
            ]);
        else
            return view('pages.ledger', ['data' => $this->getLedger(), 'paginate' => true]);
    }

    private function getLedgerForCurrentMonth($month)
    {
        return DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*', 'items.name as item_name', 'categories.name as cat_name', 'uom.name as uom')
            ->where('date_time', '>=', date('Y-' . $month . '-1'))
            ->where('date_time', '<', date('Y-' . strval(intval($month) + 1) . '-1'))
            ->orderBy('id', 'DESC')
            ->get();
    }

    private function getLedger()
    {
        return DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*', 'items.name as item_name', 'categories.name as cat_name', 'uom.name as uom')
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    private function getTotals($month)
    {
        $issues_total = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->where('in', false)
            ->where('date_time', '>=', date('Y-' . $month . '-1'))
            ->where('date_time', '<', date('Y-' . strval(intval($month) + 1) . '-1'))
            ->select(DB::raw('sum((ledger.quantity * items.unit_price)) as total'))
            ->first();

        $restock_total = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->where('in', true)
            ->where('date_time', '>=', date('Y-' . $month . '-1'))
            ->where('date_time', '<', date('Y-' . strval(intval($month) + 1) . '-1'))
            ->select(DB::raw('sum((ledger.quantity * items.unit_price)) as total'))
            ->first();

        return [
            'issue_total' => number_format($issues_total->total, 2),
            'restock_total' => number_format($restock_total->total, 2)
        ];
    }

    public function showLedgerEntry(Request $request)
    {
        $id = $request->get('id');
        $entry = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*','items.name as item_name','categories.name as cat','items.unit_price as price','uom.name as uom')
            ->where('ledger.id', $id)
            ->first();

//        return response()->json($entry);

        if ($entry->in == 0) { // issue
            return view('pages.ledger_entry', ['entry' => $entry, 'issue' => true]);
        } else { // restock
            return view('pages.ledger_entry', ['entry' => $entry, 'issue' => false]);
        }
    }


}
