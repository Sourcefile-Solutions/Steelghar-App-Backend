<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct;
use App\Models\Tmtdetail;
use Illuminate\Http\Request;

class TmtdetailController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) $this->getTmtdetail($request);
        return view('console.tmt-detail.index');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'thickness' => 'required',
            'weight' => 'required',
            'status' => 'required|boolean'
        ]);

        $create = Tmtdetail::create($validated);
        if ($create) return response()->json(['message' => 'Thickness ' . $request->thickness . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Thickness ' . $request->thickness, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    public function edit(Tmtdetail $tmt_detail)
    {
        return response()->json(['message' => 'success', 'tmtdetail' => $tmt_detail], 200);
    }


    public function update(Request $request, Tmtdetail $tmt_detail)
    {

        $validated = $request->validate([
            'thickness' => 'required',
            'weight' => 'required',
            'status' => 'required|boolean'
        ]);


        $updated = $tmt_detail->update($validated);

        if ($updated) {
            $this->updateProducts('update', $tmt_detail);
            return response()->json(['message' => 'Thickness ' . $tmt_detail->thickness . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update thickness ' . $tmt_detail->thickness, 'title' => 'Failed', 'status' => 'error'], 200);
    }


    public function destroy(Tmtdetail $tmt_detail)
    {
        if ($tmt_detail->delete()) {
            $this->updateProducts("delete", $tmt_detail);
            return response()->json(['message' => 'Thickness ' . $tmt_detail->thickness . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete thickness ' . $tmt_detail->thickness, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getTmtdetail($request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        // Total records
        $totalRecords = Tmtdetail::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Tmtdetail::select('count(*) as allcount')
            ->count();
        // Fetch records
        $records = Tmtdetail::select('tmtdetails.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $thickness = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->thickness . '</span>
                        </span>
                    </div>';

            $weight = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->weight . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "thickness" => $thickness,
                "weight" => $weight,
                "status" => $status,
                "action" => $id,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    }

    public function weight($id)
    {
        $tmt = Tmtdetail::find($id);

        return $tmt->weight;
    }




    private function updateProducts($action, $tmt_detail)
    {
        if ($action == "update") {
            $products = Product::where([['category_id', 1], ['thickness_id', $tmt_detail->id]])->get();
            foreach ($products as $product) {
                $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();
                $product->low_price = number_format($brands->min('price') * $tmt_detail->weight, 2, '.', '');
                $product->save();
            }
        } else if ($action == "delete") {

            $products = Product::where([['category_id', 1], ['thickness_id', $tmt_detail->id]])->pluck('id')->toArray();
            $carts = Cart::where('status', false)->pluck('id')->toArray();
            Cartproduct::whereIn('cart_id', $carts)->delete();
            $customers = Customer::get();
            foreach ($customers as $customer) {
                $wishlist = json_decode($customer->wishlists);
                $new = array_diff($wishlist, $products);
                $customer->wishlists = array_values($new);
                $customer->save();
            }
            $products = Product::where([['category_id', 1], ['thickness_id', $tmt_detail->id]])->delete();
        }
    }
}
