<div id="modalMessage" class="absolute inset-0 z-1 bg-[rgba(238,238,238,0.5)] backdrop-blur-[10px] flex justify-center items-center">
    <div class="flex flex-col justify-center items-center gap-[16px] max-w-[75vh] max-h-[60vh] min-w-[50vh] min-h-fit border p-[32px] rounded-[16px]">
        <h1 class="text-[32px] font-bold">{{ Session::has('message') ? 'Message' : 'Error' }}</h1>
        <p class="text-[20px]">{{ Session::get('message') }}{{ $errors->first() }}</p>
        <button id="btnModalMessage" class="text-[20px] py-[8px] w-full border rounded-[8px] bg-[#3D90D7] text-[#eeeeee] font-bold hover:bg-[#3A59D1] cursor-pointer">Ok</button>
    </div>
</div>
<script>
    let modalMessage = document.getElementById('modalMessage');
    let btnModalMessage = document.getElementById('btnModalMessage');

    btnModalMessage.addEventListener('click', function() {
        modalMessage.classList.add('hidden');
        modalMessage.classList.remove('flex');
    });
</script>
