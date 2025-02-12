<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Products</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openCreateModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-plus-circle'></i>
                            <span>Add Products</span>
                        </button>

                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="productTableContainer" class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full" id="productTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Product ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Product Category</th>
                        <th class="py-4 px-6 border-b border-gray-200">Product Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Sort</th>
                        <th class="py-4 px-6 border-b border-gray-200">Status</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center" id="userTableBody">
                        @if (!sizeof($products))
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                        @endif

                        @foreach ($products->unique('productID') as $product)
                        <tr>
                            <td class="p-3 mt-4">{{ $product->productID }}</td>
                            <td class="p-3 mt-4">
                                <span class="font-semibold">{{ $product->category->name }}<br></span>
                            </td>
                            <td class="p-3 mt-4">{{ $product->name }}</td>
                            <td class="p-3 mt-4">{{ $product->category->sort }}</td>
                            <td class="p-3 mt-4">{{ $product->status }}</td>

                                @foreach ($product->customizableCategory->unique('customizeCategoryID') as $customizableCategory)
                                    @foreach ($customizableCategory->options->unique('customizeOptionsID') as $option)

                                    @endforeach
                                @endforeach

                            <td class="p-3 mt-4 flex justify-center space-x-2">
                            <button class="text-gray-500 hover:text-blue-600" onclick="openPhotoModal('{{ asset($product->image) }}')">
                                <i class="bx bx-image"></i>
                            </button>
                            <button
                                class="text-gray-500 hover:text-blue-600"
                                onclick="openEditModal(
                                    {{ $product->productID }},
                                    '{{ $product->name }}',
                                    {{ $product->price }},
                                    '{{ $product->description }}',
                                    '{{ $product->status }}',
                                    {{ $product->category->categoryID }},
                                    '{{ $product->category->name }}',
                                    '{{ $product->category->status }}',
                                    {{ $product->category->sort }},
                                    {{ json_encode($product->customizableCategory->map(function ($cat) {
                                        return [
                                            'name' => $cat->name,
                                            'sort' => $cat->sort,
                                            'status' => $cat->status,
                                            'singleChoose' => $cat->singleChoose,
                                            'isRequired' => $cat->isRequired,
                                            'options' => $cat->options->map(function ($opt) {
                                                return [
                                                    'name' => $opt->name,
                                                    'maxAmount' => $opt->maxAmount,
                                                    'status' => $opt->status,
                                                    'sort' => $opt->sort,
                                                ];
                                            }),
                                        ];
                                    })) }}
                                )">
                                <i class="bx bx-pencil"></i>
                            </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <nav aria-label="Page navigation">
                    <ul class="flex space-x-2 mr-4">
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="px-4 py-2 border rounded-md {{ $i == request()->get('page', 1) ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }} hover:bg-indigo-600 hover:text-white transition">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </nav>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="photoModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl p-6">
                <img id="photoModalImage" src="" alt="Photo Not Available" class="max-w-full max-h-96 rounded-lg">
                <button onclick="closePhotoModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mt-4">Close</button>
            </div>
        </div>

        <div id="productsFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Products</h2>
                <hr class="py-2">
                <form action="{{ route('filterProducts.get') }}" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="filterProductID">Product ID</option>
                        <option value="filterCategory">Product Category</option>
                        <option value="filterProductName">Product Name</option>
                        <option value="filterStatus">Product Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="{{ route('admin-products') }}" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="productEditModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Edit User</h2>
                <hr class="py-2">
                <form action="{{ route('editProduct.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="productID" name="productID">
                    <input type="hidden" id="editCustomizableCategoriesInput" name="editCustomizableCategories">
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Product Name <span class="text-red-500">*</span></label>
                            <input name="editName" type="text" id="editName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Product Price <span class="text-red-500">*</span></label>
                            <input name="editPrice" type="numeric" id="editPrice" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1 mt-4">
                            <label class="block text-gray-700 text-sm font-medium">Category<span class="text-red-500">*</span></label>
                            <select name="editCategory" id="editCategory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->categoryID }}">{{ $category->name }}</option>
                                @endforeach
                                <option value="others">Others</option>
                            </select>
                        </div>

                        <div class="flex-1 mt-4">
                            <label class="block text-gray-700 text-sm font-medium">Category Sort &#40;Max: {{ count($products->unique('category.name')) + 1 }}&#41;<span class="text-red-500">*</span></label>
                            <input name="editCategorySort" type="number" id="editCategorySort" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" max="{{ count($products->unique('category.name')) + 1 }}" required>
                        </div>
                    </div>

                    <!-- Hidden input field for "Others" -->
                    <div id="editOtherCategoryField" class="mt-4" style="display: none;">
                        <label for="otherCategory" class="block text-gray-700 text-sm font-medium mt-4">Specify Category</label>
                        <input type="text" name="editOtherCategory" id="editOtherCategory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" placeholder="Enter Category">
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Description</label>
                    <input name="editDescription" type="text" id="editDescription" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Product Status <span class="text-red-500">*</span></label>
                    <select name="editStatus" id="editStatus" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                        <option value="">Select Status</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Product Image</label>
                    <input name="editImage" type="file" id="image" accept="image/png, image/jpg, image/jpeg, image/webp" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div id="editCustomizableContainer" class="space-y-4"></div>

                    <div id="editDefaultButtonLocation">
                        <div id="edit-modalFooter" class="flex justify-end mt-10">
                            <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                            <button type="submit" id="" name="addUserButton" value="Add Product" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="productAddModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Add Product</h2>
                <hr class="py-2">
                <form action="{{ route('addProduct.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Product Name <span class="text-red-500">*</span></label>
                            <input name="name" type="text" id="name" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Product Price <span class="text-red-500">*</span></label>
                            <input name="price" type="numeric" id="price" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1 mt-4">
                            <label class="block text-gray-700 text-sm font-medium">Category<span class="text-red-500">*</span></label>
                            <select name="category" id="category" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->categoryID }}">{{ $category->name }}</option>
                                @endforeach
                                <option value="others">Others</option>
                            </select>
                        </div>

                        <div class="flex-1 mt-4">
                            <label class="block text-gray-700 text-sm font-medium">Category Sort &#40;Max: {{ count($products->unique('category.name')) + 1 }}&#41;<span class="text-red-500">*</span></label>
                            <input name="sort" type="number" id="sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" max="{{ count($products->unique('category.name')) + 1 }}" required>
                        </div>
                    </div>

                    <!-- Hidden input field for "Others" -->
                    <div id="otherCategoryField" class="mt-4" style="display: none;">
                        <label for="otherCategory" class="block text-gray-700 text-sm font-medium mt-4">Specify Category</label>
                        <input type="text" name="otherCategory" id="otherCategory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" placeholder="Enter Category">
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Description</label>
                    <input name="description" type="text" id="description" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Product Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                        <option value="">Select Status</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Product Image</label>
                    <input name="image" type="file" id="image" accept="image/png, image/jpg, image/jpeg, image/webp" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div id="addCategoryButtonContainer" class="flex mt-4 flex-col">
                        <button type="button" id="addCategoryButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                            Add Category
                        </button>
                    </div>

                    <div id="defaultButtonLocation">
                        <div id="modalFooter" class="flex justify-end mt-10">
                            <button type="button" onclick="closeCreateModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                            <button type="submit" id="addProductButton" name="addUserButton" value="Add Product" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Add Product</button>
                        </div>
                    </div>

                    <div id="categories-container" class="mt-8">
                        <h2 class="text-xl font-bold hidden" id="categories-container-header">Customizable Category</h2>
                    </div>
                </form>
            </div>
        </div>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>
<script type="text/template" id="category-template">
    <div class="category mt-2 border p-4 rounded-lg">
        <h2 class="font-semibold text-lg category-title">Category ${categoryIndex}</h2>
        <div class="flex space-x-4">
            <div class="flex-1 mt-2">
                <label class="block text-gray-700 text-sm font-medium">Customizable Category<span class="text-red-500">*</span></label>
                <input name="customizableCategories[${categoryIndex}][name]" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700"/>
            </div>

            <div class="flex-1 mt-2">
                <label class="block text-gray-700 text-sm font-medium">Category Sort &#40;Max: {{ $categoryDistinctSortCount + 1 }}&#41;<span class="text-red-500">*</span></label>
                <input name="customizableCategories[${categoryIndex}][sort]" type="number" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" max="{{ $categoryDistinctSortCount + 1 }}">
            </div>
        </div>

        <div class="flex space-x-4">
            <div class="flex-1">
                <label class="block text-gray-700 text-sm font-medium mt-2">Is Category Required <span class="text-red-500">*</span></label>
                <select name="customizableCategories[${categoryIndex}][isRequired]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700">
                    <option value="">Select Required or Optional</option>
                    <option value="1">Required</option>
                    <option value="0">Optional</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-gray-700 text-sm font-medium mt-2">Single Choose</label>
                <select name="customizableCategories[${categoryIndex}][singleChoose]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700">
                    <option value="">Select Yes or No</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        <label class="block text-gray-700 text-sm font-medium mt-2">Customizable Category Status <span class="text-red-500">*</span></label>
        <select name="customizableCategories[${categoryIndex}][status]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700">
            <option value="">Select Status</option>
            <option value="Available">Available</option>
            <option value="Not Available">Not Available</option>
        </select>

        <div class="mt-4" id="options-container-${categoryIndex}"></div>

        <div class="flex justify-between mt-4">
            <button type="button" class="add-option-btn bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                Add Option
            </button>

            <button type="button" class="remove-category-btn bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">
                Remove Category
            </button>
        </div>
    </div>
</script>

<style>
    .modal {
        transition: opacity 0.3s ease, transform 0.3s ease;
        opacity: 0;
        transform: scale(0.9);
        pointer-events: none;
    }

    .modal.show {
        opacity: 1;
        transform: scale(1);
        pointer-events: auto;
    }
</style>

<script>
function openPhotoModal(imagePath) {
    document.getElementById('photoModalImage').src = imagePath;
    const modal = document.getElementById('photoModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    // Trigger the transition
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closePhotoModal() {
    const modal = document.getElementById('photoModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}

function openFilterModal() {
    const modal = document.getElementById('productsFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeFilterModal() {
    const modal = document.getElementById('productsFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}

function openModal() {
    const modal = document.getElementById('userModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function openCreateModal() {
    const modal = document.getElementById('productAddModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeCreateModal() {
    const modal = document.getElementById('productAddModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}

function openEditModal(
    productID,
    productName,
    productPrice,
    productDescription,
    productStatus,
    categoryID,
    categoryName,
    categoryStatus,
    categorySort,
    customizableCategories
) {
    const modal = document.getElementById("productEditModal");
    const overlay = document.getElementById("modalOverlay");

    modal.classList.remove("hidden");
    overlay.classList.remove("hidden");

    document.getElementById("editCustomizableCategoriesInput").value = customizableCategories || "";
    document.getElementById("productID").value = productID;
    document.getElementById("editName").value = productName;
    document.getElementById("editPrice").value = productPrice;
    document.getElementById("editDescription").value = productDescription;
    document.getElementById("editStatus").value = productStatus;
    document.getElementById("editCategory").value = categoryID;
    document.getElementById("editCategorySort").value = categorySort;

    const container = document.getElementById("editCustomizableContainer");

    if (!container) {
        console.error("Element #editCustomizableContainer not found");
        return;
    }

    container.innerHTML = ""; // Clear previous content

    if (!Array.isArray(customizableCategories)) {
        console.error("customizableCategories is not an array:", customizableCategories);
        return;
    }
    // Dynamically generate inputs for customizable categories
    customizableCategories.forEach((category, index) => {
        const categoryHTML = `
            <div class="category mt-4 border p-4 rounded-lg">
                <h2 class="font-semibold text-lg">Category ${index + 1}</h2>
                <input type="hidden" name="editCustomizableCategories[${index}][oldName]" value="${category.name}">
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Customizable Category Name</label>
                        <input type="text" name="editCustomizableCategories[${index}][name]" value="${category.name}" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Category Sort</label>
                        <input type="number" name="editCustomizableCategories[${index}][sort]" value="${category.sort}" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium mt-2">Is Category Required <span class="text-red-500">*</span></label>
                        <select name="editCustomizableCategories[${index}][isRequired]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700">
                            <option value="">Select Required or Optional</option>
                            <option value="1" ${category.isRequired == "1" || category.isRequired === true ? "selected" : ""}>Required</option>
                            <option value="0" ${category.isRequired == "0" || category.isRequired === false ? "selected" : ""}>Optional</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium mt-2">Single Choose</label>
                        <select name="editCustomizableCategories[${index}][singleChoose]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                            <option value="1" ${category.singleChoose == "1" || category.singleChoose === true ? "selected" : ""}>Yes</option>
                            <option value="0" ${category.singleChoose == "0" || category.singleChoose === false ? "selected" : ""}>No</option>
                        </select>
                    </div>
                </div>

                <label class="block text-gray-700 text-sm font-medium mt-2">Category Status</label>
                <select name="editCustomizableCategories[${index}][status]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 " required>
                    <option value="Available" ${category.status === "Available" ? "selected" : ""}>Available</option>
                    <option value="Not Available" ${category.status === "Not Available" ? "selected" : ""}>Not Available</option>
                </select>

                <div class="mt-4">
                    <hr>
                    <div id="edit-options-container-${index}" class="space-y-2">
                        ${category.options
                            .map(
                                (option, optIndex) => `
                                <h3 class="text-md font-semibold mt-4">Option ${optIndex + 1}</h3>
                                <input type="hidden" name="editCustomizableCategories[${index}][options][${optIndex}][oldOptionName]" value="${option.name}">
                                    <div class="flex space-x-4">
                                        <div class="option flex-1">
                                            <label class="block text-gray-700 text-sm font-medium">Option Name</label>
                                            <input type="text" name="editCustomizableCategories[${index}][options][${optIndex}][name]" value="${option.name}" placeholder="Option Name" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                                        </div>

                                        <div class="flex-1">
                                            <label class="block text-gray-700 text-sm font-medium">Max Amount</label>
                                            <input type="number" name="editCustomizableCategories[${index}][options][${optIndex}][maxAmount]" value="${option.maxAmount}" placeholder="Max Amount" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                                        </div>
                                    </div>

                                    <div class="flex space-x-4">
                                        <div class="flex-1">
                                            <label class="block text-gray-700 text-sm font-medium">Option Status</label>
                                            <select name="editCustomizableCategories[${index}][options][${optIndex}][status]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                                                <option value="Available" ${option.status === "Available" ? "selected" : ""}>Available</option>
                                                <option value="Not Available" ${option.status === "Not Available" ? "selected" : ""}>Not Available</option>
                                            </select>
                                        </div>

                                        <div class="flex-1">
                                            <label class="block text-gray-700 text-sm font-medium">Option Sort</label>
                                            <input type="number" name="editCustomizableCategories[${index}][options][${optIndex}][sort]" value="${option.sort}" placeholder="Sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                                        </div>
                                    </div>
                                `
                            )
                            .join("")}
                    </div>
                </div>
            </div>`;
            container.insertAdjacentHTML("beforeend", categoryHTML);
    });

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}



function closeEditModal() {
    const modal = document.getElementById('productEditModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        clearModalFields();
    }, 300);
}

function clearModalFields() {
    document.getElementById('productID').value = '';
    document.getElementById('editCustomizableCategoriesInput').value = '';
    document.getElementById('editName').value = '';
    document.getElementById('editPrice').value = '';
    document.getElementById('editCategory').value = '';
    document.getElementById('editCategorySort').value = '';
    document.getElementById('otherCategory').value = '';
    document.getElementById('editDescription').value = '';
    document.getElementById('editStatus').value = '';
    document.getElementById('editImage').value = '';
}

document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category');
    const otherCategoryField = document.getElementById('otherCategoryField');
    const otherCategory = document.getElementById('otherCategory');

    const editCategorySelect = document.getElementById('editCategory');
    const editOtherCategoryField = document.getElementById('editOtherCategoryField');
    const editOtherCategory = document.getElementById('editOtherCategory');

    categorySelect.addEventListener('change', function () {
        if (this.value === 'others') {
            otherCategoryField.style.display = 'block';
            otherCategory.setAttribute('required', '');
        } else {
            otherCategoryField.style.display = 'none';
            otherCategory.removeAttribute('required');
        }
    });

    editCategorySelect.addEventListener('change', function () {
        if (this.value === 'others') {
            editOtherCategoryField.style.display = 'block';
            editOtherCategory.setAttribute('required', '');
        } else {
            editOtherCategory.style.display = 'none';
            editOtherCategory.removeAttribute('required');
        }
    });
});

// Function to toggle header visibility
function toggleCategoriesHeader() {
    const categoriesContainer = document.getElementById('categories-container');
    const categoriesContainerHeader = document.getElementById('categories-container-header');
    const hasCategories = categoriesContainer.querySelectorAll('.category').length > 0;
    if (hasCategories) {
        categoriesContainerHeader.classList.remove('hidden');
        categoriesContainerHeader.classList.add('flex');
    } else {
        categoriesContainerHeader.classList.add('hidden');
        categoriesContainerHeader.classList.remove('flex');
    }
}

let categoryIndex = 1;
const maxCategories = 4;
const maxOptionsPerCategory = 4;

document.getElementById('addCategoryButton').addEventListener('click', function () {
    const modalFooter = document.getElementById('modalFooter');
    const addCategoryButtonContainer = document.getElementById('addCategoryButtonContainer');
    const categoryTitles = document.getElementsByClassName('category-title');
    const container = document.getElementById('categories-container');
    const categoryTemplate = document.getElementById('category-template').innerHTML;

    if (categoryIndex <= maxCategories) {
        // Render the category with the correct index
        const categoryHtml = categoryTemplate.replace(/\${categoryIndex}/g, categoryIndex);

        // Append the new category to the container
        container.insertAdjacentHTML('beforeend', categoryHtml);

        // Add 'required' to all inputs in the new category
        const newCategoryElement = container.lastElementChild;
        const inputs = newCategoryElement.querySelectorAll('input, select');
        inputs.forEach(input => input.setAttribute('required', ''));

        categoryIndex++;

        // Move the "Add Category" button to the bottom
        const addButton = document.getElementById('addCategoryButton');
        container.appendChild(addButton.parentElement);

        // Scroll to the newly added category
        const addedCategory = container.lastElementChild;
        addedCategory.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Move the modal footer back to the bottom of the modal content
        addCategoryButtonContainer.appendChild(modalFooter);
    } else {
        alert("You can only add up to 4 categories.");
    }
});

// Event delegation for dynamically added categories
document.getElementById('categories-container').addEventListener('click', function (event) {
    if (event.target.classList.contains('add-option-btn')) {
        const categoryElement = event.target.closest('.category');

        const categoryIndex = Array.from(categoryElement.parentElement.children).indexOf(categoryElement);
        const optionsContainer = document.getElementById(`options-container-${categoryIndex}`);
        const currentOptionsCount = optionsContainer.querySelectorAll('.option').length;

        if (currentOptionsCount < maxOptionsPerCategory) {
            const newOptionHtml = `
            <div class="option">
                <div class="flex space-x-4 mt-2">
                    <div class="flex-1 mt-2">
                        <label for="option-name" class="block text-sm font-medium text-gray-700">Option Name <span class="text-red-500">*</span></label>
                        <input type="text" name="customizableCategories[${categoryIndex}][options][${currentOptionsCount}][name]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                    </div>

                    <div class="flex-1 mt-2">
                        <label class="block text-gray-700 text-sm font-medium">Max Amount<span class="text-red-500">*</span></label>
                        <input name="customizableCategories[${categoryIndex}][options][` + currentOptionsCount + `][maxAmount]" type="number" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" required>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <div class="flex-1 mt-2">
                        <label class="block text-gray-700 text-sm font-medium">Options Sort (Max: 4)<span class="text-red-500">*</span></label>
                        <input name="customizableCategories[${categoryIndex}][options][` + currentOptionsCount + `][sort]" type="number" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" max="4" required>
                    </div>

                    <div class="flex-1 mt-2">
                        <label class="block text-gray-700 text-sm font-medium">Option Status <span class="text-red-500">*</span></label>
                        <select name="customizableCategories[${categoryIndex}][options][` + currentOptionsCount + `][status]" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                            <option value="">Select Status</option>
                            <option value="Available">Available</option>
                            <option value="Not available">Not Available</option>
                        </select>
                    </div>
                </div>

                <div class="flex-none mt-2">
                    <button type="button" class="remove-option-btn bg-red-500 text-white px-4 py-2 rounded-lg">Remove</button>
                </div>
            </div>
            `;
            optionsContainer.insertAdjacentHTML('beforeend', newOptionHtml);
        } else {
            alert("You can only add up to 4 options per category.");
        }
    }

    // Remove Option Button
    if (event.target.classList.contains('remove-option-btn')) {
        const optionElement = event.target.closest('.option');
        if (optionElement) {
            optionElement.remove();
        } else {
            console.error("Remove button not inside an option element.");
        }
    }

    // Remove Category Button
    if (event.target.classList.contains('remove-category-btn')) {
        const categoryElement = event.target.closest('.category');
        if (categoryElement) {
            categoryElement.remove();
            categoryIndex--;

            // Move the "Add Category" button back to the correct position
            const addButton = document.getElementById('addCategoryButton');
            const container = document.getElementById('categories-container');
            container.appendChild(addButton.parentElement);
            toggleCategoriesHeader();
        }
    }
});
</script>