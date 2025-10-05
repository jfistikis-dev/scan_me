<?=$this->extend("common/main")?>

<?=$this->section("content")?>


<!-- HEADER TOP BLACK -->
<div class="row navbar navbar-dark sticky-top bg-dark p-0 shadow">&nbsp;</div>

<!-- The actuall window of this page -->
<div class="row featurette class-supplies p-3 g-3 " >

    <!-- Title & Exit buttons -->
    <div class="d-flex justify-content-between pb-2" >

        <div class="display-5">
            <button class="btn btn-primary fs-3" type="button" data-bs-toggle="offcanvas" data-bs-backdrop="true" data-bs-target="#basketOffCanvas" aria-controls="basketOffCanvas">
                <i class="bi bi-card-checklist" style="pointer-events: none;"></i>
            </button>
            - Καταχώρηση
        </div>
        <!--<div id="dymoLabel"><button type="button" href="#" class="btn btn-primary mt-3 btn-lg gap-2"></button> </div>-->
        <div class="card border-0">
            <button onclick="location=window.location='<?= base_url(); ?>'" class="btn btn-primary mt-3 btn-lg gap-2 btn-exit" type="button">
                <i class="bi bi-arrow-bar-left"></i> Έξοδος
            </button>
        </div>
    </div>

    <!-- MAIN PANEL -->
    <div class="border rounded row p-3" >

        <!-- camera area -->
        <div class="col-5 position-relative">
            <div class="ratio ratio-16x9 border rounded p-1 m-2 "><video id="video" autoplay ></video></div>
            <!-- special button to take a piture -->
            <div class="position-absolute top-0 end-0 p-3"><button type="button" class="btn btn-dark pic-btn invisible "><i class="bi bi-camera"></i></button></div>

            <div class="pt-2 pb-1"><small class="blockquote-footer">Τοποθετήστε το προϊόν στην camera</small></div>
        </div>

        <!-- Product area -->
        <div class="col-7">

            <?php
            if ( $invoiceType == 0 || $invoiceType == 1 ) {

                $hiddenFormFields =
                    [   'imageData'         => '',
                        'invoiceType'       => $invoiceType,
                        'discount'          => '',
                        'supplier_id'       => '',
                        'brand_id'          => '',
                        'product_id'        => '',
                        'categoryrow_id'    => ''
                    ];
            }
            else {
                $hiddenFormFields =
                    [   'imageData'         => '',
                        'invoiceType'       => $invoiceType,
                        'invoice_id'        => $invoice['id'],
                        'discount'          => $invoice['discount'],
                        'supplier_id'       => $invoice['supplier_id'],
                        'brand_id'          => '',
                        'categoryrow_id'    => '',
                        'product_id'        => ''
                    ];

            }


            //echo form_open(base_url('supplies' ), ['id'=> 'productForm'], $hiddenFormFields );
            ?>
            <form id="productForm" action="<?= base_url('supplies' ) ?>" method="post"  enctype="multipart/form-data">

                <?= csrf_field() ?>
                <?php foreach ( $hiddenFormFields as $key => $value ) : ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
                <?php endforeach; ?>

            <!-- Barcode & Textcode -->
            <div class="row mb-3 mt-2">

                <!-- Barcode -->
                <div class="col input-group ">
                    <button class="btn btn-secondary input-group-text fs-5" type="button" data-bs-toggle="modal" data-bs-target="#barcodeModal" ><i class="bi bi-upc-scan p-1"></i></button>
                    <input type="input" class="form-control only-number" id="barcode" name = "barcode" placeholder="barcode" readonly>
                    <button class="btn btn-outline-secondary del-barcode-btn" type="button"><i class="bi bi-arrow-left"></i></button>
                </div>

                <!-- Generate button -->
                <div class="col-3 pt-1">
                    <button type="button" class="btn btn-secondary " id="btn-bardode">
                        <i class="bi bi-upc-scan"></i> - Δημιουργία
                    </button>
                </div>


            </div>

            <!-- Supplier & brand select -->
            <div class="row g-3 mb-3 ">
                <div class="col-4 form-floating">
                    <input type="input" class="form-control" id="supplierInput" name="supplier" placeholder="Προμηθευτής" readonly>
                    <label for="supplier">Προμηθευτής</label>
                </div>
                <div class="col-2 pt-2">
                    <button type="button" class="btn btn-secondary supplier-btn-modal" ><i class="bi bi-card-heading"></i></button>
                </div>
                <div class="col-4 form-floating">
                    <input type="input" class="form-control" id="brandInput" name = "brand" placeholder="Μάρκα" readonly>
                    <label for="brand">Μάρκα</label>
                </div>
                <div class="col-2 pt-2">
                    <button type="button" class="btn btn-secondary brand-btn-modal"><i class="bi bi-card-heading"></i></button>
                </div>


            </div>

            <!-- Name -->
            <div class="row  g-3 mb-3">
                <div class="col-10 form-floating">
                    <input type="input" class="form-control" id="description" name = "description" autocomplete="off" placeholder="Στριφταροπαραμανα">
                    <label for="description">Όνομα προϊόντος</label>
                </div>
                <div class="col pt-2">
                    <button type="button" class="btn btn-secondary" data-state="off" id="clone-product"><i class="bi bi-square"></i></i></button>
                </div>
            </div>

            <!-- Purchase price / Retail price -->
            <?php if ( $invoiceType != 1 ) : ?>
            <div class="row g-3 mb-3 hide-on-raw-insert">
                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="wholesale_price" name = "wholesale_price" placeholder="Τιμή αγοράς">
                    <label for="wholesale_price">Τιμή χονδρικής</label>
                </div>
                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="quantity" name = "quantity" placeholder="Στριφταροπαραμανα">
                    <label for="stock">Ποσότητα</label>
                </div>
                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="wholesale_discount" name = "wholesale_discount" placeholder="Έκπτωση %" >
                    <label for="wholesale_discount">Έκπτωση %</label>
                </div>
                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="sum" name="sum" disabled>
                    <label for="sum">Σύνολο</label>
                </div>
            </div>
            <?php endif; ?>

            <!-- Purchase moq / threshold -->
            <div class="row g-3 mb-3">
                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="stock" name = "stock" placeholder="Στριφταροπαραμανα">
                    <label for="stock">Ποσότητα στο ράφι</label>
                </div>

                <?php if ( $invoiceType != 1 ) : ?>
                    <div class="col form-floating hide-on-raw-insert">
                    <input type="input" class="form-control only-number" id="minimum_quantity" name = "minimum_quantity" placeholder="Στριφταροπαραμανα">
                    <label for="minimum_quantity">Ελάχιστή ποσότητα</label>
                    </div>
                <?php endif; ?>

                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="retail_price" name = "retail_price" placeholder="Τιμή πώλησης">
                    <label for="retail_price">Τιμή λιανικής</label>
                </div>
                <div class="col form-floating">
                    <input type="input" class="form-control only-number" id="reorder_quantity" name = "reorder_quantity" placeholder="Στριφταροπαραμανα">
                    <label for="reorder_quantity">Όριο αναπαραγγελίας</label>
                </div>


            </div>

            <!-- category select & discount-->
            <div class="row g-3 mb-3">
                <div class="col-4 form-floating">
                    <input type="input" class="form-control" id="categoryItemInput" name = "categoryItem" placeholder="Τεχνική-Κατηγορία" readonly>
                    <label for="categoryItemInput">Τεχνική - Κατηγορία</label>
                </div>
                <div class="col-2 pt-2">
                    <button type="button" class="btn btn-secondary category-btn-modal" ><i class="bi bi-card-heading"></i></button>
                </div>
                <div class="col-6 ">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="discount_on_sales" name="discount_on_sales">
                        <label class="form-check-label" for="discount">
                            Το προϊόν <u>ΔΕΝ</u> επιδέχεται έκπτωση στην πώληση
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="printlabel" name="printlabel">
                        <label class="form-check-label" for="printlabel">
                            Εκτύπωση ετικέτας με barcode & τιμες
                        </label>
                    </div>
                </div>
            </div>

            <hr/>
            <!-- Save button & clear form -->
            <div class="row g-3 mb-3">
                <!-- Save button -->
                <div class="col-10 d-grid">
                    <button class="btn btn-primary btn-save pt-2 pb-2" type="submit"  value="Submit"><span class="fs-4"> <i class="bi bi-save2"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Αποθήκευση</span></button>
                </div>

                <div class="col-1 fs-1 text-center">|</div>

                <!-- Clear form button -->
                <div class="col-1 pt-1">
                    <button class="btn btn-danger bg-danger bg-gradient text-white fs-3" onClick="window.location.reload();" type="button"><i class="bi bi-arrow-clockwise"></i></button>
                </div>
            </div>

            <?php echo form_close() ?>
        </div>

    </div>

</div>

<!-- Canvas located left and treated as the buying basket a.k.a invoice -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="basketOffCanvas" data-bs-backdrop="true" aria-labelledby="offcanvasWithBackdropLabel">

    <div class="offcanvas-header">

        <div >
            <h4 class="offcanvas-title" ></h4>
            <div class="invoice-details"></div>
        </div>
        <button type="button" class="btn-close text-reset" class="width:50%" data-bs-dismiss="offcanvas" aria-label="Close"></button>

    </div>
    <hr class="my-1"/>
    <div class="offcanvas-body px-2 pt-1">

        <ul class="list-group list-group-flush">


        </ul>

    </div>

    <div class="offcanvas-footer p-2 border-top">
        <div class = "row" >
            <div class="col-7">
                <div class="form-floating">
                    <input type="input" class="form-control only-number" id="invoice-discount" name="invoice-discount" placeholder="Έκπτωση Τιμολογίου">
                    <label for="invoice-discount">Έκπτωση Τιμολογίου</label>
                </div>
            </div>
            <div class="col-2 pt-2"><button type="button" id=btn-discount class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></button></div>
            <div class="col-3 pt-2">|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id=btn-close-invoice class="btn btn-danger text-center"><i class="bi bi-check-lg"></i></button></div>
        </div>


    </div>

</div>

<!-- Supplier modal -->
<div class="modal fade" id="supplierModal" aria-hidden="true" aria-labelledby="exampleModalLabel"  tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Επιλογή Προμηθευτή</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" autocomplete="off"  id="supplierName" name="supplierName" placeholder="'Ονομα νέου προμηθευτή" aria-label="'Ονομα νέου προμηθευτή" aria-describedby="button-addon2">
                    <div class="position-absolute invisible z-index-4 mt-5" id="supplierAutocompleteList" ></div>
                    <button class="btn btn-secondary btn-add" type="button">Προσθήκη</button>

                </div>

                <div class="mt-3">
                    Λίστα Προμηθευτών
                    <ul class="dropdown-menu mt-1 py-0 sortable" style="display: block;position: static;min-width: 10rem;list-style: none;height: 500px; overflow: auto">
                    </ul>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<!-- Βrand select -->
<div class="modal fade" id="brandModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Επιλογή Μάρκας</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" autocomplete="off" id="brandName" placeholder="'Ονομα νέας μάρκας" aria-label="'Ονομα νέας μάρκας" aria-describedby="button-addon2">
                    <div class="position-absolute invisible z-index-4 mt-5" id="brandAutocompleteList" ></div>
                    <button class="btn btn-secondary btn-add" type="button">Προσθήκη</button>

                </div>

                <div class="mt-3">
                    Λίστα με Mάρκες
                    <ul class="dropdown-menu mt-1 py-0 sortable" style="display: block;position: static;min-width: 10rem;list-style: none;height: 300px; overflow: auto">
                    </ul>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<!-- Category modal -->
<div class="modal fade" id="categoryModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Επιλογή Κατηγορίας</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" autocomplete="off"  id="categoryItemName" name="categoryItemName" placeholder="'Ονομα νέας κατηγορίας" aria-label="'Ονομα νέας κατηγορίας" aria-describedby="button-addon2">
                    <div class="position-absolute invisible z-index-4 mt-5" id="categoryAutocompleteList" ></div>
                    <button class="btn btn-secondary btn-add" type="button">Προσθήκη</button>

                </div>

                <div class="mt-3">

                    <nav>
                        <div class="nav nav-tabs mt-1" id="nav-tab" role="tablist" ></div>
                        <div class="tab-content" id="nav-tabContent"></div>
                    </nav>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close-category-modal" >Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<!-- Barcode modal -->
<div class="modal fade"  id="barcodeModal" aria-labelledby="barcode-modal-title" aria-hidden="true" tabindex="-1">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barcode-modal-title">Εισαγωγή barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

                <div class="input-group">
                    <input type="text" class="form-control form-control-lg"  autocomplete="off"  name="modalBarcodeInput" placeholder="barcode" aria-label="barcode" >
                    <button class="btn btn-secondary btn-add" type="button">Προσθήκη</button>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>

<!-- Invoice selection modal -->
<div class="modal fade" id="invoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="invoice-modal-title" aria-hidden="true" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Επιλογή παραστατικού</h5>
            </div>
            <div class="modal-body ">

                <!-- select type of insertion -->
                <div class="form-floating " data-size="4" >
                    <select class="form-select" id="insert-select">
                        <option value="1" selected>Ξέμπαρκη καταχώρηση</option>
                        <option value="2" >Νέο Τιμολόγιο</option>
                        <option value="3" >Παλιό τιμολόγιο</option>
                    </select>
                    <label for="insert-select">Τύπος Καταχώρησης</label>
                </div>

                <!-- select supplier name -->
                <div class="form-floating visually-hidden mt-3 ">
                    Λίστα Προμηθευτών
                    <ul id="supplier-select" class="dropdown-menu mt-1 py-0 sortable" style="display: block;position: static;min-width: 10rem;list-style: none;height: 500px; overflow: auto">
                        <li>asd</li>
                    </ul>
                </div>

                <!-- select open/pending invoices -->
                <div class="form-floating visually-hidden mt-3"  >
                    <ul id="invoice-select" class="dropdown-menu mt-1 pt-0 sortable" style="display: block;position: static;min-width: 10rem;list-style: none;height: 500px; overflow: auto">
                        <li>asd</li>
                    </ul>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close-modal" data-bs-dismiss="modal">Αποθήκευση</button>
            </div>
        </div>
    </div>

</div>

<!-- various functions needed by jquery below!! -->
<script>

    var invoiceType = '<?php echo $invoiceType ?>';
    var product         = {id:""};
    var categoryrow_id  = {id:""};


    <?php if ( $invoiceType == 1 || $invoiceType == 0): ?>
    var invoiceLoaded   = {id:"", cost:"",disc:"", date:"" };
    var brandLoaded     = {id:"", name:"" };
    var supplierLoaded  = {id:"", name:""};

    <?php else : ?>
    var invoiceLoaded   = {id:"<?php echo $invoice['id'] ?>", cost:"<?php echo $invoice['cost'] ?>",disc:"<?php echo $invoice['discount'] ?>", date:"<?php echo $invoice['updated_at'] ?>" };
    var brandLoaded     = {id:"", name:"" };
    var supplierLoaded  = {id:"<?php echo $invoice['supplier_id'] ?>", name:"<?php echo $invoice['name'] ?>"};


    updateInvoiceHeader ();
    updateInvoiceFooter ();
    updateSubmitForm ();

    <?php endif; ?>

    // update the header of the left canvas
    function updateInvoiceHeader () {
        $(".offcanvas-title").html(supplierLoaded.name);
        $(".invoice-details").html( invoiceLoaded.date + "&nbsp;&nbsp;|&nbsp;&nbsp;" +  invoiceLoaded.cost + "&euro;</div>&nbsp;&nbsp;|&nbsp;&nbsp;" + invoiceLoaded.disc  + "% εκπτ." );
    }

    // update the footer of the left canvas
    function updateInvoiceFooter () {
        if ( invoiceLoaded.disc > 0 ) $("#invoice-discount").val( invoiceLoaded.disc );
    }

    // set certain supplier to the form
    function updateSubmitForm () {

        // set supplier to the user's selected
        $("#supplierInput").val (  supplierLoaded.name );

        if ( invoiceType != 0 && invoiceType != 1) {
            //disable selection of another supplier by disabling button
            $(".supplier-btn-modal").addClass("disabled");
        }

        // change invoiceType in the hidden value of the form to be posted
        $("input[name='supplier_id']").val( supplierLoaded.id );

        // change invoiceType in the hidden value of the form to be posted
        $("input[name='brand_id']").val( brandLoaded.id );

        // change invoiceType in the hidden value of the form to be posted
        $("input[name='invoiceType']").val(  invoiceType );

        // change invoice_id  in the hidden value of the form to be posted
        $("input[name='invoice_id']").val(  invoiceLoaded.id );

        // change product_id  in the hidden value of the form to be posted
        $("input[name='product_id']").val(  product.id );

        // change invoice_id  in the hidden value of the form to be posted
        $("input[name='discount']").val(  invoiceLoaded.disc );

        // change invoice_id  in the hidden value of the form to be posted
        $("input[name='categoryrow_id']").val(  categoryrow_id.id );
        
    }

    function getTodayDate( ) {

        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        return (day<10 ? '0' : '') + day + "/" +(month<10 ? '0' : '') + month + "/" + d.getFullYear() ;

    }

    function fillProductValues ( ajaxProduct ) {

        var fields = Object.keys( ajaxProduct );

        // fill the form based on input names and fields
        for ( var field of fields  ) {
            $("input[name='" + field + "']").removeClass("is-invalid").addClass("is-valid").val( ajaxProduct [ field ] );   }


        // checkbox is a tricky one!!
        if ( ajaxProduct['discount_on_sales'] == '1') $("#discount_on_sales").prop('checked', true);

        $("#quantity").focus();

        updateFormFields ();
        // hide the video and show image of the deduced product
        $("video").hide();
        var div = $("video").parent();
        div.append( "<img class='img-div img-fluid p-1' src='" + ajaxProduct['image'] + "'>");

        // display a button that when pressed -> removes existing pic and display the video .. os we can create a new image for this old item!
        $(".pic-btn").removeClass("invisible").addClass("visible");

        // fill the object
        supplierLoaded.name = ajaxProduct['supplier'];
        supplierLoaded.id   = ajaxProduct['supplier_id'];
        brandLoaded.id      = ajaxProduct['brand_id'];
        brandLoaded.name    = ajaxProduct['brand'];
        product.id          = ajaxProduct['product_id'];
        categoryrow_id.id   = ajaxProduct['categoryrow_id'];

    }

    function updateFormFields ( ) {

        // if user enters a number on order_quantity.. update automaticall the stock
        var quantity        = parseFloat($("#quantity").val(), 10);
        var stock           = parseFloat($("#stock").val(), 10);
        var wsale_price     = parseFloat($("#wholesale_price").val(), 10);
        var wsale_discount  = parseFloat($("#wholesale_discount").val(), 10);

        if(isNaN(quantity))         { quantity = 0; }
        if(isNaN(stock))            { stock = 0; }
        if(isNaN(wsale_price))      { wsale_price = 0; }
        if(isNaN(wsale_discount))   { wsale_discount = 0; }

        $("#stock").val ( quantity + stock ) ;

        var sum = quantity * wsale_price;
        sum     -= (sum * wsale_discount )/100

        $("#sum").val ( sum );
    }

</script>

<!-- script for the supplier modal -->
<script>

    // function that populates the list
    function supplierPopulateList ( supplierName = null, htmlList = null ) {

        // Using ajax,  get a list of values for this item and display in the modal
        $.ajax({

            type: "post",
            url: "suppliers/search",
            data: { "supplierName" : supplierName },
            success:function( serverData ) {

                var list;

                if ( htmlList == null )
                    list = $("#supplierModal .dropdown-menu");
                else list = htmlList;

                var data = JSON.parse( serverData );

                list.empty();

                // fill the ul with available items
                for (let i = 0; i < data.length; i++) {
                    list.append("" +
                        "<li class='border-bottom' data-id='" + data[i].id + "'>" +
                        "<div class='d-flex'>" +
                        "<a class='dropdown-item h5 mb-0' href='#' style='padding-top:10px!important'><i class='bi bi-arrows-expand'></i> &nbsp;"+ data[i].name + "</a>" +
                        "<div class='p-2 mr-3 px-4'><h5><a href='#' class='link-danger'><i class='bi bi-trash'></i></a></h5></div>" +
                        "</div>" +
                        "</li>");
                }

                list.sortable({
                    axis: 'y',
                    update: function( event, ui ) {

                        var data = $(this).sortable('serialize');

                        $.ajax({

                            type: 'post',
                            url: 'suppliers/sort',
                            data: { "sortString" : data },
                            success : function ( serverData ) {
                                // perhaps a save success message
                            }

                        });

                    }
                });
                    
            },
            error:function(){
                alert("error");
            }

        });

    }

    // the supplier modal just opened ... so.. ::
    $(".supplier-btn-modal").on ( "click", function (event) {

        // clear input and ul list
        var input = $('#supplierName');

        input.val("");
        supplierPopulateList ( input.val() );

        $("#supplierModal").modal("show");

    });

    // a keypress was entered on list
    $("#supplierName").on ('keyup', function (e) {

        var input   = $('#supplierName');
        if (  input.val().length <= 0) { input.val(""); }
        supplierPopulateList ( input.val() );

    });

    // An item from the list is pressed !
    $("body").on ("click", "#supplierModal ul li a.dropdown-item", function () {

        $("#supplierInput").removeClass("is-invalid").val ( $(this).text() );
        $("#brandInput").val(""); // empty the brand of the supplier since a new one is chosen!
        $("#supplierModal").modal("hide");

        supplierLoaded.name = $(this).text();
        supplierLoaded.id   = $(this).closest("li").data("id");
        brandLoaded.id      = "";
        updateSubmitForm ();
    });

    // The delete button of a list item was just pressed
    $("body").on ("click", "#supplierModal ul li a.link-danger", function () {

        deleteText = $(this).closest(".d-flex").find("a.dropdown-item").text().trim();

        $.ajax({
            type: "post",
            url: "suppliers/delete",
            data: { "supplierName" : deleteText },
            success:function( serverData ) {

                var input = $('#supplierName');
                supplierPopulateList ( input.val() );

            },
            error:function(){
                alert("error");
            }

        });

    });

    // the Add button of the modal pressed!!
    $("#supplierModal .btn-add").on ( "click", function () {

        var input   = $('#supplierModal  #supplierName');

        $.ajax({
            type: "post",
            url: "suppliers",
            data: { "supplierName" : input.val() },
            success:function( serverData ) {

                input.val(""); // delete the entered value since everything went as planned!!
                supplierPopulateList ( input.val() );

            },
            error:function(){
                alert("error");
            }

        });

    })



</script>

<!-- script for the brand modal -->
<script>

    // function that populates the list
    function brandPopulateList ( list, data ) {

        list.empty();

        // fill the ul with available items
        for (let i = 0; i < data.length; i++) {
            list.append("" +
                "<li class='border-bottom' data-id='" + data[i].id + "'>" +
                "<div class='d-flex'>" +
                "<a class='dropdown-item h5 pt-2 pb-2' href='#'><i class=\"bi bi-arrows-expand\"></i> &nbsp;"+ data[i].name + "</a>" +
                "<div class='p-2 mr-3 px-4'><h5><a href='#' class=\"link-danger\"><i class='bi bi-trash'></i></a></h5></div>" +
                "</div>" +
                "</li>");
        }

        list.sortable({
            axis: 'y',
            update: function( event, ui ) {

                var data = $(this).sortable('serialize');

                $.ajax({

                    type: 'post',
                    url: 'brands/sort',
                    data: { "sortString" : data },
                    success : function ( serverData ) {
                        // perhaps a save success message
                    }

                });

            }
        });


    }

    // the brand modal button just pressed to open modal ... so.. ::
    $(".brand-btn-modal").on ( "click", function (event) {

        // get items of the modal
        var input       = $('#brandModal  #brandName');
        var list        = $("#brandModal .dropdown-menu");

        // if a supplier has not been selected!
        if ( supplierLoaded.id == "" ) { alert ("Παρακαλώ επιλέξτε προμηθευτή πρώτα!"); return ;}

        // clear input and ul list
        input.val("");

        // Now, using ajax,  get a list of values for this item and display in the modal
        $.ajax({
            type: "get",
            url: "brands/" + supplierLoaded.id,
            success:function( serverData ) {

                serverData = JSON.parse( serverData );

                var autoArray = [];
                for(let i=0; i < serverData.length; i++){ autoArray[i] = serverData[ i ].name; }

                // fill the autocomplete
                set_autocomplete( 'brandName', 'brandAutocompleteList', autoArray);
                brandPopulateList ( list, serverData);

            },
            error:function(){
                alert("error");
            }

        });

        $("#brandModal").modal("show");

    });

    // the Add button of the modal pressed!!
    $("#brandModal .btn-add").on ( "click", function () {

        var input       = $('#brandModal  #brandName');
        var list        = $("#brandModal .dropdown-menu");

        $.ajax({
            type: "post",
            url: "brands/" + supplierLoaded.id,
            data: { "brandName" : input.val() },
            success:function( serverData ) {

                input.val(""); // delete the entered value since everything went as planned!!

                serverData = JSON.parse( serverData );

                var autoArray = [];
                for(let i=0; i < serverData.length; i++){ autoArray[i] = serverData[ i ].name; }

                // fill the autocomplete
                set_autocomplete( 'brandName', 'brandAutocompleteList', autoArray);
                brandPopulateList ( list, serverData);

            },
            error:function( ts ){
                alert( ts.responseText );
            }

        });

    })

    // An item from the list is pressed !
    $("body").on ("click", "#brandModal ul li a.dropdown-item", function () {

        $("#brandInput").removeClass("is-invalid").val ( $(this).text() );
        $("#brandModal").modal("hide");

        brandLoaded.id   = $(this).closest("li").data("id");
        updateSubmitForm ();

    });

    // The delete button of a list item was just pressed
    $("body").on ("click", "#brandModal ul li a.link-danger", function () {

        var list        = $("#brandModal .dropdown-menu");
        var deleteText  = $(this).closest(".d-flex").find("a.dropdown-item").text().trim();


        $.ajax({
            type: "post",
            url: "brands/delete/" + supplierLoaded.id,
            data: { "brandName" : deleteText },
            success:function( serverData ) {

                serverData = JSON.parse( serverData );
                brandPopulateList ( list, serverData);

            },
            error:function(){
                alert("error");
            }

        });

    });



</script>

<!-- script for the Category modal -->
<script>

    // function that populates the list
    function categoryPopulateList ( categoryItemName = null ) {

        // Using ajax,  get a list of values for this item and display in the modal
        $.ajax({

            type: "get",
            url: "/categories/search",
            data: { "categoryItemName" : categoryItemName },
            success:function( serverData ) {

                var data                = JSON.parse( serverData );
                var categoryList        = $("#categoryModal .nav-tabs");
                var categoryItemList    = $("#categoryModal .tab-content");

                categoryList.empty();
                categoryItemList.empty()

                var index=0;
                var active = "active"
                // fill the ul with available items
                for ( var key in data ) {

                    if ( index >= 1 ) active = "";

                    categoryList.append("" +
                        '<button class="nav-link ' + active + '" ' +
                        'id="nav-id-'+ index +'-tab" ' +
                        'data-bs-toggle="tab" ' +
                        'data-bs-target="#nav-id-'+ index +'" ' +
                        'type="button" role="tab" ' +
                        'aria-controls="nav-id-' +index+ '" aria-selected="false"> ' + key +
                        ' </button>');


                    var text = "";
                    data[ key ].forEach( element  =>  { text +=
                        '<li class="list-group-item">' +
                        '<div class="form-check">' +
                        '<input class="form-check-input" type="radio" name="radioItem" data-id="' + element.id + '">' +
                        '<label class="form-check-label" for="radioItem-'+ element.id +'"">' + element.name + '</label>' +
                        '</div>' +
                        '</li>' } );

                    categoryItemList.append (
                        '<div class="tab-pane fade show ' + active + '" id="nav-id-' + index + '" ' +
                        'role="tabpanel" aria-labelledby="nav-id-' + index + '-tab"> ' +
                        '<ul class="list-group sortable">' +
                        text  +
                        '</ul>' +
                        '</div>');



                    index++;
                }

            },
            error:function(){
                alert("error");
            }

        });

    }

    // the technique modal just opened ... so.. ::
    $(".category-btn-modal").on ( "click", function (event) {

        // clear input and ul list
        var input = $('#categoryItemName');
        input.val("");
        categoryPopulateList( input.val() );

        $("#categoryModal").modal("show");

    });

    // An item from the list is pressed !
    $("body").on("change", ".list-group-item input[name=radioItem]:radio",function(){
        $("#categoryItemInput").removeClass("is-invalid").val ( $(this).next().text() );
        $("#categoryModal").modal("hide");

        categoryrow_id.id = $(this).data("id")
        updateSubmitForm ();

    });

    btn-close-category-modal
    $("#categoryModal .btn-close-category-modal").on ( "click", function () {
        $("#categoryModal").modal("hide");
    })

</script>

<!-- Script for html5 video -->
<!--<script>

    var video = document.getElementById('video');

    // Get access to the camera!
    if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        });
    }


</script> -->

<!-- Script acting upon form controls -->
<script>

    var acceptScanningChars = true;

    // keypress or barcode detection
    $(document).on("keypress", function(key) {

        if ( acceptScanningChars == false) { return false; }

        var focusedInputNumbersOnly = $(':focus').hasClass( "only-number");
        var focusedInput            = $(':focus');

        switch ( key.keyCode ) {

            // if barcode scanner pressed with a code...
            // detect it because first key of barcode is '@' - 64
            case 64 : {
                acceptScanningChars = false; // stop accepting chars
                setTimeout(function(){ acceptScanningChars = true }, 1000); // freeze input for 1 sec
                return false;
            }
                break;

            // user entered ','
            case 44:
            case 46: {
                if ( focusedInputNumbersOnly == true ) {
                    if ( focusedInput.val().indexOf(".") >= 0 ) { key.preventDefault(); return false; }
                    if ( key.keyCode == 44) { key.preventDefault(); focusedInput.val( focusedInput.val() + '.'); }
                }
            }break;


            default : {
                // if only numbers allowed on an input and user enters text...
                if ( focusedInputNumbersOnly == true && ( key.keyCode < 48 || key.keyCode > 57 ) ) { key.preventDefault(); return false; }
            }
                break;

        }
    });

    // automatically update the stock input based on order's item quantity
    $(document).on("keyup", function( key ) {

        if ($("#wholesale_price").is(":focus") || $("#wholesale_discount").is(":focus")) { updateFormFields (); }
        if ($("#quantity").is(":focus")) {

            updateFormFields ();

            if  ( key.keyCode == 13 ) { $(".btn-save").click(); } // user pressed 13... so "Hit" the save button!!
        }


    });

</script>

<!-- Script dealing with SAVE button press -->
<script>

    // if input is marked as invalid ... if user types in the input clear the "invalid" flag!
    $("#productForm :input").on ( 'input change keyup paste', function () { if ( $(this).val().length >= 1 ) {  $(this).removeClass("is-invalid"); }  });

    // press of button SAVE
    $(".btn-save").on ( "click", function ( event ) {

        event.preventDefault();

        // check that there is a text in the inputs
        if ($("#barcode").val().length <= 3)            { alert("Παρακαλώ βάλτε barcode ή κάποιο textcode στο είδος!"); $("#barcode").addClass("is-invalid"); return;  }
        if (supplierLoaded.id.length <= 0)              { alert("Παρακαλώ βάλτε το όνομα του προμηθευτή που προμηθεύεστε το είδος!"); $("#supplierInput").addClass("is-invalid"); return;  }
        if ($("#description").val().length <= 3)        { alert("Παρακαλώ βάλτε όνομα στο είδος!"); $("#description").addClass("is-invalid"); return;  }
        if ($("#retail_price").val().length < 1)        { alert("Παρακαλώ εισάγετε μια τιμή λιανικής στο είδος!"); $("#retail_price").addClass("is-invalid"); return;  }

        if ($("#reorder_quantity").val().length < 1)    { alert("Παρακαλώ βάλτε όριο αναπαραγγελίας στο είδος!"); $("#reorder_quantity").addClass("is-invalid"); return;  }
        if ($("#stock").val().length <= 0)              { alert("Παρακαλώ βάλτε την ποσότητας που αγοράστηκε!"); $("#stock").addClass("is-invalid"); return;  }
        if (brandLoaded.id.length <= 0)                 { alert("Παρακαλώ βάλτε την μάρκα του είδους!"); $("#brandInput").addClass("is-invalid"); return;  }
        if (categoryrow_id.id.length <= 0)              { alert("Παρακαλώ βάλτε τεχνική που ανήκει το είδος!"); $("#categoryItemInput").addClass("is-invalid"); return;  }

        if ( invoiceType >= 2) {
            if ($("#wholesale_price").val().length < 1)     { alert("Παρακαλώ βάλτε αγοράς στο είδος!"); $("#wholesale_price").addClass("is-invalid"); return;  }
            if ($("#quantity").val().length < 1)            { alert("Παρακαλώ βάλτε το σύνολο της ποσότητας που τελικώς θα υπάρχει στο ράφι σήμερα!"); $("#quantity").addClass("is-invalid"); return;  }
            if ($("#minimum_quantity").val().length < 1)    { alert("Παρακαλώ βάλτε ελάχιστη ποσότητα αγοράς στο είδος!"); $("#minimum_quantity").addClass("is-invalid"); return;  }
        }

        // Check if video is visible... which can happen on inserting or updating an item
        // If we are editing an old item and we are happy with the image then "video" is NOT visible

        /*if ( $("video").is(":visible") ) {
            // create a snapshot of image and save
            var video       = document.getElementById('video');
            var canvas      = document.createElement('canvas');
            canvas.width    = 640;
            canvas.height   = 480;
            var ctx         = canvas.getContext('2d');

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            var dataURI     = canvas.toDataURL('image/jpeg'); // can also use 'image/png'
            $("input[name='imageData']").val ( dataURI );
        }*/

        $("#productForm").submit();// submit form!

    });


</script>

<!-- Script to hide image and start the video to take a new picture for an old product -->
<script>

    $(".pic-btn").on ("click", function () {

        $("video").show();
        $(".img-div").remove();
        $(".pic-btn").removeClass("visible").addClass("invisible");
    })

</script>

<!--
Δεν είμαι σίγουρος ότι αυτό είναι απαραίτητο!!

Autocomplete script when writing product description
<script>
    $(document).ready(function(){

        $('#description').autocomplete({
            source: "product/autocomplete_search",
            minLength: 2,
            select: function(event, ui)
            {
                $('#description').val(ui.item.value);
            },
            open: function (){$('.ui-menu').addClass('list-group');}

        })
            .data('ui-autocomplete')._renderItem = function(ul, item){
            return $("<li class='list-group-item'></li>")
                .data("item.autocomplete", item)
                .append(item.label)
                .appendTo(ul);
        };

    });
</script>
-->

<!-- Print the label ( barcode & price ) using the Dymo450 SDK -->
<script>
    /*
        // 40mmX15mm
        var DymoPrinterName = "";
        if(dymo.label.framework.init) {

            var printers    = dymo.label.framework.getPrinters();
            var result      = dymo.label.framework.checkEnvironment();

            if ( result.isBrowserSupported && result.isFrameworkInstalled && result.isWebServicePresent  ){
                $("#dymoLabel > button").removeClass("btn-secondary").addClass("btn-primary").prop( "disabled", false ).html ('<i class="bi bi-printer"></i>')

                // getting printer
                var printers = dymo.label.framework.getPrinters();

                if (printers.length == 0) {
                    $("#dymoLabel > button").html ('<i class="bi bi-printer-fill"></i>');
                    $("#dymoLabel > button").removeClass("btn-success").addClass("btn-secondary").prop( "disabled", true ).append(" - No printer found!!");
                }else {

                    for (var i = 0; i < printers.length; ++i)
                    {
                        var printer = printers[i];
                        if (printer.printerType == "LabelWriterPrinter")
                        {
                            printerName = printer.name;
                            break;
                        }
                    }
                    if (printerName == "") {
                        $("#dymoLabel > button").html ('<i class="bi bi-printer-fill"></i>');
                        $("#dymoLabel > button").removeClass("btn-success").addClass("btn-secondary").prop( "disabled", true ).append(" - No printer found!!");
                    }else {
                        DymoPrinterName = printerName;
                        $("#dymoLabel > button").append(" - " + DymoPrinterName);

                    }
                }
            }
            else {

                $("#dymoLabel > button").html ('<i class="bi bi-printer-fill"></i>');
                $("#dymoLabel > button").removeClass("btn-success").addClass("btn-secondary").prop( "disabled", true );
                if ( result.isBrowserSupported == false)    $("#dymoLabel > button").append(" - browser !supported");
                else if ( result.isFrameworkInstalled == false)  $("#dymoLabel > button").append(" - framework !installed");
                else if ( result.isWebServicePresent == false)   $("#dymoLabel > button").append(" - WebService !present");

            }
        }

        $("#dymoLabel").on ( "click", function () {

            if ($("#barcode").val().length <= 3)        { alert ( "Παρακαλώ εισάγετε ένα κωδικό barcode"); return;}
            if ($("#retail_price").val().length < 1)    { alert("Παρακαλώ εισάγετε μια τιμή λιανικής του είδους!"); return;  }

            label = dymo.label.framework.openLabelXml( getLayout ($("#barcode").val(), $("#retail_price").val()) );
            label.print( DymoPrinterName );

        })

        function getLayout( barcode, price) {

            var xmlLabel = '<' +'?xml version="1.0" encoding="utf-8"?>\
            <DieCutLabel Version="8.0" Units="twips">\
                <PaperOrientation>Landscape</PaperOrientation>\
                <Id>Address</Id>\
                <PaperName>30252 Address</PaperName>\
                <DrawCommands>\
                    <RoundRectangle X="0" Y="0" Width="1581" Height="5040" Rx="270" Ry="270" />\
                </DrawCommands>\
                \
                <ObjectInfo>\
                    <BarcodeObject>\
                        <Name>BARCODE</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation0</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <Text>' + barcode + '</Text>\
                        <Type>Ean13</Type>\
                        <Size>Small</Size>\
                        <TextPosition>Bottom</TextPosition>\
                        <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                        <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                        <TextEmbedding>None</TextEmbedding>\
                        <ECLevel>0</ECLevel>\
                        <HorizontalAlignment>Center</HorizontalAlignment>\
                        <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                    </BarcodeObject>\
                        <Bounds X="0" Y="300" Width="1600" Height="560" />\
                </ObjectInfo>\
    \
    \
                <ObjectInfo>\
                    <AddressObject>\
                        <Name>Address</Name>\
                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                        <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                        <LinkedObjectName></LinkedObjectName>\
                        <Rotation>Rotation90</Rotation>\
                        <IsMirrored>False</IsMirrored>\
                        <IsVariable>True</IsVariable>\
                        <HorizontalAlignment>Left</HorizontalAlignment>\
                        <VerticalAlignment>Middle</VerticalAlignment>\
                        <TextFitMode>ShrinkToFit</TextFitMode>\
                        <UseFullFontHeight>True</UseFullFontHeight>\
                        <Verticalized>False</Verticalized>\
                        <StyledText>\
                            <Element>\
                                <String>' + price +' E\
                                 </String>\
                                <Attributes>\
                                    <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                                    <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                                </Attributes>\
                            </Element>\
                        </StyledText>\
                        <ShowBarcodeFor9DigitZipOnly>False</ShowBarcodeFor9DigitZipOnly>\
                        <BarcodePosition>AboveAddress</BarcodePosition>\
                        <LineFonts>\
                            <Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                        </LineFonts>\
                    </AddressObject>\
                    <Bounds X="800" Y="390" Width="2455" Height="460" />\
                </ObjectInfo>\
            </DieCutLabel>';
            return xmlLabel;
        }
    */
</script>

<!-- Script for Type of insertion of products  -->
<script>

    // ------------------------------------------------------------
    // if it's the first time we are entering this form .. ask user
    // what type of insertion he requires
    // 0 -> Χύμα καταχώρηση ενός προϊόντος
    // 1 -> Δημιουργία ενός ενός νέου invoice κάποιου προμηθευτή
    // 2 -> Μεταβολή ενός ανοικτού τιμολογίου κάποιου προμηθευτή
    // ------------------------------------------------------------
    $( document ).ready(function() {

        // on load set focus on barcode edit
        $( document ).ready(function() { $("#barcode").focus();  });

        // user loaded this page through initial menu.. not after having save/edit products
        // so ask his intentions...
        var invoiceType = '<?php echo $invoiceType ?>';
        if ( invoiceType == '0')    { $("#invoiceModal").modal("show"); }
    });

    // user select on the type of insertion of the products
    $("#insert-select").on("change", function () {

        invoiceType = $(this).val();

        // Just edit products
        if ( invoiceType == 1) { // this item (to be posted) does not have any invoice to be attached..
            $("#invoice-select").parent().removeClass( "visually-hidden").addClass("visually-hidden");
            $("#supplier-select").parent().removeClass( "visually-hidden").addClass("visually-hidden");
            $("#invoiceModal .btn-close-modal").removeClass().addClass("btn btn-secondary btn-close-modal");

        }

        // Add product to an new invoice
        if ( invoiceType == 2) { // this item (to be posted) belongs to a new invoice of a supplier

            $("#invoice-select").parent().removeClass( "visually-hidden").addClass("visually-hidden");
            $("#supplier-select").parent().removeClass( "visually-hidden");
            $("#invoiceModal .btn-close-modal").removeClass().addClass("btn btn-outline-secondary btn-close-modal disabled");

            supplierPopulateList ( "", $("#supplier-select") );

        }

        // Add product to an old invoice
        if ( invoiceType == 3) { // this item (to be posted) belongs to an old invoice of a supplier

            $("#invoice-select").parent().removeClass( "visually-hidden");
            $("#supplier-select").parent().removeClass( "visually-hidden").addClass("visually-hidden");
            $("#invoiceModal .btn-close-modal").removeClass().addClass("btn btn-outline-secondary btn-close-modal disabled");

            var list = $("#invoice-select");

            // get the last 10 invoices and show to the user to choose
            $.ajax({
                type: "get",
                url: "invoices/ajaxGetlastinvoices",
                success: function (serverData) {
                    var data = JSON.parse( serverData );
                    list.empty();

                    // fill the ul with available items
                    for (let i = 0; i < data.length; i++) {
                        if ( data[i].closed ) {
                            list.append("" +
                                "<li class='border-bottom' data-invoice-date = '" + data[i].date + "' data-invoice-discount = '" + data[i].discount + "' data-invoice-cost = '" + data[i].cost + "' data-supplier-name = '" + data[i].name + "' data-id='" + data[i].id + "' id='prod-" + data[i].supplier_id + "'>" +
                                "<div class='d-flex'>" +
                                "<a class='dropdown-item h5 mb-0 text-danger' href='#' style='padding-top: 8px'>" + data[i].name + "</a>" +
                                "<div class='p-2 mr-3 px-4'><h6>" + data[i].date + "</h6></div>" +
                                "</div></li>");
                        }
                        else {
                            list.append("" +
                                "<li class='border-bottom' data-invoice-date = '" + data[i].date + "' data-invoice-discount = '" + data[i].discount + "' data-invoice-cost = '" + data[i].cost + "' data-supplier-name = '" + data[i].name + "' data-id='" + data[i].id + "' id='prod-" + data[i].supplier_id + "'>" +
                                "<div class='d-flex'>" +
                                "<a class='dropdown-item h5 mb-0 text-success' href='#' style='padding-top: 8px'>" + data[i].name + "</a>" +
                                "<div class='p-2 mr-3 px-4'><h5>" + data[i].date + "</h5></div>" +
                                "</div></li>");
                        }
                    }

                },
                error: function () {
                    alert("Πρόβλημα στην εμφάνιση των παραστατικών του εισαγωγέα!");
                }
            });

        }


        updateSubmitForm ();

    });

    // user selected edit/insert individually products
    $("body").on( "click", "#invoiceModal .btn-close-modal", function () { invoiceType = '1'; $(".hide-on-raw-insert").hide(); updateSubmitForm (); $("#barcode").focus();});

    // user selected to create a new invoice of a specific supplier
    // so grab supplier's id and make appropriate changes ...
    $("body").on( "click", "#invoiceModal #supplier-select li", function () {

        // create a new invoice object
        invoiceType         = '2';
        invoiceLoaded.cost  = "0";
        invoiceLoaded.disc  = "0";
        invoiceLoaded.date  = getTodayDate();
        supplierLoaded.id   = $(this).data("id");
        supplierLoaded.name = $(this).find ("a").text();

        updateInvoiceHeader (); // show header
        updateInvoiceFooter (); // show discount
        updateSubmitForm ();// make appropriate changes in the form

        // hide the modal
        $("#invoiceModal").modal("hide");

        // set focus to the barcode input for immediate input
        $("#barcode").focus();
    });

    // user selected to update a specific supplier's invoice
    $("body").on( "click", "#invoiceModal #invoice-select li", function () {

        // load the invoice products to the left canvas
        $.ajax({
            type: "get",
            url: "invoices/ajaxGetInvoice/" + $(this).data("id"),
            success: function (serverData) {

                var data        = JSON.parse( serverData );
                var products    = data["products"];
                var invoice     = data["invoice"];

                // append on the offcanvas header the supplier and selected invoice particulars
                if ( Array.isArray(invoice) ) { invoice = invoice[0]; }

                invoiceType         = '2';
                invoiceLoaded.id    = invoice.invoice_id;
                invoiceLoaded.cost  = invoice.cost;
                invoiceLoaded.disc  = invoice.discount;
                invoiceLoaded.date  = invoice.invoice_date;
                supplierLoaded.id   = invoice.supplier_id;
                supplierLoaded.name = invoice.supplier_name;

                updateInvoiceHeader (); // show header
                updateInvoiceFooter (); // show discount
                updateSubmitForm ( );// make appropriate changes in the form so the supplier is always selected

                // append on the offcanvas the products
                products.forEach (function (  product ) {

                    $(".offcanvas-body ul").append(

                        '<li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">' +
                        '<span class="lh-2 text-truncate d-inline-block" style="max-width: 330px;">' +
                        '<span class="fs-5" > ' + product.description + '</span> ' +
                        '<div class="row pt-1 gx-2">' +
                        '<div class="col-4 "><img class="img-thumbnail" src="' + product.image + '" ></div>' +
                        '<div class="col-8 ">' +
                        '<span class="text-secondary"><small>' + product.brand_name + '</small></span>' +
                        '<hr class="my-1">' +
                        '#' + product.barcode + ' <br/>' +
                        '<small>' + product.wholesale_price + ' x ' + product.quantity + '&euro; - ' + product.discount +'% = ' + product.sum + '&euro;</small>' +
                        '</div>' +
                        '</div>' +
                        '</span>'+
                        '<a href="#" class="fs-4 text-danger remove-btn pt-1" style="padding-right:20px;" data-id = "'+ product.row_id +'" ><i class="bi bi-x-circle-fill"></i></a>'+
                        '</li>'
                    )

                })

                // hide the modal
                $("#invoiceModal").modal("hide");

                // set focus to the barcode input for immediate input
                $("#barcode").focus();
            },
            error: function () {
                alert("Πρόβλημα στην εμφάνιση των παραστατικών του εισαγωγέα!");
            }
        });


    });


</script>

<!-- Script for actions related with ( invoice shown on ) left canvas -->
<script>

    // remove an item from the basket ...
    $("body").on( "click", ".offcanvas-body ul li .remove-btn", function ( ) {

        // Remove the item from the database and using return value
        // update the invoice's sum on top of offCanvas
        $.ajax({
            type: "get",
            url: "invoices/ajaxRemoveInvoiceProduct/" + $(this).data("id"),
            success: function (serverData) {

                var data = JSON.parse( serverData );

                invoiceLoaded.cost  = data.cost;
                invoiceLoaded.disc  = data.discount;

                updateInvoiceHeader ()

                // TODO :: show confirmation to user that item is delete! if ( serverData == ) {  }

            },
            error: function () {
                alert("Πρόβλημα στην διαγραφή προϊόντων απο το παραστατικό του εισαγωγέα!");
            }
        });



        // visually hide item from user..  because delete would cause the offCanvas to close!!
        $(this).parent().addClass( "visually-hidden");


    });

    // update the discount of the invoice
    $("#btn-discount").on ( "click", function () {

        var discount = $("#invoice-discount").val();
        if ( discount < 0 ) return;

        $.ajax({
            type: "post",
            url: "invoices/ajaxUpdateInvoiceDiscount/" + invoiceLoaded.id,
            data : { "discount" : discount },

            success: function (serverData) {

                var data = JSON.parse( serverData );

                invoiceLoaded.disc = data.discount;
                invoiceLoaded.cost = data.cost;

                updateInvoiceHeader ();
                updateSubmitForm ()

            },
            error: function () {
                alert("Πρόβλημα στην ενημέρωση της έκπτωσης στο παραστατικό του εισαγωγέα!");
            }
        });



    })


</script>

<!-- Script for button Clone-product -->
<script>

    $("#clone-product").on ( "click", function () {

        if ( $(this).data("state") == "on" ) {

            $(this).removeClass("btn-primary").addClass("btn-secondary").data("state", "off");
            $(this).find($(".bi")).removeClass('bi-check2-square').addClass('bi-square');

        }else {

            $(this).removeClass("btn-secondary").addClass("btn-primary").data("state", "on");
            $(this).find($(".bi")).removeClass('bi-square').addClass('bi-check2-square');

            $.ajax({
                type: "get",
                url: "supplies/ajaxGetLastProduct/",
                success: function (serverData) {


                    if ( serverData != "" && serverData != null ) {

                        var ajaxProduct = JSON.parse( serverData );

                        // prevent these values .. so we do not save on top of another product
                        ajaxProduct['barcode']      = "";
                        ajaxProduct['product_id']   = "";
                        ajaxProduct['stock']        = "";

                        fillProductValues ( ajaxProduct );

                        $("#barcode").removeClass("is-invalid").removeClass("is-valid").val("");



                    }

                },
                error: function () {
                    alert("Πρόβλημα στην συμπλήρωση της φόρμας προϊόντος !");
                },
            });
        }

    })


</script>

<!----------------------- BARCODE RELATED STUFF ---------------------->
<!-------------------------------------------------------------------->

<!-- Script for barcode scanner -->
<script>
    // in conjuction with script onScan.js
    // https://github.com/axenox/onscan.js

    function checkEnteredBarcode ( barcode ) {
        // if barcode exists load the form with values...!!

        $.ajax({
            type: "get",
            url: "barcode/search/" + barcode,
            success: function (serverData) {

                if ( serverData != "" ) {

                    var ajaxProduct = JSON.parse( serverData );
                    fillProductValues ( ajaxProduct );
                }

            },
            error: function () {
                alert("Πρόβλημα στην συμπλήρωση της φόρμας προϊόντος !");
            },
        });
    }

    onScan.attachTo(document, {

        suffixKeyCodes: [13], // enter-key expected at the end of a scan
        reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
        onScan: function(sCode, iQty) {

            $("#barcode").val(sCode.substr(1, 15));

            checkEnteredBarcode ( sCode.substr(1, 15) );
        },
        onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!
            // console.log('Pressed: ' + );
        }
    });

    // delete barcode button pressed !
    $(".del-barcode-btn").on("click", function () { $('#barcode').removeClass("is-valid").removeClass("is-invalid").val("").trigger ( "focus"); });

</script>

<!-- Script for barcode generation -->
<script>

    $("#btn-bardode").on ( "click", function () {

        $.ajax({ type: "get", url: "barcode/create",
            success:function( serverData ) { $("#barcode").val ( serverData );  $("#barcode").removeClass("is-invalid"); },
            error:function(){ alert("Πρόβλημα στην δημιουργία Barcode !"); }
        });

    });

</script>

<!-- Script for barcode manual entry modal -->
<script>

    // trigger focus on the input when modal is opened..
    $("#barcodeModal").on ( 'shown.bs.modal', function(){
        if ( $("#barcode").val ().length > 4 )
            $("input[name='modalBarcodeInput']").val(  $("#barcode").val () ); // clear input
        else $("input[name='modalBarcodeInput']").val(""); // clear input

        $("input[name='modalBarcodeInput']").trigger ( "focus");
    });

    $("#barcodeModal .btn-add").on( "click", function () {

        $("#barcode").val ( $("input[name='modalBarcodeInput']").val() );
        $("#barcode").removeClass("is-invalid");
        $("#barcodeModal").modal("hide");
        checkEnteredBarcode ( $("#barcode").val () );
    })



</script>

<!-- do not DELETE!! .. prevents re-submission!! -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?=$this->endSection()?>


