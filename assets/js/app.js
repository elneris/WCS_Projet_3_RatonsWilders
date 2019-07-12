/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

import 'bootstrap';
import './kitconfig_fontawesome.js';
import changeRole from './_listAdmin';


$('#image_type').on('change',function(){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

/*
 * Js pour la sidebar $ ListAdmin
 */

$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $('a.changeRole').click(function () {
        let user_id = $(this).attr("data-id");
        changeRole(user_id);
    });
});





