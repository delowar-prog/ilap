<nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
        </div>
        <a class="navbar-brand" href="index.html">
            <div class="d-flex align-items-center py-3"><img class="me-2"
                    src="{{ asset('contents/backend/assets/img/icons/spot-illustrations/falcon.png') }}" alt=""
                    width="40" /><span class="font-sans-serif text-primary">iLap</span></div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                <!-- ==================== Dashboard ==================== -->
                <li class="nav-item mb-4">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link active" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1 d-flex align-items-center flex-wrap">
                                        {{ auth()->user()->name }}
                                        <span class="badge bg-success bg-opacity-10 text-success ms-2"
                                            style="font-size: 0.7rem;">
                                            <i class="fas fa-circle me-1"
                                                style="font-size: 0.4rem; vertical-align: middle;"></i> Active
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ==================== Campus Config ==================== -->
                 <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#configuration" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="configuration">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-building"></span></span>
                            <span class="nav-link-text ps-1">Configuration</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="configuration">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('countries.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Countries</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('states.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Divisions/State</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cities.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Districts/City</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Campus Config ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#campus" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="campus">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-building"></span></span>
                            <span class="nav-link-text ps-1">Campus Mgt</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="campus">
                        @can('campus view')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('campuses.index') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">All Campuses</span>
                                    </div>
                                </a>
                            </li>
                        @endcan
                        @can('campus add')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('campuses.create') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">Add New Campuses</span>
                                    </div>
                                </a>
                            </li>
                        @endcan
                     
                    </ul>
                </li>
                <li class="nav-item">
                    <!-- ==================== User & Role ==================== -->
                    <a class="nav-link dropdown-indicator" href="#user_role" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="user_role">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-users-cog"></span></span>
                            <span class="nav-link-text ps-1">User & Role</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="user_role">
                        @can('user view')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">All Users</span>
                                    </div>
                                </a>
                            </li>
                        @endcan
                        @can('permission view')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('permissions.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Permissions</span>
                                </div>
                            </a>
                        </li>
                        @endcan

                        @can('role view')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('roles.index') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">Roles</span>
                                    </div>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Staff Management</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <!-- ==================== Agent Management ==================== -->
                    <a class="nav-link dropdown-indicator" href="#agent" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="agent">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-users-cog"></span></span>
                            <span class="nav-link-text ps-1">Agent Management</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="agent">
                        @can('agent view')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agents.index') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">All Agent</span>
                                    </div>
                                </a>
                            </li>
                        @endcan
                        @can('commission view')
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('commissions.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Agent Commission</span>
                                </div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <!-- ==================== Courses & Academic ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#ilap_course" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="ilap_course">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-book-open"></span></span>
                            <span class="nav-link-text ps-1">iLAP Own Courses</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="ilap_course">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Course List</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <a class="nav-link dropdown-indicator" href="#institute" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="institute">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-university"></span></span>
                            <span class="nav-link-text ps-1">Institute & Courses</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="institute">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('institutes.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">All Institute</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Courses</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <a class="nav-link dropdown-indicator" href="#academic" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="academic">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-award"></span></span>
                            <span class="nav-link-text ps-1">Academic Results</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="academic">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Results</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Transcript</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Certificate</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ==================== Enrolment Details ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#students" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="students">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-user-graduate"></span></span>
                            <span class="nav-link-text ps-1">Enrolment Details</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="students">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">All Students</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">New Applications</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Multi-Program Students</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Enrolment Pipeline</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <!-- Note: I kept this ul inside the same li, just updated icons -->
                    <ul class="nav collapse" id="letter_certificate">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Offer Letters</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Certificates</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Document ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#docuemnts" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="docuemnts">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-wallet"></span></span>
                            <span class="nav-link-text ps-1">Docuemnts</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="docuemnts">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Upload Center</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Dropbox Sync Status</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Student Documents</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Exchange</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Verification</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Templates</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Finance ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#finance" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="finance">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-wallet"></span></span>
                            <span class="nav-link-text ps-1">Finance</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="finance">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Invoices</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Payment Approvals</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Fee Management</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Fee Collection Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Installment Plans</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Due Fee Reminders</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ==================== Letter & Certificate ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#letter" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="letter">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-headset"></span></span>
                            <span class="nav-link-text ps-1">Letter and Certificate Engine</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="letter">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Letter Templates</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Generate Letters</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Certificates</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Transcripts</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Letter History</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Support ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#support" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="support">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-headset"></span></span>
                            <span class="nav-link-text ps-1">Support</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="support">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">All Tickets</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Create Ticket</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">My Assigned Tickets</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Report ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#report" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="report">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-chart-bar"></span></span>
                            <span class="nav-link-text ps-1">Report</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="report">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Dashboard Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Student Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Financial Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Support Reports</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== SYSTEM SETTINGS ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#setting" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="setting">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-chart-bar"></span></span>
                            <span class="nav-link-text ps-1">System Settings</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="setting">
                        <li class="nav-item">
                            <a class="nav-link" href="">    
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">General Settings</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Email Configuration</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Payment Gateway</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Audit Logs</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
