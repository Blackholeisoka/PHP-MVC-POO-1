const typeList = document.querySelectorAll('.content_type div');
const inputType = document.querySelector('#content_type');
const form = document.querySelector('form');
const search = document.querySelector('#search');
const before = document.querySelector('.footer_container_before');
const next = document.querySelector('.footer_container_next');
const counter = document.querySelector('#counter_start');

(function preloadFromLocalStorage() {
    const shouldClear = window.localStorage.getItem('clear_search_on_load') === 'true';
    if (shouldClear) {
        window.localStorage.removeItem('search');
        window.localStorage.removeItem('clear_search_on_load');
        search.value = '';
    } else {
        const savedSearch = window.localStorage.getItem('search');
        if (savedSearch !== null) search.value = savedSearch;
    }

    const savedCounter = window.localStorage.getItem('counter_start');
    const savedType = window.localStorage.getItem('type_class');

    if (savedCounter !== null && !isNaN(savedCounter)) counter.value = savedCounter;
    if (savedType !== null) inputType.value = savedType;
})();

search.addEventListener('input', () => {
    const raw = search.value;
    const clean = raw.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    search.value = clean;
    window.localStorage.setItem('search', clean);
});

function saveAndSubmit() {
    const lastSearch = window.localStorage.getItem('search') || '';
    search.value = lastSearch;
    window.localStorage.setItem('counter_start', counter.value);
    window.localStorage.setItem('search', search.value);
    window.localStorage.setItem('type_class', inputType.value);
    setTimeout(() => {
        form.submit();
    }, 0);
}

function submitSearchWithReset() {
    let searchValue = search.value.trim();

    if (!searchValue) {
        const lastSearch = window.localStorage.getItem('search');
        if (!lastSearch) return;
        searchValue = lastSearch;
        search.value = lastSearch;
    }

    inputType.value = inputType.value || window.localStorage.getItem('type_class') || 'website';

    window.localStorage.setItem('search', searchValue);
    window.localStorage.setItem('type_class', inputType.value);
    window.localStorage.setItem('counter_start', '0');

    setTimeout(() => {
        form.submit();
    }, 0);
}

typeList.forEach((t) => {
    t.addEventListener('click', () => {
        inputType.value = t.className;
        window.localStorage.setItem('type_class', t.className);
        submitSearchWithReset();
    });
});

next.addEventListener('click', () => {
    const current = parseInt(counter.value || '0', 10);
    counter.value = current + 15;
    saveAndSubmit();
});

before.addEventListener('click', () => {
    const current = parseInt(counter.value || '0', 10);
    counter.value = Math.max(0, current - 15);
    saveAndSubmit();
});