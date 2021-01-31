<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li>
                <a href="{{ route('dashboard.index') }}" class="waves-effect">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            {{-- --------------------------------------------------------- --}}
            <li class="menu-title text-muted">Item-Management</li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="fab fa-artstation"></i>
                    <span>Categories</span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('categories.index')}}">Category List</a>
                    </li>
                    <li>
                        <a href="{{route('subcategories.index')}}">Sub Category List</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="mdi mdi-layers"></i>
                    <span>Products</span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="nav-second-level" aria-expanded="false">

                    <li>
                        <a href="{{route('products.index')}}">Products List</a>
                    </li>
                </ul>
            </li>

            {{-- -------------------------------------- --}}

            {{-- ------------------------------------------------------------ --}}

        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->