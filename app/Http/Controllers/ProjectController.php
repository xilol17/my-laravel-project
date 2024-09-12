<?php

namespace App\Http\Controllers;

use App\Exports\ProjectExport;
use App\Models\Attachment;
use App\Models\project;
use App\Models\Sales;
use App\Models\UpdateHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Models\ProjectView;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;


class ProjectController extends Controller
{

    public function dashboard(){
        if (!Auth::check()) {
            session()->flash('alert', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }
        // Check if the current user can access admin pages
        if (Auth::user()->sales) {
            abort(403, 'Unauthorized action.');
        }
        //Recent View
        $recentViews = ProjectView::orderBy('viewed_at', 'desc')
            ->limit(6)
            ->get();

        //Recent Uptdate
        $recentupdatedProjects = Project::whereNotNull('lastUpdateDate')
            ->orderBy('lastUpdateDate', 'desc')
            ->take(6)
            ->get();

        $UpdatedprojectsTime = $recentupdatedProjects->map(function ($project) {
            // Calculate hours ago based on 'lastUpdateDate'
            $updatedAt = Carbon::parse($project->lastUpdateDate);
            $minutesAgo = $updatedAt->diffInMinutes(Carbon::now());
            $hoursAgo = $minutesAgo / 60; // Decimal value for hours

            // Add 'hoursAgo' attribute to each project
            $project->hoursAgo = $hoursAgo;
            return $project;
        });
        //New Project
        $Newprojects = Project::latest()->take(6)->get();

        $NewprojectsTime = $Newprojects->map(function ($project) {
            $createdAt = Carbon::parse($project->created_at);
            $minutesAgo = $createdAt->diffInMinutes(Carbon::now());
            $hoursAgo = $minutesAgo / 60; // Decimal value for hours

            // Add 'hoursAgo' attribute to each project
            $project->hoursAgo = $hoursAgo;
            return $project;
        });

        return view('dashboard', [
            'NewprojectsTime' => $NewprojectsTime,
            'UpdatedprojectsTime' => $UpdatedprojectsTime,
            'recentViews' => $recentViews,
        ]);
    }

    public function index(Request $request){

        if (!Auth::check()) {
            session()->flash('alert', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }
        // Check if the current user can access admin pages
        if (Auth::user()->admin) {
            abort(403, 'Unauthorized action.');
        }
        //Lastest Projects
        $latestProjects = Project::where('sales_id', Auth::user()->sales->id) // Filter by user ID
        ->orderBy('created_at', 'desc') // Order by lastUpdateDate in descending order
        ->take(6) // Limit to 6 projects
        ->get();

        //Recent Uptdate
        $recentUpdatedProjects = Project::where('sales_id', Auth::user()->sales->id) // Filter by user ID
        ->whereNotNull('lastUpdateDate') // Ensure lastUpdateDate is not null
        ->orderBy('lastUpdateDate', 'desc') // Order by lastUpdateDate in descending order
        ->take(6) // Limit to 6 projects
        ->get();

        $UpdatedprojectsTime = $recentUpdatedProjects->map(function ($project) {
            // Calculate hours ago based on 'lastUpdateDate'
            $updatedAt = Carbon::parse($project->lastUpdateDate);
            $minutesAgo = $updatedAt->diffInMinutes(Carbon::now());
            $hoursAgo = $minutesAgo / 60; // Decimal value for hours

            // Add 'hoursAgo' attribute to each project
            $project->hoursAgo = $hoursAgo;
            return $project;
        });
        //New Project
        $Newprojects = Project::latest()->take(6)->get();

        $NewprojectsTime = $Newprojects->map(function ($project) {
            $createdAt = Carbon::parse($project->created_at);
            $minutesAgo = $createdAt->diffInMinutes(Carbon::now());
            $hoursAgo = $minutesAgo / 60; // Decimal value for hours

            // Add 'hoursAgo' attribute to each project
            $project->hoursAgo = $hoursAgo;
            return $project;
        });

        $query = Project::query();

        // Apply search filter if the search query exists
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('Region', 'like', "%{$search}%")
                    ->orWhere('salesName', 'like', "%{$search}%")
                    ->orWhere('customerName', 'like', "%{$search}%")
                    ->orWhere('visitDate', 'like', "%{$search}%")
                    ->orWhere('startDate', 'like', "%{$search}%");
            });
        }

        // Filter projects by the logged-in user's ID
        $query->where('sales_id', Auth::user()->sales->id);

        // Apply sorting if provided
        if ($request->has('sort_field') && $request->has('sort_order')) {
            if ($request->sort_field == 'winRate') {
                $query->orderByRaw('CAST(winRate AS UNSIGNED) ' . $request->sort_order);
            } else {
                $query->orderBy($request->sort_field, $request->sort_order);
            }
        } else {
            $query->orderBy('name', 'asc'); // Default sort
        }

        // Paginate the results
        $projects = $query->paginate(10)->appends([
            'search' => $request->input('search'),
            'sort_field' => $request->input('sort_field'),
            'sort_order' => $request->input('sort_order'),
        ]);

        return view('index', [
            'NewprojectsTime' => $NewprojectsTime,
            'UpdatedprojectsTime' => $UpdatedprojectsTime,
            'latestProjects' => $latestProjects,
            'projects' => $projects,
        ]);
    }

    public function show(Project $project)
    {
        if (!Auth::check()) {
            session()->flash('alert', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }

        // Make sure to load the attachments relationship
        $project->load('attachments');

        // Calculate the number of days ago
        if (empty($project->lastUpdateDate)) {
            $hoursAgo = 'Not update yet.';
        } else {
            $createdAt = Carbon::parse($project->lastUpdateDate);
            $minutesAgo = $createdAt->diffInMinutes(Carbon::now());
            $hoursAgo = $minutesAgo / 60; // This will give a decimal value for less than an hour
        }

        if(Auth::user()->admin){
            // Check if a view record for this project and user already exists
            $view = ProjectView::where('project_id', $project->id)
                ->where('user_id', auth()->id()) // Assuming user authentication is in place
                ->first();

            if ($view) {
                // Update the `viewed_at` timestamp
                $view->update(['viewed_at' => now()]);
            } else {
                // Create a new view record
                ProjectView::create([
                    'project_id' => $project->id,
                    'user_id' => auth()->id(), // Assuming user authentication is in place
                    'viewed_at' => now()
                ]);
            }
        }


        $updateHistories = $project->updateHistories()->get();
        return view('project', [
            'project' => $project,
            'hoursAgo' => $hoursAgo,
            'updateHistories' => $updateHistories,
        ]);
//        $job = Job::find($jobId);
//        $updateHistory = $job->updateHistories()->with('user')->get();
//
//        return view('job.show', compact('job', 'updateHistory'));
    }

    public function list(Request $request){
        if (!Auth::check()) {
            session()->flash('alert', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }

        $query = Project::query();

        // Apply search filter if the search query exists
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('Region', 'like', "%{$search}%")
                    ->orWhere('salesName', 'like', "%{$search}%")
                    ->orWhere('customerName', 'like', "%{$search}%")
                    ->orWhere('visitDate', 'like', "%{$search}%")
                    ->orWhere('startDate', 'like', "%{$search}%");
            });
        }

        // Apply Region filter
        if ($request->has('region') && $request->region != '') {
            $query->where('Region', $request->region);
        }

        // Apply Sales Name filter
        if ($request->has('sales_name') && $request->sales_name != '') {
            $query->where('salesName', $request->sales_name);
        }

        // Apply Win Rate filter
        if ($request->has('win_rate') && $request->win_rate != '') {
            $query->where('winRate', $request->win_rate);
        }

        // Apply sorting if provided
        if ($request->has('sort_field') && $request->has('sort_order')) {
            if ($request->sort_field == 'winRate') {
                $query->orderByRaw('CAST(winRate AS UNSIGNED) ' . $request->sort_order);
            } else {
                $query->orderBy($request->sort_field, $request->sort_order);
            }
        } else {
            $query->orderBy('name', 'asc'); // Default sort
        }

        // Paginate the results
        $projects = $query->paginate(10 )->appends([
            'search' => $request->input('search'),
            'sort_field' => $request->input('sort_field'),
            'sort_order' => $request->input('sort_order'),
            'region' => $request->input('region'),
            'sales_name' => $request->input('sales_name'),
            'win_rate' => $request->input('win_rate')
        ]);
        $uniqueSalesNames = $projects->pluck('salesName')->unique(); // Extract unique sales names

        return view('project-list', [
            'projects' => $projects,
            'uniqueSalesNames' => $uniqueSalesNames
        ]);
    }



    public function store()
    {
        // Validate the request data
        $validatedData = request()->validate([
            'projectName' => 'required|string',
            'dateVi' => 'nullable|date',
            'dateDi' => 'nullable|date',
            'turnKey' => 'required|string',
            'BDM/PM' => 'required|string',
            'region' => 'required|string',
            'customerName' => 'required|string',
            'products' => 'nullable|array',
            'products.*' => 'nullable|string', // Validate each product
            'revenue' => 'required',
            'SI' => 'required|string',
            'SIname' => 'nullable|string',
            'other_product' => 'nullable|string', // Validate 'other_product'
            'dateViSelect' => 'nullable|string',
            'dateDisSelect' => 'nullable|string',
        ]);

        $projectData = [
            'sales_id' => Auth::user()->sales->id,
            'name' => $validatedData['projectName'],
            'visitDate' => $validatedData['dateVi'],
            'disStartDate' => $validatedData['dateDi'],
            'turnKey' => $validatedData['turnKey'],
            'BDMPM' => $validatedData['BDM/PM'],
            'region' => $validatedData['region'],
            'customerName' => $validatedData['customerName'],
            'salesName' => Auth::user()->sales->name,
            'products' => $validatedData['products'] ? json_encode($validatedData['products']) : null,
            'revenue' => $validatedData['revenue'],
            'SI' => $validatedData['SI'],
            'SIname' => $validatedData['SIname'],
        ];

        // Handle the conditional fields
        if ($validatedData['dateViSelect'] === 'no') {
            $projectData['visitDate'] = null;
        }
        if ($validatedData['dateDisSelect'] === 'no') {
            $projectData['disStartDate'] = null;
        }
        $productsArray = $validatedData['products'] ?? [];

        if (in_array('Other', $productsArray) && !empty($validatedData['other_product'])) {
            $productsArray[] = $validatedData['other_product'];
        }

        // Update products
        $projectData['products'] = json_encode($productsArray);

        // Create the project
        $project = Project::create($projectData);

        // Flash a success message to the session
        session()->flash('success', 'Project created successfully!');

        return redirect('/project/' . $project->id);
    }
    public function update(project $project){
        // Validate incoming request data
        $validatedData = request()->validate([
            'revenue' => ['sometimes', 'required', 'numeric'],
            'winRate' => ['sometimes', 'required', 'integer'],
            'SO' => request('winRate') == 100 ? ['required', 'string'] : ['nullable', 'string'], // Conditionally required
            'visitDate' => ['sometimes', 'required', 'date'],
            'disStartDate' => ['sometimes', 'required', 'date'],
            'turnKey' => ['sometimes', 'required', 'string'],
            'status' => ['sometimes', 'required', 'string'],
            'BDMPM' => ['sometimes', 'required', 'string'],
            'region' => ['sometimes', 'required', 'string'],
            'customerName' => ['sometimes', 'required', 'string'],
            'products' => ['sometimes', 'array'], // Validate as array if present
            'SI' => ['sometimes', 'required', 'string'],
            'SIname' => ['sometimes', 'nullable', 'string'],
            'other_product' => ['sometimes', 'nullable', 'string'], // Other product validation
        ]);

        // Check if products exist in the request
        if (request()->has('products')) {
            // Get the products array from the request or set it as an empty array
            $productsArray = $validatedData['products'] ?? [];

            // Handle "Other" product inclusion
            if (in_array('Other', $productsArray) && !empty($validatedData['other_product'])) {
                $productsArray[] = $validatedData['other_product'];
            }

            // Update products in the database
            $project->update(['products' => json_encode($productsArray)]);

        }
        if (request('SI') == 'NO') {
            $validatedData['SIname'] = ''; // Clear SIname if SI is NO
        }

        // Update other fields
        foreach ($validatedData as $field => $value) {
            if ($field !== 'products') {
                $project->$field = $value;
            }
        }
        $project->lastUpdateDate = now();
        $project->save();

        // Success message handling
        session()->flash('success', 'Project updated successfully.');

        // Redirect back to the project page after the update
        return redirect('/project/' . $project->id);
    }

    public function storeAttachments(Request $request, Project $project)
    {
        $request->validate([
            'attachments.*' => 'required|file|max:5120',
        ]);

        foreach ($request->file('attachments') as $file) {
            $originalName = $file->getClientOriginalName();
            $uniqueName = time() . '-' . $originalName;
            $path = $file->storeAs('attachments', $uniqueName, 'public');

            $project->attachments()->create([
                'path' => $path,
                'original_name' => $originalName,
            ]);

            // Log the file upload in job_update_histories
            \App\Models\UpdateHistory::create([
                'project_id' => $project->id,
                'user_id' => Auth::id(),
                'update_type' => 'file_upload',
                'title' => 'Upload Attachment',
                'file_name' => $originalName,
                'updated_at' => now(),
            ]);
        }
        $project->lastUpdateDate = now();
        $project->save();

        session()->flash('success', 'Attachments uploaded successfully.');
        return redirect()->back();
    }




    public function deleteAttachment(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            session()->flash('error', 'Project not found.');
            return redirect()->back();
        }


        $attachmentPath = $request->input('attachment_path');
        $attachment = $project->attachments()->where('path', $attachmentPath)->first();

        if ($attachment) {
            // Get the original name of the attachment
            $originalName = $attachment->original_name;

            // Delete the attachment file from storage
            Storage::disk('public')->delete($attachmentPath);

            // Delete the record from the database
            $attachment->delete();

            // Log the attachment deletion in job_update_histories
            \App\Models\UpdateHistory::create([
                'project_id' => $project->id,
                'user_id' => Auth::id(),
                'update_type' => 'file_deletion',
                'title' => 'Delete File Attachment',
                'file_name' => $originalName, // Store the original name
                'updated_at' => now(),
            ]);
        }

        $project->lastUpdateDate = now();
        $project->save();
        session()->flash('success', 'Attachment deleted successfully.');
        return redirect()->back();
    }



    public function storeRemarks(Request $request, Project $project)
    {
        $request->validate([
            'remark' => ['required']
        ]);

        $remark = $request->input('remark');
        $project->remarks()->create(['remark' => $remark]);

        // Log the remark addition in job_update_histories
        \App\Models\UpdateHistory::create([
            'project_id' => $project->id,
            'user_id' => Auth::id(),
            'update_type' => 'remark',
            'title' => 'Add Remark',
            'remark' => $remark,
            'updated_at' => now(),
        ]);

        $project->lastUpdateDate = now();
        $project->save();
        session()->flash('success', 'Remark add successfully.');
        return redirect()->back();
    }

    public function export(Request $request)
    {
        // Start building the query
        $query = Project::query();

        // Apply filters
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('Region', 'like', "%{$search}%")
                    ->orWhere('salesName', 'like', "%{$search}%")
                    ->orWhere('customerName', 'like', "%{$search}%")
                    ->orWhere('visitDate', 'like', "%{$search}%")
                    ->orWhere('startDate', 'like', "%{$search}%");
            });
        }

        if ($request->has('region') && $request->region != '') {
            $query->where('Region', $request->region);
        }

        if ($request->has('sales_name') && $request->sales_name != '') {
            $query->where('salesName', $request->sales_name);
        }

        if ($request->has('win_rate') && $request->win_rate != '') {
            $query->where('winRate', $request->win_rate);
        }

        // Fetch all the matching projects
        $projects = $query->get();

        // Pass the complete collection to the export
        return Excel::download(new ProjectExport($projects), 'projects.xlsx');
    }





}
