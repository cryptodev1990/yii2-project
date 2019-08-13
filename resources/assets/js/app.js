/*
 * Created by Artem Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2018
 */

require('./bootstrap');

import Vue from 'vue';

let moment = require('moment');

console.log("Yii 2 application loaded! Current time: " + moment().format('DD/MM/Y HH:mm:ss'));

/**
 * Creates a new instance of Vue app
 */
const app = new Vue({
    el: '#app',
});