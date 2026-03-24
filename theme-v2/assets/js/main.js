
/* === barel-homepage.html === */
{
    "@context": "https://schema.org",
    "@type": "HardwareStore",
    "name": "בר-אל אופיר בע״מ",
    "description": "חנות כלי עבודה מקצועיים – מברגות, מקדחות, ציוד בנייה ועוד",
    "url": "https://www.barel-ofir.co.il",
    "telephone": "",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "IL"
    },
    "priceRange": "₪₪",
    "openingHours": "Su-Th 08:00-18:00",
    "sameAs": []
  }
  
// ── ADVANCED LIVE SEARCH ──
(function() {
  const RECENT_KEY = 'barel_recent_searches';
  const MAX_RECENT = 5;

  // Mock data (בפרודקשן - Ajax מ-WooCommerce)
  const MOCK_PRODUCTS = [
    {id:1,brand:'Hunter Tools',name:'מקדחה קורדלס 18V PRO',cat:'כלי עבודה חשמליים',sku:'HT-201',price:'₪489',old:'₪699',img:'🔧',badge:'-30%'},
    {id:2,brand:'Worx',name:'מסור עגול 190mm WX530',cat:'כלי עבודה חשמליים',sku:'WX530',price:'₪620',old:'',img:'🪚',badge:''},
    {id:3,brand:'Kress',name:'מברגה קורדלס 20V KU310',cat:'כלי עבודה חשמליים',sku:'KU310',price:'₪549',old:'',img:'🪛',badge:'פופולרי'},
    {id:4,brand:'Signet',name:'פטיש הרס SDS 800W',cat:'כלי עבודה חשמליים',sku:'SG-800',price:'₪890',old:'₪1120',img:'🔨',badge:'-20%'},
    {id:5,brand:'Worx',name:'ג'יגסו 650W WX477',cat:'כלי עבודה חשמליים',sku:'WX477',price:'₪290',old:'₪340',img:'🔌',badge:''},
    {id:6,brand:'Hunter Tools',name:'גראינדר זווית 125mm',cat:'כלי עבודה חשמליים',sku:'HT-125',price:'₪340',old:'',img:'⚙️',badge:''},
    {id:7,brand:'Kress',name:'מסור שרשרת 18V KU405',cat:'כלי גינון חשמליים',sku:'KU405',price:'₪780',old:'',img:'🌲',badge:'חדש'},
    {id:8,brand:'Worx',name:'מכסחת דשא WG779',cat:'כלי גינון חשמליים',sku:'WG779',price:'₪1290',old:'₪1590',img:'🌱',badge:'-18%'},
    {id:9,brand:'Signet',name:'ארגז כלים מקצועי SG-400',cat:'כלי עבודה ידניים',sku:'SG-400',price:'₪380',old:'',img:'🧰',badge:''},
    {id:10,brand:'Hunter Tools',name:'סט מפתחות 24 חלקים',cat:'כלי עבודה ידניים',sku:'HT-SET24',price:'₪220',old:'₪280',img:'🔑',badge:''},
    {id:11,brand:'Worx',name:'מפוח עלים WG575',cat:'כלי גינון חשמליים',sku:'WG575',price:'₪420',old:'',img:'💨',badge:''},
    {id:12,brand:'Kress',name:'גוזמת גינה חשמלית KU601',cat:'כלי גינון חשמליים',sku:'KU601',price:'₪350',old:'₪440',img:'✂️',badge:''},
  ];

  const MOCK_CATS = [
    {name:'כלי עבודה חשמליים',icon:'⚡',url:'/product-category/kley-avoda-hashmaliyim/',count:320},
    {name:'כלי עבודה ידניים',icon:'🔧',url:'/product-category/kley-avoda-yadaniyim/',count:280},
    {name:'כלי גינון חשמליים',icon:'🌿',url:'/product-category/kley-ginun-hashmaliyim/',count:145},
    {name:'כלי גינון ידניים',icon:'🪴',url:'/product-category/kley-ginun-yadaniyim/',count:98},
    {name:'אביזרים לכלי עבודה',icon:'🔩',url:'/product-category/avizarim/',count:410},
    {name:'טמבוריה',icon:'🥁',url:'/product-category/tamboria/',count:55},
    {name:'מברגות קורדלס',icon:'🪛',url:'/product-category/mevragot/',count:84},
    {name:'מסורים חשמליים',icon:'🪚',url:'/product-category/masarim-hashmal/',count:62},
    {name:'מכונות שטיפה',icon:'💦',url:'/product-category/mekonot-shetifa/',count:33},
  ];

  const POPULAR = ['מברגה','מסור','גראינדר','Worx','Kress','Hunter','מכסחת','ג'יגסו'];

  const input = document.getElementById('searchInput');
  const dropdown = document.getElementById('searchDropdown');
  const clearBtn = document.getElementById('searchClear');
  const overlay = document.getElementById('searchOverlay');
  const submitBtn = document.getElementById('searchSubmit');

  if (!input) return;

  let timer = null;
  let selectedIndex = -1;
  let isOpen = false;

  // ── RECENT SEARCHES ──
  function getRecent() {
    try { return JSON.parse(localStorage.getItem(RECENT_KEY) || '[]'); } catch { return []; }
  }
  function addRecent(q) {
    let r = getRecent().filter(x => x !== q);
    r.unshift(q);
    r = r.slice(0, MAX_RECENT);
    localStorage.setItem(RECENT_KEY, JSON.stringify(r));
  }

  // ── HIGHLIGHT ──
  function hl(text, q) {
    if (!q) return text;
    const re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&') + ')', 'gi');
    return text.replace(re, '<mark>$1</mark>');
  }

  // ── SEARCH ──
  function doSearch(q) {
    q = q.trim().toLowerCase();
    const prods = MOCK_PRODUCTS.filter(p =>
      p.name.toLowerCase().includes(q) ||
      p.brand.toLowerCase().includes(q) ||
      p.sku.toLowerCase().includes(q) ||
      p.cat.toLowerCase().includes(q)
    ).slice(0, 6);

    const cats = MOCK_CATS.filter(c =>
      c.name.toLowerCase().includes(q) ||
      MOCK_PRODUCTS.some(p => p.cat === c.name && (
        p.brand.toLowerCase().includes(q) || p.name.toLowerCase().includes(q)
      ))
    ).slice(0, 5);

    return { prods, cats };
  }

  // ── RENDER ──
  function render(q) {
    selectedIndex = -1;
    if (!q.trim()) { renderEmpty(); return; }

    dropdown.innerHTML = '<div class="sd-loading"><div class="sd-spinner"></div> מחפש...</div>';
    openDd();

    setTimeout(() => {
      const { prods, cats } = doSearch(q);
      if (!prods.length && !cats.length) { renderNoResults(q); return; }

      let html = '';

      if (cats.length) {
        html += `<div class="sd-section"><div class="sd-section-title">קטגוריות <a href="/shop/?s=${encodeURIComponent(q)}">כל התוצאות</a></div><div class="sd-cats">`;
        cats.forEach(c => {
          html += `<a class="sd-cat-chip" href="${c.url}"><span class="sd-cat-chip-icon">${c.icon}</span>${c.name}</a>`;
        });
        html += '</div></div>';
      }

      if (prods.length) {
        html += `<div class="sd-section"><div class="sd-section-title">מוצרים ${prods.length < MOCK_PRODUCTS.filter(p=>doSearch(q).prods.includes(p)).length ? `<a href="/shop/?s=${encodeURIComponent(q)}">כל ${MOCK_PRODUCTS.filter(p=>doSearch(q).prods.includes(p)).length}+ התוצאות</a>` : ''}</div>`;
        prods.forEach((p, i) => {
          html += `<a class="sd-prod" href="/product/${p.id}/" data-idx="${i}">
            <div class="sd-prod-img">${p.img}</div>
            <div class="sd-prod-info">
              <div class="sd-prod-brand">${p.brand}</div>
              <div class="sd-prod-name">${hl(p.name, q)}</div>
              <div class="sd-prod-meta">${p.cat} · ${p.sku}</div>
            </div>
            <div class="sd-prod-price">
              ${p.price}
              ${p.old ? `<span class="old">${p.old}</span>` : ''}
              ${p.badge ? `<span class="sd-prod-badge">${p.badge}</span>` : ''}
            </div>
          </a>`;
        });
        html += '</div>';
        html += `<div class="sd-footer"><span class="sd-footer-count">נמצאו <strong>${prods.length}+</strong> מוצרים</span><button class="sd-footer-btn" onclick="location.href='/shop/?s=${encodeURIComponent(q)}'">כל התוצאות ←</button></div>`;
      }

      html += '<div class="sd-keys"><span><kbd class="kbd">↑↓</kbd> ניווט</span><span><kbd class="kbd">Enter</kbd> בחירה</span><span><kbd class="kbd">Esc</kbd> סגירה</span></div>';
      dropdown.innerHTML = html;
      openDd();
    }, 180);
  }

  function renderEmpty() {
    const recent = getRecent();
    let html = '';
    if (recent.length) {
      html += '<div class="sd-section"><div class="sd-section-title">חיפושים אחרונים</div>';
      recent.forEach(r => {
        html += `<div class="sd-recent" onclick="setQuery('${r}')"><span class="sd-recent-icon">🕐</span>${r}</div>`;
      });
      html += '</div>';
    }
    html += '<div class="sd-section"><div class="sd-section-title">חיפושים פופולריים</div><div class="sd-popular">';
    POPULAR.forEach(p => {
      html += `<div class="sd-popular-chip" onclick="setQuery('${p}')">${p}</div>`;
    });
    html += '</div></div>';
    dropdown.innerHTML = html;
    openDd();
  }

  function renderNoResults(q) {
    dropdown.innerHTML = `<div class="sd-no-results">
      <div class="sd-no-icon">🔍</div>
      <div class="sd-no-title">לא נמצאו תוצאות עבור "${q}"</div>
      <div class="sd-no-sub">נסה מילה אחרת, שם מותג, או קטגוריה</div>
      <div class="sd-suggestions">${POPULAR.map(p => `<div class="sd-sug" onclick="setQuery('${p}')">${p}</div>`).join('')}</div>
    </div>`;
  }

  // ── OPEN / CLOSE ──
  function openDd() {
    dropdown.classList.add('open');
    overlay.classList.add('show');
    isOpen = true;
  }
  function closeDd() {
    dropdown.classList.remove('open');
    overlay.classList.remove('show');
    isOpen = false;
    selectedIndex = -1;
  }

  window.setQuery = function(q) {
    input.value = q;
    clearBtn.classList.add('visible');
    render(q);
    input.focus();
  };

  // ── EVENTS ──
  input.addEventListener('input', e => {
    const q = e.target.value;
    clearBtn.classList.toggle('visible', q.length > 0);
    clearTimeout(timer);
    if (!q.trim()) { renderEmpty(); return; }
    timer = setTimeout(() => render(q), 200);
  });

  input.addEventListener('focus', () => {
    if (input.value.trim()) render(input.value);
    else renderEmpty();
  });

  clearBtn.addEventListener('click', () => {
    input.value = '';
    clearBtn.classList.remove('visible');
    closeDd();
    input.focus();
  });

  submitBtn.addEventListener('click', () => {
    const q = input.value.trim();
    if (q) { addRecent(q); location.href = `/shop/?s=${encodeURIComponent(q)}`; }
  });

  // Keyboard nav
  input.addEventListener('keydown', e => {
    const items = dropdown.querySelectorAll('.sd-prod');
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
      items.forEach((el,i) => el.classList.toggle('highlighted', i === selectedIndex));
      if (items[selectedIndex]) items[selectedIndex].scrollIntoView({block:'nearest'});
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      selectedIndex = Math.max(selectedIndex - 1, -1);
      items.forEach((el,i) => el.classList.toggle('highlighted', i === selectedIndex));
    } else if (e.key === 'Enter') {
      if (selectedIndex >= 0 && items[selectedIndex]) {
        items[selectedIndex].click();
      } else {
        const q = input.value.trim();
        if (q) { addRecent(q); location.href = `/shop/?s=${encodeURIComponent(q)}`; }
      }
    } else if (e.key === 'Escape') {
      closeDd();
      input.blur();
    }
  });

  overlay.addEventListener('click', closeDd);
  document.addEventListener('click', e => {
    if (!document.getElementById('searchWrap').contains(e.target)) closeDd();
  });
})();

/* === barel-homepage.html === */
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "בר-אל אופיר בע״מ",
    "url": "https://www.barel-ofir.co.il",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://www.barel-ofir.co.il/?s={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  }

/* === barel-category.html === */
// ── SIDEBAR MOBILE ──
function openSidebar() {
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('sidebarOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ── FILTER TOGGLE ──
function toggleFilter(head) {
  const body = head.nextElementSibling;
  head.classList.toggle('open');
  body.classList.toggle('open');
}

// ── VIEW TOGGLE ──
function setView(v) {
  const grid = document.getElementById('prodsGrid');
  document.getElementById('gridBtn').classList.toggle('active', v === 'grid');
  document.getElementById('listBtn').classList.toggle('active', v === 'list');
  if (v === 'list') {
    grid.style.gridTemplateColumns = '1fr';
    grid.querySelectorAll('.prod-card').forEach(c => {
      c.style.flexDirection = 'row';
      c.querySelector('.prod-img').style.width = '140px';
      c.querySelector('.prod-img').style.height = '120px';
      c.querySelector('.prod-img').style.flexShrink = '0';
    });
  } else {
    grid.style.gridTemplateColumns = '';
    grid.querySelectorAll('.prod-card').forEach(c => {
      c.style.flexDirection = '';
      c.querySelector('.prod-img').style.width = '';
      c.querySelector('.prod-img').style.height = '';
      c.querySelector('.prod-img').style.flexShrink = '';
    });
  }
}

// ── PRICE RANGE SYNC ──
document.getElementById('priceRange').addEventListener('input', function() {
  document.getElementById('priceMax').value = this.value;
});
document.getElementById('priceMax').addEventListener('input', function() {
  document.getElementById('priceRange').value = this.value;
});

// ── APPLY FILTERS (demo) ──
function applyFilters() {
  // בפרודקשן - Ajax request ל-WooCommerce
  console.log('Applying filters...');
  // Reset infinite scroll
  page = 2;
  finished = false;
}

// ── CLEAR FILTERS ──
function clearAllFilters() {
  document.querySelectorAll('.filter-opt input, .star-opt input').forEach(i => i.checked = false);
  document.getElementById('priceMin').value = 0;
  document.getElementById('priceMax').value = 2000;
  document.getElementById('priceRange').value = 2000;
  document.getElementById('activeFilters').style.display = 'none';
}

function removeFilter(btn) {
  btn.closest('.active-tag').remove();
  if (!document.querySelectorAll('.active-tag').length) {
    document.getElementById('activeFilters').style.display = 'none';
  }
}

// ── INFINITE SCROLL ──
let page = 2;
let loading = false;
let finished = false;
const maxPages = 27; // demo

// Mock products for infinite scroll demo
const mockProducts = [
  {brand:'Worx', name:'מברגה קורדלס WX101', price:'₪380', badge:''},
  {brand:'Hunter Tools', name:'מסור עגול 185mm HT-85', price:'₪560', badge:'b-sale'},
  {brand:'Kress', name:'גראינדר 125mm KU500', price:'₪440', badge:'b-new'},
  {brand:'Signet', name:'פטיש הרס SDS+ SG-200', price:'₪720', badge:''},
  {brand:'Worx', name:'ג'יגסו WX480 650W', price:'₪310', badge:'b-hot'},
  {brand:'Hunter Tools', name:'מברגה מקוונת HT-306', price:'₪490', badge:'b-sale'},
];

function createProductCard(p) {
  return `<article class="prod-card">
    <div class="prod-img">🔧${p.badge ? `<span class="badge ${p.badge}">מבצע</span>` : ''}<button class="prod-wishlist">♡</button></div>
    <div class="prod-body">
      <div class="prod-brand">${p.brand}</div>
      <div class="prod-name">${p.name}</div>
      <div class="prod-stars">★★★★☆ <span>(42)</span></div>
    </div>
    <div class="prod-footer">
      <div><div class="price-main">${p.price}</div></div>
      <button class="add-btn">+ לעגלה</button>
    </div>
  </article>`;
}

window.addEventListener('scroll', function() {
  if (loading || finished) return;
  const scrollBottom = window.scrollY + window.innerHeight;
  const docHeight = document.documentElement.scrollHeight;
  
  if (scrollBottom >= docHeight - 500) {
    loading = true;
    document.getElementById('infLoader').style.display = 'block';
    
    // Simulate API call
    setTimeout(() => {
      if (page > maxPages) {
        finished = true;
        document.getElementById('infLoader').style.display = 'none';
        document.getElementById('infEnd').style.display = 'block';
        return;
      }
      
      const grid = document.getElementById('prodsGrid');
      const newCards = mockProducts.map(p => createProductCard(p)).join('');
      grid.insertAdjacentHTML('beforeend', newCards);
      
      // Update count
      const shown = grid.querySelectorAll('.prod-card').length;
      document.getElementById('countShown').textContent = '1–' + shown;
      
      page++;
      loading = false;
      document.getElementById('infLoader').style.display = 'none';
    }, 800);
  }
});

// Header scroll effect
window.addEventListener('scroll', () => {
  document.querySelector('header').style.boxShadow = window.scrollY > 10 
    ? '0 2px 20px rgba(0,0,0,.12)' 
    : '0 1px 4px rgba(0,0,0,.08)';
});

// ── ADVANCED LIVE SEARCH ──
(function() {
  const RECENT_KEY = 'barel_recent_searches';
  const MAX_RECENT = 5;

  // Mock data (בפרודקשן - Ajax מ-WooCommerce)
  const MOCK_PRODUCTS = [
    {id:1,brand:'Hunter Tools',name:'מקדחה קורדלס 18V PRO',cat:'כלי עבודה חשמליים',sku:'HT-201',price:'₪489',old:'₪699',img:'🔧',badge:'-30%'},
    {id:2,brand:'Worx',name:'מסור עגול 190mm WX530',cat:'כלי עבודה חשמליים',sku:'WX530',price:'₪620',old:'',img:'🪚',badge:''},
    {id:3,brand:'Kress',name:'מברגה קורדלס 20V KU310',cat:'כלי עבודה חשמליים',sku:'KU310',price:'₪549',old:'',img:'🪛',badge:'פופולרי'},
    {id:4,brand:'Signet',name:'פטיש הרס SDS 800W',cat:'כלי עבודה חשמליים',sku:'SG-800',price:'₪890',old:'₪1120',img:'🔨',badge:'-20%'},
    {id:5,brand:'Worx',name:'ג'יגסו 650W WX477',cat:'כלי עבודה חשמליים',sku:'WX477',price:'₪290',old:'₪340',img:'🔌',badge:''},
    {id:6,brand:'Hunter Tools',name:'גראינדר זווית 125mm',cat:'כלי עבודה חשמליים',sku:'HT-125',price:'₪340',old:'',img:'⚙️',badge:''},
    {id:7,brand:'Kress',name:'מסור שרשרת 18V KU405',cat:'כלי גינון חשמליים',sku:'KU405',price:'₪780',old:'',img:'🌲',badge:'חדש'},
    {id:8,brand:'Worx',name:'מכסחת דשא WG779',cat:'כלי גינון חשמליים',sku:'WG779',price:'₪1290',old:'₪1590',img:'🌱',badge:'-18%'},
    {id:9,brand:'Signet',name:'ארגז כלים מקצועי SG-400',cat:'כלי עבודה ידניים',sku:'SG-400',price:'₪380',old:'',img:'🧰',badge:''},
    {id:10,brand:'Hunter Tools',name:'סט מפתחות 24 חלקים',cat:'כלי עבודה ידניים',sku:'HT-SET24',price:'₪220',old:'₪280',img:'🔑',badge:''},
    {id:11,brand:'Worx',name:'מפוח עלים WG575',cat:'כלי גינון חשמליים',sku:'WG575',price:'₪420',old:'',img:'💨',badge:''},
    {id:12,brand:'Kress',name:'גוזמת גינה חשמלית KU601',cat:'כלי גינון חשמליים',sku:'KU601',price:'₪350',old:'₪440',img:'✂️',badge:''},
  ];

  const MOCK_CATS = [
    {name:'כלי עבודה חשמליים',icon:'⚡',url:'/product-category/kley-avoda-hashmaliyim/',count:320},
    {name:'כלי עבודה ידניים',icon:'🔧',url:'/product-category/kley-avoda-yadaniyim/',count:280},
    {name:'כלי גינון חשמליים',icon:'🌿',url:'/product-category/kley-ginun-hashmaliyim/',count:145},
    {name:'כלי גינון ידניים',icon:'🪴',url:'/product-category/kley-ginun-yadaniyim/',count:98},
    {name:'אביזרים לכלי עבודה',icon:'🔩',url:'/product-category/avizarim/',count:410},
    {name:'טמבוריה',icon:'🥁',url:'/product-category/tamboria/',count:55},
    {name:'מברגות קורדלס',icon:'🪛',url:'/product-category/mevragot/',count:84},
    {name:'מסורים חשמליים',icon:'🪚',url:'/product-category/masarim-hashmal/',count:62},
    {name:'מכונות שטיפה',icon:'💦',url:'/product-category/mekonot-shetifa/',count:33},
  ];

  const POPULAR = ['מברגה','מסור','גראינדר','Worx','Kress','Hunter','מכסחת','ג'יגסו'];

  const input = document.getElementById('searchInput');
  const dropdown = document.getElementById('searchDropdown');
  const clearBtn = document.getElementById('searchClear');
  const overlay = document.getElementById('searchOverlay');
  const submitBtn = document.getElementById('searchSubmit');

  if (!input) return;

  let timer = null;
  let selectedIndex = -1;
  let isOpen = false;

  // ── RECENT SEARCHES ──
  function getRecent() {
    try { return JSON.parse(localStorage.getItem(RECENT_KEY) || '[]'); } catch { return []; }
  }
  function addRecent(q) {
    let r = getRecent().filter(x => x !== q);
    r.unshift(q);
    r = r.slice(0, MAX_RECENT);
    localStorage.setItem(RECENT_KEY, JSON.stringify(r));
  }

  // ── HIGHLIGHT ──
  function hl(text, q) {
    if (!q) return text;
    const re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&') + ')', 'gi');
    return text.replace(re, '<mark>$1</mark>');
  }

  // ── SEARCH ──
  function doSearch(q) {
    q = q.trim().toLowerCase();
    const prods = MOCK_PRODUCTS.filter(p =>
      p.name.toLowerCase().includes(q) ||
      p.brand.toLowerCase().includes(q) ||
      p.sku.toLowerCase().includes(q) ||
      p.cat.toLowerCase().includes(q)
    ).slice(0, 6);

    const cats = MOCK_CATS.filter(c =>
      c.name.toLowerCase().includes(q) ||
      MOCK_PRODUCTS.some(p => p.cat === c.name && (
        p.brand.toLowerCase().includes(q) || p.name.toLowerCase().includes(q)
      ))
    ).slice(0, 5);

    return { prods, cats };
  }

  // ── RENDER ──
  function render(q) {
    selectedIndex = -1;
    if (!q.trim()) { renderEmpty(); return; }

    dropdown.innerHTML = '<div class="sd-loading"><div class="sd-spinner"></div> מחפש...</div>';
    openDd();

    setTimeout(() => {
      const { prods, cats } = doSearch(q);
      if (!prods.length && !cats.length) { renderNoResults(q); return; }

      let html = '';

      if (cats.length) {
        html += `<div class="sd-section"><div class="sd-section-title">קטגוריות <a href="/shop/?s=${encodeURIComponent(q)}">כל התוצאות</a></div><div class="sd-cats">`;
        cats.forEach(c => {
          html += `<a class="sd-cat-chip" href="${c.url}"><span class="sd-cat-chip-icon">${c.icon}</span>${c.name}</a>`;
        });
        html += '</div></div>';
      }

      if (prods.length) {
        html += `<div class="sd-section"><div class="sd-section-title">מוצרים ${prods.length < MOCK_PRODUCTS.filter(p=>doSearch(q).prods.includes(p)).length ? `<a href="/shop/?s=${encodeURIComponent(q)}">כל ${MOCK_PRODUCTS.filter(p=>doSearch(q).prods.includes(p)).length}+ התוצאות</a>` : ''}</div>`;
        prods.forEach((p, i) => {
          html += `<a class="sd-prod" href="/product/${p.id}/" data-idx="${i}">
            <div class="sd-prod-img">${p.img}</div>
            <div class="sd-prod-info">
              <div class="sd-prod-brand">${p.brand}</div>
              <div class="sd-prod-name">${hl(p.name, q)}</div>
              <div class="sd-prod-meta">${p.cat} · ${p.sku}</div>
            </div>
            <div class="sd-prod-price">
              ${p.price}
              ${p.old ? `<span class="old">${p.old}</span>` : ''}
              ${p.badge ? `<span class="sd-prod-badge">${p.badge}</span>` : ''}
            </div>
          </a>`;
        });
        html += '</div>';
        html += `<div class="sd-footer"><span class="sd-footer-count">נמצאו <strong>${prods.length}+</strong> מוצרים</span><button class="sd-footer-btn" onclick="location.href='/shop/?s=${encodeURIComponent(q)}'">כל התוצאות ←</button></div>`;
      }

      html += '<div class="sd-keys"><span><kbd class="kbd">↑↓</kbd> ניווט</span><span><kbd class="kbd">Enter</kbd> בחירה</span><span><kbd class="kbd">Esc</kbd> סגירה</span></div>';
      dropdown.innerHTML = html;
      openDd();
    }, 180);
  }

  function renderEmpty() {
    const recent = getRecent();
    let html = '';
    if (recent.length) {
      html += '<div class="sd-section"><div class="sd-section-title">חיפושים אחרונים</div>';
      recent.forEach(r => {
        html += `<div class="sd-recent" onclick="setQuery('${r}')"><span class="sd-recent-icon">🕐</span>${r}</div>`;
      });
      html += '</div>';
    }
    html += '<div class="sd-section"><div class="sd-section-title">חיפושים פופולריים</div><div class="sd-popular">';
    POPULAR.forEach(p => {
      html += `<div class="sd-popular-chip" onclick="setQuery('${p}')">${p}</div>`;
    });
    html += '</div></div>';
    dropdown.innerHTML = html;
    openDd();
  }

  function renderNoResults(q) {
    dropdown.innerHTML = `<div class="sd-no-results">
      <div class="sd-no-icon">🔍</div>
      <div class="sd-no-title">לא נמצאו תוצאות עבור "${q}"</div>
      <div class="sd-no-sub">נסה מילה אחרת, שם מותג, או קטגוריה</div>
      <div class="sd-suggestions">${POPULAR.map(p => `<div class="sd-sug" onclick="setQuery('${p}')">${p}</div>`).join('')}</div>
    </div>`;
  }

  // ── OPEN / CLOSE ──
  function openDd() {
    dropdown.classList.add('open');
    overlay.classList.add('show');
    isOpen = true;
  }
  function closeDd() {
    dropdown.classList.remove('open');
    overlay.classList.remove('show');
    isOpen = false;
    selectedIndex = -1;
  }

  window.setQuery = function(q) {
    input.value = q;
    clearBtn.classList.add('visible');
    render(q);
    input.focus();
  };

  // ── EVENTS ──
  input.addEventListener('input', e => {
    const q = e.target.value;
    clearBtn.classList.toggle('visible', q.length > 0);
    clearTimeout(timer);
    if (!q.trim()) { renderEmpty(); return; }
    timer = setTimeout(() => render(q), 200);
  });

  input.addEventListener('focus', () => {
    if (input.value.trim()) render(input.value);
    else renderEmpty();
  });

  clearBtn.addEventListener('click', () => {
    input.value = '';
    clearBtn.classList.remove('visible');
    closeDd();
    input.focus();
  });

  submitBtn.addEventListener('click', () => {
    const q = input.value.trim();
    if (q) { addRecent(q); location.href = `/shop/?s=${encodeURIComponent(q)}`; }
  });

  // Keyboard nav
  input.addEventListener('keydown', e => {
    const items = dropdown.querySelectorAll('.sd-prod');
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
      items.forEach((el,i) => el.classList.toggle('highlighted', i === selectedIndex));
      if (items[selectedIndex]) items[selectedIndex].scrollIntoView({block:'nearest'});
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      selectedIndex = Math.max(selectedIndex - 1, -1);
      items.forEach((el,i) => el.classList.toggle('highlighted', i === selectedIndex));
    } else if (e.key === 'Enter') {
      if (selectedIndex >= 0 && items[selectedIndex]) {
        items[selectedIndex].click();
      } else {
        const q = input.value.trim();
        if (q) { addRecent(q); location.href = `/shop/?s=${encodeURIComponent(q)}`; }
      }
    } else if (e.key === 'Escape') {
      closeDd();
      input.blur();
    }
  });

  overlay.addEventListener('click', closeDd);
  document.addEventListener('click', e => {
    if (!document.getElementById('searchWrap').contains(e.target)) closeDd();
  });
})();

/* === barel-product.html === */
{"@context":"https://schema.org","@type":"Product","name":"מקדחה קורדלס DeWalt DCD776 18V","brand":{"@type":"Brand","name":"DeWalt"},"offers":{"@type":"Offer","price":"489","priceCurrency":"ILS","availability":"https://schema.org/InStock"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","reviewCount":"214"}}

/* === barel-product.html === */
function showTab(id){
  document.querySelectorAll('.tab-content').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  event.target.classList.add('active');
}
// Qty buttons
document.querySelectorAll('.qty-btn').forEach(btn=>{
  btn.addEventListener('click',()=>{
    const input=btn.parentElement.querySelector('.qty-num');
    let v=parseInt(input.value);
    if(btn.textContent==='+'&&v<99)input.value=v+1;
    if(btn.textContent==='−'&&v>1)input.value=v-1;
  });
});

/* === barel-cart.html === */
{"@context":"https://schema.org","@type":"CheckoutPage","name":"עגלת קניות"}

/* === barel-checkout.html === */
const BASE = 2278;
let ship = 0, disc = 0;

// חישוב תאריך לפי ימי עסקים (ללא שישי=5 ושבת=6)
function addBusinessDays(days) {
  const d = new Date();
  // אם אחרי 14:00 – מתחילים מחר
  if (d.getHours() >= 14) d.setDate(d.getDate() + 1);
  let added = 0;
  while (added < days) {
    d.setDate(d.getDate() + 1);
    const dow = d.getDay();
    if (dow !== 5 && dow !== 6) added++; // דלג שישי ושבת
  }
  const days_heb = ['ראשון','שני','שלישי','רביעי','חמישי','שישי','שבת'];
  return 'יום ' + days_heb[d.getDay()] + ' ' + d.getDate() + '/' + (d.getMonth()+1);
}

// Init delivery dates
document.getElementById('date1').textContent = addBusinessDays(7);
document.getElementById('date2').textContent = addBusinessDays(2);

// Shipping select
function pickShip(cost, el) {
  document.querySelectorAll('.s-opt').forEach(o => o.classList.remove('on'));
  el.classList.add('on');
  ship = cost;
  const r = document.getElementById('shipRow');
  r.innerHTML = cost ? '<span>משלוח</span><span>₪'+cost+'</span>'
    : '<span>משלוח</span><span class="green">חינם ✓</span>';
  calc();
}

// Payment select
function pickPay(type, el) {
  document.querySelectorAll('.p-opt').forEach(o => o.classList.remove('on'));
  el.classList.add('on');
  document.getElementById('ccWrap').style.display = type==='cc' ? 'block' : 'none';
  document.getElementById('bitInfo').style.display = type==='bit' ? 'block' : 'none';
  document.getElementById('bankInfo').style.display = type==='bank' ? 'block' : 'none';
}

// Calc
function calc() {
  const t = BASE - disc + ship;
  const f = '₪' + t.toLocaleString();
  document.getElementById('tot').textContent = f;
  document.getElementById('tot2').textContent = f;
  document.getElementById('tot3').textContent = f;
  updateInstall();
}

function updateInstall() {
  const n = parseInt(document.getElementById('inst').value);
  const t = BASE - disc + ship;
  const el = document.getElementById('instAmt');
  el.textContent = n > 1 ? n + ' × ₪' + Math.ceil(t/n).toLocaleString() : '';
}

// Coupon - hidden toggle
function toggleCoupon() {
  const w = document.getElementById('cpnWrap');
  w.style.display = w.style.display === 'none' ? 'flex' : 'none';
  if (w.style.display !== 'none') document.getElementById('cpn').focus();
}

const CPNS = {'BAREL10':10,'TOOLS20':20,'VIP15':15};
function applyCpn() {
  const code = document.getElementById('cpn').value.trim().toUpperCase();
  const msg = document.getElementById('cpnMsg');
  if (CPNS[code]) {
    const pct = CPNS[code];
    disc = Math.round(BASE * pct / 100);
    msg.style.color = '#1a7a3a';
    msg.textContent = '✓ חיסכון ₪' + disc + '!';
    document.getElementById('discRow').style.display = 'flex';
    document.getElementById('discAmt').textContent = '-₪' + disc;
  } else {
    msg.style.color = '#e53935';
    msg.textContent = '✗ קוד לא תקין';
    disc = 0;
    document.getElementById('discRow').style.display = 'none';
  }
  calc();
}

// CC format
function fCC(el) {
  let v = el.value.replace(/\D/g,'').substring(0,16);
  el.value = v.replace(/(\d{4})/g,'$1 ').trim();
}
function fExp(el) {
  let v = el.value.replace(/\D/g,'').substring(0,4);
  if (v.length >= 2) v = v.slice(0,2)+'/'+v.slice(2);
  el.value = v;
}

// Validate
function val() {
  const ids = ['fn','ph','em','addr','city'];
  let ok = true;
  ids.forEach(id => {
    const el = document.getElementById(id);
    if (!el.value.trim()) { el.classList.add('e'); ok = false; }
    else el.classList.remove('e');
  });
  if (!ok) {
    document.querySelector('.e').scrollIntoView({behavior:'smooth',block:'center'});
    shake(document.querySelector('.e'));
  }
  return ok;
}

function shake(el) {
  el.style.animation = 'shake .4s ease';
  setTimeout(() => el.style.animation = '', 400);
}

// Submit
function go() {
  if (!val()) return;
  document.getElementById('overlay').classList.add('on');
  setTimeout(() => {
    const n = '#' + (Math.floor(Math.random()*9000)+1000);
    document.getElementById('overlay').innerHTML =
      '<div class="done"><div style="font-size:56px">🎉</div>' +
      '<h2>ההזמנה התקבלה!</h2>' +
      '<p>תודה על הרכישה!<br>אישור נשלח לאימייל שלך<br><strong>הזמנה ' + n + '</strong></p>' +
      '<a href="/" class="done-btn">חזרה לחנות</a></div>';
  }, 1600);
}

// Remove error on input
document.querySelectorAll('input').forEach(i => i.addEventListener('input', () => i.classList.remove('e')));
calc();


// Show sticky bar on mobile when scrolled
if (window.innerWidth <= 740) {
  document.getElementById('stickyBar').style.display = 'block';
}

/* === barel-contact.html === */
{"@context":"https://schema.org","@type":"ContactPage","name":"צור קשר – בר-אל אופיר","url":"https://www.barel-ofir.co.il/contact/"}

/* === barel-my-account.html === */
{"@context":"https://schema.org","@type":"ProfilePage","name":"החשבון שלי"}

/* === barel-about.html === */
{"@context":"https://schema.org","@type":"AboutPage","name":"אודות בר-אל אופיר בע״מ","url":"https://www.barel-ofir.co.il/about/"}