document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#actor-form');
    const errorContainer = document.getElementById('error-messages');
    const errorList = errorContainer.querySelector('ul');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        errorContainer.classList.add('hidden');
        errorList.innerHTML = '';

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
                const li = document.createElement('li');
                li.textContent = json.message || 'Something went wrong!';
                errorList.appendChild(li);
                errorContainer.classList.remove('hidden');
                return;
            }

            window.location.href = json.redirect;

        } catch (err) {
            console.error(err);
            const li = document.createElement('li');
            li.textContent = 'Server error';
            errorList.appendChild(li);
            errorContainer.classList.remove('hidden');
        }
    });
});
