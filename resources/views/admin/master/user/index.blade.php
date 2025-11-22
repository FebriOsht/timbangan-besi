<x-admin-layout title="Data User">

<div 
    x-data="{ 
        addModal: false, 
        editModal: false, 
        editId: null, 
        editName: '', 
        editRole: '' 
    }"
>

    <!-- HEADER -->
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Data User</h2>

        <button @click="addModal = true" class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah User
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-3 px-2">No</th>
                    <th class="py-3 px-2">Nama User</th>
                    <th class="py-3 px-2">Role</th>
                    <th class="py-3 px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $u)
                <tr class="border-b">

                    <td class="py-3 px-2">{{ $loop->iteration }}</td>
                    <td class="py-3 px-2">{{ $u->name }}</td>

                    <!-- ROLE BADGE -->
                    <td class="py-3 px-2">
                        <span class="px-3 py-1 rounded text-white text-sm
                            {{
                                [
                                    'Admin'     => 'bg-red-600',
                                    'Operator'  => 'bg-blue-600',
                                    'User'      => 'bg-green-600'
                                ][$u->role] ?? 'bg-gray-500'
                            }}">
                            {{ $u->role }}
                        </span>
                    </td>

                    <!-- ACTIONS -->
                    <td class="py-3 px-2 flex justify-center gap-2">

                        <!-- EDIT -->
                        <button 
                            class="bg-blue-600 text-white px-3 py-1 rounded"
                            @click="
                                editModal = true;
                                editId   = {{ $u->id }};
                                editName = {{ json_encode($u->name) }};
                                editRole = {{ json_encode($u->role) }};
                            "
                        >
                            ✎
                        </button>

                        <!-- DELETE -->
                        <form 
                            id="delete-{{ $u->id }}" 
                            action="{{ route('master.user.destroy', $u->id) }}" 
                            method="POST"
                        >
                            @csrf 
                            @method('DELETE')

                            <button 
                                type="button"
                                onclick="confirmDelete('delete-{{ $u->id }}')" 
                                class="bg-red-600 text-white px-3 py-1 rounded"
                            >
                                🗑
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAL: ADD -->
    <div 
        x-show="addModal"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center"
    >
        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="addModal = false">

            <h2 class="font-bold mb-4">Tambah User</h2>

            <form action="{{ route('master.user.store') }}" method="POST">
                @csrf

                <label>Nama</label>
                <input type="text" name="name" class="w-full border p-2 rounded mb-3">

                <label>Role</label>
                <select name="role" class="w-full border p-2 rounded mb-3">
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                    <option value="User">User</option>
                </select>

                <button class="bg-green-600 text-white px-3 py-2 rounded w-full">
                    Simpan
                </button>
            </form>

            <button 
                @click="addModal = false" 
                class="mt-2 text-sm text-gray-500"
            >
                Tutup
            </button>

        </div>
    </div>

    <!-- MODAL: EDIT -->
    <div 
        x-show="editModal"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center"
    >
        <div class="bg-white p-6 rounded shadow-lg w-96" @click.outside="editModal = false">

            <h2 class="font-bold mb-4">Edit User</h2>

            <form :action="'/master/user/' + editId" method="POST">
                @csrf
                @method('PUT')

                <label>Nama</label>
                <input 
                    type="text" 
                    name="name" 
                    x-model="editName" 
                    class="w-full border p-2 rounded mb-3"
                >

                <label>Role</label>
                <select 
                    name="role" 
                    x-model="editRole" 
                    class="w-full border p-2 rounded mb-3"
                >
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                    <option value="User">User</option>
                </select>

                <button class="bg-blue-600 text-white px-3 py-2 rounded w-full">
                    Update
                </button>
            </form>

            <button 
                @click="editModal = false" 
                class="mt-2 text-sm text-gray-500"
            >
                Tutup
            </button>

        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data user tidak dapat dikembalikan!",
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
