<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{

    public function getAlert()
    {
        $alerts = Alert::where('status', false)->latest()->get();
        $notifications = '';
        if (count($alerts)) {
            foreach ($alerts as $alert) {
                $notifications .= '<div class="mb-5"><div class=""><div class="p-3 rounded bg-light-info text-dark fw-semibold text-start" data-kt-element="message-text"><div class="d-flex flex-stack flex-wrap"><span class="badge badge-light-info fw-bold my-2">' . $alert->title . '</span><div class="d-flex align-items-center pe-2"><div class="fs-8 fw-bold"><span class="text-muted">' . $alert->created_at->diffForHumans() . '</span></div></div></div>' . $alert->message . '</div></div></div>';
                $alert->status = true;
                $alert->save();
            }
        } else $notifications = '<div class="alert alert-danger d-flex align-items-center p-5"><i class="bi bi-info fs-2hx text-danger me-4"></i><div class="d-flex flex-column"><h4 class="mb-1 text-danger">No Notification Found!</h4></div></div>';
        return response()->json(['status' => 'success', 'notifications' => $notifications]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifications = Alert::latest()->paginate(15);
            foreach ($notifications as $no) {
                $no->date = $no->created_at->format('d M Y H:i:s');
            }
            return response()->json(['notifications' => $notifications, 'status' => 'success'], 200);
        }
        return view('alert.index');
    }
}
