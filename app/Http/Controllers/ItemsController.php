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

   public function index(){
//       return response()->json($this->getItemsFromDB());
       return view('pages.items', ['items'=>$this->getItemsFromDB()]);
   }

   private function getItemsFromDB(){
       return DB::table('items')
                ->join('categories','items.id_category','=','categories.id')
                ->join('uom','items.id_uom','=','uom.id')
                ->select('items.*','categories.name as cat','uom.name as uom')
                ->orderBy('items.id','ASC')
                ->paginate(18);
   }



}
