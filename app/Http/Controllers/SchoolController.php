<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\School;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FileController $fileController): View
        {
            $schools = School::with('files')->get()->map(function ($school) {
                return [
                    'id' => $school->id,
                    'image' => $school->files->path ?? '',
                    'is_featured' => $school->is_featured ?? '',
                    'name' => $school->description ?? '',
                ];
            });

            return view('admin.schools.index', [
                'schools' => $schools,
            ]);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        @dd('test');
        return view('admin.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FileController $fileController)
    {
        try {

            DB::beginTransaction();

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'is_featured' => 'nullable',
                'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB limit
            ]);            
    
            //pass the image of the logo
            // Check if a file is uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                //$imagePath = $image->store('image', 'public'); // Store in storage/app/public/profile_images
                //$image = asset('storage/' . $imagePath); // Convert to accessible URL
            }
    
            //send the image link to the controller
            $file_records = $fileController->store($request);
    
            $file_id = $file_records->original['file']->id;
            $file_description = $file_records->original['file']->description;
            $file_description = $file_records->original['file']->type;
    
            $school_record = School::create([
                'description' => $request->name,
                'image' => $file_id,
                'is_featured' => $request->is_featured ?? 'off',
                'file_id' => $file_id,
            ]);

            DB::commit();
            
            return redirect()->route('admin.schools')->with('success', 'School added successfully!');
        }
        catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with('invalid', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

public function show($id): View
{
    $school = School::find($id);

    if (!$school) {
        abort(404, 'School not found');
    }

    $file = File::where('id', $school->file_id)->first();

    $schoolData = [
        'id' => $school->id,
        'image' => $file->path ?? '',
        'is_featured' => $school->is_featured ?? '',
        'name' => $school->description ?? '',
    ];

    return view('admin.schools.show', [
        'school' => $schoolData,
    ]);
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, FileController $fileController)
{
    try {
        
        DB::beginTransaction();
        
        // Validate input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_featured' => 'nullable',
            'file' => 'nullable|image|max:5120',
        ]);
    
        // Retrieve the school model properly
        $school = School::with('files')->find($id);

        if (!$school) {
            return back()->with('invalid', 'The input is invalid. Please try again!');
        }

        
        
        // Handle file upload if present
        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Use ->file() instead of array access
            
            $file_path = File::where('id', $school->file_id)->first();
            
            // Check if school has an existing file and update accordingly
            $fileFormat = $school->file_id === null
            ? $fileController->store($request)
            : $fileController->edit($request, $file_path->description);
            
                // Extract the image URL safely
                //$image_url = $fileFormat->original['data']['preview_url'] ?? null;
                
            $file = File::where('id', $school->file_id)->first();

            $file->update([
                'description' => $fileFormat->original['data']['id'],
                'path' => $fileFormat->original['data']['preview_url'],
            ]);
        }
        
        $school->update([
            'description' => $request['name'],
            'is_featured' => $request['is_featured'],
        ]);

        DB::commit();

        return redirect()->route('admin.schools')->with('update', 'Updated Successfully! If you uploaded an image, the Admin will review it first.');

    } catch (\Exception $ex) {
        @dd($ex->getMessage());
        DB::rollBack();
        return back()->with('invalid', $ex->getMessage());
    }
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
