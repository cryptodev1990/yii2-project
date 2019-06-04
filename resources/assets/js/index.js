/*
 * Created by Artem Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2018
 */

let moment = require('moment');

let currentTime = moment().format('DD/MM/Y H:m:s');

console.log("Yii 2 application loaded! Current time: " + currentTime);