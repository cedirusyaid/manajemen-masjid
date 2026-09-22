/**
 * Display Core Engine - Masjid Agung Nujumul Ittihad Sinjai
 * Combined Realtime Clock, API Synchronization, Accurate Offline Prayer Calculation,
 * Pure Screen Blanking, and Admin Keyboard Shortcuts.
 */

// Global State
window.DisplayCore = {
  namaMasjid: "MASJID AGUNG NUJUMUL ITTIHAD",
  prayerTimes: {
    subuh: "04:45",
    syuruq: "06:00",
    dzuhur: "12:05",
    ashar: "15:26",
    maghrib: "18:03",
    isya: "19:17"
  },
  blankSettings: {
    before_prayer: 0,
    subuh: 25,
    dzuhur: 20,
    ashar: 20,
    maghrib: 20,
    isya: 25,
    jumat: 45
  },
  isManualBlank: false,
  userOverriddenWindow: false,
  apiData: null
};

// 1. Accurate Offline Astronomical Prayer Calculation Engine for Sinjai (Lat: -5.1242, Long: 120.2536, GMT+8)
function calculateOfflinePrayerTimes(date = new Date()) {
  const lat = -5.1242;
  const lng = 120.2536;
  const tz = 8; // WITA

  const rad = d => d * Math.PI / 180;
  const deg = r => r * 180 / Math.PI;

  const start = new Date(date.getFullYear(), 0, 0);
  const diff = date - start;
  const oneDay = 1000 * 60 * 60 * 24;
  const dayOfYear = Math.floor(diff / oneDay);

  const B = 360 / 365 * (dayOfYear - 81);
  const dec = 23.45 * Math.sin(rad(B)); // degrees
  const EoT = 9.87 * Math.sin(rad(2 * B)) - 7.53 * Math.cos(rad(B)) - 1.5 * Math.sin(rad(B)); // minutes

  // Solar Noon (transit) in local hours
  const noon = 12 + tz - (lng / 15) - (EoT / 60);

  function hourAngle(alt) {
    const cosHA = (Math.sin(rad(alt)) - Math.sin(rad(lat)) * Math.sin(rad(dec))) /
                  (Math.cos(rad(lat)) * Math.cos(rad(dec)));
    if (cosHA > 1 || cosHA < -1) return null;
    return deg(Math.acos(cosHA)) / 15;
  }

  // Ashar calculation (Shafi'i)
  const asrAlt = deg(Math.atan(1 / (1 + Math.tan(rad(Math.abs(lat - dec))))));
  const haAsr = hourAngle(asrAlt);

  const haFajr = hourAngle(-20); // Subuh: 20 deg
  const haSunrise = hourAngle(-0.833);
  const haMaghrib = hourAngle(-0.833);
  const haIsha = hourAngle(-18); // Isya: 18 deg

  function toTime(hours) {
    if (hours === null || isNaN(hours)) return "00:00";
    let h = Math.floor(hours);
    let m = Math.floor((hours - h) * 60);
    if (m >= 60) { h++; m -= 60; }
    if (h >= 24) h -= 24;
    return String(h).padStart(2, '0') + ":" + String(m).padStart(2, '0');
  }

  return {
    imsak: toTime(noon - haFajr - (10 / 60)),
    subuh: toTime(noon - haFajr + (2 / 60)),
    syuruq: toTime(noon - haSunrise),
    dzuhur: toTime(noon + (2 / 60)),
    ashar: toTime(noon + haAsr + (2 / 60)),
    maghrib: toTime(noon + haMaghrib + (2 / 60)),
    isya: toTime(noon + haIsha + (2 / 60))
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
  if (nominal === null || nominal === undefined || isNaN(nominal)) return 'Rp 0';
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(nominal);
}

// 5. Prayer Time Fetching & Checking
async function fetchPrayerTimes() {
  // If we already have prayer times from API, skip
  if (window.DisplayCore.prayerTimes && window.DisplayCore.prayerTimes.subuh) {
    return;
  }
  // Offline calculation fallback
  window.DisplayCore.prayerTimes = calculateOfflinePrayerTimes();
}

function timeToMinutes(tStr) {
  if (!tStr || typeof tStr !== 'string') return 0;
  const p = tStr.split(':');
  if (p.length < 2) return 0;
  return parseInt(p[0], 10) * 60 + parseInt(p[1], 10);
}

function isWithinPrayerWindow(nowMinutes, prayerTimeStr, prayerKey) {
  if (!prayerTimeStr || typeof prayerTimeStr !== 'string' || !prayerTimeStr.includes(':')) return false;
  const pMin = timeToMinutes(prayerTimeStr);
  if (pMin <= 0) return false;

  const settings = window.DisplayCore.blankSettings || {};
  const beforeMin = parseInt(settings.before_prayer, 10) || 5;

  // Cek apakah hari ini adalah hari Jumat dan waktu shalat Dzuhur
  const now = new Date();
  const isFriday = (now.getDay() === 5); // 5 = Jumat

  let durationAfter = 20;
  if (prayerKey === 'dzuhur' && isFriday) {
    durationAfter = parseInt(settings.jumat, 10) || 45;
  } else if (settings[prayerKey] !== undefined) {
    durationAfter = parseInt(settings[prayerKey], 10) || 20;
  }

  const startMin = pMin - beforeMin;
  const endMin = pMin + durationAfter;
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
  const pTimes = window.DisplayCore.prayerTimes || {};
  for (const key of ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']) {
    if (pTimes[key] && isWithinPrayerWindow(nowMin, pTimes[key], key)) {
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
    const urlsToTry = [
      basePath + 'api/display',
      basePath + 'index.php/api/display',
      '/api/display',
      '/index.php/api/display'
    ];

    for (const u of urlsToTry) {
      try {
        const res = await fetch(u);
        if (res.ok) {
          response = res;
          break;
        }
      } catch (e) {
        // try next
      }
    }

    if (!response) {
      console.warn("DisplayCore: Semua endpoint API tidak dapat dijangkau. Menggunakan data offline.");
      return;
    }

    const res = await response.json();

    if (res && res.status && res.data) {
      window.DisplayCore.apiData = res.data;

      // Sync Prayer Times from backend if available
      if (res.data.jadwal_sholat) {
        window.DisplayCore.prayerTimes = res.data.jadwal_sholat;
      }

      // Sync Screen Blanking Durations per Prayer Time from backend
      if (res.data.display_blank_settings) {
        window.DisplayCore.blankSettings = res.data.display_blank_settings;
      }

      if (res.data.masjid) {
        if (res.data.masjid.nama) {
          window.DisplayCore.namaMasjid = res.data.masjid.nama;
          const nameEl = document.getElementById('disp-nama-masjid');
          if (nameEl) nameEl.textContent = res.data.masjid.nama;
        }
        if (res.data.masjid.alamat) {
          const alamatEl = document.getElementById('disp-alamat-masjid');
          if (alamatEl) alamatEl.textContent = res.data.masjid.alamat;
        }
      }

      if (typeof callback === 'function') {
        callback(res.data);
      }
    }
  } catch (err) {
    console.error("Gagal sinkronisasi data API display:", err);
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
    navigator.wakeLock.request('screen').catch(() => {});
  }
}
