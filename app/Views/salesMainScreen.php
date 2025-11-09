<?=$this->extend("common/main")?>

<?=$this->section("content")?>
	
	
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
            <!-- Product Log -->
            <div class="card mt-3" >
                <div class="card-body" >
                    <div class="row" style="overflow-y: scroll;height:calc(100vh - 540px);">
                        <ul class="list-group list-group-flush product-log-list" data-product-id="0"></ul>
                    </div>
                </div>
                    
            </div>

            <!-- Total Sum -->
            <div class="mt-3 text-white card border-0" >

                <div class="row" style="height: 125px;margin: 0px;" >
                    <!-- save basekt button -->
                    <div style="position:absolute;top: 0;left: 0;z-index: 9;margin-top: -5px;margin-left: 20px;">
                        <div class="rounded-circle bg-white " style="margin-left:-18px;width: 124px;height:135px">
                            <button id="submitSale" class="btn btn-outline-primary  text-center rounded-circle  pb-2 btn-save-basket" style="font-size:65px;margin-top:8px;margin-left:-6px;width: 120px;height:120px">
                                <i class="bi bi-cart-check"></i>
                            </button>
                        </div>
                    </div>

                    <!-- total sum -->
                    <div class="bg-light card col-10 offset-md-2 position-relative border-secondary" >

                        <div class="card-body float-end position-absolute top-50 end-0 translate-middle-y text-right text-secondary d-flex align-items-end flex-column">
                            <h1 class="pb-0 mb-0 border-bottom"><span class="total-sum">0.00</span></h1>

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

        <!-- Toast messages -->
		<?= $this->include('common/toast') ?>

    </div>


    <!-- managing basket functions  -->
    <script>

        let basketProductList = [];

        
        function __updateProductPriceInHtml ( $node ) {
            
            let barcode         = $node.parents('.basket-item').data("barcode").toString();
            let product         = __getProductFromHtml ( barcode );
            
            let quantity        = SFNumberFunctions._parseNumber( product.find(".quantity-input").val() );
            let price           = SFNumberFunctions._parseNumber( product.find(".price-input").val() );
            
            let productIndex    = basketProductList.findIndex( product => product.data.barcode === barcode);

            basketProductList[productIndex].basketQuantity  = quantity;
            basketProductList[productIndex].basketPrice     = price;

            __renderBasketDisplay ();
           /*
            console.log( '----------------------------' );
            console.log( barcode );
            console.log( quantity );
            console.log( price );
            console.log( productIndex );
            console.log( basketProductList[productIndex] );
            console.log( '----------------------------' );
                */
          
            
            
        }

        function __getProductFromList( barcode ) {
            return basketProductList.find( product => product.data.barcode === barcode) || null;
        }
        
        function __getProductFromHtml ( barcode ) {
            
            let foundItem = null;
            $(".basket>.basket-item").each ( function () {
                let barcodeStr = $(this).data("barcode").toString();
                if ( barcodeStr === barcode ) {
                    foundItem = $(this);
                }
            })
            return foundItem;
        }

        function __removeProductFromBasket ( product ) {
            
            // remove from list first
            let productIndex = basketProductList.findIndex(p => p.data.barcode === product.data.barcode);
            basketProductList.splice( productIndex, 1 );
            
            // remove from html
            __getProductFromHtml( product.data.barcode ).remove();
            if ( product.data.id == $(".product-log-list").attr("data-product-id") ) {  __clearProductLogs(); }
                
            // update basket display
            __renderBasketDisplay ();
            
        }

        function __addProductToBasket ( product ) {
            
            product.basketQuantity  = 1;
            product.basketPrice     = product.data.selling_price;
            
            // add to list
            basketProductList.push( product );
            // add to html
            $(".basket").find(".add-basket-item").before( product.html );

            // update price in html
            let $productHtml = __getProductFromHtml( product.data.barcode );
            $productHtml.find(".price-input").val( SFNumberFunctions._displayNumber( product.basketPrice , 2 )) ;

            // update basket display
            __renderBasketDisplay ();
        }

        function __updateProductQuantity ( product, quantity ) {
            
            let productIndex = basketProductList.findIndex(p => p.data.barcode === product.data.barcode);
            // update quantity in list
            basketProductList[productIndex].basketQuantity += SFNumberFunctions._parseNumber( quantity );
            
            // update quantity in html
            let productHtml = __getProductFromHtml( product.data.barcode );
            productHtml.find(".quantity-input").val( SFNumberFunctions._displayNumber( basketProductList[productIndex].basketQuantity , 2 )) ;

            // update basket display
            __renderBasketDisplay ();
            
        }

        function __renderBasketDisplay () {

            let totalSum    = 0;
            let totalPcs    = 0;
            let totalDiscount = 0;

            basketProductList.forEach ( product => {
                totalSum        += parseFloat( product.basketPrice ) * parseFloat( product.basketQuantity );
                totalPcs        += parseFloat( product.basketQuantity );
                totalDiscount   += ( parseFloat( product.basket_price ) - parseFloat( product.basketPrice ) ) * parseFloat( product.basketQuantity );
                
                // update total price in List
                product.totalPrice = product.basketPrice   * product.basketQuantity ;
                // update total price in html
                let $productHtml = __getProductFromHtml( product.data.barcode );
                $productHtml.find(".basket-item-sum").text ( SFNumberFunctions._displayCurrency ( product.totalPrice, 2  ) );
                
            });

            $(".total-sum").text( SFNumberFunctions._displayCurrency(totalSum, 2) );
            $(".total-pcs").text( SFNumberFunctions._displayNumber(totalPcs, 2) );
            $(".total-discount").text( SFNumberFunctions._displayNumber(totalDiscount, 2) );


        }
        
        function __clearBasket () {
            $(".list-group.basket>.basket-item").each( function () {
                let barcode = $(this).data("barcode");
                
                let product = __getProductFromList ( barcode.toString() );
                __removeProductFromBasket ( product );
            })
        }
    
        function __clearProductLogs () {
            let $list = $(".product-log-list");
            $list.attr("data-product-id", "0");
            $list.empty();
        }

        function __renderProductLogs ( log ) {
        
            //console.log ( log )
            if ( log == null || log.length == 0 ) return;
            
            let $list = $(".product-log-list");
            let html = "";

            $list.empty();
            
            log.forEach ( function ( log_entry ) {
                if ( log_entry.type_id == "<?=  PRODUCT_LOG_TYPE_BUYING ?>") {
                    html += "<li class='text-sm ";
                    html += log_entry.quantity >= 0 ? 'bg-success' : 'bg-warning' ;
                    html += " text-white px-2 py-1 rounded mb-1 opacity-75' style='font-size:0.8rem'>" + __toEuropeanDate ( log_entry.created_at );     
                    html += log_entry.quantity > 0 ? " - ΑΓΟΡΑ : " : " - ΡΥΘΜ. : ";
                    html += log_entry.quantity + " " + log_entry.measuring_unit_name + " @ " + SFNumberFunctions._displayCurrency(log_entry.buying_price, 2);
                    html += '</li>';
                }
                else  {
                    html += "<li class='text-sm bg-danger text-white px-2 py-1 rounded mb-1 opacity-75' style='font-size:0.8rem'>" + __toEuropeanDate ( log_entry.created_at );    
                    html += " - ΠΩΛΗΣΗ : " ;
                    html += log_entry.quantity + " " + log_entry.measuring_unit_name + " @ " + SFNumberFunctions._displayCurrency(log_entry.selling_price, 2);
                    html += '</li>';
                }
                $(".product-log-list").attr("data-product-id", log_entry.product_id);
                
            });

            $list.append(html);

        }
                
        function __ajaxGetProductLog ( barcode ) {
            $.ajax({
            url: "<?= base_url('products?barcode=') ?>" + barcode,
            method: "get",
            dataType: "json",

            success: function(serverData) {
                __clearProductLogs ();
                serverData.log != "" && serverData.log != null ? __renderProductLogs ( serverData.log ) : null;
            }

        });
        }

        function __toEuropeanDate(datetimeStr) {
            // Split date and time
            const [datePart, timePart] = datetimeStr.split(' ');
            const [year, month, day] = datePart.split('-');
            
            // Return in European format
            return `${day}-${month}-${year} ${timePart}`;
        }
    </script>

    <!-- DOM event functions -->
    <script>
        // when scanned a new item  
       $(function() {
            let barcode = '';
            let timer;

            $(document).on('keydown', function(e) {
                // Reset timer if the user types/scans again soon
                clearTimeout(timer);

                // Check if key is Enter or Tab — scanner done
                if (e.key === 'Enter' || e.key === 'Tab') {
                    if (barcode.length > 3) { // avoid false triggers
                        
                        console.log('Scanned barcode:', barcode);
                        $barcodeStr = barcode.substring (1);
                        
                        $.ajax({
                            method: "POST",
                            url: "sales/ajax-sales-entry",
                            data: { barcode: $barcodeStr },
                            dataType: "json",
                            success: function (serverData) {
                                
                                __clearProductLogs ();
                                if ( serverData.data != null ) {
                                    let product = __getProductFromList ( $barcodeStr );
                                    
                                    product != null ? __updateProductQuantity ( product, 1) : __addProductToBasket( serverData );

                                    __renderProductLogs( serverData.log );
                                
                                } else {
                                    alert("Product not found!");
                                }
                            }
                        });
                     
                    }
                    barcode = '';
                    return;
                }

                // Ignore special keys
                if (e.key.length === 1) {
                    barcode += e.key;
                }

                // Reset if no key pressed for 100ms (manual typing cutoff)
                timer = setTimeout(() => barcode = '', 100);
            });
           
        });

        // delete an item from list ... 
        $("body").on( "click", ".btn-close", function (event ) {
            event.preventDefault();
            event.stopPropagation();

            let product = __getProductFromList ( $(this).parent().data("barcode").toString() );
            __removeProductFromBasket ( product );
           
        });

        // change item's quantity or price
        $(document).on( 'input', '.quantity-input', function() { __updateProductPriceInHtml( $(this) ); });
        $(document).on( 'input', '.price-input', function() { __updateProductPriceInHtml( $(this) ); });

        // empty the basket 
        $(document).on( "click", ".btn-empty-basket", function () {
            __clearBasket ();
            __clearProductLogs ();
        });

        // save basket
        $("body").on( "click", ".btn-save-basket", async function () {
            
            await $.ajax({
                method: "POST",
                url: "sales",  
                data: { products: basketProductList },
                dataType: "json",
                success: function (serverData) {
                    __clearBasket ();
                    __clearProductLogs ();

                    if ( serverData.error ) { return show_toast(serverData.message, "error"); }
                    else { show_toast(serverData.success, "success");  }
                    
                    $(':focus').blur();
                }

            })
        });

        $("body").on("click", ".basket>.basket-item", function (event ) {
            __ajaxGetProductLog ( $(this).data("barcode").toString() );
        });

    </script>

<?=$this->endSection()?>
