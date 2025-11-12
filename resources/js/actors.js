document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#actor-form');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/actors', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const json = await response.json();

            if (!json.success) {
                alert(json.message || 'Something went wrong!');
                return;
            }

            // редірект на сторінку index
            window.location.href = json.redirect;

        } catch (err) {
            console.error(err);
            alert('Server error');
        }
    });
});

window.addEventListener('ajaxError', function(event) {
    const errors = event.detail.errors;
    const container = document.getElementById('error-messages');
    container.innerHTML = '<ul class="list-disc pl-5"></ul>';
    for (const msg of errors) {
        const li = document.createElement('li');
        li.textContent = msg;
        container.querySelector('ul').appendChild(li);
    }
    container.style.display = 'block';
});

