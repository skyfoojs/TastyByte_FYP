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
        // Validate Category Table data.
        $request->validate([
            'category' => 'required',
            'sort' => 'required',
            'otherCategory' => 'nullable|string|max:255',
        ]);

        // Validate Products Table data.
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        // Check if "Others" was selected and use the specified category.
        $categoryName = $request->category === 'others' ? $request->otherCategory : $request->category;

        // Check if category exists or create a new one.
        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['sort' => $request->sort, 'status' => 'Available']
        );

        if (!$category) {
            return redirect()->route('admin-products')->with('error', 'Error adding category.');
        }

        // Create product with the category ID.
        $product = Product::create([
            'categoryID' => $category->categoryID,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if (!$product) {
            return redirect()->route('admin-products')->with('error', 'Error adding product.');
        }

        if($request->customizable === 'customizable') {
            $request->validate([
                'customizable-category' => 'required',
                'customizable-sort' => 'required',
                'customizable-status' => 'required',
            ]);

            $customizableCategory = CustomizeableCategory::create([
                'productID' => $product->productID,
                'name' => $request['customizable-category'],
                'status' => $request['customizable-status'],
                'sort' => $request['customizable-sort'],
                'singleChoose' => 0,
            ]);

            if (!$customizableCategory) {
                return redirect()->route('admin-products')->with('error', 'Error adding customizable category.');
            }

            $request->validate([
                'option-name' => 'required',
                'option-max-amount' => 'required',
                'option-sort' => 'required',
                'option-status' => 'required',
            ]);

            $customizableOptions = CustomizableOptions::create([
                'customizeCategoryID' => $customizableCategory->customizeCategoryID,
                'name' => $request['option-name'],
                'maxAmount' => $request['option-max-amount'],
                'status' => $request['option-status'],
                'sort' => $request['option-sort'],
            ]);

            if (!$customizableOptions) {
                return redirect()->route('admin-products')->with('error', 'Error adding customizable options.');
            }
        }
        return redirect()->route('admin-products')->with('success', 'User added successfully!');
    }

    public function addProduct(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'sort' => 'required|integer',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'customizable' => 'nullable|string',
            'customizable-categories' => 'array',
            'customizable-sorts' => 'array',
            'customizable-options' => 'array',
            'customizable-max-amounts' => 'array',
        ]);

        // Save Product
        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'category' => $validatedData['category'],
            'sort' => $validatedData['sort'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'customizable' => $validatedData['customizable'] ?? 'No',
        ]);
        return redirect()->back()->with('success', 'Product added successfully.');
    }
}