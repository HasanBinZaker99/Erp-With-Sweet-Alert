<?php

namespace App\Http\Controllers\Purchase;
use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\CRM\Leeds;
use App\Models\Supplier\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function addingPurchase(){

        return view('purchase.adding-purchase');
    }
    public function addPurchase(){

        return view('purchase.createpurchase');
    }
    public function getTables(){
//        $data = Product::all();
        $user = Supplier::all();
//        $leeds = Leeds::all();
//        $supp = User::all()->where('id', '=', session('id'));
        return response()->json($user) ;
    }
    public function getClients(){
        $leeds = Leeds::all();
        return response()->json($leeds) ;
    }
    public function getProducts(){
        $data = Product::all();
        return response()->json($data);
    }
//    public function __construct(){
//        $this->middleware('auth');
//    }
    public function getAuth(){
        $supp = Auth::user();
        return response()->json($supp) ;
        Log::info($supp);
    }
}
