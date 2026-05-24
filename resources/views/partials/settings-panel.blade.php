<!-- ========== SETTINGS OVERLAY ========== -->
<div class="settings-overlay" id="settingsOverlay" onclick="toggleSettings()"></div>

<!-- ========== SETTINGS PANEL ========== -->
<div class="settings-panel" id="settingsPanel">
  <div class="settings-panel-header">
    <h3>⚙️ Customize</h3>
    <button class="modal-close" onclick="toggleSettings()"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
  </div>
  <div class="settings-section">
    <h4>Theme</h4>
    <div class="toggle-row"><label>Dark Mode</label><label class="toggle"><input type="checkbox" id="darkToggle" onchange="toggleDark(this)"><span class="toggle-slider"></span></label></div>
  </div>
  <div class="settings-section">
    <h4>Header</h4>
    <div class="color-row"><label>Background</label><div class="color-swatch"><input type="color" value="#1a56a0" onchange="setCSSVar('--header-bg',this.value)"></div></div>
    <div class="color-row"><label>Text Color</label><div class="color-swatch"><input type="color" value="#ffffff" onchange="setCSSVar('--header-text',this.value)"></div></div>
  </div>
  <div class="settings-section">
    <h4>Sidebar</h4>
    <div class="color-row"><label>Background</label><div class="color-swatch"><input type="color" value="#1a2744" onchange="setCSSVar('--sidebar-bg',this.value)"></div></div>
    <div class="color-row"><label>Active Item</label><div class="color-swatch"><input type="color" value="#1a56a0" onchange="setCSSVar('--sidebar-active',this.value)"></div></div>
    <div class="color-row"><label>Hover Item</label><div class="color-swatch"><input type="color" value="#2a3a60" onchange="setCSSVar('--sidebar-hover',this.value)"></div></div>
    <div class="color-row"><label>Text Color</label><div class="color-swatch"><input type="color" value="#c8d6f0" onchange="setCSSVar('--sidebar-text',this.value)"></div></div>
  </div>
  <div class="settings-section">
    <h4>Footer</h4>
    <div class="color-row"><label>Background</label><div class="color-swatch"><input type="color" value="#1a2744" onchange="setCSSVar('--footer-bg',this.value)"></div></div>
    <div class="color-row"><label>Text Color</label><div class="color-swatch"><input type="color" value="#8a9bc0" onchange="setCSSVar('--footer-text',this.value)"></div></div>
  </div>
  <div class="settings-section">
    <h4>Accent & Primary</h4>
    <div class="color-row"><label>Primary Color</label><div class="color-swatch"><input type="color" value="#1a56a0" onchange="setCSSVar('--primary',this.value)"></div></div>
    <div class="color-row"><label>Accent Color</label><div class="color-swatch"><input type="color" value="#e8a020" onchange="setCSSVar('--accent',this.value)"></div></div>
  </div>
  <div class="settings-section">
    <h4>Animations</h4>
    <div class="toggle-row"><label>Hover Transitions</label><label class="toggle"><input type="checkbox" checked onchange="toggleAnim('hover',this)"><span class="toggle-slider"></span></label></div>
    <div class="toggle-row"><label>Page Transitions</label><label class="toggle"><input type="checkbox" checked onchange="toggleAnim('page',this)"><span class="toggle-slider"></span></label></div>
    <div style="margin-top:8px">
      <label style="font-size:0.83rem;color:var(--text-muted);">Transition Speed</label>
      <select class="select-style" onchange="setTransSpeed(this.value)">
        <option value="0.15s">Fast (0.15s)</option>
        <option value="0.22s" selected>Normal (0.22s)</option>
        <option value="0.4s">Slow (0.4s)</option>
      </select>
    </div>
  </div>
  <div class="settings-section">
    <h4>Sidebar Style</h4>
    <select class="select-style" onchange="setSidebarStyle(this.value)">
      <option value="default">Default</option>
      <option value="compact">Compact</option>
      <option value="wide">Wide</option>
    </select>
  </div>
  <div style="padding:16px 20px;">
    <button class="btn btn-outline" style="width:100%" onclick="resetSettings()">Reset to Default</button>
  </div>
</div>
