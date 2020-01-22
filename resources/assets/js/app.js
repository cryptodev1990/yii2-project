require('./bootstrap');

// ES6 imports
import Vue from 'vue';
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// Node.js imports
let moment = require('moment');

UIkit.use(Icons);

console.log(`Yii 2 application loaded! Current time: ${moment().format('DD/MM/Y HH:mm:ss')}`);

/**
 * Creates a new instance of Vue app
 */
const app = new Vue({
    el: '#app',
});