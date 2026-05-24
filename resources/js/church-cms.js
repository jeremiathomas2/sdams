// ========== STATE ==========
let sidebarCollapsed = false;
let currentPage = 'dashboard';

// ========== SPLASH ==========
window.addEventListener('load', () => {
    const splash = document.getElementById('splash');
    const app = document.getElementById('app');
    const authContainer = document.getElementById('auth-container');

    // Check if splash has already been shown in this session
    const splashShown = sessionStorage.getItem('splashShown');

    if (splashShown) {
        // Immediately show content if splash was already shown
        if (splash) {
            splash.style.display = 'none';
        }
        if (app) {
            app.classList.add('visible');
        }
        if (authContainer) {
            authContainer.style.opacity = '1';
            authContainer.style.visibility = 'visible';
        }
    } else {
        // First time in this session: show the splash animation
        if (authContainer) {
            authContainer.style.opacity = '0';
            authContainer.style.visibility = 'hidden';
        }

        setTimeout(() => {
            if (splash) {
                splash.classList.add('hidden');
            }
            
            if (app) {
                app.classList.add('visible');
            }
            
            if (authContainer) {
                authContainer.style.opacity = '1';
                authContainer.style.visibility = 'visible';
            }

            // Mark splash as shown for the rest of the session
            sessionStorage.setItem('splashShown', 'true');
        }, 2800);
    }
});

// ========== AUTH (UI ONLY) ==========
window.showAuthPage = function(id) {
  document.querySelectorAll('.auth-page').forEach(p => p.classList.remove('active'));
  const page = document.getElementById(id);
  if (page) page.classList.add('active');
}

window.togglePwd = function(id, btn) {
  const inp = document.getElementById(id);
  if (inp) inp.type = inp.type === 'password' ? 'text' : 'password';
}

window.checkStrength = function(val) {
  const segs = [document.getElementById('s1'),document.getElementById('s2'),document.getElementById('s3'),document.getElementById('s4')];
  const label = document.getElementById('strength-label');
  if (!label) return;
  
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  
  segs.forEach((s,i) => {
    if (s) {
      s.className = 'strength-seg';
      if (i < score) {
        if (score <= 1) s.classList.add('weak');
        else if (score <= 2) s.classList.add('fair');
        else s.classList.add('strong');
      }
    }
  });
  label.textContent = ['Enter a password','Weak — add more variety','Fair — try a number or symbol','Good password','Strong password!'][score];
}

window.showResetStep2 = function() {
  const s1 = document.getElementById('reset-step1');
  const s2 = document.getElementById('reset-step2');
  if (s1 && s2) {
    s1.style.display = 'none';
    s2.style.display = 'block';
  }
}

window.otpNext = function(el, idx) {
  const inputs = document.querySelectorAll('.otp-input');
  if (el.value && idx < 5) inputs[idx + 1].focus();
}

// ========== NAVIGATION ==========
const pageMap = {
  'dashboard':'page-dashboard','members-all':'page-members-all','members-add':'page-members-add',
  'offerings-record':'page-offerings-record','transfers-pending':'page-transfers-pending',
  'reports-membership':'page-reports-membership','reports-finance':'page-reports-finance',
  'settings':'page-settings','users-all':'page-users-all',
};

window.navigateTo = function(route) {
  // If we are using Laravel routing, we should use window.location.href instead of this
  // But for the "single-page" feel of the reference HTML, we'll keep this for now
  // and later migrate to actual Laravel routes.
  
  const pageId = pageMap[route];
  if (pageId) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
    document.querySelectorAll('.sidebar-sub-link').forEach(l => l.classList.remove('active'));
    
    const page = document.getElementById(pageId);
    if (page) page.classList.add('active');
    
    currentPage = route;
    // Close avatar dropdown
    const drop = document.getElementById('avatarDrop');
    if (drop) drop.classList.remove('open');
    
    // On mobile, close sidebar
    if (window.innerWidth <= 900) {
      const sb = document.getElementById('sidebar');
      if (sb) sb.classList.remove('mobile-open');
    }
    window.scrollTo(0,0);
  } else {
    // Fallback for missing pages
    const gen = document.getElementById('page-generic');
    if (gen) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        gen.classList.add('active');
        document.getElementById('genericTitle').textContent = route.replace(/-/g,' ').replace(/\b\w/g,c=>c.toUpperCase());
        document.getElementById('genericSub').textContent = 'Navigate to: ' + route;
    }
  }
}

// ========== SIDEBAR ==========
window.toggleSidebar = function() {
  const sb = document.getElementById('sidebar');
  if (!sb) return;
  if (window.innerWidth <= 900) {
    sb.classList.toggle('mobile-open');
  } else {
    sidebarCollapsed = !sidebarCollapsed;
    sb.classList.toggle('collapsed', sidebarCollapsed);
  }
}

window.toggleSubmenu = function(subId, linkId) {
  const sub = document.getElementById(subId);
  const link = document.getElementById(linkId);
  if (!sub || !link) return;
  
  const isOpen = sub.classList.contains('open');
  // Close all submenus
  document.querySelectorAll('.sidebar-submenu').forEach(s => s.classList.remove('open'));
  document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('open'));
  if (!isOpen) {
    sub.classList.add('open');
    link.classList.add('open');
  }
}

// ========== MODALS ==========
window.openMemberModal = function() { 
  const modal = document.getElementById('memberModal');
  if (modal) modal.classList.add('open'); 
}

window.closeModal = function(id) { 
  const modal = document.getElementById(id);
  if (modal) modal.classList.remove('open'); 
}

document.addEventListener('click', e => {
  document.querySelectorAll('.modal-overlay').forEach(m => {
    if (e.target === m) m.classList.remove('open');
  });
});

// ========== AVATAR DROPDOWN ==========
window.toggleAvatarDrop = function() {
  const drop = document.getElementById('avatarDrop');
  if (drop) drop.classList.toggle('open');
}

document.addEventListener('click', e => {
  const avatar = document.querySelector('.header-avatar');
  const drop = document.getElementById('avatarDrop');
  if (avatar && drop && !avatar.contains(e.target)) drop.classList.remove('open');
});

// ========== SETTINGS PANEL ==========
window.toggleSettings = function() {
  const panel = document.getElementById('settingsPanel');
  const overlay = document.getElementById('settingsOverlay');
  if (panel && overlay) {
    panel.classList.toggle('open');
    overlay.classList.toggle('open');
  }
}

window.setCSSVar = function(varName, value) {
  document.documentElement.style.setProperty(varName, value);
}

window.toggleDark = function(cb) {
  document.documentElement.setAttribute('data-theme', cb.checked ? 'dark' : '');
}

window.toggleAnim = function(type, cb) {
  if (!cb.checked) {
    document.documentElement.style.setProperty('--hover-anim', 'none');
  } else {
    document.documentElement.style.setProperty('--hover-anim', 'all 0.22s cubic-bezier(.4,0,.2,1)');
  }
}

window.setTransSpeed = function(val) {
  document.documentElement.style.setProperty('--hover-anim', `all ${val} cubic-bezier(.4,0,.2,1)`);
  document.documentElement.style.setProperty('--transition', `all ${val} cubic-bezier(.4,0,.2,1)`);
}

window.setSidebarStyle = function(val) {
  if (val === 'compact') {
    document.documentElement.style.setProperty('--sidebar-width','200px');
  } else if (val === 'wide') {
    document.documentElement.style.setProperty('--sidebar-width','300px');
  } else {
    document.documentElement.style.setProperty('--sidebar-width','270px');
  }
}

window.resetSettings = function() {
  document.documentElement.removeAttribute('data-theme');
  document.documentElement.style.cssText = '';
  const darkToggle = document.getElementById('darkToggle');
  if (darkToggle) darkToggle.checked = false;
  showToast('Settings', 'Reset to default settings.', 'info');
}

// ========== TOAST ==========
let toastCount = 0;
window.showToast = function(title, msg, type='info') {
  const c = document.getElementById('toastContainer');
  if (!c) return;
  
  const id = 'toast-' + (++toastCount);
  const colors = {success:'#16a34a',danger:'#dc2626',warning:'#d97706',info:'#1a56a0'};
  const icons = {
    success:'<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="'+colors.success+'" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>',
    danger:'<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="'+colors.danger+'" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
    warning:'<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="'+colors.warning+'" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg>',
    info:'<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="'+colors.info+'" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
  };
  const t = document.createElement('div');
  t.className = 'toast';
  t.id = id;
  t.style.borderLeft = '3px solid ' + (colors[type]||colors.info);
  t.innerHTML = (icons[type]||icons.info) + `<div><div class="toast-title">${title}</div><div class="toast-msg">${msg}</div></div>`;
  c.appendChild(t);
  setTimeout(() => {
    t.classList.add('removing');
    setTimeout(() => t.remove(), 300);
  }, 3500);
}
