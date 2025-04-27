<div id="modalDetailUserTask"
    class="fixed inset-0 z-40 bg-black/30 backdrop-blur-md hidden justify-center items-center">
    <div class="w-full max-w-md bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-2xl flex flex-col gap-6 relative">
        <!-- Tombol Close -->
        <div class="absolute top-4 right-4">
            <button class="btnModalDetailUserTask text-2xl font-bold hover:text-red-500">X</button>
        </div>

        <!-- Judul Modal -->
        <h1 class="text-2xl font-bold text-center">Detail Progress User</h1>

        <!-- Info User -->
        <div class="flex flex-col gap-2 text-left">
            <p class="text-base text-gray-400">Username: <span id="modalUsername"
                    class="font-semibold text-gray-200"></span></p>
            <p class="text-base text-gray-400">Status: <span id="modalStatus"
                    class="font-semibold text-gray-200"></span></p>
        </div>

        <!-- Worker Content -->
        <div id="workerContent" class="hidden">
            <div id="workerCompletedInfo" class="hidden flex-col gap-3 text-left">
                <p class="text-base">Completed At: <span id="modalCompletedAt" class="font-semibold"></span></p>
                <a id="modalFileLink" href="#" target="_blank" class="text-base underline hover:text-blue-400">View
                    Uploaded File</a>
                <p id="modalFeedback" class="text-base text-gray-200 hidden"></p>
            </div>

            <form id="workerUploadForm" action="{{ route('backend.tasks.submit', ['id' => 'userTaskId']) }}"
                method="POST" enctype="multipart/form-data" class="hidden flex-col gap-4 text-left">
                @csrf
                <label for="fileUserTask"
                    class="flex flex-col items-center gap-2 cursor-pointer border-2 border-dashed border-gray-500 rounded-lg p-4 hover:border-blue-400">
                    <img src="{{ asset('icons/upload_file.svg') }}" alt="Upload File" width="40" height="40">
                    <span class="text-base">Click to Upload File</span>
                    <input type="file" name="file" id="fileUserTask" accept=".jpg, .png, .svg, .jpeg" class="hidden">
                </label>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 rounded-lg py-2 px-4 font-semibold text-base">Submit
                    File</button>
            </form>
        </div>

        <!-- Tasker Content -->
        <div id="taskerContent" class="hidden">
            <div id="taskerCompletedInfo" class="hidden flex-col gap-4 text-left">
                <p id="taskerFeedback" class="text-base text-gray-200 hidden"></p>
                <p class="text-base">Completed At: <span id="taskerCompletedAt" class="font-semibold"></span></p>
                <a id="taskerFileLink" href="#" target="_blank" class="text-base underline hover:text-blue-400">View
                    Uploaded File</a>

                <!-- Form Feedback -->
                <form id="taskerFeedbackForm" action="{{ route('backend.tasks.users.status', ['id' => 'userTaskId']) }}"
                    method="POST" class="flex flex-col gap-3 mt-4">
                    @csrf
                    <label class="text-base font-semibold" for="feedback">Give Feedback</label>
                    <textarea name="feedback" id="feedback" rows="3"
                        class="rounded-lg border p-2 bg-gray-700 text-gray-200 placeholder-gray-400 text-base"
                        placeholder="Type feedback here..."></textarea>

                    <label class="text-base font-semibold" for="status">Change Status</label>
                    <select name="status" id="status" class="rounded-lg border p-2 bg-gray-700 text-gray-200 text-base">
                        <option value="rejected">Reject</option>
                        <option value="approved">Approve</option>
                    </select>

                    <button type="submit" onclick="return confirm('Are you sure?')"
                        class="bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg font-semibold text-base mt-2">
                        Submit Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let modalDetailUserTask = document.getElementById('modalDetailUserTask');
    let btnModalDetailUserTask = document.querySelectorAll('.btnModalDetailUserTask');

    function resetModalDetailUserTask() {
        // Reset teks kosong
        document.getElementById('modalUsername').textContent = '';
        document.getElementById('modalStatus').textContent = '';
        document.getElementById('modalCompletedAt').textContent = '';
        document.getElementById('taskerCompletedAt').textContent = '';
        document.getElementById('modalFeedback').textContent = '';
        document.getElementById('taskerFeedback').textContent = '';

        // Reset href link
        document.getElementById('modalFileLink').href = '#';
        document.getElementById('taskerFileLink').href = '#';

        // Reset form action
        document.getElementById('workerUploadForm').action = "{{ route('backend.tasks.submit', ['id' => 'userTaskId']) }}";
        document.getElementById('taskerFeedbackForm').action = "{{ route('backend.tasks.users.status', ['id' => 'userTaskId']) }}";

        // Sembunyikan semua konten
        document.getElementById('workerContent').classList.add('hidden');
        document.getElementById('workerCompletedInfo').classList.add('hidden');
        document.getElementById('workerCompletedInfo').classList.remove('flex');
        document.getElementById('workerUploadForm').classList.add('hidden');
        document.getElementById('workerUploadForm').classList.remove('flex');

        document.getElementById('taskerContent').classList.add('hidden');
        document.getElementById('taskerCompletedInfo').classList.add('hidden');
        document.getElementById('taskerCompletedInfo').classList.remove('flex');

        // Sembunyikan feedback juga
        document.getElementById('modalFeedback').classList.add('hidden');
        document.getElementById('taskerFeedback').classList.add('hidden');

        // Reset textarea dan select
        document.getElementById('feedback').value = '';
        document.getElementById('status').selectedIndex = 0;
    }

    btnModalDetailUserTask.forEach(btn => {
        btn.addEventListener('click', function () {
            resetModalDetailUserTask();
            if (btn.dataset.userTask) {
                try {
                    let data = JSON.parse(btn.dataset.userTask);
                    const userRole = "{{ auth()->user()->role }}";

                    // Set basic info
                    document.getElementById('modalUsername').textContent = data.user.username;
                    document.getElementById('modalStatus').textContent = data.status;

                    if (userRole === 'worker') {
                        document.getElementById('workerContent').classList.remove('hidden');

                        if (['completed', 'approved'].includes(data.status)) {
                            document.getElementById('workerCompletedInfo').classList.remove('hidden');
                            document.getElementById('workerCompletedInfo').classList.add('flex');
                            document.getElementById('modalCompletedAt').textContent = data.completed_at;
                            document.getElementById('modalFileLink').href = '/storage/' + data.file_path;

                            if (data.status !== 'completed' && data.feedback) {
                                document.getElementById('modalFeedback').textContent = `Feedback: ${data.feedback}`;
                                document.getElementById('modalFeedback').classList.remove('hidden');
                            }
                        } else if (data.status === 'rejected') {
                            document.getElementById('workerUploadForm').classList.remove('hidden');
                            document.getElementById('workerUploadForm').classList.add('flex');
                            document.getElementById('workerUploadForm').action = document.getElementById('workerUploadForm').action.replace('userTaskId', data.id);

                            if (data.feedback) {
                                document.getElementById('modalFeedback').textContent = `Feedback: ${data.feedback}`;
                                document.getElementById('modalFeedback').classList.remove('hidden');
                            }
                        } else {
                            document.getElementById('workerUploadForm').classList.remove('hidden');
                            document.getElementById('workerUploadForm').classList.add('flex');
                            document.getElementById('workerUploadForm').action = document.getElementById('workerUploadForm').action.replace('userTaskId', data.id);
                        }
                    } else if (userRole === 'tasker') {
                        document.getElementById('taskerContent').classList.remove('hidden');

                        if (['completed', 'approved', 'rejected'].includes(data.status)) {
                            document.getElementById('taskerCompletedInfo').classList.remove('hidden');
                            document.getElementById('taskerCompletedInfo').classList.add('flex');
                            document.getElementById('taskerCompletedAt').textContent = data.completed_at;
                            document.getElementById('taskerFileLink').href = '/storage/' + data.file_path;
                            document.getElementById('taskerFeedbackForm').action = document.getElementById('taskerFeedbackForm').action.replace('userTaskId', data.id);

                            if (data.status !== 'completed' && data.feedback) {
                                document.getElementById('taskerFeedback').textContent = 'Feedback: ' + data.feedback;
                                document.getElementById('taskerFeedback').classList.remove('hidden');
                            }
                        }
                    }
                } catch (e) {
                    console.error('Error parsing user task data:', e);
                }
            }

            modalDetailUserTask.classList.toggle('hidden');
            modalDetailUserTask.classList.toggle('flex');
        });
    });
</script>
