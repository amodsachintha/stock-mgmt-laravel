<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',['items'=>$this->getStockLowItems()]);
    }

    private function getStockLowItems(){
        $items =  DB::table('items')
                ->join('uom','items.id_uom','=','uom.id')
                ->select('items.id','items.name','items.quantity','items.low','uom.name as uom')
                ->where('deleted',false)
                ->get();

        $itemsArray = [];

        foreach ($items as $item) {
            if($item->quantity <= $item->low){
                array_push($itemsArray,$item);
            }
        }

        return $itemsArray;

    }


}
