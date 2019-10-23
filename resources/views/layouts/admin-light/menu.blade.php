<aside class="menu is-hidden-mobile" id="side-menu" style="position: relative;">
    @if(Auth::check() && hasPermission('home'))
    <p class="menu-label">
        Application Form
        <span class="icon has-text-success pull-right is-large" onclick="hideMenu()">
          <i class="fas fa-angle-left"></i>
        </span>
    </p>
    <ul class="menu-list">
        @if(hasPermission('applications.create'))
        <li><a href="{{route('applications.create')}}" alt="(1)New Application"><span>Create New</span></a></li>
        @endif
        @if(hasPermission('applications.draft'))
        <li><a href="{{route('applications.draft')}}" alt="(2)Draft Applications"><span>Drafts</span></a></li>
        @endif
        @if(hasPermission('applications.pending'))
        <li><a href="{{route('applications.pending')}}" alt="(3)Pending Applications"><span>Process Applications</span></a></li>
        @endif
        @if(hasPermission('applications.index'))
        <li><a href="{{route('applications.index')}}" alt="All Applications"><span>All Applications</span></a></li>
        @endif
    </ul>
    <p class="menu-label">
        Inspection
    </p>
    <ul class="menu-list">
        @if(hasPermission('inspections.upcoming'))
        <li><a href="{{route('inspections.upcoming')}}" alt="(4)Upcoming Inspections"><span>Upcoming</span></a></li>
        @endif
        @if(hasPermission('normal-forms.pending'))
        <li><a href="{{route('normal-forms.pending')}}" alt="(5)Approve Inspection Forms"><span>Approve Forms</span></a></li>
        @endif
        @if(hasPermission('normal-forms.processed'))
        <li><a href="{{route('normal-forms.processed')}}" alt="(6)Processed Inspection Forms"><span>Generate Reports</span></a></li>
        @endif
        @if(hasPermission('inspections.index'))
        <li><a href="{{route('inspections.index')}}" alt="All Inspections"><span>All Inspections</span></a></li>
        @endif
    </ul>
    <p class="menu-label">
        Grading Inspection
    </p>
    <ul class="menu-list">
        @if(hasPermission('grading-inspections.upcoming'))
        <li><a href="{{route('grading-inspections.upcoming')}}" alt="Upcoming Grading Inspections"><span>Upcoming</span></a></li>
        @endif
    </ul>
    <p class="menu-label">
        Reports
    </p>
    <ul class="menu-list">
        @if(hasPermission('inspections.pending-reports'))
        <li><a href="{{route('inspections.pending-reports')}}" alt="(7)Forms with Pending Reports"><span>Waiting For Approval</span></a></li>
        @endif
        @if(hasPermission('inspections.processed-reports'))
        <li><a href="{{route('inspections.processed-reports')}}" alt="(8)Forms with Processed Reports"><span>Handover Reports</span></a></li>
        @endif
    </ul>
    <p class="menu-label">
        Business Related
    </p>
    <ul class="menu-list">
        @if(hasPermission('licenses.index'))
        <li><a href="{{route('licenses.index')}}" alt="Licenses"><span>Licenses</span></a></li>
        @endif
        @if(hasPermission('fines.index'))
        <li><a href="{{route('fines.index')}}" alt="Fines"><span>Fines</span></a></li>
        @endif
        @if(hasPermission('terminations.index'))
        <li><a href="{{route('terminations.index')}}" alt="Terminations"><span>Terminations</span></a></li>
        @endif
    </ul>
    <p class="menu-label">
        Manage
    </p>
    <ul class="menu-list">
        @if(hasPermission('normal-points.manage'))
        <a href="{{route('normal-points.manage')}}"><span>Inspection Points</span></a>
        @endif
        @if(hasPermission('normal-categories.manage'))
        <a href="{{route('normal-categories.manage')}}"><span>Inspection Categories</span></a>
        @endif
        @if(hasPermission('grading-points.manage'))
        <li><a href="{{route('grading-points.manage')}}"><span>Grading Points</span></a>
        @endif
        @if(hasPermission('grading-categories.manage'))
        <li><a href="{{route('grading-categories.manage')}}"><span>Grading Categories</span></a>
        @endif
        @if(hasPermission('password.change'))
        <li><a href="{{route('password.change')}}">Change Password</a></li>
        @endif
        @if(hasPermission('acl.dashboard'))
        <li><a href="{{route('acl.dashboard')}}"><span>ACL Dashboard</span></a></li>
        @endif
        @if(hasPermission('activities.index'))
        <li><a href="{{route('activities.index')}}"><span>User Activities</span></a></li>
        @endif
    </ul>
    @endauth
</aside>

<aside class="menu is-hidden-mobile" id="closed-side-menu" style="display: none;">
    <p class="menu-label">
        <span class="icon has-text-success pull-left is-large" onclick="showMenu()">
          <i class="fas fa-angle-right"></i>
        </span>
    </p>
</aside>