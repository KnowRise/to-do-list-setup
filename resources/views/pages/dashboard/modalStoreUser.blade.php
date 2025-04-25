<div id="modalStoreUser"
    class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px] bg-[#eeeeee]">
        <div class="flex justify-end w-full">
            <button class="btnStoreUser text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</button>
        </div>
        <h1 class="text-[32px] font-bold">Store User</h1>
        <form id="formStoreUser" data-action="{{ route('backend.users.store', ['id' => 'userId']) }}" action="{{ route('backend.users.store', ['id' => 'userId']) }}" method="POST" class="flex flex-col gap-[16px] w-full">
            @csrf
            <div class="flex flex-col gap-[8px]">
                <label for="username" class="text-[20px]">Username:</label>
                <input type="text" name="username" id="username" placeholder="Input Username"
                    class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" value="{{ old('username') }}"
                    required>
            </div>
            <div class="flex flex-col gap-[8px]">
                <label for="role" class="text-[20px]">Role:</label>
                <select name="role" id="role" class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full">
                    <option value="admin">Admin</option>
                    <option value="tasker">Tasker</option>
                    <option value="worker">Worker</option>
                </select>
            </div>
            <div class="flex flex-col gap-[8px]">
                <label for="password" class="text-[20px]">Password:</label>
                <input type="password" name="password" id="password" placeholder="Input Password"
                    class="inputPassword text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full">
            </div>
            <div class="flex flex-col gap-[8px]">
                <label for="password_confirmation" class="text-[20px]">Password Confirmation:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Input Password Confirmation"
                    class="inputPassword text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full">
            </div>
            <div class="flex gap-[8px]">
                <input type="checkbox" name="showPassword" id="showPassword">
                <label for="showPassword">Show Password</label>
            </div>
            <button
                class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Submit</button>
         </form>
    </div>
</div>
<script>
    let modalStoreUser = document.getElementById('modalStoreUser');
    let btnStoreUser = document.querySelectorAll('.btnStoreUser');
    let formStoreUser = document.getElementById('formStoreUser');
    let dataAction = formStoreUser.dataset.action;
    let inputPassword = document.querySelectorAll('.inputPassword')
    let showPassword = document.getElementById('showPassword');
    let inputUsername = document.getElementById('username')
    let inputRole = document.getElementById('role')
    let userId = null;

    btnStoreUser.forEach((btn) => {
        btn.addEventListener('click', function() {
            formStoreUser.action = dataAction;
            if (btn.dataset.userId && btn.dataset.role && btn.dataset.username) {
                inputUsername.value = btn.dataset.username;
                inputRole.value = btn.dataset.role;
                userId = btn.dataset.userId;
                formStoreUser.action = formStoreUser.action.replace('userId', userId);
            } else {
                formStoreUser.action = dataAction.replace('userId', '');
            }
            console.log(formStoreUser.action)
            modalStoreUser.classList.toggle('hidden');
            modalStoreUser.classList.toggle('flex');
        });
    });

    showPassword.addEventListener('change', function() {
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
