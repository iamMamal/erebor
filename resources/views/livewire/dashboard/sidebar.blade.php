<ul
    class="overflow-auto menu-inner " >
    <!-- Dashboards -->

    <li
        class="{{ $activeRoute == 'dashboard' ?  'menu-item btn-primary' : 'menu-item' }}">
        <a  class="menu-link"  wire:navigate href="{{ route('admin.dashboard') }}">
            <i class="menu-icon las la-home"></i>
            <div data-i18n="Dashboards">صفحه اصلی</div>
        </a>
    </li>

    @auth
        @if(auth()->user()->is_admin)
            <li
                class="{{ $activeRoute == 'dashboard.user-manager' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.user-manager')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">کاربران </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.sliders' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.sliders')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">اسلایدر </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.pkg-manager' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.pkg-manager')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">مدیریت پکیج </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.shop-product' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.shop-product')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">مدیریت محصولات </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.support' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.support')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">مدیریت پشتیبانی </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.user-point' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.user-point')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">امتیاز کاربران </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.pkg-request' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.pkg-request')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">درخواست پکیج ادمین</div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.evacuation-request' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.evacuation-request')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">درخواست تخلیه ادمین </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.referral' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.referral')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">تنظیمات معرفی به دوستان </div>
                </a>
            </li>
            <li
                class="{{ $activeRoute == 'dashboard.shop-order' ?  'menu-item btn-primary' : 'menu-item' }}">
                <a  class="menu-link" wire:navigate href="{{route('dashboard.shop-order')}}">
                    <i class="menu-icon las la-university"></i>
                    <div data-i18n="Dashboards">سفارشات فروشگاه</div>
                </a>
            </li>
        @endif
    @endauth

    <li
        class="{{ $activeRoute == 'dashboard.user.pkg-request' ?  'menu-item btn-primary' : 'menu-item' }}">
        <a  class="menu-link" wire:navigate href="{{route('dashboard.user.pkg-request')}}">
            <i class="menu-icon las la-recycle"></i>
            <div data-i18n="Dashboards">درخواست پکیج </div>
        </a>
    </li>
    <li
        class="{{ $activeRoute == 'dashboard.user.clearance-request' ?  'menu-item btn-primary' : 'menu-item' }}">
        <a  class="menu-link" wire:navigate href="{{route('dashboard.user.clearance-request')}}">
            <i class="menu-icon las la-truck-moving"></i>
            <div data-i18n="Dashboards">درخواست تخلیه </div>
        </a>
    </li>
    <li
        class="{{ $activeRoute == 'dashboard.user.referral' ?  'menu-item btn-primary' : 'menu-item' }}">
        <a  class="menu-link" wire:navigate href="{{route('dashboard.user.referral')}}">
            <i class="menu-icon las la-users"></i>
            <div data-i18n="Dashboards">معرفی به دوستان</div>
        </a>
    </li>
    <li
        class="{{ $activeRoute == 'dashboard.user.user-shop' ?  'menu-item btn-primary' : 'menu-item' }}">
        <a  class="menu-link" wire:navigate href="{{route('dashboard.user.user-shop')}}">
            <i class="menu-icon las la-shopping-cart"></i>
            <div data-i18n="Dashboards">فروشگاه</div>
        </a>
    </li>
    <li
        class="{{ $activeRoute == 'user.settings' ?  'menu-item btn-primary' : 'menu-item' }}">
        <a  class="menu-link" wire:navigate href="{{route('user.settings')}}">
            <i class="menu-icon las la-cog"></i>
            <div data-i18n="Dashboards">تنظیمات حساب</div>
        </a>
    </li>

    <li
        class="{{ $activeRoute == 'logout' ?  'menu-item btn-primary' : 'menu-item' }}">
            <form method="POST" action="{{ route('logout') }}">
        <button type="submit" class="menu-link">
                @csrf
                <i class="menu-icon las la-sign-out-alt"></i>
            <div data-i18n="Dashboards">خروج از برنامه</div>
        </button>
            </form>
    </li>


</ul>
