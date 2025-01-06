<?php

namespace App\Http\Controllers;

use App\Models\Fabircator;
use App\Models\RegisteredFabricator;
use App\Models\User;
use Illuminate\Http\Request;

class FabircatorController extends Controller
{



    public function index(Request $request)
    {
        if ($request->ajax()) $this->getFabricator($request);
        return view('console.fabricator.index');
    }



    public function show(Fabircator $fabricator)
    {
        $fabricator = Fabircator::where('fabircators.id', $fabricator->id)->join('customers', 'customers.id', 'fabircators.customer_id')
            ->select(
                'fabircators.id',
                'customers.id as user_id',
                'name',
                'customers.email',
                'customers.phone',
                'fab_id',
                'approval_status',
                'company_name',
                'fabircators.phone as fabircator_phone',
                'fabircators.email as fabircator_email',
                'gst',
                'pan',
                'aadhaar',
                'business_agreement',
                'photo',
                'reason',
                'attempt',
                'applied_at'
            )->first();


        if ($fabricator->approval_status == 'PENDING') {
            $statuses = ['APPROVED', 'BLOCKED', 'REJECTED'];
        } else if ($fabricator->approval_status == 'APPROVED') {
            $statuses = ['BLOCKED'];
        } else if ($fabricator->approval_status == 'REJECTED') {
            $statuses = ['BLOCKED', 'APPROVED'];
        } else if ($fabricator->approval_status == 'BLOCKED') {
            $statuses = ['APPROVED', 'REJECTED'];
        }

        return view('console.fabricator.show', ['fabricator' => $fabricator, 'statuses' => $statuses]);
    }



    public function update(Request $request, Fabircator $fabricator)
    {
        $validated = $request->validate([
            'approval_status' => 'required',
        ]);

        if ($validated['approval_status'] == 'REJECTED') {
            $validated = $request->validate([
                'approval_status' => 'required',
                'reason' => 'required|required|max:1000',
            ]);
        }
        if ($validated['approval_status'] == 'APPROVED') {
            $x = Fabircator::whereNotNull('fab_id')->count();
            $z = $x + 1;
            if (strlen($z) == 1) {
                $z = '00' . $z;
            } else if (strlen($z) == 2) {
                $z = '0' . $z;
            }
            $validated['fab_id'] = 'FAB-' . $z;
        }
        $updated = $fabricator->update($validated);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fabircator $fabircator)
    {
        if ($fabircator->delete()) {
            return response()->json(['message' => 'Fabricator ' . $fabircator->company_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Fabricator ' . $fabircator->company_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getFabricator($request)
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
        $totalRecords = Fabircator::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Fabircator::select('count(*) as allcount')
            ->where('company_name', 'like', '%' . $searchValue . '%')
            ->orWhere('phone', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Fabircator::where('company_name', 'like', '%' . $searchValue . '%')
            ->orWhere('phone', 'like', '%' . $searchValue . '%')
            ->select('fabircators.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;
            $company_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->company_name . '</span>
                        </span>
                    </div>';

            $phone = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->phone . '</span>
                        </span>
                    </div>';

            $email = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->email . '</span>
                        </span>
                    </div>';

            // $gst = '<div class="d-flex align-items-center gap-3">
            //             <span class="d-flex flex-column text-muted">
            //                 <span class="text-gray-800 text-hover-primary fw-bold">' . $record->gst . '</span>
            //             </span>
            //         </div>';

            // $pan = '<div class="d-flex align-items-center gap-3">
            //             <span class="d-flex flex-column text-muted">
            //                 <span class="text-gray-800 text-hover-primary fw-bold">' . $record->pan . '</span>
            //             </span>
            //         </div>';

            // $aadhaar = '<div class="d-flex align-items-center gap-3">
            //         <span class="d-flex flex-column text-muted">
            //             <span class="text-gray-800 text-hover-primary fw-bold">' . $record->aadhaar . '</span>
            //         </span>
            //     </div>';

            // $business_agreement = '<div class="d-flex align-items-center gap-3">
            //             <span class="d-flex flex-column text-muted">
            //                 <span class="text-gray-800 text-hover-primary fw-bold">' . $record->business_agreement . '</span>
            //             </span>
            //         </div>';

            if ($record->approval_status == "PENDING") {
                $approval_status = "<span class='badge badge-primary'>Pending</span>";
            } elseif ($record->approval_status == "APPROVED") {
                $approval_status = "<span class='badge badge-success'>Approved</span>";
            } elseif ($record->approval_status == "BLOCKED") {
                $approval_status = "<span class='badge badge-warning'>Blocked</span>";
            } else $approval_status = "<span class='badge badge-danger'>Rejected</span>";

            $data_arr[] = array(
                "id" => $id,
                "company_name" => $company_name,
                "phone" => $phone,
                "email" => $email,
                "approval_status" => $approval_status,
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
}
