/**
 * Display Core Engine - Masjid Agung Nujumul Ittihad Sinjai
 * Combined Realtime Clock, API Synchronization, Offline Prayer Calculation,
 * Pure Screen Blanking, and Admin Keyboard Shortcuts.
 */

// Global State
window.DisplayCore = {
  namaMasjid: "MASJID AGUNG NUJUMUL ITTIHAD",
  prayerTimes: {
    subuh: "04:45",
    syuruq: "06:00",
    dzuhur: "12:12",
    ashar: "15:20",
    maghrib: "18:15",
    isya: "19:24"
  },
  isManualBlank: false,
  userOverriddenWindow: false,
  apiData: null
};

// 1. Offline Astronomical Prayer Calculation Engine for Sinjai (Lat: -5.1242, Long: 120.2536, GMT+8)
function calculateOfflinePrayerTimes(date = new Date()) {
  const lat = -5.1242;
  const lng = 120.2536;
  const timezone = 8; // WITA (GMT+8)

  const year = date.getFullYear();
  const month = date.getMonth() + 1;
  const day = date.getDate();

  // Julian Date calculation
  const a = Math.floor((14 - month) / 12);
  const y = year + 4800 - a;
  const m = month + 12 * a - 3;
  const jd = day + Math.floor((153 * m + 2) / 5) + 365 * y + Math.floor(y / 4) - Math.floor(y / 100) + Math.floor(y / 400) - 32045;

  const d = jd - 2451545.0;

  // Sun's declination and equation of time
  const g = 357.529 + 0.98560028 * d;
  const q = 280.459 + 0.98564736 * d;
  const L = q + 1.915 * Math.sin(g * Math.PI / 180) + 0.020 * Math.sin(2 * g * Math.PI / 180);
  const e = 23.439 - 0.00000036 * d;
  
  const RA = Math.atan2(Math.cos(e * Math.PI / 180) * Math.sin(L * Math.PI / 180), Math.cos(L * Math.PI / 180)) * 180 / Math.PI;
  const EqT = (q/15 - (RA < 0 ? RA + 360 : RA)/15);
  const Dec = Math.asin(Math.sin(e * Math.PI / 180) * Math.sin(L * Math.PI / 180)) * 180 / Math.PI;

  const transit = 12 + timezone - (lng / 15) - EqT;

  const hourAngle = (angle) => {
    const cosHA = (Math.sin(angle * Math.PI / 180) - Math.sin(lat * Math.PI / 180) * Math.sin(Dec * Math.PI / 180)) / (Math.cos(lat * Math.PI / 180) * Math.cos(Dec * Math.PI / 180));
    if (cosHA > 1 || cosHA < -1) return null;
    return Math.acos(cosHA) * 180 / Math.PI / 15;
  };

  const asrAngle = () => {
    const shadowFactor = 1; // Shafi'i / Maliki / Hanbali
    const phiMinusDec = Math.abs(lat - Dec);
    const cotA = shadowFactor + Math.tan(phiMinusDec * Math.PI / 180);
    const alt = Math.atan(1 / cotA) * 180 / Math.PI;
    return hourAngle(-alt);
  };

  const formatHours = (hours) => {
    if (hours === null || isNaN(hours)) return "00:00";
    let h = Math.floor(hours);
    let mins = Math.floor((hours - h) * 60);
    if (mins >= 60) { h++; mins -= 60; }
    if (h >= 24) h -= 24;
    return `${String(h).padStart(2, '0')}:${String(mins).padStart(2, '0')}`;
  };

  const fajrHA = hourAngle(-20); // Kemenag 20 deg
  const ishaHA = hourAngle(-18); // Kemenag 18 deg
  const asrHA = asrAngle();
  const maghribHA = hourAngle(-0.833);

  return {
    subuh: formatHours(transit - fajrHA),
    dzuhur: formatHours(transit + (2/60)), // +2 mins safety
    ashar: formatHours(transit + asrHA),
    maghrib: formatHours(transit + maghribHA),
    isya: formatHours(transit + ishaHA)
  };
}

// 2. Realtime Clock Updater
function updateClock() {
  const now = new Date();
  const clockEl = document.getElementById('disp-clock');
  const dateEl = document.getElementById('disp-date');

  if (clockEl) {
    clockEl.textContent = now.toLocaleTimeString('id-ID', {
      timeZone: 'Asia/Makassar',
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    }).replace(/\./g, ':');
  }

  if (dateEl) {
    dateEl.textContent = now.toLocaleDateString('id-ID', {
      timeZone: 'Asia/Makassar',
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }).replace(/Minggu/g, 'Ahad');
  }
}

// 3. Theme Rotator (Burn-in Prevention)
const displayThemes = [
  { bg: '#0a192f', card: '#112240', accent: '#64ffda' },
  { bg: '#062c1e', card: '#0d402d', accent: '#50e3c2' },
  { bg: '#1a0e2e', card: '#281746', accent: '#a78bfa' },
  { bg: '#241808', card: '#38260f', accent: '#fbbf24' },
  { bg: '#0f172a', card: '#1e293b', accent: '#38bdf8' }
];
let currentThemeIdx = 0;

function rotateTheme() {
  currentThemeIdx = (currentThemeIdx + 1) % displayThemes.length;
  const t = displayThemes[currentThemeIdx];
  document.documentElement.style.setProperty('--bg-dark', t.bg);
  document.documentElement.style.setProperty('--card-bg', t.card);
  document.documentElement.style.setProperty('--accent-cyan', t.accent);
}

// 4. Time Formatting Helpers
function formatIndoDate(dateStr) {
  if (!dateStr) return '-';
  const p = dateStr.split('-');
  if (p.length === 3) {
    const dt = new Date(p[0], p[1] - 1, p[2]);
    return dt.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).replace(/Minggu/g, 'Ahad');
  }
  return dateStr;
}

function formatTimeShort(timeStr) {
  if (!timeStr) return '-';
  const p = timeStr.split(':');
  return p.length >= 2 ? `${p[0]}:${p[1]}` : timeStr;
}

function formatRupiah(nominal) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(nominal);
}

// 5. Prayer Time Fetching & Checking
async function fetchPrayerTimes() {
  try {
    const res = await fetch("https://api.aladhan.com/v1/timingsByCity?city=Sinjai&country=Indonesia&method=20");
    const json = await res.json();
    if (json && json.data && json.data.timings) {
      const t = json.data.timings;
      window.DisplayCore.prayerTimes = {
        subuh: t.Fajr,
        dzuhur: t.Dhuhr,
        ashar: t.Asr,
        maghrib: t.Maghrib,
        isya: t.Isha
      };
      return;
    }
  } catch (err) {
    console.log("Aladhan API offline/unreachable. Switching to offline astronomical calculation.");
  }
  // Fallback to offline calculation
  window.DisplayCore.prayerTimes = calculateOfflinePrayerTimes();
}

function timeToMinutes(tStr) {
  if (!tStr) return 0;
  const p = tStr.split(':');
  return parseInt(p[0], 10) * 60 + parseInt(p[1], 10);
}

function isWithinPrayerWindow(nowMinutes, prayerTimeStr) {
  if (!prayerTimeStr) return false;
  const pMin = timeToMinutes(prayerTimeStr);
  const startMin = pMin - 10;
  const endMin = pMin + 10;
  return nowMinutes >= startMin && nowMinutes <= endMin;
}

function checkPrayerBlankTrigger() {
  const now = new Date();
  const timeStr = now.toLocaleTimeString('id-ID', {
    timeZone: 'Asia/Makassar',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  }).replace(/\./g, ':');

  const nowMin = timeToMinutes(timeStr);

  let inWindow = false;
  for (const key in window.DisplayCore.prayerTimes) {
    if (isWithinPrayerWindow(nowMin, window.DisplayCore.prayerTimes[key])) {
      inWindow = true;
      break;
    }
  }

  if (!inWindow) {
    window.DisplayCore.userOverriddenWindow = false;
  }

  if (window.DisplayCore.isManualBlank || (inWindow && !window.DisplayCore.userOverriddenWindow)) {
    showBlankScreen();
  } else {
    hideBlankScreen();
  }
}

function showBlankScreen() {
  const overlay = document.getElementById('prayer-overlay');
  if (overlay) overlay.style.display = 'flex';
}

function hideBlankScreen() {
  const overlay = document.getElementById('prayer-overlay');
  if (overlay) overlay.style.display = 'none';
}

function toggleManualBlank() {
  window.DisplayCore.isManualBlank = true;
  showBlankScreen();
}

function restoreDisplay() {
  window.DisplayCore.isManualBlank = false;
  window.DisplayCore.userOverriddenWindow = true;
  hideBlankScreen();
}

// 6. Keyboard Event Listeners
document.addEventListener('keydown', (e) => {
  if (e.key === 'b' || e.key === 'B') {
    toggleManualBlank();
  } else if (e.key === 'Escape') {
    restoreDisplay();
  }
});

// 7. Base API Data Synchronization
async function fetchDisplayData(callback) {
  try {
    let path = window.location.pathname;
    if (path.endsWith('.html') || path.endsWith('.php')) {
      path = path.substring(0, path.lastIndexOf('/'));
    }
    if (!path.endsWith('/')) {
      path += '/';
    }
    const basePath = path.replace(/\/display\/$/, '/');

    let response;
    try {
      response = await fetch(basePath + 'api/display');
      if (!response.ok) {
        response = await fetch(basePath + 'index.php/api/display');
      }
    } catch (e) {
      response = await fetch(basePath + 'index.php/api/display');
    }

    const res = await response.json();

    if (res.status) {
      window.DisplayCore.apiData = res.data;
      if (res.data.masjid && res.data.masjid.nama) {
        window.DisplayCore.namaMasjid = res.data.masjid.nama;
        const nameEl = document.getElementById('disp-nama-masjid');
        if (nameEl) nameEl.textContent = res.data.masjid.nama;
      }
      if (typeof callback === 'function') {
        callback(res.data);
      }
    }
  } catch (err) {
    console.error("Gagal sinkronisasi data API:", err);
  }
}

// 8. Core Initialization
function initDisplayCore(dataRenderCallback) {
  updateClock();
  setInterval(updateClock, 1000);
  setInterval(rotateTheme, 180000);

  fetchPrayerTimes();
  setInterval(checkPrayerBlankTrigger, 1000);

  fetchDisplayData(dataRenderCallback);
  setInterval(() => fetchDisplayData(dataRenderCallback), 30000);

  if ('wakeLock' in navigator) {
    navigator.wakeLock.request('screen').catch(console.error);
  }
}
