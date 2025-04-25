<div id="modalPassword"
    class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px] bg-[#eeeeee]">
        <div class="flex justify-end w-full">
            <button class="btnPassword text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</button>
        </div>
        <h1 class="text-[32px] font-bold">Profile</h1>
        <form action="{{ route('backend.users.store', ['id' => auth()->user()->id]) }}" method="POST"
            class="flex flex-col gap-[16px] w-full" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-[8px]">
                <label for="password" class="text-[20px]">Password:</label>
                <input type="password" name="password" id="password" placeholder="Input password"
                    class="inputPassword text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" required>
            </div>
            <div class="flex flex-col gap-[8px]">
                <label for="password_confirmation" class="text-[20px]">Password Confirmation:</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Input Password Confirmation"
                    class="inputPassword text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" required>
            </div>
            <div class="flex gap-[8px]">
                <input type="checkbox" id="showPassword">
                <label for="showPassword">Show Password</label>
            </div>
            <input type="hidden" name="role" value="{{ auth()->user()->role }}">
            <button
                class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Submit</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let modalPassword = document.getElementById('modalPassword');
        let btnPassword = document.querySelectorAll('.btnPassword');
        let inputPassword = document.querySelectorAll('inputPassword');
        let showPassword = document.getElementById('showPassword');

        btnPassword.forEach(btn => {
            btn.addEventListener('click', function() {
                modalPassword.classList.toggle('hidden')
                modalPassword.classList.toggle('flex')
            })
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
    });
</script>
