<x-admin-layout title="Data User">

@php
    $perPageOptions = [10,25,50];
    // current query values
    $q = request('q', '');
    $roleFilter = request('role', '');
    $perPage = request('per_page', 10);
    $sortBy = request('sort_by', 'created_at');
    $sortDir = request('sort_dir', 'desc');
    // helper to build new query strings
    function qs(array $overrides = []) {
        return http_build_query(array_merge(request()->query(), $overrides));
    }
@endphp

<div x-data="userIndex()" class="pb-10">

    <!-- HEADER: SEARCH, FILTER, ACTIONS -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <!-- LEFT: Title + Search/Filter -->
            <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto">
                <h2 class="text-lg font-semibold mr-4">Data User</h2>

                <form method="GET" action="{{ route('master.user') }}" class="flex gap-2 items-center flex-wrap">
                    <input
                        type="text"
                        name="q"
                        placeholder="Cari nama / email / telepon..."
                        value="{{ $q }}"
                        class="border rounded px-3 py-2 w-full md:w-60"
                    />

                    <select name="role" class="border rounded px-2 py-2 w-full md:w-auto">
                        <option value="">Semua Role</option>
                        <option value="Admin" {{ $roleFilter=='Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Operator" {{ $roleFilter=='Operator' ? 'selected' : '' }}>Operator</option>
                        <option value="User" {{ $roleFilter=='User' ? 'selected' : '' }}>User</option>
                    </select>

                    <select name="per_page" class="border rounded px-2 py-2 w-full md:w-auto">
                        @foreach($perPageOptions as $opt)
                            <option value="{{ $opt }}" {{ (int)$perPage == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                        </svg>
                        <span>Cari / Filter</span>
                    </button>
                </form>
            </div>

            <!-- RIGHT: Actions -->
            <div class="flex items-center gap-2">
                <button @click="openAddModal()" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah</span>
                </button>
            </div>

        </div>
    </div>

    <!-- TABLE WRAPPER: only this div scrolls (fixed header above) -->
    <div class="bg-white p-4 rounded shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-100 text-sm">
                    <th class="py-3 px-2">No</th>

                    <th class="py-3 px-2">
                        <button class="flex items-center gap-2" @click="sort('first_name')">
                            User
                            <template x-if="sort_by === 'first_name'">
                                <svg x-show="sort_dir === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 12h10l-5-7-5 7z"/></svg>
                                <svg x-show="sort_dir === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 8h10l-5 7-5-7z"/></svg>
                            </template>
                        </button>
                    </th>

                    <th class="py-3 px-2">
                        <button class="flex items-center gap-2" @click="sort('email')">
                            Email
                            <template x-if="sort_by === 'email'">
                                <svg x-show="sort_dir === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 12h10l-5-7-5 7z"/></svg>
                                <svg x-show="sort_dir === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 8h10l-5 7-5-7z"/></svg>
                            </template>
                        </button>
                    </th>

                    <th class="py-3 px-2">
                        <button class="flex items-center gap-2" @click="sort('phone_number')">
                            Telepon
                            <template x-if="sort_by === 'phone_number'">
                                <svg x-show="sort_dir === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 12h10l-5-7-5 7z"/></svg>
                                <svg x-show="sort_dir === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5 8h10l-5 7-5-7z"/></svg>
                            </template>
                        </button>
                    </th>

                    <th class="py-3 px-2">Role</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $u)
                <tr class="border-t">
                    <td class="py-3 px-2 align-middle">{{ $users->firstItem() + $loop->index }}</td>

                    <td class="py-3 px-2 flex items-center gap-3">
                        <!-- avatar auto: initials -->
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-700">
                            {!! strtoupper(substr($u->first_name,0,1) . substr($u->last_name,0,1)) !!}
                        </div>
                        <div>
                            <div class="font-medium">{{ $u->first_name }} {{ $u->last_name }}</div>
                            <div class="text-xs text-gray-500">since {{ $u->created_at->format('Y-m-d') }}</div>
                        </div>
                    </td>

                    <td class="py-3 px-2">{{ $u->email }}</td>

                    <td class="py-3 px-2">+{{ $u->phone_code ?? '' }} {{ $u->phone_number ?? '' }}</td>

                    <td class="py-3 px-2">
                        <span class="px-2 py-1 rounded text-white text-xs {{ $u->role == 'Admin' ? 'bg-red-600' : ($u->role == 'Operator' ? 'bg-blue-600' : 'bg-green-600') }}">
                            {{ $u->role }}
                        </span>
                    </td>

                    <td class="py-3 px-2 text-center">
                        <div class="flex items-center justify-center gap-2">

                            <!-- EDIT -->
                            <button title="Edit" @click="openEditModal($event)" data-user='@json($u)' class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                                <!-- pencil -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4L18.5 2.5z" />
                                </svg>
                            </button>

                            <!-- RESET PASSWORD (lock icon) -->
                            <button title="Reset Password" @click="confirmReset(@json($u->id))" class="bg-amber-500 text-white p-2 rounded hover:bg-amber-600">
                                <!-- lock -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.1046 0 2-.8954 2-2V7a4 4 0 10-8 0v2c0 1.1046.8954 2 2 2h4z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11v8a2 2 0 002 2h10a2 2 0 002-2v-8" />
                                </svg>
                            </button>

                            <!-- DELETE -->
                            <form id="delete-{{ $u->id }}" action="{{ route('master.user.destroy', $u->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" title="Hapus" onclick="confirmDelete('delete-{{ $u->id }}')" class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                                    <!-- trash -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-2 text-center text-gray-500">Belum ada user</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- MODAL ADD -->
    <div x-show="showAdd" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
        <div @keydown.escape="closeAdd()" x-ref="addModal" x-init="$refs.firstInput && $refs.firstInput.focus()" class="bg-white rounded p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah User</h3>

            <form id="formAdd" action="{{ route('master.user.store') }}" method="POST" @submit.prevent="submitAdd" novalidate>
                @csrf

                <div class="mb-2">
                    <label class="block text-sm">Nama Depan</label>
                    <input x-ref="firstInput" type="text" name="first_name" x-model="add.first_name" @input="onNameChange()" class="w-full border rounded px-2 py-2" required>
                    <template x-if="errors['first_name']"><p class="text-red-600 text-sm mt-1" x-text="errors['first_name'][0]"></p></template>
                </div>

                <div class="mb-2">
                    <label class="block text-sm">Nama Belakang</label>
                    <input type="text" name="last_name" x-model="add.last_name" @input="onNameChange()" class="w-full border rounded px-2 py-2">
                    <template x-if="errors['last_name']"><p class="text-red-600 text-sm mt-1" x-text="errors['last_name'][0]"></p></template>
                </div>

                <div class="mb-2">
                    <label class="block text-sm">Email <span class="text-xs text-gray-500">(otomatis, bisa diedit)</span></label>
                    <input type="email" name="email" x-model="add.email" @input="emailEdited = true" class="w-full border rounded px-2 py-2" required>
                    <template x-if="errors['email']"><p class="text-red-600 text-sm mt-1" x-text="errors['email'][0]"></p></template>
                </div>

                <div class="mb-2 grid grid-cols-2 gap-2 items-center">
                    <div>
                        <label class="block text-sm">Password</label>
                        <div class="relative">
                            <input :type="add.showPassword ? 'text' : 'password'" name="password" x-model="add.password" class="w-full border rounded px-2 py-2" placeholder="(opsional) minimal 6">
                            <button type="button" @click="add.showPassword = !add.showPassword" class="absolute right-2 top-2 text-gray-500">
                                <svg x-show="!add.showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="add.showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm">Konfirmasi Password</label>
                        <div class="relative">
                            <input :type="add.showPasswordConfirm ? 'text' : 'password'" name="password_confirmation" x-model="add.password_confirmation" class="w-full border rounded px-2 py-2" placeholder="konfirmasi">
                            <button type="button" @click="add.showPasswordConfirm = !add.showPasswordConfirm" class="absolute right-2 top-2 text-gray-500">
                                <svg x-show="!add.showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="add.showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-2 grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-sm">Kode</label>
                        <input type="text" name="phone_code" x-model="add.phone_code" class="w-full border rounded px-2 py-2" placeholder="62">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm">Nomor Telepon</label>
                        <input type="text" name="phone_number" x-model="add.phone_number" class="w-full border rounded px-2 py-2">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-sm">Role</label>
                    <select name="role" x-model="add.role" class="w-full border rounded px-2 py-2">
                        <option value="User">User</option>
                        <option value="Operator">Operator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeAdd()" class="px-3 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="showEdit" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
        <div @keydown.escape="closeEdit()" x-ref="editModal" x-init="$refs.editFirst && $refs.editFirst.focus()" class="bg-white rounded p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit User</h3>

            <form id="formEdit" :action="editAction" method="POST" @submit.prevent="submitEdit" novalidate>
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-2">
                    <label class="block text-sm">Nama Depan</label>
                    <input x-ref="editFirst" type="text" name="first_name" x-model="edit.first_name" class="w-full border rounded px-2 py-2" required>
                    <template x-if="errors['first_name']"><p class="text-red-600 text-sm mt-1" x-text="errors['first_name'][0]"></p></template>
                </div>

                <div class="mb-2">
                    <label class="block text-sm">Nama Belakang</label>
                    <input type="text" name="last_name" x-model="edit.last_name" class="w-full border rounded px-2 py-2">
                    <template x-if="errors['last_name']"><p class="text-red-600 text-sm mt-1" x-text="errors['last_name'][0]"></p></template>
                </div>

                <div class="mb-2">
                    <label class="block text-sm">Email</label>
                    <input type="email" name="email" x-model="edit.email" class="w-full border rounded px-2 py-2" required>
                    <template x-if="errors['email']"><p class="text-red-600 text-sm mt-1" x-text="errors['email'][0]"></p></template>
                </div>

                <div class="mb-2 grid grid-cols-2 gap-2 items-center">
                    <div>
                        <label class="block text-sm">Password (baru)</label>
                        <div class="relative">
                            <input :type="edit.showPassword ? 'text' : 'password'" name="password" x-model="edit.password" class="w-full border rounded px-2 py-2" placeholder="biarkan kosong jika tidak diubah">
                            <button type="button" @click="edit.showPassword = !edit.showPassword" class="absolute right-2 top-2 text-gray-500">
                                <svg x-show="!edit.showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="edit.showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm">Konfirmasi Password</label>
                        <div class="relative">
                            <input :type="edit.showPasswordConfirm ? 'text' : 'password'" name="password_confirmation" x-model="edit.password_confirmation" class="w-full border rounded px-2 py-2" placeholder="konfirmasi">
                            <button type="button" @click="edit.showPasswordConfirm = !edit.showPasswordConfirm" class="absolute right-2 top-2 text-gray-500">
                                <svg x-show="!edit.showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="edit.showPasswordConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-2 grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-sm">Kode</label>
                        <input type="text" name="phone_code" x-model="edit.phone_code" class="w-full border rounded px-2 py-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm">Nomor Telepon</label>
                        <input type="text" name="phone_number" x-model="edit.phone_number" class="w-full border rounded px-2 py-2">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-sm">Role</label>
                    <select name="role" x-model="edit.role" class="w-full border rounded px-2 py-2">
                        <option value="User">User</option>
                        <option value="Operator">Operator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <button type="button" @click="closeEdit()" class="px-3 py-2 border rounded">Batal</button>

                    <div class="flex gap-2">
                        <button type="button" @click="confirmReset(edit.id)" class="px-3 py-2 bg-amber-500 text-white rounded">Reset PW</button>
                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function userIndex(){
    return {
        // UI state
        showAdd: false,
        showEdit: false,

        // sorting
        sort_by: '{{ $sortBy }}',
        sort_dir: '{{ $sortDir }}',

        // forms
        add: { first_name:'', last_name:'', email:'', phone_code:'', phone_number:'', role:'User', password:'', password_confirmation:'', showPassword:false, showPasswordConfirm:false },
        edit: { id:null, first_name:'', last_name:'', email:'', phone_code:'', phone_number:'', role:'', password:'', password_confirmation:'', showPassword:false, showPasswordConfirm:false },

        // flags
        emailEdited: false,

        // errors
        errors: {},

        // edit action
        editAction: '',

        openAddModal(){
            this.resetForm();
            this.showAdd = true;
            this.$nextTick(()=> this.$refs.firstInput && this.$refs.firstInput.focus());
        },
        closeAdd(){
            this.showAdd = false;
            this.resetErrors();
        },

        openEditModal(payload){
            this.resetErrors();

            // payload may be an Event (when called from the button) or an object
            let user = null;
            try {
                if (payload && payload.currentTarget && payload.currentTarget.dataset && payload.currentTarget.dataset.user) {
                    user = JSON.parse(payload.currentTarget.dataset.user);
                } else {
                    user = payload;
                }
            } catch (e) {
                console.error('Failed to parse user payload for edit modal', e);
                user = payload;
            }

            // ensure we have an object
            user = user || {};

            this.edit = {
                id: user.id ?? null,
                first_name: user.first_name ?? '',
                last_name: user.last_name ?? '',
                email: user.email ?? '',
                phone_code: user.phone_code ?? '',
                phone_number: user.phone_number ?? '',
                role: user.role ?? 'User',
                password: '',
                password_confirmation: '',
                showPassword: false,
                showPasswordConfirm: false
            };

            this.editAction = '/master/user/' + (user.id ?? '');
            this.showEdit = true;
            this.$nextTick(()=> this.$refs.editFirst && this.$refs.editFirst.focus());
        },
        closeEdit(){
            this.showEdit = false;
            this.resetErrors();
        },

        resetForm(){
            this.add = { first_name:'', last_name:'', email:'', phone_code:'', phone_number:'', role:'User', password:'', password_confirmation:'', showPassword:false, showPasswordConfirm:false };
            this.emailEdited = false;
            this.resetErrors();
        },

        resetErrors(){
            this.errors = {};
        },

        // when name changes, auto-generate email if user hasn't edited email manually
        onNameChange(){
            if(this.emailEdited) return;
            let f = (this.add.first_name || '').trim().toLowerCase().replace(/\s+/g,'');
            let l = (this.add.last_name || '').trim().toLowerCase().replace(/\s+/g,'');
            if(f || l){
                this.add.email = `${f || 'user'}.${l || 'user'}@timbang.com`;
            } else {
                this.add.email = '';
            }
        },

        // client-side sort toggle -> reload with querystring
        sort(column){
            let dir = 'asc';
            if(this.sort_by === column){
                dir = this.sort_dir === 'asc' ? 'desc' : 'asc';
            }
            // build new URL keeping other query params
            const url = new URL(window.location.href);
            url.searchParams.set('sort_by', column);
            url.searchParams.set('sort_dir', dir);
            window.location.href = url.toString();
        },

        // Submit Add via AJAX
        async submitAdd(e){
            this.resetErrors();
            const form = e.target;
            const data = new FormData(form);

            const res = await fetch(form.action, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                body: data
            });

            if(res.status === 422){
                const json = await res.json();
                this.errors = json.errors || {};
                // keep modal open
                this.showAdd = true;
                return;
            }

            if(!res.ok){
                Swal.fire('Error','Gagal menambahkan user','error');
                return;
            }

            Swal.fire('Berhasil','User berhasil ditambahkan','success').then(()=> location.reload());
        },

        // Submit Edit via AJAX (uses PUT)
        async submitEdit(e){
            this.resetErrors();
            const form = e.target;
            // build FormData and include _method=PUT
            const data = new FormData(form);
            data.set('_method', 'PUT');

            const res = await fetch(this.editAction, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                body: data
            });

            if(res.status === 422){
                const json = await res.json();
                this.errors = json.errors || {};
                this.showEdit = true;
                return;
            }

            if(!res.ok){
                Swal.fire('Error','Gagal mengupdate user','error');
                return;
            }

            Swal.fire('Berhasil','User berhasil diperbarui','success').then(()=> location.reload());
        },

        // Confirm reset password (lock icon)
        confirmReset(id){
            Swal.fire({
                title: 'Reset password?',
                text: 'Password akan di-set ke "password123".',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, reset'
            }).then(async (res) => {
                if(!res.isConfirmed) return;
                try {
                    const response = await fetch(`/master/user/${id}/reset-password`, {
                        method: 'POST',
                        headers: {'Content-Type':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                        body: JSON.stringify({})
                    });
                    const json = await response.json();
                    Swal.fire('Berhasil', json.message || 'Password telah direset ke password123', 'success');
                } catch (e) {
                    Swal.fire('Error','Gagal mereset password','error');
                }
            });
        }

    };
}
</script>

<!-- SweetAlert for server-side flash -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}" });
    @endif

    // If backend redirected with validation errors and with old input, optionally we could reopen modal.
    @if($errors->any())
        // show a generic validation alert (AJAX handles most cases); user can re-open modal if needed
        // If you prefer auto-open modal on server validation, the controller should return JSON or session flag.
        console.log('Validation errors: check form fields');
    @endif
});
</script>

<!-- Confirm delete -->
<script>
function confirmDelete(formId){
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Aksi ini tidak dapat dibatalkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>

@endpush

</x-admin-layout>
