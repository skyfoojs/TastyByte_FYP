@section('title', 'Admin Users Page - TastyByte')

<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Users</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openCreateModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-plus-circle'></i>
                            <span>Add User</span>
                        </button>

                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="userTableContainer" class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto flex flex-col justify-between" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full" id="userTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Full Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Role</th>
                        <th class="py-4 px-6 border-b border-gray-200">Phone</th>
                        <th class="py-4 px-6 border-b border-gray-200">Email</th>
                        <th class="py-4 px-6 border-b border-gray-200">Gender</th>
                        <th class="py-4 px-6 border-b border-gray-200">Status</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center" id="userTableBody">
                        @if (!sizeof($users))
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                        @endif

                            @foreach ($users as $user)
                            <tr class="">
                                <td class="p-3 mt-4">{{ $user->userID }}</td>
                                <td class="p-3 mt-4">
                                    <span class="font-semibold">{{ $user->firstName . " " . $user->lastName }}<br></span>
                                    <span class="text-gray-500">{{ $user->username }}</span>
                                </td>
                                <td class="p-3 mt-4">{{ $user->role }}</td>
                                <td class="p-3 mt-4">{{ $user->phoneNo }}</td>
                                <td class="p-3 mt-4">{{ $user->email }}</td>
                                <td class="p-3 mt-4">{{ $user->gender }}</td>
                                <td class="p-3 mt-4">
                                    <span class="<?php echo $user->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> text-sm font-medium px-3 py-1 rounded-lg">
                                        <?php echo $user->status; ?>
                                    </span>
                                </td>

                                <td class="p-3 mt-4 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openEditModal({{ $user->userID }}, '{{ $user->firstName }}', '{{ $user->lastName }}', '{{ $user->username }}', '{{ $user->nickname }}', '{{ $user->role }}', '{{ $user->gender }}', '{{ $user->dateOfBirth }}', '{{ $user->email }}', '{{ $user->phoneNo }}', '{{ $user->status }}')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>

                <div>
                {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="userFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Users</h2>
                <hr class="py-2">
                <form action="{{ route('filterUser.get') }}" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="filterUserID">User ID</option>
                        <option value="filterUsername">Username</option>
                        <option value="filterFullName">Full Name</option>
                        <option value="filterRole">Role</option>
                        <option value="filterPhone">Phone</option>
                        <option value="filterEmail">Email</option>
                        <option value="filterGender">Gender</option>
                        <option value="filterStatus">Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeUserFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="{{ route('admin-users') }}" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
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

                    <label class="block text-gray-700 text-sm font-medium mt-4">E-mail</label>
                    <input name="editEmail" type="email" id="editEmail" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number</label>
                    <input name="editPhoneNo" type="text" id="editPhoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">Role<span class="text-red-500">*</span></label>
                            <select name="editRole" id="editRole" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Role</option>
                                <option value="Waiter">Waiter</option>
                                <option value="Admin">Admin</option>
                                <option value="Kitchen">Kitchen</option>
                                <option value="Cashier">Cashier</option>
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">User Status</label>
                            <select name="editStatus" id="editStatus" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

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


        <div id="userAddModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Add User</h2>
                <hr class="py-2">
                <form action="{{ route('addUser.post') }}" method="POST">
                    @csrf
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input name="firstName" type="text" id="firstName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input name="lastName" type="text" id="lastName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Username</label>
                    <input name="username" type="text" id="username" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Nickname</label>
                    <input name="nickname" type="text" id="nickname" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Password</label>
                    <input name="password" type="password" id="password" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Confirm Password</label>
                    <input name="confirm-password" type="password" id="confirm_password" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                    <span id='message'></span>

                    <label class="block text-gray-700 text-sm font-medium mt-4">E-mail</label>
                    <input name="email" type="email" id="email" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number</label>
                    <input name="phoneNo" type="text" id="phoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">Role<span class="text-red-500">*</span></label>
                            <select name="role" id="role" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Role</option>
                                <option value="Waiter">Waiter</option>
                                <option value="Admin">Admin</option>
                                <option value="Kitchen">Kitchen</option>
                                <option value="Cashier">Cashier</option>
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">User Status</label>
                            <select name="status" id="status" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                            <input name="dateOfBirth" type="date" id="dateOfBirth" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeUserAddModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="addUserButton" name="addUserButton" value="Add User" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Add User</button>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val() == $('#confirm_password').val()) {
            $('#message').html('Matching').css('color', 'green');
        } else {
            $('#message').html('Not Matching').css('color', 'red');
        }
    });

    $('form').on('submit', function (e) {
        if ($('#password').val() !== $('#confirm_password').val()) {
            e.preventDefault(); // Prevent form submission
            alert("Passwords do not match!"); // Alert the user
        }
    });
});

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
        const modal = document.getElementById('userAddModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeUserAddModal() {
        const modal = document.getElementById('userAddModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('show');

        setTimeout(() => {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, firstName, lastName, username, nickname, role, gender, dateOfBirth, email, phoneNo, status) {
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
        document.getElementById('editStatus').value = status;

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
        document.getElementById('editFirstName').value = '';
        document.getElementById('editLastName').value = '';
        document.getElementById('editUsername').value = '';
        document.getElementById('editNickname').value = '';
        document.getElementById('editEmail').value = '';
        document.getElementById('editPhoneNo').value = '';
        document.getElementById('editRole').value = '';
        document.getElementById('editGender').value = '';
        document.getElementById('editDateOfBirth').value = '';
    }
</script>
