document.addEventListener('DOMContentLoaded', () => {
    const storagePrefix = 'loved_';
    const buttonsSelector = '.love-button';
    const loveCountSelector = '.love-count';
    const ajaxUrl = loveButtonAjax.ajax_url;

    const observer = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;

                const button = entry.target;
                const postId = button.dataset.postId;
                if (!postId) continue;

                const storageKey = storagePrefix + postId;

                if (localStorage.getItem(storageKey)) {
                    button.classList.add('loved');
                }

                observer.unobserve(button);
            }
        },
        {
            rootMargin: '100px 0px', // preload a bit before visible
            threshold: 0.01,
        }
    );

    const observeNewButtons = () => {
        document
            .querySelectorAll(`${buttonsSelector}:not([data-observed])`)
            .forEach((button) => {
                button.dataset.observed = '1';
                observer.observe(button);
            });
    };

    observeNewButtons(); // On load
    document.addEventListener('love-buttons-updated', observeNewButtons); // On AJAX

    // Centralized click handler using event delegation
    document.body.addEventListener('click', (e) => {
        const button = e.target.closest(buttonsSelector);
        if (!button || button.classList.contains('loved')) return;

        const postId = button.dataset.postId;
        if (!postId) return;

        const storageKey = storagePrefix + postId;
        if (localStorage.getItem(storageKey)) return;

        const countEl = button.querySelector(loveCountSelector);
        if (!countEl) return;

        // Instant UI update
        const currentCount = parseInt(countEl.textContent, 10) || 0;
        countEl.textContent = currentCount + 1;
        button.classList.add('loved');
        localStorage.setItem(storageKey, '1');

        // Fire-and-forget AJAX
        const body = `action=update_love_count&post_id=${encodeURIComponent(
            postId
        )}`;

        fetch(ajaxUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body,
        })
            .then((res) => res.json())
            .then((data) => {
                if (
                    data?.success &&
                    parseInt(data.data, 10) > currentCount + 1
                ) {
                    countEl.textContent = data.data;
                }
            })
            .catch((err) => {
                // Silent fail, log for devs
                console.warn('Love AJAX failed', err);
            });
    });
});
