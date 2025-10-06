"use strict";

  

$(function () {
  
    
    // Prevent form submission on Enter keypress due to barcode scanner input
    $("#productForm").on("submit", function (e) { e.preventDefault(); return false; });


});
