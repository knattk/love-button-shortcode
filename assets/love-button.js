document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.love-button').forEach((button) => {
        let postId = button.getAttribute('data-post-id');
        let loved = localStorage.getItem('loved_' + postId);

        if (loved) {
            button.classList.add('loved');
        }

        button.addEventListener('click', function () {
            if (!localStorage.getItem('loved_' + postId)) {
                fetch(loveButtonAjax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_love_count&post_id=${postId}`,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            button.querySelector('.love-count').textContent =
                                data.data;
                            button.classList.add('loved');
                            localStorage.setItem('loved_' + postId, true);
                        }
                    });
            }
        });
    });
});
