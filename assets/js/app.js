/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.less';

window.$ = window.jQuery = require('jquery');
global.Tether = require('tether');

require('bootstrap');

$(document).ready(function() {
    $('body .container').prepend('<h1>From webpack</h1>');
});

