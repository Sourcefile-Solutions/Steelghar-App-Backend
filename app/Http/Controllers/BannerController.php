<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{



    public function index(Request $request)
    {
        if ($request->ajax()) $this->getBanners($request);
        return view('console.banner.index');
    }


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
            'banner_name' => 'required|max:20|unique:banners',
            'status' => 'nullable|boolean',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'mobile_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        if ($request->banner_image) {
            $validated['banner_image'] = $request->file('banner_image')->storeAs('banners',  $validated['banner_name'] . '-' . str_replace(".", "", microtime(true)) . '.' . $request->file('banner_image')->getClientOriginalExtension());
        } else $validated['banner_image'] = '';

        if ($request->mobile_banner) {
            $validated['mobile_banner'] = $request->file('mobile_banner')->storeAs('banners',  $validated['banner_name'] . '-mobile_banner-' . str_replace(".", "", microtime(true)) . '.' . $request->file('mobile_banner')->getClientOriginalExtension());
        } else $validated['mobile_banner'] = '';

        $created = Banner::create($validated);
        if ($created) return response()->json(['message' => 'Banner ' . $request->banner_name . ' added successfully!', 'status' => 'success', 'title' => 'Added!'], 201);

        return response()->json(['message' => 'Failed to add Banner ' . $request->banner_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return response()->json(['message' => 'success', 'banner' => $banner], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'banner_name' => 'nullable|max:20|unique:banners,banner_name,' . $banner->id,
            'status' => 'nullable|boolean',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'mobile_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        if ($request->banner_image) {
            Storage::delete($banner->banner_image);
            $validated['banner_image'] = $request->file('banner_image')->storeAs('banners', $validated['banner_name'] . '.' . $request->file('banner_image')->getClientOriginalExtension());
        } else $validated['banner_image'] = $banner->banner_image;
        if ($request->mobile_banner) {
            Storage::delete($banner->mobile_banner);
            $validated['mobile_banner'] = $request->file('mobile_banner')->storeAs('banners', $validated['banner_name'] . '-mobile_banner-' . str_replace(".", "", microtime(true)) . '.' . $request->file('mobile_banner')->getClientOriginalExtension());
        } else $validated['mobile_banner'] = $banner->mobile_banner;
        $updated = $banner->update($validated);
        if ($updated) {
            return response()->json(['message' => 'Banner ' . $banner->banner_name . ' updated successfully!', 'status' => 'success', 'title' => 'Updated!'], 201);
        }
        return response()->json(['message' => 'Failed to update Banner ' . $banner->banner_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->delete()) {
            Storage::delete([$banner->banner_image, $banner->mobile_banner]);
            return response()->json(['message' => 'Banner ' . $banner->banner_name . ' deleted successfully!', 'status' => 'success', 'title' => 'Deleted!'], 200);
        }
        return response()->json(['message' => 'Failed to delete Banner ' . $banner->banner_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getBanners($request)
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
        $totalRecords = Banner::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Banner::select('count(*) as allcount')
            ->where('banner_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Banner::where('banner_name', 'like', '%' . $searchValue . '%')
            ->select('banners.*')
            ->orderBy($columnName, $columnSortOrder)    
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $banner_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->banner_name . '</span>
                        </span>
                    </div>';

            $banner_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->banner_image") . '" />
                        </span>
                    </div>';


            $mobile_banner = '<div class="d-flex align-items-center gap-3">
                    <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                        <img src="' . asset("/storage/$record->mobile_banner") . '" />
                    </span>
                </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "banner_name" => $banner_name,
                "banner_image" => $banner_image,
                "mobile_banner" => $mobile_banner,
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
