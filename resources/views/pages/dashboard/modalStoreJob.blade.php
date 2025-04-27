<div id="modalStoreJob" class="fixed inset-0 z-40 bg-black/30 backdrop-blur-md hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-6 w-full max-w-md bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-lg relative">

        <button class="btnStoreJob absolute top-4 right-4 text-2xl font-bold text-gray-400 hover:text-red-500">
            ×
        </button>

        <h1 class="text-2xl font-bold text-center">Store job</h1>

        <form id="formStoreJob" action="{{ route('backend.jobs.store') }}" method="POST"
            class="flex flex-col gap-4 w-full">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="title" class="text-base font-semibold">Title:</label>
                <input type="text" name="title" id="titleJob" placeholder="Input Title"
                    class="text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description" class="text-base font-semibold">Description:</label>
                <textarea type="text" name="description" id="descriptionJob" placeholder="Input Description"
                    class="text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required></textarea>
            </div>

            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                Submit
            </button>
        </form>
    </div>
</div>
<script>
    let modalStoreJob = document.getElementById('modalStoreJob');
    let btnStoreJob = document.querySelectorAll('.btnStoreJob');

    btnStoreJob.forEach(btn => {
        btn.addEventListener('click', function () {
            modalStoreJob.classList.toggle('hidden');
            modalStoreJob.classList.toggle('flex');
        });
    });
</script>
