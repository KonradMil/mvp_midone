import axios from 'axios';

// Automatically add CSRF token to every outgoing request
const baseURL = window.App.base_url;
const headers = {
    'X-CSRF-TOKEN'    : window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

const Parent = axios.create({
    baseURL,
    headers,
});
Parent.interceptors.response.use(response => response, error => httpFail(error));

function httpFail(error) {
    // Reject on Laravel-driven validation errors
    if (error.response && error.response.status === 422) {
        return Promise.reject(error);
    }

    // Refresh tokens and reject to be further handled be the request initiator
    if (error.response && error.response.status === 419) {
        return refreshAppTokens().then(() => Promise.reject(error));
    }

    // If internal error
    if (error.message && !error.response) {
        // Due to a possible bug in Laravel Echo, whitelist Echo server error
        // See explanation above
        if (error.message === "Cannot read property 'socketId' of undefined") {
            // showError(error.message);
            return Promise.resolve(error);
        }

        // Display any other errors to the user and reject
        // showError(error.message);
        return Promise.reject(error);
    }

    // Redirect to log in page if unauthenticated
    if (error.response && error.response.status === 401) {
        const router = window.router;
        const segments = router.currentRoute.path.split('/');
        const isAuth = segments.length > 1 && segments[1] === 'auth';

        // If not on main page and not on /auth page (change this block or remove accordingly to your app logic)
        if (router.currentRoute.path !== '/' && !isAuth) {
            // store.dispatch('resetAuthorizedUser');
            window.router.push(`/auth/login?back=${router.currentRoute.path}`);
        }
        return Promise.reject(error);
    }

    // Redirect if the backend asks it
    if (error.response && error.response.status === 402 && error.response.data.redirect) {
        window.router.push(error.response.data.redirect);
        return Promise.reject(error);
    }

    // Show all other errors
    // showHttpError(error);
    return Promise.reject(error);
}

function refreshAppTokens() {
    // Retrieve a new page with a fresh token
    axios.get('/')
        .then(({ data }) => {
            const wrapper = document.createElement('div');
            wrapper.innerHTML = data;
            return div.querySelector('meta[name=csrf-token]').getAttribute('content');
        })
        .then((token) => {
            axios.defaults.headers['X-CSRF-TOKEN'] = token;
            window.Laravel.csrfToken = token;
            document.querySelector('meta[name=csrf-token]').setAttribute('content', token);
        });
}


const install = app => {
    app.config.globalProperties.$http = _;
};

export { install as default };
