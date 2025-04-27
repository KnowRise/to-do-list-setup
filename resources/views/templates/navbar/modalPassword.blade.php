{{-- resources/views/templates/navbar/modalPassword.blade.php --}}
<div id="modalPassword"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-[rgba(0,0,0,0.5)] backdrop-blur-sm">
    <div class="bg-gray-800 text-gray-200 rounded-xl shadow-xl w-full max-w-md p-6 relative">
        <button class="btnPassword absolute top-4 right-4 text-2xl text-gray-400 hover:text-red-500">&times;</button>
        <h2 class="text-xl font-bold mb-4">Change Password</h2>
        <form method="POST" action="{{ route('backend.users.store', auth()->user()->id) }}" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block mb-1">New Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 inputPassword" />
            </div>
            <div>
                <label for="password_confirmation" class="block mb-1">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 inputPassword" />
            </div>
            <div class="flex items-center gap-2">
                <input id="showPassword" type="checkbox" class="h-4 w-4" />
                <label for="showPassword">Show Password</label>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                Submit
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modalPassword')
        document.querySelectorAll('.btnPassword').forEach(btn =>
            btn.addEventListener('click', () => {
                modal.classList.toggle('hidden')
                modal.classList.toggle('flex')
            })
        )

        const inputs = document.querySelectorAll('.inputPassword')
        const toggle = document.getElementById('showPassword')
        toggle.addEventListener('change', () => {
            inputs.forEach(i => i.type = toggle.checked ? 'text' : 'password')
        })
    })
</script>
