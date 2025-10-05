<?=$this->extend("common/main")?>

<?=$this->section("content")?>
	
	<?php /*
	<div class="row" >
	
		<div class="col-md-9 col-lg-9 pt-2">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
				
				<button type="button" class="btn btn-success"><i class="fa fa-retweet"></i></button>
				<h1 class="h2">ΤΑΜΕΙΟ</h1>
			</div>
			<ul class="list-group">
			  <li class="list-group-item">An item</li>
			  <li class="list-group-item">A second item</li>
			  <li class="list-group-item">A third item</li>
			  <li class="list-group-item">A fourth item</li>
			  <li class="list-group-item">And a fifth one</li>
			</ul>
        
		</div>
	
		
		<nav id="sidebar" class="pl-3">
            <div class="sidebar-header">
                <h3>Bootstrap Sidebar</h3>
            </div>
			<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">1</div>
			<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">2</div>
			
			
			
        
		
		</nav>
		
		
	
	</div>
	*/ ?>
	
	
	<!-- HEADER TOP BLACK -->
	<div class="row navbar navbar-dark sticky-top bg-dark p-0 shadow">&nbsp;</div>
	
	
	<div class="row featurette class-tamio" >

        <!-- MAIN PANEL -->
		<div class="col-md-8 " >
			<div class="card mt-3 h-100 mh-100" > 
				<div class="card-body" >
                    <div class="d-flex justify-content-between d-inline-block">
                        <h1 class="card-title mb-0">TAMEIO<sup class="text-danger ">&nbsp;<small><b>1v0</b></small></sup></h1>
                        <button type="button" class="btn h-auto btn-empty-basket"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>

					<hr>
                    <div style="overflow-y: scroll;height:calc(100vh - 240px);">
                        <ul class="list-group basket">

                            <div class="card mb-3 list-group-item  p-2 add-basket-item" style="border-style: dashed">

                                <div class="card-body text-center bg-light">
                                   <h5 class="text-muted"><i class="bi bi-cart-plus"></i> - Προσθήκη είδους</h5>
                                </div>
                            </div>

                        </ul>

                        <!-- TOAST SUCCESS MESSAGE -->
                        <div aria-live="polite" aria-atomic="true" class="position-relative ">
                            <div class="toast-container position-absolute p-3 top-0 start-50 translate-middle-x" id="toastPlacement" data-original-class="toast-container position-absolute p-3">
                                <div class="toast fade" id="myToast" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="me-auto"><i class="bi-gift-fill"></i> Eπιτυχία!</strong>
                                    </div>
                                    <div class="toast-body">
                                        Η πώληση, μόλις καταχωρήθηκε με επιτυχία. Μπορείς να την δείς <a href="#">εδώ!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
			
			</div>
        </div>

		<!-- RIGHT PANEL -->
		<div class="col-md-4">

            <div class="card border-0">
                <button class="btn btn-primary mt-3 btn-lg gap-2 btn-exit" onclick="window.location='<?php echo base_url(); ?>'" type="button"><i class="bi bi-arrow-bar-left"></i> Έξοδος</button>
            </div>
            <!-- Numeric Keypad -->
            <div class="card mt-3 bg-dark text-white class-keypad" >
                <div class="btn-group-vertical m-2" role="group" >
                    <div class="btn-group justify-content-between">
                        <input class="text-center form-control-lg m-2 w-100" id="keypadInput">
                        <button type="button" class="keypad-btn btn btn-primary m-2 w-25" data-number="10" >
                            DEL
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="1">1</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="2">2</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="3">3</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="4">4</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="5">5</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="6">6</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="7">7</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="8">8</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="9">9</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="46">,</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="0">0</button>
                        <button type="button" class="keypad-btn btn btn-outline-secondary py-3" data-number="13">ENTER</button>
                    </div>

                </div>
            </div>

            <!-- Total Sum -->
            <div class="mt-3 text-white card border-0" >

                <div class="row" style="height: 125px;margin: 0px;" >

                    <div style="position:absolute;top: 0;left: 0;z-index: 9;margin-top: -5px;margin-left: 20px;">
                        <div class="rounded-circle bg-white " style="margin-left:-18px;width: 124px;height:135px">
                            <button id="submitSale" class="btn btn-outline-primary  text-center rounded-circle  pb-2" style="font-size:65px;margin-top:8px;margin-left:-6px;width: 120px;height:120px">
                                <i class="bi bi-cart-check"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-light card col-10 offset-md-2 position-relative border-secondary" >

                        <div class="card-body float-end position-absolute top-50 end-0 translate-middle-y text-right text-secondary d-flex align-items-end flex-column">
                            <h1 class="pb-0 mb-0 border-bottom"><span class="total-sum">0.00</span> €</h1>

                            <div >
                                <h5><span class="total-pcs">0</span>&nbsp;Τεμ </h5>
                            </div>

                            <div class="border-top">
                                <small>Με έκπτωση 10% : </small><span class=""><b><span class="total-discount">0.00</span> €</b></span>
                            </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>



    </div>


    <!-- MAIN JAVASCRIPT CODE for barcode scanner -->
    <script>

        // in conjuction with script onScan.js
        // https://github.com/axenox/onscan.js
        onScan.attachTo(document, {

            suffixKeyCodes: [13], // enter-key expected at the end of a scan
            reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
            onScan: function(sCode, iQty) {


                var itemInListFound = -1;
                var barcodeFound    = sCode.substring( 1, 30);

                //first of all check if barcode is already in the list of entered products
                $( ".basket-item" ).each(function( index ) { if ( $(this).data("barcode") == barcodeFound ) itemInListFound = index; });
                if (itemInListFound >= 0 ) {

                    itemInListFound++;

                    var listItemQuantity = $( ".basket-item:nth-child( " + itemInListFound +" ) input.quantity-input" ).val();
                    $( ".basket-item:nth-child( " + itemInListFound +" ) input.quantity-input" ).val( parseFloat(listItemQuantity)  + 1);

                    basketItemCalculate ( $( ".basket-item:nth-child( " + itemInListFound +" )" ) );
                    updateBasketSum ();// update the basket sum
                    return;

                }

                $.ajax({

                    type: "get",
                    url: "barcode/search/" + barcodeFound,
                    success: function (serverData) {

                        // this barcode is already in our DB so insert to our list
                        if (serverData != "") {

                            var ajaxProduct = JSON.parse(serverData);

                            var newBasketItem = "<div class='card mb-3 list-group-item  p-2 basket-item inactive' data-state='unselected' data-barcode = '" + ajaxProduct['barcode'] + "' data-id='" + ajaxProduct['id'] + "'>" +
                                "<button type='button' class='btn btn-default btn-close mt-4' aria-label='Close'><i class='bi bi-x-lg'></i></button>" +
                                "<div class='row g-0'>" +
                                "<div class='col-md-2 p-1'>" +
                                "<img src='" + ajaxProduct['image'] + "' class='img-fluid rounded-start rounded-end' style='width: 80%' ></div>" +
                                "<div class='col-md-10'>" +
                                "<div class='card-body pb-1 pt-1'>" +
                                "<div class='row'>" +
                                "<div class='col-md-8'>" +
                                "<h4 class='card-title pb-2'>" + ajaxProduct['description'] + "</h4>" +
                                "<input type='text' size='2'  value='1' class='quantity-input' data-value-store='0' data-loose-focus='yes'>&nbsp;Τεμάχια &nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;" +
                                "<input type='text' size='2'  value = '" + ajaxProduct['retail_price'] + "' class='price-input' data-value-store='0' data-loose-focus='yes'>&nbsp;&euro;</div>" +
                                "<div class='col-md-4 text-right pt-3 text-center'>" +
                                " <h1 class='mb-0 pb-0 '><span  class='basket-item-sum'>" + ajaxProduct['retail_price'] + "</span>&euro;</h1>";

                            if ( ajaxProduct['discount_on_sales'] == "1")
                                newBasketItem += "<small>[<span class='text-danger'>&nbsp;Το προϊόν δεν επιδέχεται έκπτωση</span>&nbsp;]</small>";

                            newBasketItem += "</div></div></div></div></div></div>";

                            $(".basket .add-basket-item").before(newBasketItem);
                            updateBasketSum ();// update the basket sum
                        }

                        // This barcode was not found in our list .. so add a new uknown item
                        else {

                            var newBasketItem = "<div class='card mb-3 list-group-item  p-2 basket-item inactive' data-state='unselected' data-barcode = '" + barcodeFound +"'data-id='1'>" +
                                "<button type='button' class='btn btn-default btn-close mt-4' aria-label='Close'><i class='bi bi-x-lg'></i></button>" +
                                "<div class='row g-0'>" +
                                "<div class='col-md-2 p-1'>" +
                                "<img src='public/images/product/product-without-image.jpg' class='img-fluid rounded-start rounded-end' style='width: 80%' ></div>" +
                                "<div class='col-md-10'>" +
                                "<div class='card-body pb-1 pt-1'>" +
                                "<div class='row'>" +
                                "<div class='col-md-8'>" +
                                "<div class='d-flex justify-content-start'><h4 class='card-title mb-3'>Άγνωστο Προϊόν</h4> <small class='fw-lighter h6 pt-1'>&nbsp;:: [ καταχώρηση ? ]</small></div>" +
                                "<input type='text' size='2' value='1' class='quantity-input' data-value-store='0' data-loose-focus='yes'>&nbsp;Τεμάχια &nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;" +
                                "<input type='text' size='2'  value = '1' class='price-input' data-value-store='0' data-loose-focus='yes'>&nbsp;&euro;</div>" +
                                "<div class='col-md-4 text-right pt-3 text-center'>" +
                                " <h1><span  class='basket-item-sum'>1</span>&euro;</h1>" +
                                "</div></div></div></div></div></div>";

                            $(".basket .add-basket-item").before( newBasketItem );

                            updateBasketSum ();// update the basket sum

                            // focus on the quantity input ..of this unknwon product
                            basketItemActivate ( $("ul.list-group.basket > div:nth-last-child(2) input.quantity-input") );

                        }

                        // move the scrollbar allways to the bottom of the list..
                        $(".list-group.basket").parent().scrollTop($(".list-group.basket").parent()[0].scrollHeight);
                    },
                    error:function(){
                        alert("Αδυναμία εύρεσης του συγκεκριμένου προϊόντος!!");
                    }
                });

                // move the scrollbar allways to the bottom of the list..
                $(".list-group.basket").parent().scrollTop($(".list-group.basket").parent()[0].scrollHeight);



            },
            onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!

            }
        });

    </script>

    <!-- javascript code for main item window -->
    <script>

        var focusedBasketItemInput  = null;
        var focusedBasketItem       = null;
        var acceptScanningChars     = true;

        function updateBasketSum () {

            var basketItemSum = 0;
            var basketItemPcs = 0;

            $(".basket-item").each( function ( item ) {
                var quantity    = parseFloat( $(this).find(".quantity-input").val() );
                var price       = parseFloat ($(this).find(".price-input").val())  ;

                basketItemSum += ( quantity * price );
                basketItemPcs += quantity;
            });
            // update total sum
            $(".total-sum").text ( basketItemSum.toFixed(2) );
            $(".total-pcs").text ( basketItemPcs );

            // calculate a discount of 10%
            basketItemSum -= basketItemSum * 10/100 ;
            $(".total-discount").text ( basketItemSum.toFixed(2));


        }

        function basketItemActivate ( basketItem ) {

            focusedBasketItemInput  = basketItem;
            focusedBasketItem       = focusedBasketItemInput.parent().closest(".basket-item");

            basketItemSetState ( focusedBasketItem, "active");
            focusedBasketItemInput.attr("data-value-store", focusedBasketItemInput.val() );
            focusedBasketItemInput.val("");
            $("#keypadInput").val("");

            focusedBasketItemInput.focus().val(focusedBasketItemInput.val());

        }

        $(document).on("mousedown", function(event) {

            // get first class of pressed DOM element ( inputs, buttons etc )
            switch ( event.target.classList[0] ) {

                case "quantity-input":
                case "price-input": {

                    if ( focusedBasketItemInput != null ) { // if already smth selected
                        basketItemCalculate ( focusedBasketItem );
                    }

                    basketItemActivate ( $(event.target) );

                }break;

                case "keypad-btn" : {

                    if ( focusedBasketItemInput == null) return;

                    var btnPressed = $(event.target).attr("data-number");

                    switch ( btnPressed ) {

                        // Did someone pressed ENTER??
                        case "13": {

                            basketItemCalculate ( focusedBasketItem );

                            if ( focusedBasketItemInput.attr( "class") == "quantity-input") {
                                basketItemActivate ( focusedBasketItemInput.next() );

                            }
                            else if ( focusedBasketItemInput.attr( "class") == "price-input" ) {
                                basketItemDeactivate ( focusedBasketItem );
                            }

                        }break;

                        //Did someone pressed '.' ??
                        case "46" : {

                            if ( $("#keypadInput").val().indexOf(".") < 0 && $("#keypadInput").val().length >= 1) {
                                $("#keypadInput").val( $("#keypadInput").val() + '.' );
                                focusedBasketItemInput.val ( $("#keypadInput").val() );
                            }
                        }
                        break;

                        case "10" : {
                            $("#keypadInput").val($.trim($("#keypadInput").val()).slice(0, -1));
                            focusedBasketItemInput.val ( $("#keypadInput").val () );
                        }
                        break;

                        default: {

                            $("#keypadInput").val ( $("#keypadInput").val() + btnPressed );
                            focusedBasketItemInput.val ( $("#keypadInput").val () );
                        }
                        break;

                    }



                }break;


                default: { // user clicked outside any known elements

                    basketItemDeactivate ( focusedBasketItem );

                }break;

            }

        });

        $(document).on("keyup", function(key) {


            if ( focusedBasketItemInput == null ) return false;

            switch ( key.which ) {

                // user just pressed ESC btn!
                case 27: {
                    basketItemDeactivate ( focusedBasketItem );
                }
                break;

                // user just pressed ENTER btn!
                case 13: {

                    basketItemCalculate ( focusedBasketItem );

                    if ( focusedBasketItemInput.attr( "class") == "quantity-input") {
                        basketItemActivate ( focusedBasketItemInput.next() );
                    }
                    else if ( focusedBasketItemInput.attr( "class") == "price-input" ) {
                        basketItemDeactivate ( focusedBasketItem );
                    }

                }
                break;


           }


        });

        $(document).on("keypress", function(key) {

            if ( focusedBasketItemInput == null ) return false;
            if ( acceptScanningChars == false ) return false;

            switch ( key.keyCode ) {

                // user entered ','
                case 44:
                case 46: {
                    if ( focusedBasketItemInput.val().indexOf(".") >= 0 ) { key.preventDefault(); return false; }
                    if ( key.keyCode == 44) { key.preventDefault(); focusedBasketItemInput.val( focusedBasketItemInput.val() + '.'); }
                }break;

                default: {

                    if ( key.keyCode == 64 ) { // '@' - (64 in ascii ) is the prefix of our barcode scanner
                        acceptScanningChars = false; // stop accepting SEMA

                        basketItemDeactivate (focusedBasketItem );
                        updateBasketSum ();

                        setTimeout(function(){ acceptScanningChars = true }, 1000); // start accepting chars again,  after 1sec! byt that time the scanner will have finished!
                        return false;
                    }

                    // All inputs of this program are designed to accept only numbers!
                    if (key.keyCode < 48 || key.keyCode > 57  ) { key.preventDefault(); return false; }

                }break;
            }

        });

        function basketItemSetState( basketItem, state ) {

            if ( basketItem == null ) return;

            if ( state == "active") {
                basketItem.removeClass("inactive").addClass("active");
                focusedBasketItem = basketItem;
            } else {
                basketItem.removeClass("active").addClass("inactive");
                focusedBasketItem = null;
            }
        }

        function basketItemCalculate ( basketItem ) {


            if ( basketItem == null ) return;

            basketItem.find( "input").each( function () {

                if ( $(this).val().length <= 0 ) {
                    $(this).val( $(this).attr("data-value-store") );
                }

            });
            var basketItemQuantity  = basketItem.find(".quantity-input").val();
            var basketItemPrice     = basketItem.find(".price-input").val();
            var basketItemSum       = basketItem.find(".basket-item-sum");

            basketItemSum.text ( (basketItemQuantity * basketItemPrice).toFixed(2)  ) ; // update item's sum

            updateBasketSum ();

        }

        function basketItemDeactivate ( basketItem ) {

            basketItemCalculate ( basketItem ) ;
            basketItemSetState(basketItem, "inactive");

            if ( focusedBasketItemInput != null ) focusedBasketItemInput.blur();

            focusedBasketItemInput   = null;
            focusedBasketItem        = null;
        }

        function emptyBasket () {

            $(".basket-item").each( function () {
                $(this).remove();
                focusedBasketItemInput  = null;
                focusedBasketItem       = null;
            });
            $("#submitSale").removeClass("bg-primary").removeClass("text-white").addClass("bg-light").addClass("text-primary").blur();

            // update total sum
            $(".total-sum").text ( "0.00" );
            $(".total-discount").text ( "0.00");
            $(".total-pcs").text ("0");
        }

    </script>

    <!-- javascript code for deleting items / refresh main basket -->
    <script>

        // delete item from basket
        $(document).on( "click", ".basket .basket-item .btn-close", function () {

            $(this).parent().remove();
            updateBasketSum ();
            focusedBasketItemInput  = null;
            focusedBasketItem       = null;

        });

        // empty
        $(".btn-empty-basket").on ("click", function () { emptyBasket ();  });

    </script>

    <!-- Javascript code for POSTING the basket to saleController for inserting to DB -->
    <script>

        $("#submitSale").on( "click", function ( ) {

            var itemList    = $( ".basket > .basket-item" );
            var totalSum    = parseFloat  ( $(".total-sum").text () );

            if ( itemList.length <= 0) { return; }

            var storeItemsInSale = [];

            $( itemList ).each ( function () {
                var storeItem = {
                    product_id: $(this).data("id"),
                    quantity:   parseFloat( $(this).find(".quantity-input").val() ),
                    price:      parseFloat( $(this).find(".price-input").val() ),
                    sum:        parseFloat( $(this).find(".basket-item-sum").text() )
                };
                storeItemsInSale.push( storeItem );
            });

            $.ajax({

                type: "post",
                url: "sales",
                data: { salesItems : JSON.stringify( storeItemsInSale ), salesTotal : totalSum },

                success: function (data) {
                    emptyBasket ();
                    $("#myToast").toast("show");
                }

            });

        });



    </script>

<?=$this->endSection()?>