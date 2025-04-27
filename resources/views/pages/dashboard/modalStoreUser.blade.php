<div id="modalStoreUser" class="fixed inset-0 z-40 bg-black/30 backdrop-blur-md hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-6 w-full max-w-md bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-lg relative">

        <button class="btnStoreUser absolute top-4 right-4 text-2xl font-bold text-gray-400 hover:text-red-500">
            ×
        </button>

        <h1 class="text-2xl font-bold text-center">Store User</h1>

        <form id="formStoreUser" data-action="{{ route('backend.users.store', ['id' => 'userId']) }}"
            action="{{ route('backend.users.store', ['id' => 'userId']) }}" method="POST"
            class="flex flex-col gap-4 w-full">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="username" class="text-base font-semibold">Username:</label>
                <input type="text" name="username" id="username" placeholder="Input Username"
                    class="text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('username') }}" required>
            </div>

            <div class="flex flex-col gap-2">
                <label for="role" class="text-base font-semibold">Role:</label>
                <select name="role" id="role"
                    class="text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="admin">Admin</option>
                    <option value="tasker">Tasker</option>
                    <option value="worker">Worker</option>
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-base font-semibold">Password:</label>
                <input type="password" name="password" placeholder="Input Password"
                    class="inputPassword text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex flex-col gap-2">
                <label for="password" class="text-base font-semibold">Password:</label>
                <input type="password" name="password" placeholder="Input Password"
                    class="inputPassword text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex gap-[8px]">
                <input type="checkbox" id="showPasswordStoreUser">
                <label for="showPasswordStoreUser">Show Password</label>
            </div>

            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                Simpan
            </button>
        </form>
    </div>
</div>

<script>
    let modalStoreUser = document.getElementById('modalStoreUser');
    let btnStoreUser = document.querySelectorAll('.btnStoreUser');
    let formStoreUser = document.getElementById('formStoreUser');
    let dataAction = formStoreUser.dataset.action;
    let inputPassword = document.querySelectorAll('.inputPassword')
    let showPassword = document.getElementById('showPasswordStoreUser');
    let inputUsername = document.getElementById('username')
    let inputRole = document.getElementById('role')
    let userId = null;

    btnStoreUser.forEach((btn) => {
        btn.addEventListener('click', function () {
            formStoreUser.action = dataAction;
            inputUsername.value = '';
            if (btn.dataset.userId && btn.dataset.role && btn.dataset.username) {
                console.log(btn.dataset)
                inputUsername.value = btn.dataset.username;
                inputRole.value = btn.dataset.role;
                userId = btn.dataset.userId;
                formStoreUser.action = formStoreUser.action.replace('userId', userId);
            } else {
                formStoreUser.action = dataAction.replace('userId', '');
            }
            modalStoreUser.classList.toggle('hidden');
            modalStoreUser.classList.toggle('flex');
        });
    });

    showPassword.addEventListener('change', function () {
        if (showPassword.checked) {
            inputPassword.forEach(input => {
                input.setAttribute('type', 'text')
            })
        } else {
            inputPassword.forEach(input => {
                input.setAttribute('type', 'password')
            })
        }
    });
</script>
