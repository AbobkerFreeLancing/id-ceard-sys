<div class="flex px-0">
  <button class="set-fullscreen inline-flex justify-center items-center gap-x-2 border font-semibold focus:outline-none px-1 py-1 text-sm rounded-full border-gray-300 text-gray-800 shadow-sm hover:text-gray-800 hover:border-gray-300 hover:shadow focus:ring-1 focus:ring-primary-500 focus:ring-opacity-80 active:bg-white active:border-white active:shadow-none">
<svg xmlns="http://www.w3.org/2000/svg" class="h-6 icon icon-tabler icon-tabler-maximize" viewBox="0 0 24 24" stroke-width="2" stroke="#6b727b" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path>
   <path d="M4 16v2a2 2 0 0 0 2 2h2"></path>
   <path d="M16 4h2a2 2 0 0 1 2 2v2"></path>
   <path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path>
</svg>
  </button>
</div>

@push('scripts')
    <script>
      document.addEventListener("DOMContentLoaded", function(event) {

      let fullScreenMode = localStorage.getItem("fullScreenMode");

      if(fullScreenMode == "on"){
        document.documentElement.requestFullscreen();
      }


      document.querySelector('.set-fullscreen').addEventListener('click', function(e) {
        if(document.fullscreenElement === null) {
          document.documentElement.requestFullscreen();
          localStorage.setItem("fullScreenMode", "on");
        } else {
          document.exitFullscreen()
          localStorage.setItem("fullScreenMode", "off");
        }
      })

      });
    </script>
@endpush