<aside class="sidebar" id="sidebar">
      <!-- Dashboard -->
      <div class="sidebar-item">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          <span>Dashboard</span>
        </a>
      </div>

      <div class="sidebar-section">Membership</div>

      <!-- Members -->
      <div class="sidebar-item">
        <div class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}" id="nav-members" onclick="toggleSubmenu('sub-members','nav-members')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <span>Members</span>
          <svg class="arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <div class="sidebar-submenu {{ request()->routeIs('members.*') ? 'open' : '' }}" id="sub-members" style="{{ request()->routeIs('members.*') ? 'max-height: 600px;' : '' }}">
          <a href="{{ route('members.index') }}" class="sidebar-sub-link {{ request()->routeIs('members.index') ? 'active' : '' }}"><span>All Members</span></a>
          <a href="{{ route('members.create') }}" class="sidebar-sub-link {{ request()->routeIs('members.create') ? 'active' : '' }}"><span>Add Member</span></a>
          <a href="{{ route('members.inactive') }}" class="sidebar-sub-link {{ request()->routeIs('members.inactive') ? 'active' : '' }}"><span>Inactive Members</span></a>
          <a href="{{ route('members.search') }}" class="sidebar-sub-link {{ request()->routeIs('members.search') ? 'active' : '' }}"><span>Search & Filter</span></a>
        </div>
      </div>

      <!-- Transfers -->
      <div class="sidebar-item">
        <div class="sidebar-link {{ request()->routeIs('transfers.*') ? 'active' : '' }}" id="nav-transfers" onclick="toggleSubmenu('sub-transfers','nav-transfers')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
          <span>Transfers</span>
          <svg class="arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <div class="sidebar-submenu {{ request()->routeIs('transfers.*') ? 'open' : '' }}" id="sub-transfers" style="{{ request()->routeIs('transfers.*') ? 'max-height: 600px;' : '' }}">
          <a href="{{ route('transfers.pending') }}" class="sidebar-sub-link {{ request()->routeIs('transfers.pending') ? 'active' : '' }}"><span>Pending Requests</span></a>
          <a href="{{ route('transfers.create') }}" class="sidebar-sub-link {{ request()->routeIs('transfers.create') ? 'active' : '' }}"><span>New Transfer</span></a>
          <a href="{{ route('transfers.history') }}" class="sidebar-sub-link {{ request()->routeIs('transfers.history') ? 'active' : '' }}"><span>Transfer History</span></a>
        </div>
      </div>

      <div class="sidebar-section">Finance</div>

      <!-- Offerings -->
      <div class="sidebar-item">
        <div class="sidebar-link {{ request()->routeIs('offerings.*') ? 'active' : '' }}" id="nav-offerings" onclick="toggleSubmenu('sub-offerings','nav-offerings')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          <span>Offerings & Finance</span>
          <svg class="arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <div class="sidebar-submenu {{ request()->routeIs('offerings.*') ? 'open' : '' }}" id="sub-offerings" style="{{ request()->routeIs('offerings.*') ? 'max-height: 600px;' : '' }}">
          <a href="{{ route('offerings.create') }}" class="sidebar-sub-link {{ request()->routeIs('offerings.create') ? 'active' : '' }}"><span>Record Offering</span></a>
          <a href="{{ route('offerings.index') }}" class="sidebar-sub-link {{ request()->routeIs('offerings.index') ? 'active' : '' }}"><span>All Contributions</span></a>
          <a href="{{ route('offerings.tithe') }}" class="sidebar-sub-link {{ request()->routeIs('offerings.tithe') ? 'active' : '' }}"><span>Tithe Records</span></a>
          <a href="{{ route('offerings.bulk') }}" class="sidebar-sub-link {{ request()->routeIs('offerings.bulk') ? 'active' : '' }}"><span>Bulk CSV Upload</span></a>
          <a href="{{ route('offerings.receipts') }}" class="sidebar-sub-link {{ request()->routeIs('offerings.receipts') ? 'active' : '' }}"><span>Receipts</span></a>
          <a href="{{ route('offerings.funds') }}" class="sidebar-sub-link {{ request()->routeIs('offerings.funds') ? 'active' : '' }}"><span>Fund Allocation</span></a>
        </div>
      </div>

      <div class="sidebar-section">Events & Attendance</div>

      <!-- Events -->
      <div class="sidebar-item">
        <div class="sidebar-link {{ request()->routeIs('events.*') ? 'active' : '' }}" id="nav-events" onclick="toggleSubmenu('sub-events','nav-events')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          <span>Events</span>
          <svg class="arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <div class="sidebar-submenu {{ request()->routeIs('events.*') ? 'open' : '' }}" id="sub-events" style="{{ request()->routeIs('events.*') ? 'max-height: 600px;' : '' }}">
          <a href="{{ route('events.index') }}" class="sidebar-sub-link {{ request()->routeIs('events.index') ? 'active' : '' }}"><span>All Events</span></a>
          <a href="{{ route('events.create') }}" class="sidebar-sub-link {{ request()->routeIs('events.create') ? 'active' : '' }}"><span>Create Event</span></a>
          <a href="{{ route('events.attendance') }}" class="sidebar-sub-link {{ request()->routeIs('events.attendance') ? 'active' : '' }}"><span>Attendance Tracker</span></a>
        </div>
      </div>

      <div class="sidebar-section">Reports</div>

      <!-- Reports -->
      <div class="sidebar-item">
        <div class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" id="nav-reports" onclick="toggleSubmenu('sub-reports','nav-reports')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          <span>Reports</span>
          <svg class="arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <div class="sidebar-submenu {{ request()->routeIs('reports.*') ? 'open' : '' }}" id="sub-reports" style="{{ request()->routeIs('reports.*') ? 'max-height: 600px;' : '' }}">
          <a href="{{ route('reports.membership') }}" class="sidebar-sub-link {{ request()->routeIs('reports.membership') ? 'active' : '' }}"><span>Membership Reports</span></a>
          <a href="{{ route('reports.finance') }}" class="sidebar-sub-link {{ request()->routeIs('reports.finance') ? 'active' : '' }}"><span>Finance Reports</span></a>
          <a href="{{ route('reports.attendance') }}" class="sidebar-sub-link {{ request()->routeIs('reports.attendance') ? 'active' : '' }}"><span>Attendance Reports</span></a>
          <a href="{{ route('reports.transfers') }}" class="sidebar-sub-link {{ request()->routeIs('reports.transfers') ? 'active' : '' }}"><span>Transfer Reports</span></a>
        </div>
      </div>

      <div class="sidebar-section">Administration</div>

      <!-- Users -->
      <div class="sidebar-item">
        <div class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}" id="nav-users" onclick="toggleSubmenu('sub-users','nav-users')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <span>User Management</span>
          <svg class="arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>
        <div class="sidebar-submenu {{ request()->routeIs('users.*') ? 'open' : '' }}" id="sub-users" style="{{ request()->routeIs('users.*') ? 'max-height: 600px;' : '' }}">
          <a href="{{ route('users.index') }}" class="sidebar-sub-link {{ request()->routeIs('users.index') ? 'active' : '' }}"><span>All Users</span></a>
          <a href="{{ route('users.roles') }}" class="sidebar-sub-link {{ request()->routeIs('users.roles') ? 'active' : '' }}"><span>Roles & Permissions</span></a>
          <a href="{{ route('users.audit') }}" class="sidebar-sub-link {{ request()->routeIs('users.audit') ? 'active' : '' }}"><span>Audit Logs</span></a>
        </div>
      </div>

      <!-- Settings -->
      <div class="sidebar-item">
        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          <span>System Settings</span>
        </a>
      </div>

      <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
          @csrf
          <div class="sidebar-link" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" style="color:rgba(200,214,240,0.6)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Sign Out</span>
          </div>
        </form>
      </div>
    </aside>
