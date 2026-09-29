/**
 * TechStore — клиентские скрипты.
 * 1. Мобильное меню
 * 2. Слайдер акций (свайпы, автопрокрутка, точки)
 * 3. «Живой» поиск в каталоге
 * 4. Показ/скрытие пароля
 * 5. Уведомление «Добавлено в корзину»
 */
document.addEventListener('DOMContentLoaded', () => {
  initBurger();
  document.querySelectorAll('.slider').forEach(initSlider);
  initLiveSearch();
  initPasswordToggles();
  initCartButtons();
});

/* ---------- 1. Мобильное меню ---------- */
function initBurger() {
  const burger = document.querySelector('.burger');
  const nav = document.getElementById('main-nav');
  if (!burger || !nav) return;

  burger.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    burger.classList.toggle('open', open);
    burger.setAttribute('aria-expanded', String(open));
  });
}

/* ---------- 2. Слайдер ---------- */
function initSlider(slider) {
  const track = slider.querySelector('.slider-track');
  const slides = Array.from(slider.querySelectorAll('.slide'));
  const dotsWrap = slider.querySelector('.slider-dots');
  const prevBtn = slider.querySelector('.slider-prev');
  const nextBtn = slider.querySelector('.slider-next');
  const delay = Number(slider.dataset.autoplay) || 0;
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!track || slides.length === 0) return;

  let current = 0;
  let timer = null;

  const dots = slides.map((_, i) => {
    const dot = document.createElement('button');
    dot.type = 'button';
    dot.className = 'slider-dot';
    dot.setAttribute('role', 'tab');
    dot.setAttribute('aria-label', `Перейти к слайду ${i + 1}`);
    dot.addEventListener('click', () => { goTo(i); restart(); });
    dotsWrap?.appendChild(dot);
    return dot;
  });

  function goTo(index) {
    current = (index + slides.length) % slides.length;
    track.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === current);
      dot.setAttribute('aria-selected', String(i === current));
    });
    slides.forEach((slide, i) => slide.setAttribute('aria-hidden', String(i !== current)));
  }

  function start() {
    if (delay && !reduceMotion) timer = setInterval(() => goTo(current + 1), delay);
  }
  function stop() { clearInterval(timer); }
  function restart() { stop(); start(); }

  prevBtn?.addEventListener('click', () => { goTo(current - 1); restart(); });
  nextBtn?.addEventListener('click', () => { goTo(current + 1); restart(); });

  // Пауза при наведении мышью и при фокусе с клавиатуры
  slider.addEventListener('mouseenter', stop);
  slider.addEventListener('mouseleave', restart);
  slider.addEventListener('focusin', (e) => { if (e.target.matches(':focus-visible')) stop(); });
  slider.addEventListener('focusout', restart);

  // Клавиатура
  slider.tabIndex = 0;
  slider.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') { goTo(current - 1); restart(); }
    if (e.key === 'ArrowRight') { goTo(current + 1); restart(); }
  });

  // Свайпы на тач-экранах
  let startX = 0;
  let deltaX = 0;
  track.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    deltaX = 0;
    stop();
  }, { passive: true });
  track.addEventListener('touchmove', (e) => {
    deltaX = e.touches[0].clientX - startX;
  }, { passive: true });
  track.addEventListener('touchend', () => {
    if (Math.abs(deltaX) > 50) goTo(current + (deltaX < 0 ? 1 : -1));
    start();
  });

  // Не крутим слайды во вкладке, которая не видна
  document.addEventListener('visibilitychange', () => (document.hidden ? stop() : restart()));

  goTo(0);
  start();
}

/* ---------- 3. «Живой» поиск ---------- */
function initLiveSearch() {
  const input = document.getElementById('live-search');
  if (!input) return;

  const cards = Array.from(document.querySelectorAll('.product-card'));
  const blocks = Array.from(document.querySelectorAll('.category-block'));
  const counter = document.getElementById('search-count');
  const empty = document.getElementById('no-results');

  input.addEventListener('input', () => {
    const query = input.value.trim().toLowerCase();
    let visible = 0;

    cards.forEach((card) => {
      const haystack = `${card.dataset.name} ${card.dataset.category} ${card.dataset.description}`;
      const match = query === '' || haystack.includes(query);
      card.hidden = !match;
      if (match) visible++;
    });

    // Прячем категорию, если в ней не осталось товаров
    blocks.forEach((block) => {
      block.hidden = !block.querySelector('.product-card:not([hidden])');
    });

    if (counter) counter.textContent = query ? `Найдено: ${visible}` : '';
    if (empty) empty.hidden = visible !== 0;
  });
}

/* ---------- 4. Показ пароля ---------- */
function initPasswordToggles() {
  document.querySelectorAll('.toggle-password').forEach((btn) => {
    btn.addEventListener('click', () => {
      const input = btn.previousElementSibling;
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.setAttribute('aria-label', show ? 'Скрыть пароль' : 'Показать пароль');
      btn.classList.toggle('active', show);
    });
  });
}

/* ---------- 5. Корзина (демо-уведомление) ---------- */
function initCartButtons() {
  document.querySelectorAll('.js-add-to-cart').forEach((btn) => {
    btn.addEventListener('click', () => showToast(`«${btn.dataset.name}» добавлен в корзину`));
  });
}

function showToast(text) {
  let toast = document.querySelector('.toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.className = 'toast';
    toast.setAttribute('role', 'status');
    document.body.appendChild(toast);
  }
  toast.textContent = text;
  toast.classList.add('show');
  clearTimeout(showToast.timer);
  showToast.timer = setTimeout(() => toast.classList.remove('show'), 2500);
}
