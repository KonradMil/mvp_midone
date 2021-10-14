<template>

</template>

<script>

export default function DirectusCall(url, callback) {

    async function directusCall(url, callback) {
        delete axios.defaults["xsrfCookieName"];
        delete axios.defaults["xsrfHeaderName"];
        delete axios.defaults.headers.common["X-Requested-With"];
        axios.get('https://dbrdirectus.appworks-dev.pl/' + url, {
            responseType: 'json',
            withCredentials: true,
        }).then(response => {
              callback(response.data.data, response.data.meta);
        })
    }

    directusCall(url, callback);
}
</script>
