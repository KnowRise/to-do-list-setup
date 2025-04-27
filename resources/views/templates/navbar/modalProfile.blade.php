{{-- resources/views/templates/navbar/modalProfile.blade.php --}}
<div id="modalProfile"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-[rgba(0,0,0,0.5)] backdrop-blur-sm">
    <div class="bg-gray-800 text-gray-200 rounded-xl shadow-xl w-full max-w-md p-6 relative">
        <button class="btnProfile absolute top-4 right-4 text-2xl text-gray-400 hover:text-red-500">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
        <form method="POST" action="{{ route('backend.users.store', auth()->user()->id) }}"
            enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="block mb-1">Username</label>
                <input id="username" name="username" type="text" required
                    class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ auth()->user()->username }}" />
            </div>
            <div>
                <label class="block mb-1">Profile Picture (optional)</label>
                <input id="file" name="profile" type="file" accept="image/*"
                    class="block w-full text-gray-300 bg-gray-700 border border-gray-600 rounded p-2" />
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                Save
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modalProfile')
        document.querySelectorAll('.btnProfile').forEach(btn =>
            btn.addEventListener('click', () => {
                modal.classList.toggle('hidden')
                modal.classList.toggle('flex')
            })
        )
    })
</script>
