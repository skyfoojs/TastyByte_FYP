<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomizableOptions;
use App\Models\CustomizeableCategory;
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

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'username' => $request->username,
            'nickname' => $request->nickname,
            'role' => $request->role,
            'gender' => $request->gender,
            'dateOfBirth' => $request->dateOfBirth,
            'email' => $request->email,
            'phoneNo' => $request->phoneNo,
            'password' => Hash::make($request->password),
            'status' => 'Active',
        ]);

        if (!$user) {
            return redirect()->route('admin-users')->with('error', 'Error adding user.');
        }

        return redirect()->route('admin-users')->with('success', 'User added successfully!');
    }

    public function editUserPost(Request $request) {
        // Validate input data
        $request->validate([
            'registeredUserID' => 'required|exists:users,userID',
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

    public function addProductPost(Request $request) {
        // Validate the request inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'otherCategory' => 'nullable|string|max:255', // Only required if "others" is selected
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:Available,Not Available',
        ]);

        // Handle dynamic category logic
        $categoryID = null;

        if ($validatedData['category'] === 'others') {
            if (empty($validatedData['otherCategory'])) {
                return back()->withErrors(['otherCategory' => 'Please specify the category if "Others" is selected.'])->withInput();
            }

            // Check if the "otherCategory" already exists
            $existingCategory = Category::where('name', $validatedData['otherCategory'])->first();
            if ($existingCategory) {
                $categoryID = $existingCategory->categoryID;
            } else {
                // Create a new category and get its ID
                $newCategory = new Category();
                $newCategory->name = $validatedData['otherCategory'];
                $newCategory->status = 'Available';
                $newCategory->sort = '2';
                $newCategory->save();
                $categoryID = $newCategory->categoryID;
            }
        } else {
            // Retrieve the category ID from the existing category name
            $categoryID = $validatedData['category'];
        }

        // Save the product
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->categoryID = $categoryID;
        $product->description = $validatedData['description'];
        $product->status = $validatedData['status'];
        $product->save();

        return redirect()->route('admin-products')->with('success', 'Product added successfully!');
    }

}