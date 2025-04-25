<div id="modalProfile"
    class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px] bg-[#eeeeee]">
        <div class="flex justify-end w-full">
            <button class="btnProfile text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</button>
        </div>
        <h1 class="text-[32px] font-bold">Profile</h1>
        <form action="{{ route('backend.users.store', ['id' => auth()->user()->id]) }}" method="POST" class="flex flex-col gap-[16px] w-full" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-[8px]">
                <label for="username" class="text-[20px]">Username:</label>
                <input type="text" name="username" id="username" placeholder="Input Username"
                    class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" value="{{ auth()->user()->username }}"
                    required>
            </div>
            <div class="flex flex-col gap-[8px]">
                <input type="file" name="profile" id="file" accept=".jpg, .png, .svg, .jpeg" class="hidden">
                <label for="file" class="flex items-center">
                    <img src="{{ asset('icons/upload_file.svg') }}" alt="Profile" width="30" height="30">
                    <p>Input Profile (Optional)</p>
                </label>
            </div>
            <input type="hidden" name="role" value="{{ auth()->user()->role }}">
            <button
                class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Submit</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let modalProfile = document.getElementById('modalProfile');
        let btnProfile = document.querySelectorAll('.btnProfile');

        btnProfile.forEach(btn => {
            btn.addEventListener('click', function() {
                modalProfile.classList.toggle('hidden')
                modalProfile.classList.toggle('flex')
            })
        });
    });
</script>
