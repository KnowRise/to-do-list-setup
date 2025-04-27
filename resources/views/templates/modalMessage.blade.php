<div id="modalMessage" class="fixed inset-0 z-40 bg-black/30 backdrop-blur-md flex justify-center items-center">
    <div
        class="flex flex-col justify-center items-center gap-6 w-full max-w-md bg-gray-800 text-gray-200 p-8 rounded-2xl shadow-lg relative">
        <h1 class="text-[32px] font-bold">{{ Session::has('message') ? 'Message' : 'Error' }}</h1>
        <p class="text-[20px]">{{ Session::get('message') }}{{ $errors->first() }}</p>
        <button id="btnModalMessage"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold w-full">Ok</button>
    </div>
</div>
<script>
    let modalMessage = document.getElementById('modalMessage');
    let btnModalMessage = document.getElementById('btnModalMessage');

    btnModalMessage.addEventListener('click', function () {
        modalMessage.classList.add('hidden');
        modalMessage.classList.remove('flex');
    });
</script>
