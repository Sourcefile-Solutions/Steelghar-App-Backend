<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Fabircator;

use App\Models\Product;
use App\Models\Public\Order;
use App\Models\User;
use App\Traits\AppTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    use AppTrait;

    public function index()
    {

        // $users = User::select('id')->pluck('id')->toArray();

        // $data = [
        //     'title' => 'Second Notification',
        //     'message' => 'This is a sample notification text',
        //     'image' => ''
        // ];

        // $this->sendNotifications($users, $data);


        $todaySale = Order::where('order_status', true)->whereDate('order_date', now()->today())->select(DB::raw('SUM(REPLACE(payable_amount, ",", "")) as total'))
            ->value('total');
        $todayOrder = Order::where('order_status', true)->whereDate('order_date', now()->today())->count();
        $thisMonthSale = Order::where('order_status', true)->whereMonth('order_date', now()->month)->select(DB::raw('SUM(REPLACE(payable_amount, ",", "")) as total'))
            ->value('total');
        $thisMonthOrder = Order::where('order_status', true)->whereMonth('order_date', now()->month)->count();
        $totalCustomers = Customer::count();
        $totalFabricators = Fabircator::where('approval_status', 'APPROVED')->count();

        $totalSale = Order::where('order_status', true)
            ->select(DB::raw('SUM(REPLACE(payable_amount, ",", "")) as total'))
            ->value('total');
        $totalOrder = Order::where('order_status', true)->count();
        $products = Product::where('status', true)->count();
        $brands = Brand::where('status', true)->count();



        // info('Sales Graph data');
        $period = now()->subMonths(11)->monthsUntil(now());
        $month = $amount = [];
        foreach ($period as $date) {
            $sales = Order::where('order_status', true)->whereBetween(
                'order_date',
                [$date->startOfMonth()->format('Y-m-d'),  $date->endOfMonth()->format('Y-m-d')]
            )->select(DB::raw('SUM(REPLACE(payable_amount, ",", "")) as total'))
                ->value('total');

            array_push($month, $date->format('Y M'));
            array_push($amount, $sales);
        }





        return view('console.index', [
            'todaySale' => $todaySale,
            'todayOrder' => $todayOrder,
            'thisMonthSale' => $thisMonthSale,
            'thisMonthOrder' => $thisMonthOrder,
            'totalCustomers' => $totalCustomers,
            'totalFabricators' => $totalFabricators,

            'totalOrder' => $totalOrder,
            'totalSale' => $totalSale,
            'products' => $products,
            'brands' => $brands,
            'chartAmount' => $amount,
            'chartMonth' => $month,
        ]);
    }
}
