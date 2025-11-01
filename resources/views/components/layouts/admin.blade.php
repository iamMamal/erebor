<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حسابداری شخصی اربور</title>
    @livewireStyles
    @livewireScripts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @vite('resources/css/auth/demo.css')
    @vite('resources/css/auth/page-auth.css')
    @vite('resources/css/auth/core-dark.css')
    @vite('resources/css/auth/theme-default-dark.css')
    <style>
        .icon-size{
            font-size: 2.376rem !important;
        }
    </style>
    @stack('styles')
</head>
<body class=" layout-wrapper layout-content-navbar">



<div class="layout-container" x-data="{ sidebarOpen: false }">



    <div class="sidebar p-3" style="display: contents">
{{--        <livewire:dashboard.sidebar />--}}

        <div x-data="screenWidth()" x-init="init()" @resize.window="handleResize()">

            <!-- این div فقط وقتی بزرگ‌تر یا مساوی 1200 باشه نمایش داده میشه -->
            <div x-show="isLargeScreen" >
                <aside class="layout-menu layout-menu-expanded
             menu-vertical menu bg-menu-theme" id="layout-menu" data-bg-class="bg-menu-theme"
                    style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                    <div class="menu-inner-shadow"></div>
                    <div>
                        @livewire('dashboard.sidebar')

                    </div>
                </aside>
            </div>

            <!-- این div فقط وقتی کوچیک‌تر از 1200 باشه نمایش داده میشه -->
            <div x-show="!isLargeScreen">
                <aside
                    :style="sidebarOpen ? 'transform:translate3d(0, 0, 0);' : ''"
                    class="layout-menu layout-menu-expanded
             menu-vertical menu bg-menu-theme" id="layout-menu" data-bg-class="bg-menu-theme"
                    style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                    <div class="menu-inner-shadow"></div>



                    <div
                        x-show="sidebarOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full opacity-0"
                        x-transition:enter-end="translate-x-0 opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="translate-x-0 opacity-100"
                        x-transition:leave-end="translate-x-full opacity-0"
                        class=" top-0 right-0 h-full w-80  z-50 p-6"
                        style="will-change: transform;"
                    >

                        @livewire('dashboard.sidebar')
                    </div>
                </aside>
            </div>

        </div>


    </div>
    <div class="content w-100">
        <div class="col-12 text-left mt-4">
            <nav style="display:contents" class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <button @click="sidebarOpen = true" class="px-2 mb-4 btn btn-primary layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4">
                        <i class="las la-home"></i>
                        <span>مشاهده منو</span>
                    </a>
                </button>

                {{--        transform: translate3d(0, 0, 0) !important;--}}
            </nav>
        </div>

        {{ $slot }}
        <footer class=" content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                    <div> ©
                        2025
                        , ارائه شده توسط
                        <span class="text-danger byte-hover">گروه اربور</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div @click="sidebarOpen = false"
        :style="sidebarOpen ? 'display:block;' : ''"
        class="layout-overlay layout-menu-toggle "
    ></div>

</div>



<script>
    function screenWidth() {
        return {
            isLargeScreen: window.innerWidth >= 1200,

            init() {
                this.isLargeScreen = window.innerWidth >= 1200;
            },

            handleResize() {
                this.isLargeScreen = window.innerWidth >= 1200;
            }
        }
    }
</script>


<script>
    window.addEventListener('show-delete-confirmation', event => {
        Swal.fire({
            icon: 'warning',
            title: 'حذف',
            text: "از حذف مورد مطمئن هستید ؟",
            showCancelButton: true,
            confirmButtonText: 'اره',
            cancelButtonText: 'خیر'
        }).then((result)=> {
            if(result.isConfirmed) {
                Livewire.dispatch('deleteConfirmed')
            }})
        });


    window.addEventListener('studentDeleted', event => {
        Swal.fire(
            'حذف شد',
            'حساب مورد نظر حذف شد',
            'success'
        )
    });
</script>

<script>
    window.addEventListener('show-delete-confirmation1', event => {
        Swal.fire({
            icon: 'warning',
            title: 'حذف',
            text: "از حذف تراکنش پس انداز مطمئن هستید ؟",
            showCancelButton: true,
            confirmButtonText: 'اره',
            cancelButtonText: 'خیر'
        }).then((result)=> {
            if(result.isConfirmed) {
                Livewire.dispatch('deleteConfirmed1')
            }})
    });


    window.addEventListener('studentDeleted1', event => {
        Swal.fire(
            'حذف شد',
            'حساب مورد نظر حذف شد',
            'success'
        )
    });
</script>
@if (session('reload'))
    <script> window.location.reload(); </script>
@endif


@stack('scripts')


</body>
</html>

