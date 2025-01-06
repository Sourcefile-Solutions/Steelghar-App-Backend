<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) $this->getTestimonial($request);
        return view('console.testimonial.index');
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:testimonials',
            'status' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'testimonial' => 'required|string',
        ]);

        if ($request->image) {
            $validated['image'] = $request->file('image')->storeAs('testimonials',  $validated['name'] . '-' . str_replace(".", "", microtime(true)) . '.' . $request->file('image')->getClientOriginalExtension());
        } else $validated['image'] = '';

        $created = Testimonial::create($validated);
        if ($created) return response()->json(['message' => 'Testimonial ' . $request->name . ' added successfully!', 'status' => 'success', 'title' => 'Added!'], 201);

        return response()->json(['message' => 'Failed to add testimonial ' . $request->name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }


    public function edit(Testimonial $testimonial)
    {
        return response()->json(['message' => 'success', 'testimonial' => $testimonial], 200);
    }


    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:testimonials,name,' . $testimonial->id,
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'testimonial' => 'required|string',
        ]);

        if ($request->image) {
            Storage::delete($testimonial->image);
            $validated['image'] = $request->file('image')->storeAs('testimonials', $validated['name'] . '.' . $request->file('image')->getClientOriginalExtension());
        } else $validated['image'] = $testimonial->image;

        $updated = $testimonial->update($validated);
        if ($updated) {
            return response()->json(['message' => 'Testimonial ' . $testimonial->name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update testimonial ' . $testimonial->name, 'title' => 'Failed', 'status' => 'error'], 200);
    }


    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->delete()) {
            Storage::delete($testimonial->image);
            return response()->json(['message' => 'Testimonial ' . $testimonial->name . ' deleted successfully!', 'status' => 'success', 'title' => 'Deleted!'], 200);
        }
        return response()->json(['message' => 'Failed to delete Testimonial ' . $testimonial->name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getTestimonial($request)
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
        $totalRecords = Testimonial::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Testimonial::select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Testimonial::where('name', 'like', '%' . $searchValue . '%')
            ->select('testimonials.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->name . '</span>
                        </span>
                    </div>';

            $image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->image") . '" />
                        </span>
                    </div>';

            $testimonial = '<div class="d-flex align-items-center gap-3">
                    <span class="d-flex flex-column text-muted">
                        <span class="text-gray-800 text-hover-primary fw-bold">' . $record->testimonial . '</span>
                    </span>
                </div>';



            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "image" => $image,
                "testimonial" => $testimonial,
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
