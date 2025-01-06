<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PushNotification;
use App\Traits\AppTrait;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    use AppTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getNotifications($request);
        return view('console.push-notification.index');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_type' => 'required|string',
            'title' => 'required|string|max:40',
            'message' => 'required|string|max:500'
        ]);

        if ($validated['user_type'] == 'ALL' || $validated['user_type'] == 'CUSTOMERS') {
            $users = Customer::pluck('id')->toArray();
        } else {
            $users = Customer::join('fabircators', 'fabircators.customer_id', 'customers.id')->where('approval_status', 'APPROVED')->pluck('customers.id')->toArray();
        }
        if (!count($users)) return redirect()->back();

        $validated['count'] = count($users);
        PushNotification::create($validated);
        $data = [
            'title' => $validated['title'],
            'message' => $validated['message'],
            'image' => ''
        ];

        $this->sendNotifications($users, $data);

        return redirect()->back();
    }


    protected function getNotifications($request)
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
        $totalRecords = Pushnotification::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Pushnotification::select('count(*) as allcount')
            ->where('title', 'like', '%' . $searchValue . '%')
            ->count();
        $records = Pushnotification::where('title', 'like', '%' . $searchValue . '%')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;



            $data_arr[] = array(
                "id" => $id,
                "count" => $record->count,
                "title" => $record->title,
                "message" => $record->message,
                "created_at" => $record->created_at->format('d M Y, H:i:s'),
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
