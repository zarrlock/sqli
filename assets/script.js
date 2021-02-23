$(document).ready(function() {
   console.log('rdy');
    $('.toggle-qry').on('click', function() {
       $('footer').toggleClass('show');
    });
});