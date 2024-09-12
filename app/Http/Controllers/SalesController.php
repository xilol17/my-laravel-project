<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedAttributes = $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'region' => 'required|string',
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);

        // Create the user
        $user = User::create([
            'username' => $validatedAttributes['username'],
            'email' => $validatedAttributes['email'],
            'password' => $validatedAttributes['password'],
        ]);

        // Create the sales record associated with the user
        Sales::create([
            'user_id' => $user->id,
            'name' => $validatedAttributes['name'], // Assuming 'name' for sales is the same as user's full name
            'region' => $validatedAttributes['region']
        ]);

        return redirect('/sales-list');
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return Redirect::back()->with('success', 'User deleted successfully.');
    }



    public function sales_list(Request $request)
    {
        if (!Auth::check()) {
            session()->flash('alert', 'You must be logged in to access this page.');
            return redirect()->route('login');
        }

        // Allow only admins to access this page
        if (!Auth::user()->admin) {
            abort(403, 'Unauthorized action.');
        }

        $query = Sales::query();

// Join the users table to access the email field from the User model
        $query->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select('sales.*', 'users.email');

// Apply search filter if it exists
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('sales.name', 'like', "%{$search}%")
                    ->orWhere('sales.region', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%"); // Search in the user's email as well
            });
        }

// Apply sorting if fields exist
        if ($request->has('sort_field') && $request->has('sort_order')) {
            if ($request->sort_field === 'email') {
                // Sort by the email from the users table
                $query->orderBy('users.email', $request->sort_order);
            } else {
                $query->orderBy($request->sort_field, $request->sort_order);
            }
        } else {
            $query->orderBy('sales.name', 'asc'); // Default sorting
        }

// Pagination with query parameters
        $users = $query->paginate(10)->appends([
            'search' => $request->input('search'),
            'sort_field' => $request->input('sort_field'),
            'sort_order' => $request->input('sort_order'),
        ]);


        return view('sales-list', [
            'users' => $users,
        ]);
    }

}
