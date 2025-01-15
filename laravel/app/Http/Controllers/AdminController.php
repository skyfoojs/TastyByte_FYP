<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function users() {
        $users = User::get();
        return view('admin.users', compact('users'));
    }

    public function products() {
        // Get the count of distinct sort values from customizableCategory
        $categoryDistinctSortCount = DB::table('customizablecategory')->distinct('sort')->count('sort');

        // Get the count of distinct sort values from customizableCategory
        $optionDistinctSortCount = DB::table('customizableoptions')->distinct('sort')->count('sort');

        // Fetch products with their categories and customizable categories
        $products = Product::with(['category', 'customizableCategory'])->get();

        return view('admin.products', compact('products', 'categoryDistinctSortCount', 'optionDistinctSortCount'));
    }


    public function addUserPost(Request $request) {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'username' => 'required',
            'nickname' => 'required',
            'role' => 'required',
            'gender' => 'required',
            'dateOfBirth' => 'required',
            'email' => 'required|email|unique:users',
            'phoneNo' => 'required',
            'password' => 'required',
        ]);

        $data['firstName'] = $request->firstName;
        $data['lastName'] = $request->lastName;
        $data['username'] = $request->username;
        $data['nickname'] = $request->nickname;
        $data['role'] = $request->role;
        $data['gender'] = $request->gender;
        $data['dateOfBirth'] = $request->dateOfBirth;
        $data['email'] = $request->email;
        $data['phoneNo'] = $request->phoneNo;
        $data['password'] = Hash::make($request->password);
        $data['status'] = 'Active';

        $user = User::create($data);

        if (!$user) {
            return redirect()->route('admin-users')->with('error', 'Error adding user.');
        }

        return redirect()->route('admin-users')->with('success', 'User added successfully!');

        }

        public function editUserPost(Request $request)
        {
            // Validate input data
            $request->validate([
                'registeredUserID' => 'required|exists:users,userID', // Ensure the user ID exists
                'editFirstName' => 'required|string|max:255',
                'editLastName' => 'required|string|max:255',
                'editUsername' => 'required|string|max:255',
                'editNickname' => 'required|string|max:255',
                'editRole' => 'required|string',
                'editGender' => 'required',
                'editDateOfBirth' => 'required|date',
                'editEmail' => 'required' ,
                'editPhoneNo' => 'required|string|max:15',
            ]);

            // Retrieve the user record
            $user = User::find($request->registeredUserID);

            if (!$user) {
                return redirect()->route('admin-users')->with('error', 'User not found.');
            }

            // Update user details
            $user->firstName = $request->editFirstName;
            $user->lastName = $request->editLastName;
            $user->username = $request->editUsername;
            $user->nickname = $request->editNickname;
            $user->role = $request->editRole;
            $user->gender = $request->editGender;
            $user->dateOfBirth = $request->editDateOfBirth;
            $user->email = $request->editEmail;
            $user->phoneNo = $request->editPhoneNo;
            $user->status = 'Active';

            if ($user->save()) {
                return redirect()->route('admin-users')->with('success', 'User updated successfully!');
            } else {
                return redirect()->route('admin-users')->with('error', 'Error updating user.');
            }
        }
}


