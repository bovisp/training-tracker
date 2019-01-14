window.axios = require('axios');

// Sets the X-Requested-With header for all axios method calls.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Allows axios to gain access to the current CSRF token that it can use in all
// of its requests.
let token = document.head.querySelector('meta[name="csrf-token"]');

// Adds the CSRF token by default to axios' headers object. Throws a console
// error if not present.
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}