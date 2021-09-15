<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";


export default function RequestHandler(url, type, data, callback) {
    const toast = useToast();
    const getParams = ref('');

    async function requestHandler(url, type, data, callback) {
        if (type === 'post') {
            await axios.post('/api/' + url, data)
                .then(response => {
                    callback(response)
                }).catch((error) => {
                    handleErrors(error);
                })
        } else if (type == 'get') {
            getParams.value = new URLSearchParams(data).toString();
            await axios.get('/api/' + url + '?' + getParams.value).then(response => {
                callback(response)
            }).catch((error) => {
                handleErrors(error);
            })
        } else {
            console.log('Wrong request type: ' + type);
        }
    }

    const handleErrors = (error) => {
        error.response.data.errors.forEach((val) => {
            toast.error(val);
        });
        error.response.data.warnings.forEach((val) => {
            toast.warning(val);
        });
    }

    requestHandler(url, type, data, callback);

}
</script>
