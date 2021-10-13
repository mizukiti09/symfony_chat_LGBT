// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
require('jquery');
// uncomment if you have legacy code that needs global variables
// global.$ = $;

require('bootstrap');

$(window).load(function() {

    alert($().jquery);
    console.log('Version')
});

var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
});


