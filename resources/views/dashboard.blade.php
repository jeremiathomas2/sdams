@extends('layouts.app')

@section('content')
      <!-- ========== DASHBOARD ========== -->
      <div class="page active" id="page-dashboard">
        <div class="breadcrumb">Home <span>/ Dashboard</span></div>
        <div class="page-header">
          <div><h2>📊 Dashboard</h2><p>Welcome back, {{ auth()->user()->name ?? 'Administrator' }}. Here's your church overview.</p></div>
          <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <button class="btn btn-outline" onclick="showToast('Report','Generating monthly report...','info')">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
              Export Report
            </button>
            <button class="btn btn-primary-solid" onclick="navigateTo('members-add')">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Add Member
            </button>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
              <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
              <div class="stat-val">1,284</div>
              <div class="stat-label">Total Members</div>
              <div class="stat-change up">↑ 12 this month</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
              <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
              <div class="stat-val">TZS 4.2M</div>
              <div class="stat-label">Monthly Offerings</div>
              <div class="stat-change up">↑ 8.4% vs last month</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" style="background:rgba(217,119,6,0.1)">
              <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
            </div>
            <div>
              <div class="stat-val">3</div>
              <div class="stat-label">Pending Transfers</div>
              <div class="stat-change down">2 awaiting approval</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" style="background:rgba(8,145,178,0.1)">
              <svg viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
              <div class="stat-val">87%</div>
              <div class="stat-label">Avg Attendance</div>
              <div class="stat-change up">↑ 3% vs last week</div>
            </div>
          </div>
        </div>

        <div class="grid-2" style="margin-bottom:20px">
          <div class="card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
              <div class="card-title">Monthly Offerings (2025)</div>
              <span class="badge badge-success">Live</span>
            </div>
            <div class="chart-placeholder">
              <div class="chart-bar" style="height:55%" title="Jan"></div>
              <div class="chart-bar" style="height:70%" title="Feb"></div>
              <div class="chart-bar" style="height:60%" title="Mar"></div>
              <div class="chart-bar" style="height:85%" title="Apr"></div>
              <div class="chart-bar" style="height:75%" title="May"></div>
              <div class="chart-bar" style="height:90%;background:var(--accent)" title="Jun"></div>
              <div class="chart-bar" style="height:65%" title="Jul"></div>
              <div class="chart-bar" style="height:80%" title="Aug"></div>
              <div class="chart-bar" style="height:70%" title="Sep"></div>
              <div class="chart-bar" style="height:95%" title="Oct"></div>
              <div class="chart-bar" style="height:88%" title="Nov"></div>
              <div class="chart-bar" style="height:78%;opacity:0.4" title="Dec"></div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:0.75rem;color:var(--text-muted)">
              <span>Jan</span><span>Mar</span><span>May</span><span>Jul</span><span>Sep</span><span>Nov</span>
            </div>
          </div>
          <div class="card">
            <div class="card-title" style="margin-bottom:16px">Membership by Status</div>
            <div class="donut-wrap">
              <svg width="120" height="120" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="45" fill="none" stroke="var(--border)" stroke-width="18"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#1a56a0" stroke-width="18" stroke-dasharray="197 86" stroke-dashoffset="0" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#16a34a" stroke-width="18" stroke-dasharray="48 235" stroke-dashoffset="-197" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#d97706" stroke-width="18" stroke-dasharray="25 258" stroke-dashoffset="-245" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#dc2626" stroke-width="18" stroke-dasharray="13 270" stroke-dashoffset="-270" transform="rotate(-90 60 60)"/>
                <text x="60" y="64" text-anchor="middle" font-size="14" font-weight="700" fill="var(--text)" font-family="Nunito Sans">1,284</text>
              </svg>
              <div class="donut-legend">
                <div class="legend-item"><div class="legend-dot" style="background:#1a56a0"></div><span style="font-size:0.82rem"><b>Active</b> — 1,021</span></div>
                <div class="legend-item"><div class="legend-dot" style="background:#16a34a"></div><span style="font-size:0.82rem"><b>New</b> — 156</span></div>
                <div class="legend-item"><div class="legend-dot" style="background:#d97706"></div><span style="font-size:0.82rem"><b>Inactive</b> — 82</span></div>
                <div class="legend-item"><div class="legend-dot" style="background:#dc2626"></div><span style="font-size:0.82rem"><b>Removed</b> — 25</span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid-2">
          <div class="card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
              <div class="card-title">Recent Members</div>
              <button class="btn btn-ghost btn-sm" onclick="navigateTo('members-all')">View All →</button>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>Name</th><th>Status</th><th>Joined</th></tr></thead>
                <tbody>
                  <tr><td><div style="display:flex;align-items:center;gap:8px"><div class="member-avatar">JM</div>John Mwangi</div></td><td><span class="badge badge-success">Active</span></td><td>Jan 15, 2025</td></tr>
                  <tr><td><div style="display:flex;align-items:center;gap:8px"><div class="member-avatar">SK</div>Sarah Kioko</div></td><td><span class="badge badge-success">Active</span></td><td>Feb 2, 2025</td></tr>
                  <tr><td><div style="display:flex;align-items:center;gap:8px"><div class="member-avatar">PM</div>Peter Moshi</div></td><td><span class="badge badge-warning">Probation</span></td><td>Mar 10, 2025</td></tr>
                  <tr><td><div style="display:flex;align-items:center;gap:8px"><div class="member-avatar">GN</div>Grace Njoroge</div></td><td><span class="badge badge-info">Transfer In</span></td><td>Apr 5, 2025</td></tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
              <div class="card-title">Recent Activity</div>
              <button class="btn btn-ghost btn-sm">View Log →</button>
            </div>
            <div>
              <div class="activity-item">
                <div class="activity-icon" style="background:rgba(22,163,74,0.1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                <div><div class="activity-text">New member <b>John Mwangi</b> registered</div><div class="activity-time">2 hours ago</div></div>
              </div>
              <div class="activity-item">
                <div class="activity-icon" style="background:rgba(26,86,160,0.1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <div><div class="activity-text">Tithe offering of <b>TZS 150,000</b> recorded</div><div class="activity-time">4 hours ago</div></div>
              </div>
              <div class="activity-item">
                <div class="activity-icon" style="background:rgba(217,119,6,0.1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg></div>
                <div><div class="activity-text">Transfer request for <b>Grace Njoroge</b> submitted</div><div class="activity-time">Yesterday</div></div>
              </div>
              <div class="activity-item">
                <div class="activity-icon" style="background:rgba(220,38,38,0.1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                <div><div class="activity-text">3 transfers pending review</div><div class="activity-time">2 days ago</div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
