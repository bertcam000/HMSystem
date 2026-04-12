<div class="fixed top-5 right-5 z-50"
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 2000)" 
    x-show="show"
    x-transition>

    <div id="notification"
        class="flex items-center justify-between max-w-sm w-full px-4 py-3 rounded-lg shadow-md transition transform duration-300
        {{ $type === 'success' ? 'bg-green-100 border-green-200 text-green-800' : '' }}
        {{ $type === 'error' ? 'bg-red-100 border-red-200 text-red-800' : '' }}
        {{ $type === 'warning' ? 'bg-yellow-100 border-yellow-200 text-yellow-800' : '' }}
        border">

        <div class="text-sm">
            {{ $message }}
        </div>

        <button onclick="document.getElementById('notification').remove()"
            class="ml-4 focus:outline-none">
            &times;
        </button>
    </div>
</div>