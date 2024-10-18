<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    public function groupEdit(Request $request, $id)
    {
        $product_group = DB::table('product_groups')->where('id', $id)->select('group_name','product_id')->first();
        $added_products = ($product_group->product_id != 'null') ? json_decode($product_group->product_id, true) : [];

        $sort_search = null;
        $products = Product::where('category_id',4)->where('qty', '>', 0);
        if ($request->search != null) {
            $products = $products
                ->where('products.name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $products = $products->select('products.id','products.name','products.thumbnail_img')->paginate(20);
        return view('backend.product.groups.edit', compact('product_group', 'products', 'added_products', 'id', 'sort_search'));
    }

    public function products_group_details($id)
    {
        $product_group = DB::table('product_groups')->where('id', $id)->select('product_id')->first();
        $products = ($product_group->product_id != 'null') ? json_decode($product_group->product_id, true) : [];
        $products = Product::whereIn('id',$products)->select('name','thumbnail_img')->get();
        return view('backend.product.groups.details', compact('products'));
    }

    public function products_group_delete($id)
    {
        DB::table('product_groups')->where('id', $id)->delete();
        flash(translate('deleted successfully!'))->success();
        return back();
    }

    public function makeGroup(Request $request)
    {
        $random = substr(md5(mt_rand()), 0, 7);
        $p_group = new ProductGroup();
        $p_group->vendor_id = Auth::id();
        $p_group->group_name = 'group_' . $random;
        $p_group->product_id = json_encode($request->products_id);
        $p_group->save();
        Session::forget('s_pack_id');
        return 1;
    }

    public function updateGroup(Request $request)
    {
        $p_group = ProductGroup::find($request->group_id);
        $request->validate([
            'group_name' => 'unique:product_groups,group_name,'.$p_group->id
        ]);
        if($request->group_name){
            $group_name = $request->group_name;
        }
        else{
            $group_name = $p_group->group_name;
        }
        $p_group->group_name = $group_name;
        $p_group->product_id = json_encode($request->products_id);
        $p_group->update();
        flash(translate('Group updated successfully'))->success();
        return back();
    }
}
