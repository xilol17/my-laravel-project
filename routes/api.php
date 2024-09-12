// routes/api.php
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SessionController;

Route::post('/login', [SessionController::class, 'store']);
Route::get('/projects', [ProjectController::class, 'index']);
// Add other routes as needed
