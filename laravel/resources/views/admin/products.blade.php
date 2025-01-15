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

            <div id="userTableContainer" class="bg-[#E6E6E6] p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 540px;">
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

                            @foreach ($products as $product)
                            <tr class="">
                                <td class="p-3 mt-4">{{ $product->productID }}</td>
                                <td class="p-3 mt-4">
                                    <span class="font-semibold">{{ $product->category->name  }}<br></span>

                                </td>
                                <td class="p-3 mt-4">{{ $product->name }}</td>
                                <td class="p-3 mt-4">{{ $product->category->sort }}</td>
                                <td class="p-3 mt-4">{{ $product->status }}</td>

                               <td class="p-3 mt-4 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openEditModal()">
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

                    </ul>
                </nav>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="userFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Users</h2>
                <hr class="py-2">
                <form action="" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="userID">User ID</option>
                        <option value="username">Username</option>
                        <option value="fullName">Full Name</option>
                        <option value="phone">Phone</option>
                        <option value="email">Email</option>
                        <option value="gender">Gender</option>
                        <option value="membership">Membership Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeUserFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/users.php" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="userEditModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Edit User</h2>
                <hr class="py-2">
                <form action="{{ route('editUser.post') }}" method="POST">
                    <input type="hidden" id="registeredUserID" name="registeredUserID">
                    @csrf
                    @method('PUT')
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input name="editFirstName" type="text" id="editFirstName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input name="editLastName" type="text" id="editLastName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Username</label>
                    <input name="editUsername" type="text" id="editUsername" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Nickname</label>
                    <input name="editNickname" type="text" id="editNickname" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Role<span class="text-red-500">*</span></label>
                    <select name="editRole" id="editRole" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                        <option value="">Select Role</option>
                        <option value="waiter">Waiter</option>
                        <option value="admin">Admin</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="cashier">Cashier</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">E-mail</label>
                    <input name="editEmail" type="email" id="editEmail" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number</label>
                    <input name="editPhoneNo" type="text" id="editPhoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                            <input name="editDateOfBirth" type="date" id="editDateOfBirth" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                            <select name="editGender" id="editGender" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="editUserButton" name="editUserButton" value="Edit User" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="productAddModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Add Product</h2>
                <hr class="py-2">
                <form action="{{ route('addProduct.post') }}" method="POST">
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
                                @foreach ($products->unique('category.name') as $product)
                                    <option value="{{ $product->category->name }}">{{ $product->category->name }}</option>
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

                    <div class="flex items-center ps-4 border border-gray-300 rounded-lg mt-8">
                        <input id="customizable" type="checkbox" value="customizable" name="customizable" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="customizable" class="w-full py-4 ms-2 text-sm font-medium text-gray-700">Customizable</label>
                    </div>

                    <!-- Hidden input field for Customizable -->
                    <div id="customizableField" style="display: none;">
                    <h1 class="mt-8 text-xl font-semibold">Add Customizable Category</h1>
                        <div class="flex space-x-4">
                            <div class="flex-1 mt-2">
                                <label class="block text-gray-700 text-sm font-medium">Customizable Category<span class="text-red-500">*</span></label>
                                <input name="customizable-category" type="text" id="customizable-category" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700"/>
                            </div>

                            <div class="flex-1 mt-2">
                                <label class="block text-gray-700 text-sm font-medium">Category Sort &#40;Max: {{ $categoryDistinctSortCount + 1 }}&#41;<span class="text-red-500">*</span></label>
                                <input name="customizable-sort" type="number" id="customizable-sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" max="{{ $categoryDistinctSortCount + 1 }}">
                            </div>
                        </div>

                        <label class="block text-gray-700 text-sm font-medium mt-2">Customizable Category Status <span class="text-red-500">*</span></label>
                        <select name="customizable-status" id="customizable-status" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700">
                            <option value="">Select Status</option>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>

                        <h1 class="mt-8 text-xl font-semibold">Add Customizable Options</h1>
                        <div class="flex space-x-4">
                            <div class="flex-1 mt-2">
                                <label class="block text-gray-700 text-sm font-medium">Option Name<span class="text-red-500">*</span></label>
                                <input name="option-name" type="text" id="option-name" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700"/>
                            </div>

                            <div class="flex-1 mt-2">
                                <label class="block text-gray-700 text-sm font-medium">Max Amount<span class="text-red-500">*</span></label>
                                <input name="option-max-amount" type="number" id="option-max-amount" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1">
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <div class="flex-1 mt-2">
                                <label class="block text-gray-700 text-sm font-medium">Options Sort &#40;Max: {{ $optionDistinctSortCount + 1 }}&#41;<span class="text-red-500">*</span></label>
                                <input name="option-sort" type="number" id="option-sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1" max="{{ $optionDistinctSortCount + 1 }}">
                            </div>

                            <div class="flex-1 mt-2">
                                <label class="block text-gray-700 text-sm font-medium">Option Status <span class="text-red-500">*</span></label>
                                <select name="option-status" id="option-status" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700">
                                    <option value="">Select Status</option>
                                    <option value="available">Available</option>
                                    <option value="not-available">Not Available</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="addCustomizableSection" class="flex justify-end mt-4">
                            <button type="button" id="addCustomizableButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                                Add Customizable Category & Options
                            </button>
                        </div>

                        <!-- Container for Additional Customizable Fields -->
                        <div id="additionalCustomizables" class="mt-4"></div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeCreateModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="addUserButton" name="addUserButton" value="Add User" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>

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
    function openFilterModal() {
        const modal = document.getElementById('userFilterModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeUserFilterModal() {
        const modal = document.getElementById('userFilterModal');
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

    function openEditModal(id, firstName, lastName, username, nickname, role, gender, dateOfBirth, email, phoneNo, password, status) {
        const modal = document.getElementById('userEditModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');

        document.getElementById('registeredUserID').value = id;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('editUsername').value = username;
        document.getElementById('editNickname').value = nickname;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPhoneNo').value = phoneNo;
        document.getElementById('editRole').value = role;
        document.getElementById('editGender').value = gender;
        document.getElementById('editDateOfBirth').value = dateOfBirth;

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('userEditModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('show');

        setTimeout(() => {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
            clearModalFields();
        }, 300);
    }

    function clearModalFields() {
        document.getElementById('registeredUserID').value = '';
        document.getElementById('firstName').value = '';
        document.getElementById('lastName').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phoneNo').value = '';
        document.getElementById('gender').value = '';
        document.getElementById('dateOfBirth').value = '';
        document.getElementById('membershipStart').value = '';
        document.getElementById('membershipEnd').value = '';
    }

    function searchUsers() {
        const query = document.getElementById('searchInput').value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'searchUsers.php?query=' + encodeURIComponent(query), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('userTableBody').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category');
        const otherCategoryField = document.getElementById('otherCategoryField');
        const otherCategory = document.getElementById('otherCategory');

        categorySelect.addEventListener('change', function () {
            if (this.value === 'others') {
                otherCategoryField.style.display = 'block';
                otherCategory.setAttribute('required', '');
            } else {
                otherCategoryField.style.display = 'none';
                otherCategory.removeAttribute('required');
            }
        });
    });

    document.getElementById('customizable').addEventListener('change', function() {
        const customizableField = document.getElementById('customizableField');
        const customizableCategoryName = document.getElementById('customizable-category');
        const customizableStatus = document.getElementById('customizable-status');
        const customizableSort = document.getElementById('customizable-sort');
        const optionName = document.getElementById('option-name');
        const optionMaxAmount = document.getElementById('option-max-amount');
        const optionSort = document.getElementById('option-sort');
        const optionStatus = document.getElementById('option-status');

        if (this.checked) {
            customizableField.style.display = 'block';
            customizableCategoryName.setAttribute('required', '');
            customizableStatus.setAttribute('required', '');
            customizableSort.setAttribute('required', '');
            optionName.setAttribute('required', '');
            optionMaxAmount.setAttribute('required', '');
            optionSort.setAttribute('required', '');
            optionStatus.setAttribute('required', '');
        } else {
            customizableField.style.display = 'none';
            customizableCategoryName.removeAttribute('required');
            customizableStatus.removeAttribute('required');
            customizableSort.removeAttribute('required');
            optionName.removeAttribute('required', '');
            optionMaxAmount.removeAttribute('required', '');
            optionSort.removeAttribute('required', '');
            optionStatus.removeAttribute('required', '');
        }
    });

    document.getElementById('addCustomizableButton').addEventListener('click', function () {
    const customizableContainer = document.getElementById('additionalCustomizables');

    const customizableHTML = `
        <div class="customizable-category mt-6 border-t border-gray-300 pt-4">

            <h1 class="text-xl font-semibold mt-4">Add Customizable Options</h1>
            <div class="flex space-x-4">
                <div class="flex-1 mt-2">
                    <label class="block text-gray-700 text-sm font-medium">Option Name<span class="text-red-500">*</span></label>
                    <input name="customizable-options[]" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700"/>
                </div>
                <div class="flex-1 mt-2">
                    <label class="block text-gray-700 text-sm font-medium">Max Amount<span class="text-red-500">*</span></label>
                    <input name="customizable-max-amounts[]" type="number" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" min="1">
                </div>
            </div>
        </div>
    `;

    customizableContainer.insertAdjacentHTML('beforeend', customizableHTML);
});

</script>