<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            @if (Session::get('role') == 1 )
                <ul>
                    <li class="menu-title">
                        <span>Management</span>
                    </li>
                    <li class="submenu {{set_active(['home','teacher/dashboard','student/dashboard'])}}">
                        <a>
                            <i class="fas fa-tachometer-alt"></i>
                            <span> Dashboard</span> 
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('home') }}" class="{{set_active(['home'])}}">Admin Dashboard</a></li>
                            <li><a class="{{ (request()->is('teacher/dashboard/*')) ? 'active' : '' }}">Teacher Dashboard</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-graduation-cap"></i>
                            <span> Students</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                            <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                            <li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu  {{set_active(['teacher/add/page','teacher/list/page','teacher/grid/page','teacher/edit'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                            <span> Teachers</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacher/list/page') }}" class="{{set_active(['teacher/list/page','teacher/grid/page'])}}">Teacher List</a></li>
                            <li><a href="{{ route('teacher/add/page') }}" class="{{set_active(['teacher/add/page'])}}">Teacher Add</a></li>
                            <li><a class="{{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">Teacher Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu  {{set_active(['class/add/page','class/list/page','class/grid/page','class/edit'])}} {{ (request()->is('class/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-calendar-day"></i>
                            <span> Classes</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('class/list') }}" class="{{set_active(['class/list','class/grid/page'])}}">Class List</a></li>
                            <li><a href="{{ route('class/add/page') }}" class="{{set_active(['class/add/page'])}}">Class Add</a></li>
                            <li><a class="{{ (request()->is('class/edit/*')) ? 'active' : '' }}">Class Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['room/list','room/add/page'])}} {{ (request()->is('room/edit/*')) ? 'active' : '' }} {{ (request()->is('room/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-building"></i>
                            <span> Rooms</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('room/list') }}"  class="{{set_active(['room/list'])}}">Room List</a></li>
                            <li><a href="{{ route('room/add/page') }}" class="{{set_active(['room/add/page'])}}">Room Add</a></li>
                            <li><a class="{{ (request()->is('room/edit/*')) ? 'active' : '' }}">Room Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['question/list','question/add/page'])}} {{ (request()->is('question/edit/*')) ? 'active' : '' }} {{ (request()->is('question/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> Questions</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('question/list') }}"  class="{{set_active(['question/list'])}}">Question List</a></li>
                            <li><a href="{{ route('question/add/page') }}" class="{{set_active(['question/add/page'])}}">Question Add</a></li>
                            <li><a class="{{ (request()->is('question/edit/*')) ? 'active' : '' }}">Question Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['homework/list','homework/add/page'])}} {{ (request()->is('homework/edit/*')) ? 'active' : '' }} {{ (request()->is('homework/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-clipboard-list"></i>
                            <span> Homeworks</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('homework/list') }}"  class="{{set_active(['homework/list'])}}">Homework List</a></li>
                            <li><a href="{{ route('homework/add/page') }}" class="{{set_active(['homework/add/page'])}}">Homework Add</a></li>
                            <li><a class="{{ (request()->is('homework/edit/*')) ? 'active' : '' }}">Homework Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['document/list','document/add/page'])}} {{ (request()->is('document/edit/*')) ? 'active' : '' }} {{ (request()->is('document/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-book"></i>
                            <span> Documents</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('document/list') }}"  class="{{set_active(['document/list'])}}">Document List</a></li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul>
                    <li class="submenu {{set_active(['home','teacher/dashboard','student/dashboard'])}}">
                        <a>
                            <i class="fas fa-tachometer-alt"></i>
                            <span> Dashboard</span> 
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a class="{{ (request()->is('teacher/dashboard/*')) ? 'active' : '' }}">Teacher Dashboard</a></li>
                        </ul>
                    </li>

                    <li class="submenu  {{set_active(['class/add/page','class/list/page','class/grid/page','class/edit'])}} {{ (request()->is('class/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-calendar-day"></i>
                            <span> Classes</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('class/list') }}" class="{{set_active(['class/list','class/grid/page'])}}">Class List</a></li>
                            <li><a href="{{ route('class/add/page') }}" class="{{set_active(['class/add/page'])}}">Class Add</a></li>
                            <li><a class="{{ (request()->is('class/edit/*')) ? 'active' : '' }}">Class Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['question/list','question/add/page'])}} {{ (request()->is('question/edit/*')) ? 'active' : '' }} {{ (request()->is('question/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> Questions</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('question/list') }}"  class="{{set_active(['question/list'])}}">Question List</a></li>
                            <li><a href="{{ route('question/add/page') }}" class="{{set_active(['question/add/page'])}}">Question Add</a></li>
                            <li><a class="{{ (request()->is('question/edit/*')) ? 'active' : '' }}">Question Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['homework/list','homework/add/page'])}} {{ (request()->is('homework/edit/*')) ? 'active' : '' }} {{ (request()->is('homework/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-clipboard-list"></i>
                            <span> Homeworks</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('homework/list') }}"  class="{{set_active(['homework/list'])}}">Homework List</a></li>
                            <li><a href="{{ route('homework/add/page') }}" class="{{set_active(['homework/add/page'])}}">Homework Add</a></li>
                            <li><a class="{{ (request()->is('homework/edit/*')) ? 'active' : '' }}">Homework Edit</a></li>
                        </ul>
                    </li>

                    <li class="submenu {{set_active(['document/list','document/add/page'])}} {{ (request()->is('document/edit/*')) ? 'active' : '' }} {{ (request()->is('document/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-book"></i>
                            <span> Documents</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('document/list') }}"  class="{{set_active(['document/list'])}}">Document List</a></li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>