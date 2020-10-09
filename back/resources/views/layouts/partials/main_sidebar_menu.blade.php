<ul>
    <li>
        <a href="{{ route("home") }}" title="Dashboard">
            <i class="fa fa-lg fa-fw fa-home"></i>
            <span class="menu-item-parent">Dashboard</span>
        </a>
    </li>

    @if( Auth::user()->userHasPrivilege(['branch_view', 'category_view', 'section_view', 'subject_view', 'class_view', 'subject_assignment_view'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-building"></i>
                <span class="menu-item-parent">School</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.branch'), url()->current(), 'Branches', 'branch_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.category'), url()->current(), 'Category', 'category_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.section'), url()->current(), 'Section', 'section_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.class'), url()->current(), 'Class', 'class_view' ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['subject_view'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-book"></i>
                <span class="menu-item-parent">Academics</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.subject'), url()->current(), 'Subject', 'subject_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.subject_assignment'), url()->current(), 'Subject Assignment', ['subject_assign_view','subject_assign_add'] ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['student_admission'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-users"></i>
                <span class="menu-item-parent">Students</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student.admission'), url()->current(), 'Admission', 'student_admission' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student'), url()->current(), 'Students', 'student_view' ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['attendance_type_view', 'student_attendance_mark', 'student_attendance_view', 'student_attendance_sheet'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-table"></i>
                <span class="menu-item-parent">Attendance</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.attendance_type'), url()->current(), 'Attendance Types', 'attendance_type_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_attendance'), url()->current(), 'Student Attendance', 'student_attendance_mark' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_attendance.report'), url()->current(), 'Student Attendance Report', 'student_attendance_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.attendance_sheet'), url()->current(), 'Student Attendance Sheet', 'student_attendance_sheet' ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['performance_scale_view'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-fighter-jet"></i>
                <span class="menu-item-parent">Performance</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.performance_scale'), url()->current(), 'Performance Scale', 'performance_scale_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.performance_type'), url()->current(), 'Performance Type', 'performance_type_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_performance'), url()->current(), 'Student Performance', 'student_performance_mark' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_performance.report'), url()->current(), 'Student Performance Report', 'student_performance_report' ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['print_sheet_columns_view', 'print_sheet_columns_add', 'print_sheet_columns_edit', 'print_sheet_columns_delete', 'print_sheet'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-bookmark"></i>
                <span class="menu-item-parent">Print Sheet</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.print_sheet'), url()->current(), 'Print Sheet Columns', 'print_sheet_columns_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.print_sheet.view'), url()->current(), 'Print Sheet', 'print_sheet' ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['generate_student_fee', 'edit_fee_fine_arrears_multiple', 'student_fee_transaction_view_all'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-money"></i>
                <span class="menu-item-parent">Student Fee</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_fee.receive_fee.mass'), url()->current(), 'Fee Receive with PIN', 'receive_fee' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_fee.generate'), url()->current(), 'Generate', 'generate_students_fee' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_fee_fine_arrears_multiple'), url()->current(), 'Edit fee related arrears', 'edit_fee_fine_arrears_multiple' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_fee.type'), url()->current(), 'Student Fee Types', 'student_fee_type_view' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_fee.transaction.all'), url()->current(), 'All Fee Transactions', 'student_fee_transaction_view_all' ) !!}

                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.student_fee.fee_defaulters_list'), url()->current(), 'Fee Defaulter Students', 'view_defaulters_list' ) !!}
            </ul>
        </li>
    @endif

    @if( Auth::user()->userHasPrivilege(['sms_template_view'], false) )
        <li>
            <a href="#">
                <i class="fa fa-lg fa-fw fa-comment"></i>
                <span class="menu-item-parent">SMS</span>
            </a>
            <ul>
                {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.sms.templates'), url()->current(), 'Templates', 'sms_template_view' ) !!}
            </ul>
        </li>
    @endif

    <li>
        <a href="#">
            <i class="fa fa-lg fa-fw fa-user"></i>
            <span class="menu-item-parent">Accounts</span>
        </a>
        <ul>
            {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.users'), url()->current(), 'Users', 'account_user' ) !!}

            {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.users.change_account_details'), url()->current(), 'Change Account Details' ) !!}
        </ul>
    </li>

 <li>
        <a href="#">
            <i class="fa fa-lg fa-fw fa-pencil"></i>
            <span class="menu-item-parent">Reports</span>
        </a>
        <ul>
            {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.reports'), url()->current(), 'Student Report', 'account_user' ) !!}

           

        </ul>
    </li>
     <li>
        <a href="#">
            <i class="fa fa-lg fa-fw fa-book"></i>
            <span class="menu-item-parent">Test Section</span>
        </a>
        <ul>
            {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.test'), url()->current(), 'Class Test', 'account_user' ) !!}

           

        </ul>
    </li>

    {!! \App\Libraries\MenuGenerator::mainSideBarMenuItem( auth()->user(), route('dashboard.option'), url()->current(), 'Options', 'modify_options', true, 'tags' ) !!}
</ul>