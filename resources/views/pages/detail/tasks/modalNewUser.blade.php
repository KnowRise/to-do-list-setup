<div id="modalStoreUser" class="fixed inset-0 z-40 bg-black/30 backdrop-blur-md hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-6 w-full max-w-[75vh] bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-lg relative">

        <button id="btnCloseModal" class="absolute top-4 right-4 text-2xl font-bold text-gray-400 hover:text-red-500">
            ×
        </button>

        <h1 class="text-2xl font-bold text-center">Store User</h1>

        <button type="button" onclick="openModalCopyTask()"
            class="text-base border border-gray-700 py-2 px-4 rounded-lg w-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-all text-center cursor-pointer">
            Copy From Another Task
        </button>

        <form id="storeUserForm" action="{{ route('backend.tasks.users.store', ['id' => $task->id]) }}" method="POST"
            class="flex flex-col gap-4 w-full">
            @csrf
            <div class="flex flex-col gap-2">
                <label for="user_id" class="text-base font-semibold">Pilih User:</label>
                <select name="user_id[]" id="user_id" multiple
                    class="w-full text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-200">
                </select>
            </div>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                Submit
            </button>
        </form>
    </div>
</div>

<script>
    const modalStoreUser = document.getElementById('modalStoreUser');
    const btnCloseModal = document.getElementById('btnCloseModal');
    const userSelect = document.getElementById('user_id');
    const storeUserForm = document.getElementById('storeUserForm');

    // Ganti URL ini sesuai nanti
    const fetchUsersUrl = '{{ route('backend.users') }}';

    // Untuk nampil modal
    function openModalStoreUser(jobId) {
        modalStoreUser.classList.remove('hidden');
        modalStoreUser.classList.add('flex');

        // Fetch data user
        fetch(fetchUsersUrl + '?role=worker')
            .then(response => response.json())
            .then(users => {
                userSelect.innerHTML = ''; // Kosongin dulu

                users.forEach(user => {
                    let option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.username;
                    userSelect.appendChild(option);
                });

                // Refresh select2
                $('#user_id').select2({
                    placeholder: "Pilih user...",
                    allowClear: true,
                    tags: true,
                });
            })
            .catch(error => {
                console.error('Error fetch users:', error);
            });
    }

    // Close modal
    btnCloseModal.addEventListener('click', function () {
        modalStoreUser.classList.add('hidden');
        modalStoreUser.classList.remove('flex');
    });
</script>
<style>
    .select2-container .select2-selection {
        background-color: #1f2937;
        /* bg-gray-800 */
        color: #1d1d1d;
        /* text-gray-300 */
        border: 1px solid #4b5563;
        /* border-gray-700 */
    }

    .select2-dropdown {
        background-color: #1f2937;
        /* Dropdown list background */
        color: #d1d5db;
        /* Dropdown text */
    }

    .select2-results__option--highlighted {
        background-color: #2563eb;
        /* Biru saat hover */
        color: white;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #2563eb;
        /* ini warna background item yang udah dipilih */
        color: white;
        /* ini warna teks item yang udah dipilih */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        background-color: #4b5563;
        color: #d1d5db;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4b5563;
        color: white;
    }
</style>
