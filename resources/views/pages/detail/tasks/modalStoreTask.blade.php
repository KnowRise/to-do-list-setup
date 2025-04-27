<div id="modalStoreTask" class="fixed inset-0 z-40 bg-black/30 backdrop-blur-md hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-6 w-full max-w-[75vh] bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-lg relative">

        <button class="btnStoreTask absolute top-4 right-4 text-2xl font-bold text-gray-400 hover:text-red-500">
            ×
        </button>

        <h1 class="text-2xl font-bold text-center">Edit Task</h1>

        <form action="{{ route('backend.tasks.store', ['id' =>  $task->id]) }}" method="POST"
            class="flex flex-col gap-4 w-full">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="title" class="text-base font-semibold">Title:</label>
                <input type="text" name="title" id="title" placeholder="Input Title"
                    class="text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ $task->title }}" required>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description" class="text-base font-semibold">Description:</label>
                <textarea rows="5" type="text" name="description" id="description" placeholder="Input Description"
                    class="text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ $task->description }} lorem100</textarea>
            </div>
            <input type="hidden" name="job_id" id="job_id" value="{{ $task->job_id }}">

            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                Submit
            </button>
        </form>
    </div>
</div>
<script>
    let modalStoreTask = document.getElementById('modalStoreTask');
    let btnStoreTask = document.querySelectorAll('.btnStoreTask');

    btnStoreTask.forEach(btn => {
        btn.addEventListener('click', function () {
            modalStoreTask.classList.toggle('hidden');
            modalStoreTask.classList.toggle('flex');
        });
    });
</script>
