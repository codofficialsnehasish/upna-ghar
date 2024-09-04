<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-settings"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('settings-contents') }}">Site Settings</a></li>
                        {{--<li><a href="javascript: void(0);" class="has-arrow">Roles Permissions</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('roles') }}">Roles</a></li>
                                <li><a href="{{ route('permission') }}">Permission</a></li>
                            </ul>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-calendar-check"></i>
                        <span>Bookings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('booking.today-bookings') }}">Today Bookings</a></li>
                        <li><a href="{{ route('booking.index') }}">All Bookings</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-database"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('payment-type.index') }}">Payment Type</a></li>
                        <li><a href="{{ route('apartment-type.index') }}">Apartment Type</a></li>
                        <li><a href="{{ route('room.index') }}">Room</a></li>
                        <li><a href="{{ route('time-slot.index') }}">Time Slot</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-elementor"></i>
                        <span>Form Template</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('service-form-template.create') }}">Add Template</a></li>
                        <li><a href="{{ route('service-form-template.index') }}">All Templates</a></li>
                    </ul>
                </li>

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ti-user"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.add') }}">Add Users</a></li>
                        <li><a href="{{ route('users') }}">All Users</a></li>
                    </ul>
                </li>--}}
                <li>
                    <a href="{{ route('users') }}" class="waves-effect">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('workers') }}" class="waves-effect">
                        <i class="fas fa-people-carry"></i>
                        <span>Workers</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-dice-d6"></i>
                        <span>Services</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('service.create') }}">Add Services</a></li>
                        <li><a href="{{ route('service.index') }}">All Services</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
