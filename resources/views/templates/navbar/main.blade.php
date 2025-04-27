{{-- resources/views/templates/navbar/main.blade.php --}}
<div class="flex justify-between items-center w-full bg-gray-800 text-gray-200 px-6 py-4 shadow-md relative">
    <a href="{{ route('dashboard') }}" class="text-2xl font-bold">TaskFlow</a>
    <div class="flex items-center gap-4 relative">
      <span class="font-medium">{{ auth()->user()->username }}</span>
      <img id="profile" src="{{ asset('storage/' . auth()->user()->profile) }}"
           alt="Profile"
           class="w-10 h-10 rounded-full ring-2 ring-offset-2 ring-gray-600 cursor-pointer" />

      <ul id="dropdown"
          class="absolute top-full right-0 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-lg shadow-lg divide-y divide-gray-700 hidden flex-col z-50">
        <li>
          <button class="btnProfile w-full text-left px-4 py-2 hover:bg-gray-700">Profile</button>
        </li>
        <li>
          <button class="btnPassword w-full text-left px-4 py-2 hover:bg-gray-700">Password</button>
        </li>
        <li>
          <form action="{{ route('backend.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    onclick="return confirm('Are you sure want to logout?')"
                    class="w-full text-left px-4 py-2 hover:bg-red-700 hover:text-white">
              Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>

  @include('templates.navbar.modalProfile')
  @include('templates.navbar.modalPassword')

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const profile = document.getElementById('profile')
    const dropdown = document.getElementById('dropdown')

    profile.addEventListener('click', e => {
      dropdown.classList.toggle('hidden')
      dropdown.classList.toggle('flex')
    })

    window.addEventListener('click', e => {
      if (dropdown.classList.contains('flex')
          && !profile.contains(e.target)
          && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden')
        dropdown.classList.remove('flex')
      }
    })
  })
  </script>
