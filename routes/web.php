<?php

use App\Exports\ProjectExport;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SessionController;
use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

//Route::get('/test', function (Request $request) {
//    $query = Project::query();
//
//    // Apply search filter if the search query exists
//    if ($request->has('search')) {
//        $search = $request->input('search');
//        $query->where(function ($q) use ($search) {
//            $q->where('name', 'like', "%{$search}%")
//                ->orWhere('Region', 'like', "%{$search}%")
//                ->orWhere('salesName', 'like', "%{$search}%")
//                ->orWhere('customerName', 'like', "%{$search}%")
//                ->orWhere('visitDate', 'like', "%{$search}%")
//                ->orWhere('startDate', 'like', "%{$search}%");
//        });
//    }
//
//    // Paginate the results
//    $projects = $query->paginate(3)->appends(['search' => $request->input('search')]);
//
//    return view('table', ['projects' => $projects]);
//});


//$jobs = Job::with('employer')->latest()->paginate(3);
//
//return view('jobs/index', ['jobs' => $jobs]);//close return



Route::controller(ProjectController::class,'fetchProjects')->group(function () {
    Route::get('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
    Route::get('/my-project', 'index')->middleware('auth')->name('index');
    Route::get('/projects-list', 'list')->name('projects.index');

    Route::get('/project/{project}', 'show')->name('project.show');
    Route::post('/projects', 'store');
    Route::patch('/project/{project}', 'update')->name('project.update')->middleware('auth')->can('edit','project');
    Route::post('/project/{project}/attachments', 'storeAttachments')->middleware('auth')->can('edit','project');
    Route::delete('/project/{project}/delete-attachment','deleteAttachment')->middleware('auth');
    Route::post('/project/{project}/remarks', 'storeRemarks')->middleware('auth')->can('edit','project');
    //exports
    Route::get('projects/export','export')->name('projects.export');
});
Route::get('export-projects', function () {
    return Excel::download(new ProjectExport, 'projects.xlsx');
});

Route::controller(SalesController::class)->group(function () {
    Route::get('/sales-list', 'sales_list')->name('sales_list');

    Route::post('/addsales', 'store')->name('sales.store');
    Route::delete('/sales/{id}', 'destroy')->name('sales.destroy');

});


Route::get('/login',[SessionController::class, 'create'])->name('login');
Route::post('/login',[SessionController::class, 'store']);
Route::get('/logout',[SessionController::class, 'destroy']);
