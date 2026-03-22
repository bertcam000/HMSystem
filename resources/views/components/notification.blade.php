<div class="fixed top-5 right-5 z-50"
    x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 2000)" 
     x-show="show"
     x-transition>
    <div id="notification" class="flex items-center justify-between max-w-sm w-full bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-md transition transform duration-300">
        <div class="text-sm">
            {{ $message }}
        </div>

        <button onclick="document.getElementById('notification').remove()" class="text-green-800 hover:text-green-900 ml-4 focus:outline-none">
            &times;
        </button>
    </div>

</div>