<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";


export default function RequestHandler(url, method, data, successCallback = null, errorCallback = null) {

    const toast = useToast();
    const getParams = ref('');
    method = String(method).toLowerCase();

    async function requestHandler(url, method, data, successCallback = null, errorCallback = null) {
        if (method === 'post') {
            await axios.post('/api/' + url, data)
                .then(handleSuccess)
                .catch(handleError)
        } else if (method === 'get') {
            getParams.value = new URLSearchParams(data).toString();
            await axios.get('/api/' + url + '?' + getParams.value)
                .then(handleSuccess)
                .catch(handleError)
        } else {
            console.warn('Wrong request method: ' + method);
        }
    }

    const handleSuccess = (response) => {
        handleMessages(response.data);
        if (successCallback) {
            successCallback(response);
        }
    }

    const handleError = (error) => {

        if(typeof error.response !== 'undefined' && typeof error.response.status !== 'undefined') {
            handleMessages(error.response.data);
            if (errorCallback) {
                errorCallback(error);
            }
        } else {
            console.error(error);
        }

    }

    const handleMessages = (responseData) => {

        if (typeof responseData.errors !== 'undefined') {
            responseData.errors.forEach((val) => {
                toast.error(val);
            });
        }

        if (typeof responseData.warnings !== 'undefined') {
            responseData.warnings.forEach((val) => {
                toast.warning(val);
            });
        }

        if (typeof responseData.success !== 'undefined') {
            responseData.success.forEach((val) => {
                toast.success(val);
            });
        }

        if (typeof responseData.info !== 'undefined') {
            responseData.info.forEach((val) => {
                toast.info(val);
            });
        }

    }

    requestHandler(url, method, data, successCallback, errorCallback);

}
</script>
