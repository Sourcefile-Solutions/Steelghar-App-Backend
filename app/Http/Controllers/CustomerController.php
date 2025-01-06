<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Public\Address;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct;
use App\Models\Public\Order;
use App\Models\Public\Wishlist;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getRegisteredUser($request);
        return view('console.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // return $customer;
        $orders = Order::where([['customer_id', $customer->id], ['order_status', true]])->latest()->get();

        foreach ($orders as $order) {
            $cleanedAmount = str_replace(['PHP', ',', '.00'], '', $order->payable_amount);
            $order->pa = (int) $cleanedAmount;
        }


        $cart = Cart::where([['customer_id', $customer->id], ['status', false]])->first();

        if ($cart) {
            $cartProducts = Cartproduct::join('products', 'products.id', 'cartproducts.product_id')->where('cart_id', $cart->id)
                ->select('product_name', 'category_id', 'brand_id',  'length')
                ->get();
        } else $cartProducts = [];





        $wishlist = Wishlist::where('customer_id', $customer->id)->first();

        if ($wishlist) $wishlists = Product::join('categories', 'categories.id', 'products.category_id')->whereIn('products.id', json_decode($wishlist->products))->select('product_name', 'category_id', 'category_name')->get();
        else  $wishlists = [];



        $addressess = Address::where('customer_id', $customer->id)->get();
        return view('console.customer.show', [
            'customer' => $customer,
            'orders' => $orders,
            'cartProducts' => $cartProducts,
            'wishlists' => $wishlists,
            'addressess' => $addressess
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    public function updateNotification(Request $request, Customer $customer)
    {


        if ($request->has('notification1')) {


            $customer->notification1 = $request->notification1;
        } else if ($request->has('notification2')) {
            $customer->notification2 = $request->notification2;
        }

        if ($customer->save()) return response()->json([
            'status' => 'success'
        ]);
    }



    public function destroy(Customer $customer)
    {
        //
    }

    public function getRegisteredUser($request)
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
        $totalRecords = Customer::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Customer::select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Customer::where('name', 'like', '%' . $searchValue . '%')
            ->select('customers.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->latest()
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $name = '<div class="d-flex align-items-center">
            <div class="symbol symbol-30px me-3">                                                   
                <img src="https://ui-avatars.com/api/?background=random&name=' . $record->name . '" class="" alt="">                                                    
            </div>
            
            <div class="d-flex justify-content-start flex-column">
                <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">' . $record->name . '</a>
              
            </div>
        </div>';

            $email = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->email . '</span>
                        </span>
                    </div>';

            $phone = '<div class="d-flex align-items-center gap-3">
                    <span class="d-flex flex-column text-muted">
                        <span class="text-gray-800 text-hover-primary fw-bold">' . $record->phone . '</span>
                    </span>
                </div>';
            $view = '<td class="text-end  pe-12">
                <a href="' . route('console.customers.show', ['customer' => $id]) . '"
                    class="btn btn-sm btn-icon btn-bg-dark  w-30px h-30px">
                    <i class="bi bi-eye fs-4 text-white"></i> </a>
            </td>';

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "created_at" => $record->created_at->format('d M Y'),
                "view" => $view
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
}
