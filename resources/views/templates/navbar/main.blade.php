<div class="flex justify-between h-fit w-full border-b border-gray-400 p-[16px] shadow-[10px_0px_10px_10px_rgba(0,0,0,0.25)]">
    <a href="{{ route('dashboard') }}" class="text-[32px] font-bold">TaskFlow</a>
    <div class="flex items-center gap-[16px]">
        <h2>{{ auth()->user()->username }}</h2>
        <img id="profile" src="{{ asset('storage/' . auth()->user()->profile) }}" alt="Profile" class="rounded-full w-[40px] h-[40px] object-cover">
        <ul id="dropdown" class="absolute hidden flex-col top-[80px] right-1 border rounded-[8px] bg-[#eeeeee]">
            <li><button
                    class="btnProfile py-[4px] px-[16px] hover:bg-[#3A59D1] w-full cursor-pointer hover:text-[#eeeeee]">Profile</button>
            </li>
            <li><button
                    class="btnPassword py-[4px] px-[16px] hover:bg-[#3A59D1] w-full cursor-pointer hover:text-[#eeeeee]">Password</button>
            </li>
            <li>
                <form action="{{ route('backend.logout') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure wanna Logout?')"
                    class="py-[4px] px-[16px] hover:bg-[#C5172E] w-full cursor-pointer hover:text-[#eeeeee]">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>
@include('templates.navbar.modalProfile')
@include('templates.navbar.modalPassword')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let profile = document.getElementById('profile');
        let dropdown = document.getElementById('dropdown');

        profile.addEventListener('click', function() {
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('flex');
        });

        window.addEventListener('click', function(event) {
            if (!profile.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
                dropdown.classList.remove('flex');
            }
        });
    });
</script>
