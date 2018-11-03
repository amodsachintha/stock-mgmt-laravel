<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LedgerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(!Session::has('summary_year')){
            session(['summary_year'=>date('Y')]);
        }
    }

    public function index(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $date = strtotime(date($year.'-' . intval($month) . '-1'));

        $months = [];
        if ($year != strval(date('Y'))) {
            for ($i = 1; $i <= 12; $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        } else {
            for ($i = 1; $i <= intval(date('m')); $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        }

        if (isset($month))
            return view('pages.ledger', [
                'data' => $this->getLedgerForCurrentMonth(intval($month),intval($year)),
                'totals' => $this->getTotals(intval($month)),
                'month' => date('F Y', $date),
                'months' => $months,
            ]);
        else
            return view('pages.ledger', ['data' => $this->getLedger(), 'paginate' => true]);
    }

    private function getLedgerForCurrentMonth($month, $year)
    {
        return DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*', 'items.name as item_name', 'categories.name as cat_name', 'uom.name as uom')
            ->where('date_time', '>=', date($year.'-' . $month . '-1'))
            ->where('date_time', '<', date($year.'-' . strval(intval($month) + 1) . '-1'))
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
            ->get();
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


    public function setSummaryYear(Request $request){
        session(['summary_year'=>$request->get('year')]);
        return redirect('/view/all?year='.$request->get('year'));
    }


    public function viewAllFromYear(Request $request){
        $month = 01;
        $year = $request->get('year');
        $date = strtotime(date($year.'-' . intval($month) . '-1'));

        $months = [];
        if ($year != strval(date('Y'))) {
            for ($i = 1; $i <= 12; $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        } else {
            for ($i = 1; $i <= intval(date('m')); $i++)
                array_push($months, strval(date('F', strtotime(date($year . '-' . $i . '-1')))));
        }


        $data = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->join('categories', 'ledger.id_category', '=', 'categories.id')
            ->join('uom', 'items.id_uom', '=', 'uom.id')
            ->select('ledger.*', 'items.name as item_name', 'categories.name as cat_name', 'uom.name as uom')
            ->where('date_time', '>=', date($year.'-' . $month . '-1'))
            ->where('date_time', '<', date((intval($year)+1).'-01-01'))
            ->orderBy('id', 'DESC')
            ->get();


        if (isset($month))
            return view('pages.ledger', [
                'data' => $data,
                'totals' => $this->getTotalsYear(intval($year)),
                'month' => date('Y', $date),
                'months' => $months,
            ]);
        else
            return view('pages.ledger', ['data' => $this->getLedger(), 'paginate' => true]);
    }

    private function getTotalsYear($year)
    {
        $issues_total = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->where('in', false)
            ->where('date_time', '>=', date($year.'-01-01'))
            ->where('date_time', '<', date((intval($year)+1).'-01-01'))
            ->select(DB::raw('sum((ledger.quantity * items.unit_price)) as total'))
            ->first();

        $restock_total = DB::table('ledger')
            ->join('items', 'ledger.id_item', '=', 'items.id')
            ->where('in', true)
            ->where('date_time', '>=', date($year.'-01-01'))
            ->where('date_time', '<', date((intval($year)+1).'-01-01'))
            ->select(DB::raw('sum((ledger.quantity * items.unit_price)) as total'))
            ->first();

        return [
            'issue_total' => number_format($issues_total->total, 2),
            'restock_total' => number_format($restock_total->total, 2)
        ];
    }


}
