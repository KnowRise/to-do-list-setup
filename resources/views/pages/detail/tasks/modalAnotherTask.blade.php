<div id="modalCopyTask" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-md hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-6 w-full max-w-[75vh] bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-lg relative">

        <button type="button" id="btnCloseModalCopyTask"
            class="absolute top-4 right-4 text-2xl font-bold text-gray-400 hover:text-red-500 cursor-pointer">
            ×
        </button>

        <h1 class="text-2xl font-bold text-center">Choose Task</h1>

        <form id="copyTaskForm" action="{{ route('backend.tasks.users.copy', ['id' => $task->id]) }}" method="POST"
            class="flex flex-col gap-4 w-full">
            @csrf
            <div class="flex flex-col gap-2">
                <label for="task_id" class="text-base font-semibold">Pilih Task:</label>
                <select name="task_id" id="task_id"
                    class="w-full text-base border border-gray-700 rounded-lg px-4 py-2 bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-200">
                </select>
            </div>

            <input type="hidden" name="job_id" value="{{ $task->job_id }}">

            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                Submit
            </button>
        </form>
    </div>
</div>

<script>
    const modalCopyTask = document.getElementById('modalCopyTask');
    const btnCloseModalCopyTask = document.getElementById('btnCloseModalCopyTask');
    const copyTaskForm = document.getElementById('copyTaskForm');
    const taskSelect = document.getElementById('task_id');
    const fetchTaskUrl = '{{ route('backend.tasks') }}';

    // Fungsi buat buka modal
    function openModalCopyTask() {
        modalCopyTask.classList.remove('hidden');
        modalCopyTask.classList.add('flex');

        fetch(fetchTaskUrl)
            .then(response => response.json())
            .then(tasks => {
                console.log(tasks);
                taskSelect.innerHTML = ''; // Kosongin dulu

                tasks.forEach(task => {
                    let option = document.createElement('option');
                    option.value = task.id;
                    option.textContent = `Task: ${task.title} - Job: ${task.job.title}`; ;
                    taskSelect.appendChild(option);
                });

                // Refresh select2
                $('#task_id').select2({
                    placeholder: "Pilih task...",
                    allowClear: true,
                    tags: true,
                });
            })
            .catch(error => {
                console.error('Error fetch users:', error);
            });

    }

    btnCloseModalCopyTask.addEventListener('click', function () {
        modalCopyTask.classList.add('hidden');
        modalCopyTask.classList.remove('flex');
    });
</script>

<style>
    .select2-container .select2-selection {
        background-color: #1f2937;
        /* bg-gray-800 */
        color: #1d1d1d;
        /* text-gray-300 */
        border: 1px solid #4b5563;
        /* border-gray-700 */
    }

    .select2-dropdown {
        background-color: #1f2937;
        /* Dropdown list background */
        color: #d1d5db;
        /* Dropdown text */
    }

    .select2-results__option--highlighted {
        background-color: #2563eb;
        /* Biru saat hover */
        color: white;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #2563eb;
        /* ini warna background item yang udah dipilih */
        color: white;
        /* ini warna teks item yang udah dipilih */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        background-color: #4b5563;
        color: #d1d5db;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #4b5563;
        color: white;
    }
</style>
