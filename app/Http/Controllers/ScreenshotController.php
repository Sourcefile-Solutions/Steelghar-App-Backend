<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScreenshotController extends Controller
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
        if ($request->ajax()) $this->getScreenshots($request);
        return view('screenshots.index');
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
            'screenshot_name' => 'required|string|max:25|unique:screenshots',
            'screenshot_image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'status' => 'required|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['screenshot_name'], '-');
        if ($request->screenshot_image) {
            $validated['screenshot_image'] = $request->file('screenshot_image')->storeAs('screenshots', $validated['slug'] . '.' . $request->file('screenshot_image')->getClientOriginalExtension());
        } else $validated['screenshot_image'] = 'screenshots/screenshot.png';

        $create = Screenshot::create($validated);

        if ($create) return response()->json(['message' => 'Screenshot ' . $request->screenshot_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add screenshot ' . $request->screenshot_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Screenshot $screenshot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screenshot $screenshot)
    {
        return response()->json(['message' => 'success', 'screenshot' => $screenshot], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Screenshot $screenshot)
    {
        $validated = $request->validate([
            'screenshot_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'screenshot_name' => 'required|string|max:25|unique:screenshots,screenshot_name,' . $screenshot->id,
            'status' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['screenshot_name'], '-');
        if ($request->screenshot_image) {
            Storage::delete($screenshot->screenshot_image);
            $validated['screenshot_image'] = $request->file('screenshot_image')->storeAs('screenshots', $validated['slug'] . '.' . $request->file('screenshot_image')->getClientOriginalExtension());
        } else $validated['screenshot_image'] = $screenshot->screenshot_image;

        $updated = $screenshot->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Screenshot ' . $screenshot->screenshot_name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update screenshot ' . $screenshot->screenshot_name, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screenshot $screenshot)
    {
        if ($screenshot->delete()) {
            return response()->json(['message' => 'Screenshot ' . $screenshot->screenshot_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete screenshot ' . $screenshot->screenshot_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getScreenshots($request)
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
        $totalRecords = Screenshot::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Screenshot::select('count(*) as allcount')
            ->where('screenshot_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Screenshot::where('screenshot_name', 'like', '%' . $searchValue . '%')
            ->select('screenshots.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $screenshot_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->screenshot_image") . '" />
                        </span>
                    </div>';

            $screenshot_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->screenshot_name . '</span>
                        </span>
                    </div>';

            $review = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->review . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "screenshot_image" => $screenshot_image,
                "screenshot_name" => $screenshot_name,
                "review" => $review,
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
