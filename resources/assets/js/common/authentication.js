import Axios from 'axios';
import Cookies from 'js-cookie';

let token = null;

try {
    token = localStorage.getItem('federal-api-token');
} catch (e) {
    token = Cookies.get('federal-api-token');
}

if (token) {
    token = token.trim();

    Axios.defaults.headers.common['Authorization'] = 'Bearer '+token;
}
