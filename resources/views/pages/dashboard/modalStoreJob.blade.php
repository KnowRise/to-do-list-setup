<div id="modalNewJob"
    class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] hidden justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px] bg-[#eeeeee]">
        <div class="flex justify-end w-full">
            <button class="btnNewJob text-[32px] font-bold cursor-pointer hover:text-[#C5172E]">X</button>
        </div>
        <h1 class="text-[32px] font-bold">Store Job</h1>
        <form id="formNewJob" action="{{ route('backend.jobs.store') }}" method="POST" class="flex flex-col gap-[16px] w-full">
            @csrf
            <div class="flex flex-col gap-[8px]">
                <label for="title" class="text-[20px]">Title:</label>
                <input type="text" name="title" id="title" placeholder="Input Title"
                    class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full" value="{{ old('title') }}"
                    required>
            </div>
            <div class="flex flex-col gap-[8px]">
                <label for="description" class="text-[20px]">Description:</label>
                <input type="text" name="description" id="description" placeholder="Input Description"
                    class="inputPassword text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full">
            </div>
            <button
                class="text-[16px] border py-[4px] px-[8px] rounded-[8px] w-full bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Submit</button>
         </form>
    </div>
</div>
<script>
    let modalNewJob = document.getElementById('modalNewJob');
    let btnNewJob = document.querySelectorAll('.btnNewJob');

    btnNewJob.forEach(btn => {
        btn.addEventListener('click', function () {
            modalNewJob.classList.toggle('hidden');
            modalNewJob.classList.toggle('flex');
        });
    });
</script>
