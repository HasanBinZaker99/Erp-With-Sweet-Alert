<?php

namespace App\Http\Controllers\product;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Product\Brand;

class BrandController extends Controller
{
    public function brandlist()
    {
        $user = Brand::all()->sortByDesc('id');
        return view('product.brand.brandlist', ['brands' => $user]);
    }
    public function addbrand()
    {
        return view('product.brand.addbrand');
    }
    function addingBrand(Request $req)
    {
        $req->validate([
            'brandName' => 'required'
        ]);
        $user = new Brand;
        $user->brandName = $req->brandName;
        $user->note = $req->note;
        $user->save();
        return redirect('brand-list')->with('Create_Message', 'New Brand Created Successfully');
    }
    public function bedit($id){
        $data = Brand::find($id);
        return view('product.brand.updatebrand',['brand'=>$data]);
    }
    public function getBrandInformation(Request $request)
    {
        $user = Brand::where('id', $request->id)->first();
        return $user;
    }
    function bdelete(Request $request)
    {
        Brand::where('id', $request->id)->delete();
        return redirect('brand-list')->with('Delete_Message', 'Brand Deleted Successfully');
    }
    function Bupdate(Request $req){
        $data = Brand::find($req->id);
        $data->brandName = $req->brandName ;
        $data->note = $req->note;
        $data->save();
        return redirect('brand-list')->with('Update_Message','Brand Updated Successfully');
    }
    function brandSearch(Request $req)
    {
        $data = Brand::where('brandName', 'like', '%' . $req->input('query') . '%')->get();
        return view('product.brand.searchbrand', ['searchs' => $data]);
    }
}

