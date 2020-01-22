import Vue from 'vue'
import VueAxios from 'vue-axios'
import axios from 'axios'

/**
 * Marks Axios requests as AJAX
 * @type {string}
 */
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Sets up CSRF token to support requests validation
 * @type {Element}
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

/**
 * Finds all files like *.vue
 */
const files = require.context(
    './components',
    true,
    /\.vue$/i
);

/**
 * Registers each Vue component to the app
 */
files
    .keys()
    .map(key => Vue.component(
        key
            .split('/')
            .pop()
            .split('.')[0],
        files(key).default)
    );

/**
 * Enables 'this.$http' access
 */
Vue.use(VueAxios, axios);