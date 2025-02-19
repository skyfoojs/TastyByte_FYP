<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomizableOptions;
use App\Models\CustomizeableCategory;
use App\Models\Inventory;
use App\Models\Vouchers;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard() {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }
        return view('admin.dashboard');
    }

    public function users() {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $users = User::get();
        $totalUsers = User::count();
        $limit = 6;
        $totalPages = ceil($totalUsers / $limit);
        return view('admin.users', compact('users', 'totalPages'));
    }

    public function products() {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $totalProducts = Product::count();
        $limit = 6;
        $totalPages = ceil($totalProducts / $limit);
        // Get the count of distinct sort values from customizableCategory
        $categoryDistinctSortCount = DB::table('customizablecategory')->distinct('sort')->count('sort');

        // Get the count of distinct sort values from customizableCategory
        $optionDistinctSortCount = DB::table('customizableoptions')->distinct('sort')->count('sort');

        // Fetch products with their categories, customizable categories, and options
        $products = Product::with(['category', 'customizableCategory.options'])->distinct()->get();
        $categories = Category::all();
        return view('admin.products', compact('products', 'categoryDistinctSortCount', 'optionDistinctSortCount', 'categories', 'totalPages'));
    }


    public function inventory() {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $totalInventory = Inventory::count();
        $limit = 6;
        $totalPages = ceil($totalInventory / $limit);
        $inventory = Inventory::with(['product'])->get();
        $product = Product::all();
        return view('admin.inventory', compact('inventory', 'totalPages'), compact('product'));
    }

    public function vouchers() {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $vouchers = Vouchers::all();
        $totalVouchers = Vouchers::count();
        $limit = 6;
        $totalPages = ceil($totalVouchers / $limit);
        return view('admin.vouchers', compact('vouchers', 'totalPages'));
    }

    public function payments() {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $payments = Payment::all();
        $totalPayments = Payment::count();
        $limit = 6;
        $totalPages = ceil($totalPayments / $limit);

        return view('admin.payments', compact('payments', 'totalPages'));
    }

    public function getDashboardData() {
        // Return the datas as json format (API) to fetch data realtime.
        return response()->json([
            'usersCount' => User::count(),
            'productsCount' => Product::count(),
            'inventoriesCount' => Inventory::count(),
            'vouchersCount' => Vouchers::count(),
            'lowStock' => Inventory::where('stockLevel', '<', 100)->get(),
            'upcomingVouchers' => Vouchers::where('startedOn', '>', now())->get(),
            'payments' => Payment::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    public function addUserPost(Request $request) {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'nickname' => 'required|string|max:255',
            'role' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'dateOfBirth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'email' => 'required|email|unique:users,email',
            'phoneNo' => 'required|numeric|digits_between:10,11',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ], [
            'dateOfBirth.before_or_equal' => 'User must be at least 18 years old.',
            'password.regex' => 'Password must have at least one uppercase letter, one lowercase letter, one number, and one special character.',
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
        $request->validate([
            'registeredUserID' => 'required|exists:users,userID',
            'editFirstName' => 'required|string|max:255',
            'editLastName' => 'required|string|max:255',
            'editUsername' => 'required|string|max:255|unique:users,username,' . $request->registeredUserID . ',userID',
            'editNickname' => 'required|string|max:255',
            'editRole' => 'required|string',
            'editGender' => 'required|in:Male,Female,Other',
            'editDateOfBirth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'editEmail' => 'required|email|unique:users,email,' . $request->registeredUserID . ',userID',
            'editPhoneNo' => 'required|numeric|digits_between:10,15',
        ], [
            'editDateOfBirth.before_or_equal' => 'User must be at least 18 years old.',
        ]);

        $user = User::find($request->registeredUserID);

        if (!$user) {
            return redirect()->route('admin-users')->with('error', 'User not found.');
        }

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

    public function getFilteredUsers(Request $request)
    {
        $request->validate([
            'filterType' => 'required|string|in:filterUserID,filterUsername,filterFullName,filterRole,filterPhone,filterEmail,filterGender',
            'keywords' => 'required|string',
        ]);

        $query = User::query();

        $filterType = $request->input('filterType');
        $keywords = $request->input('keywords');

        // Apply filtering based on filter type
        switch ($filterType) {
            case 'filterUserID':
                $query->where('userID', $keywords);
                break;
            case 'filterUsername':
                $query->where('username', 'LIKE', "%$keywords%");
                break;
            case 'filterFullName':
                $query->whereRaw("CONCAT(firstName, ' ', lastName) LIKE ?", ["%$keywords%"]);
                break;
            case 'filterRole':
                $query->where('role', $keywords);
                break;
            case 'filterPhone':
                $query->where('phoneNo', 'LIKE', "%$keywords%");
                break;
            case 'filterEmail':
                $query->where('email', 'LIKE', "%$keywords%");
                break;
            case 'filterGender':
                $query->where('gender', $keywords);
                break;
        }
        $totalUsers = User::count();
        $limit = 6;
        $totalPages = ceil($totalUsers / $limit);
        $users = $query->paginate(6);

        return view('admin.users', compact('users', 'totalPages'));
    }

    public function addProductPost(Request $request) {
        // Validate the request inputs, including categories and options
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'otherCategory' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:Available,Not Available',
            'sort' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:PNG,JPG,JPEG,WEBP,png,jpg,jpeg,webp',
            'customizableCategories' => 'nullable|array',
            'customizableCategories.*.name' => 'nullable|string|max:255',
            'customizableCategories.*.sort' => 'nullable|integer|min:1',
            'customizableCategories.*.status' => 'nullable|in:Available,Not Available',
            'customizableCategories.*.singleChoose' => 'nullable|boolean',
            'customizableCategories.*.isRequired' => 'nullable|boolean',
            'customizableCategories.*.options' => 'nullable|array',
            'customizableCategories.*.options.*.name' => 'nullable|string|max:255',
            'customizableCategories.*.options.*.maxAmount' => 'nullable|integer|min:1',
            'customizableCategories.*.options.*.sort' => 'nullable|integer|min:1|max:4',
            'customizableCategories.*.options.*.status' => 'nullable|in:available,not-available',
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
                $newCategory->sort = $validatedData['sort'];
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

        // Get the input image file
        if(isset($validatedData['image'])) {
            $file = $validatedData['image'];
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads';
            // Move the image to /public/uploads
            $file->move(public_path($path ), $filename);
            $product->image = $path. '/' . $filename;
        }

        $product->save();

        // Save customizable categories and options (only if provided)
        if (!empty($validatedData['customizableCategories'])) {
            foreach ($validatedData['customizableCategories'] as $categoryData) {
                // Ensure the "name" key exists in the category data
                if (isset($categoryData['name']) && isset($categoryData['sort']) && isset($categoryData['status'])) {
                    $customizableCategory = new CustomizeableCategory();
                    $customizableCategory->productID = $product->productID;
                    $customizableCategory->name = $categoryData['name'];
                    $customizableCategory->sort = $categoryData['sort'];
                    $customizableCategory->status = $categoryData['status'];
                    $customizableCategory->isRequired = $categoryData['isRequired'] ?? false;
                    $customizableCategory->singleChoose = $categoryData['singleChoose'] ?? false;
                    $customizableCategory->save();

                    if (!empty($categoryData['options'])) {
                        foreach ($categoryData['options'] as $optionData) {
                            // Ensure the "name", "maxAmount", "sort", and "status" keys exist in the option data
                            if (isset($optionData['name'], $optionData['maxAmount'], $optionData['sort'], $optionData['status'])) {
                                $customizableOption = new CustomizableOptions();
                                $customizableOption->customizeCategoryID = $customizableCategory->customizeCategoryID;
                                $customizableOption->name = $optionData['name'];
                                $customizableOption->maxAmount = $optionData['maxAmount'];
                                $customizableOption->status = $optionData['status'];
                                $customizableOption->sort = $optionData['sort'];
                                $customizableOption->save();
                            }
                        }
                    }
                }
            }
        }

    return redirect()->route('admin-products')->with('success', 'Product added successfully!');
    }

    public function editProductPost(Request $request) {
        // Validate request inputs
        $validatedData = $request->validate([
            'productID' => 'required|exists:product,productID',
            'editName' => 'required|string|max:255',
            'editPrice' => 'required|numeric|min:0',
            'editCategory' => 'required|string|max:255',
            'editCategorySort' => 'required|integer|min:1',
            'editOtherCategory' => 'nullable|string|max:255',
            'editDescription' => 'nullable|string|max:1000',
            'editStatus' => 'required|in:Available,Not Available',
            'editImage' => 'nullable|image|mimes:PNG,JPG,JPEG,WEBP,png,jpg,jpeg,webp',
            'editCustomizableCategories' => '',
            'editCustomizableCategories.*.name' => 'nullable|string|max:255',
            'editCustomizableCategories.*.sort' => 'nullable|integer|min:1',
            'editCustomizableCategories.*.status' => 'nullable|in:Available,Not Available',
            'editCustomizableCategories.*.singleChoose' => 'nullable|boolean',
            'editCustomizableCategories.*.isRequired' => 'nullable|boolean',
            'editCustomizableCategories.*.options' => 'nullable|array',
            'editCustomizableCategories.*.options.*.name' => 'nullable|string|max:255',
            'editCustomizableCategories.*.options.*.maxAmount' => 'nullable|integer|min:1',
            'editCustomizableCategories.*.options.*.sort' => 'nullable|integer|min:1',
            'editCustomizableCategories.*.options.*.status' => 'nullable|in:Available,Not Available',
        ]);

        // Handle dynamic category logic
        $categoryID = null;
        if ($validatedData['editCategory'] === 'others') {
            if (empty($validatedData['editOtherCategory'])) {
                return back()->withErrors(['editOtherCategory' => 'Please specify the category if "Others" is selected.'])->withInput();
            }
            $existingCategory = Category::where('name', $validatedData['editOtherCategory'])->first();
            if ($existingCategory) {
                $categoryID = $existingCategory->categoryID;
            } else {
                $newCategory = new Category();
                $newCategory->name = $validatedData['editOtherCategory'];
                $newCategory->status = 'Available';
                $newCategory->sort = $validatedData['editCategorySort'];
                $newCategory->save();
                $categoryID = $newCategory->categoryID;
            }
        } else {
            $categoryID = $validatedData['editCategory'];
            $category = Category::find($categoryID);
            $category->sort = $validatedData['editCategorySort'];
            $category->save();
        }

        // Find the product
        $product = Product::find($request->productID);
        if (!$product) {
            return redirect()->route('admin-products')->with('error', 'Product not found.');
        }

        // Update product details
        $product->name = $validatedData['editName'];
        $product->price = $validatedData['editPrice'];
        $product->categoryID = $categoryID;
        $product->description = $validatedData['editDescription'];
        $product->status = $validatedData['editStatus'];

        // Handle image update
        if (isset($validatedData['editImage'])) {
            $file = $validatedData['editImage'];
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads';

            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Save new image
            $file->move(public_path($path), $filename);
            $product->image = $path . '/' . $filename;
        } else {
            $product->image = $product->image;
        }

        $product->save();

        // Update customizable categories and options
        // Update customizable categories and options
        if (!empty($validatedData['editCustomizableCategories'])) {
            foreach ($validatedData['editCustomizableCategories'] as $categoryData) {
                // Check if an old name is provided to find the existing category
                $customizableCategory = CustomizeableCategory::where('productID', $product->productID)
                    ->where('name', $categoryData['oldName'] ?? null) // Use oldName if provided
                    ->first();

                // If no old name was found, check for the new name
                if (!$customizableCategory && isset($categoryData['name'])) {
                    $customizableCategory = CustomizeableCategory::where('productID', $product->productID)
                        ->where('name', $categoryData['name'])
                        ->first();
                }

                if ($customizableCategory) {
                    // Update existing category
                    $customizableCategory->name = $categoryData['name'];
                    $customizableCategory->sort = $categoryData['sort'];
                    $customizableCategory->status = $categoryData['status'];
                    $customizableCategory->singleChoose = $categoryData['singleChoose'] ?? false;
                    $customizableCategory->isRequired = $categoryData['isRequired'] ?? false;
                    $customizableCategory->save();
                } else {
                    // Create a new category if not found
                    $customizableCategory = new CustomizeableCategory();
                    $customizableCategory->productID = $product->productID;
                    $customizableCategory->name = $categoryData['name'];
                    $customizableCategory->sort = $categoryData['sort'];
                    $customizableCategory->status = $categoryData['status'];
                    $customizableCategory->singleChoose = $categoryData['singleChoose'] ?? false;
                    $customizableCategory->save();
                }

                // Handle options similarly
                if (!empty($categoryData['options'])) {
                    foreach ($categoryData['options'] as $optionData) {
                        $customizableOption = CustomizableOptions::where('customizeCategoryID', $customizableCategory->customizeCategoryID)
                            ->where('name', $optionData['oldOptionName'] ?? null) // Check for old name if exists
                            ->first();

                        // If no old name was found, check for the new name
                        if (!$customizableOption && isset($optionData['name'])) {
                            $customizableOption = CustomizableOptions::where('customizeCategoryID', $customizableCategory->customizeCategoryID)
                                ->where('name', $optionData['name'])
                                ->first();
                        }

                        if ($customizableOption) {
                            // Update existing option
                            $customizableOption->name = $optionData['name'];
                            $customizableOption->maxAmount = $optionData['maxAmount'];
                            $customizableOption->status = $optionData['status'];
                            $customizableOption->sort = $optionData['sort'] ?? 2;
                            $customizableOption->save();
                        } else {
                            // Create new option if not found
                            $customizableOption = new CustomizableOptions();
                            $customizableOption->customizeCategoryID = $customizableCategory->customizeCategoryID;
                            $customizableOption->name = $optionData['name'];
                            $customizableOption->maxAmount = $optionData['maxAmount'];
                            $customizableOption->status = $optionData['status'];
                            $customizableOption->sort = $optionData['sort'] ?? 2;
                            $customizableOption->save();
                        }
                    }
                }
            }
        }


        return redirect()->route('admin-products')->with('success', 'Product updated successfully!');
    }

    public function getFilteredProducts(Request $request)
    {
        $request->validate([
            'filterType' => 'required|string|in:filterProductID,filterCategory,filterProductName,filterStatus',
            'keywords' => 'required|string',
        ]);

        $query = Product::query();

        $filterType = $request->input('filterType');
        $keywords = $request->input('keywords');

        // Apply filtering based on filter type
        switch ($filterType) {
            case 'filterProductID':
                $query->where('productID', $keywords);
                break;
            case 'filterCategory':
                // Filter by category name using a join
                $query->whereHas('category', function ($q) use ($keywords) {
                    $q->where('name', 'LIKE', "%$keywords%");
                });
                break;
            case 'filterProductName':
                $query->where('name', 'LIKE', "%$keywords%");
                break;
            case 'filterStatus':
                $query->where('status', $keywords);
                break;
        }

        $totalProducts = Product::count();
        $limit = 6;
        $totalPages = ceil($totalProducts / $limit);
        $products = $query->paginate($limit);

        $categories = Category::all();
        $categoryDistinctSortCount = DB::table('customizablecategory')->distinct('sort')->count('sort');
        $optionDistinctSortCount = DB::table('customizableoptions')->distinct('sort')->count('sort');


        return view('admin.products', compact('products', 'totalPages', 'categories', 'categoryDistinctSortCount', 'optionDistinctSortCount'));
    }

    public function addInventoryPost(Request $request) {
        $request->validate([
            'inventory' => 'required',
            'product' => 'required',
            'stockLevel' => 'required',
            'minLevel' => 'required',
        ]);

        $inventory = Inventory::create([
            'name' => $request->inventory,
            'productID' => $request->product,
            'stockLevel' => $request->stockLevel,
            'minLevel' => $request->minLevel,
        ]);

        if (!$inventory) {
            return redirect()->route('admin-inventory')->with('error', 'Error adding inventory.');
        }

        return redirect()->route('admin-inventory')->with('success', 'Inventory added successfully!');
    }

    public function editInventoryPost(Request $request) {
        $request->validate([
            'inventoryID' => 'required',
            'editInventory' => 'required',
            'editProduct' => 'required',
            'editStockLevel' => 'required',
            'editMinLevel' => 'required',
        ]);

        // Retrieve the inventory record
        $inventory = Inventory::find($request->inventoryID);

        if (!$inventory) {
            return redirect()->route('admin-inventory')->with('error', 'Inventory not found.');
        }

        // Update inventory details
        $inventory->name = $request->editInventory;
        $inventory->productID = $request->editProduct;
        $inventory->stockLevel = $request->editStockLevel;
        $inventory->minLevel = $request->editMinLevel;

        if ($inventory->save()) {
            return redirect()->route('admin-inventory')->with('success', 'Inventory updated successfully!');
        } else {
            return redirect()->route('admin-inventory')->with('error', 'Error updating inventory.');
        }
    }

    public function getFilteredInventories(Request $request)
    {
        $request->validate([
            'filterType' => 'required|string|in:filterInventoryID,filterCategoryName,filterProductName,filterStockMoreThan,filterStockLessThan',
            'keywords' => 'required|string',
        ]);

        $query = Inventory::query();

        $filterType = $request->input('filterType');
        $keywords = $request->input('keywords');

        // Apply filtering based on filter type
        switch ($filterType) {
            case 'filterInventoryID':
                $query->where('inventoryID', $keywords);
                break;
            case 'filterCategoryName':
                $query->where('name', 'LIKE', "%$keywords%");
                break;
            case 'filterProductName':
                // Filter by product name using a join
                $query->whereHas('product', function ($q) use ($keywords) {
                    $q->where('name', 'LIKE', "%$keywords%");
                });
                break;
            case 'filterStockMoreThan':
                // Stock greater than the given number
                $query->where('stockLevel', '>', (int)$keywords);
                break;
            case 'filterStockLessThan':
                // Stock less than the given number
                $query->where('stockLevel', '<', (int)$keywords);
                break;
        }

        $totalInventory = Inventory::count();
        $limit = 6;
        $totalPages = ceil($totalInventory / $limit);
        $inventory = $query->paginate($limit);

        $product = Product::all();

        return view('admin.inventory', compact('inventory', 'totalPages', 'product'));
    }

    public function addVoucherPost(Request $request) {
        $request->validate([
            'code' => 'required|string|min:6|max:12|unique:vouchers,code',
            'type' => 'required|string|max:20|in:Percentage,Amount',
            'voucherValue' => 'required|numeric',
            'singleUse' => 'required',
            'startDate' => 'required|date|after_or_equal:today',
            'expiredDate' => 'required|date|after:startDate',
            'usage' => 'required'
        ]);

        $vouchers = Vouchers::create([
            'code' => $request->code,
            'type' => $request->type,
            'singleUse' => $request->singleUse ?? 'False',
            'usage' => $request->usage ?? 0,
            'value' => $request->voucherValue,
            'startedOn' => $request->startDate,
            'expiredOn' => $request->expiredDate,
            'usedCount' => 0,
        ]);

        if (!$vouchers) {
            return redirect()->route('admin-vouchers')->with('error', 'Error adding voucher.');
        }

        return redirect()->route('admin-vouchers')->with('success', 'Voucher added successfully!');
    }

    public function editVoucherPost(Request $request) {
        $request->validate([
            'voucherID' => 'required',
            'editCode' => 'required|string|min:6|max:12',
            'editType' => 'required|string|max:20|in:Percentage,Amount',
            'editVoucherValue' => 'required|numeric',
            'editSingleUse' => 'required',
            'editStartDate' => 'required|date|after_or_equal:today',
            'editExpiredDate' => 'required|date|after:startDate',
            'editUsage' => 'required'
        ]);

        // Retrieve the voucher record
        $vouchers = Vouchers::find($request->voucherID);

        if (!$vouchers) {
            return redirect()->route('admin-vouchers')->with('error', 'Voucher not found.');
        }

        // Update voucher details
        $vouchers->code = $request->editCode;
        $vouchers->type = $request->editType;
        $vouchers->singleUse = $request->editSingleUse;
        $vouchers->usage = $request->editUsage;
        $vouchers->value = $request->editVoucherValue;
        $vouchers->startedOn = $request->editStartDate;
        $vouchers->expiredOn = $request->editExpiredDate;
        $vouchers->usedCount = 0;

        if ($vouchers->save()) {
            return redirect()->route('admin-vouchers')->with('success', 'Voucher updated successfully!');
        } else {
            return redirect()->route('admin-vouchers')->with('error', 'Error updating voucher.');
        }
    }

    public function getFilteredVouchers(Request $request)
    {
        $request->validate([
            'filterType' => 'required|string|in:filterVoucherID,filterVoucherCode,filterType',
            'keywords' => 'required|string',
        ]);

        $query = Vouchers::query();

        $filterType = $request->input('filterType');
        $keywords = $request->input('keywords');

        // Apply filtering based on filter type
        switch ($filterType) {
            case 'filterVoucherID':
                $query->where('voucherID', $keywords);
                break;
            case 'filterVoucherCode':
                $query->where('code', 'LIKE', "%$keywords%");
                break;
            case 'filterType':
                $query->where('type', $keywords);
                break;
        }

        $totalVouchers = Vouchers::count();
        $limit = 6;
        $totalPages = ceil($totalVouchers / $limit);
        $vouchers = $query->paginate($limit);

        return view('admin.vouchers', compact('vouchers', 'totalPages'));
    }

    public function getFilteredPayments(Request $request)
    {
        $request->validate([
            'filterType' => 'required|string|in:filterPaymentID,filterOrderID,filterVoucherID,filterPaymentMethod,filterPaymentStatus',
            'keywords' => 'required|string',
        ]);

        $query = Payment::query();

        $filterType = $request->input('filterType');
        $keywords = $request->input('keywords');

        // Apply filtering based on filter type
        switch ($filterType) {
            case 'filterPaymentID':
                $query->where('paymentID', $keywords);
                break;
            case 'filterOrderID':
                $query->where('orderID', $keywords);
                break;
            case 'filterVoucherID':
                $query->where('voucherID', $keywords);
                break;

            case 'filterPaymentMethod':
                $query->where('paymentMethod', $keywords);
                break;

            case 'filterPaymentStatus':
                $query->where('status', $keywords);
                break;
        }

        $totalPayments = Payment::count();
        $limit = 6;
        $totalPages = ceil($totalPayments / $limit);
        $payments = $query->paginate($limit);

        return view('admin.payments', compact('payments', 'totalPages'));
    }
}