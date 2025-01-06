<?php

namespace App\Traits;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use App\Models\User;

trait AppTrait
{



    public function homeData($user_id)
    {

        $data = [];

        $data['cartCount'] = 4;

        $data['wishlistCount'] = 7;

        $banners = Banner::whereNotNull('mobile_banner')->where('status', true)->pluck('mobile_banner')->toArray();


        foreach ($banners as &$value) {
            $value = 'http://localhost:8000/storage/' . $value;
        }
        $data['banners'] =  $banners;

        $brands = Brand::where('status', true)->pluck('logo')->toArray();

        foreach ($brands as &$value) {
            $value = 'http://localhost:8000/storage/' . $value;
        }
        $data['brands'] =  $brands;
        $latestProducts = Product::where('status', true)->whereNotNull('product_image')->latest()->take(6)->select('id', 'product_image', 'low_price', 'product_name')->get();

        foreach ($latestProducts as $products) {
            $products->product_image = 'http://localhost:8000/storage/' . $products->product_image;
        }
        $data['latestProducts'] =  $latestProducts;
        return $data;
    }

    public function sendNotifications($users, $data)
    {

        $this->storeNotification($users, $data);
    }

    protected function storeNotification($users, $sendData)
    {
        $data = [];
        foreach ($users as $user) {
            array_push($data, [
                'customer_id' => $user,
                'title' => $sendData['title'],
                'message' => $sendData['message'],
                'is_viewed' => false,
                'image' => $sendData['image'],
                'created_at' => now()
            ]);

            Notification::insert($data);
        }

        $FcmTokens = Customer::whereIn('id', $users)->where('notification1', true)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        if (count($FcmTokens)) {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://exp.host/--/api/v2/push/send', [
                'to' => $FcmTokens,
                'title' => $sendData['title'],
                'body' => $sendData['message'],
                "data" =>  ["action" => "notification"]
            ]);
        }
    }
}
