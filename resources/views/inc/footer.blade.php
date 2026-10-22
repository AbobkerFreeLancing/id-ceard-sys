<footer class="site-footer bg-[#0f172a] py-6 px-4">
    <div class="container">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <p class="text-sm text-gray-50">© <span>{{ date("Y") }}</span> 
            {{ __("backend.all_rights") }}
            </p>
            <div class="flex items-center gap-4 text-sm text-gray-50">
                <a class="hover:text-gray-100">
                    {{ settings()->company_name }}
                </a>
            </div>
        </div>
    </div>
</footer>
