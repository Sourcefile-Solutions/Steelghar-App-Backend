<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
        if ($request->ajax()) $this->getPermissions($request);
        $roles = Role::where('status', 1)->get();
        return view('permissions.index', ['roles' => $roles]);
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
            'permission' => 'required',
            'user_type_id' => 'required|unique:permissions',
            'status' => 'required|boolean',
        ]);

        $permissions = $validated['permission'];
        $validated['permission'] = implode(',', $permissions);

        $create = Permission::create($validated);

        if ($create) return response()->json(['message' => 'Permission for ' . $request->user_type_id . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add permission for ' . $request->user_type_id, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return response()->json(['message' => 'success', 'permission' => $permission], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'permission' => 'required',
            'user_type_id' => 'required|unique:permissions,user_type_id,' . $permission->id,
            'status' => 'required|boolean',
        ]);

        $permissions = $validated['permission'];
        $validated['permission'] = implode(',', $permissions);

        $updated = $permission->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Permission for ' . $permission->user_type_id . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update permission for ' . $permission->user_type_id, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        if ($permission->delete()) {
            return response()->json(['message' => 'Permission for ' . $permission->user_type_id . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete permission for ' . $permission->user_type_id, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getPermissions($request)
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
        $totalRecords = Permission::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Permission::select('count(*) as allcount')
            ->join('roles', 'roles.id', 'permissions.user_type_id')
            ->where('value', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Permission::join('roles', 'roles.id', 'permissions.user_type_id')
            ->where('value', 'like', '%' . $searchValue . '%')
            ->select('permissions.*', 'value')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $permission = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->permission . '</span>
                        </span>
                    </div>';

            $user_type = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->value . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "permission" => $permission,
                "user_type" => $user_type,
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
