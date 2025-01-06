<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->id != 1) {
                return abort(404);
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getRoles($request);
        return view('roles.index');
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
        $validated = $request->validate([
            'value' => 'required|string|max:25|unique:roles',
            'user_type' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        $create = Role::create($validated);

        if ($create) return response()->json(['message' => 'Role ' . $request->value . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add role ' . $request->value, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return response()->json(['message' => 'success', 'role' => $role], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:25|unique:roles,user_type,' . $role->id,
            'user_type' => 'required|boolean',
            'status' => 'required|boolean',
        ]);


        $updated = $role->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Role ' . $role->value . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update role ' . $role->value, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return response()->json(['message' => 'Role ' . $role->value . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete role ' . $role->value, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getRoles($request)
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
        $totalRecords = Role::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')
            ->where('value', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Role::where('value', 'like', '%' . $searchValue . '%')
            ->select('roles.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $record->user_type ? $user_type = "<span class='badge badge-warning'>State</span>" : $user_type = "<span class='badge badge-primary'>User_type</span>";

            $value = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->value . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "user_type" => $user_type,
                "value" => $value,
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
}
