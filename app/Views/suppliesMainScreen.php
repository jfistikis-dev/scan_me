<?=$this->extend("common/main")?>

<?=$this->section("content")?>


<!-- HEADER TOP BLACK -->
<div class="row navbar navbar-dark sticky-top bg-dark p-0 shadow">&nbsp;</div>

<!-- The actuall window of this page -->
<div class="row featurette class-supplies p-3 g-3 " >

    <!-- Title & Exit buttons -->
    <div class="d-flex justify-content-between pb-2 position-relative" >

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


        <!-- Log area -->
        <div class="col-md-4 position-relative">
            <div class="card mt-2" >
                <div class="card-body" >
                    <div class="row" style="overflow-y: scroll;height:calc(100vh - 340px);">
                        <ul class="list-group list-group-flush product-log-list"></ul>
                    </div>
                </div>
                    
            </div>
        </div>


        <!-- Product area -->
        <div class="col-md-8">

            
            <form id="productForm" action="<?= base_url('supplies' ) ?>" method="post"  enctype="multipart/form-data">

                <?= csrf_field() ?>
                <input type="hidden" name="stock" value="">

                <!-- Barcode & Textcode -->
                <div class="row mb-3 mt-2">
                    <div class="col-12">
                        <?= view('/components/input_barcode', ['name'=> 'barcode']) ?>
                    </div>  
                </div>
                
                <!-- Name -->
                <div class="row g-3 mb-3">
                    <div class="col-12 form-floating">
                   
                    <?= view('components/input_text', [
                            'name'          => 'name',
                            'placeholder'   => 'Περιγραφή προϊόντος',
                            'label'         => 'Περιγραφή προϊόντος',
                            'disabled'      => false,
                            'remember_me'   => true,
                            'add_delete_btn'=> true
                        ]);  ?>    
                    </div>
                </div>
                
                 <!-- Supplier & brand select -->
                <div class="row g-3 mb-3 ">
                    
                    <!-- Supplier select -->
                    <div class="col-6">
                        <?= view('/components/select_live', [
                            'name'          => 'supplier_id', 
                            'v_name'        => 'Προμηθευτή',
                            'v_name_plural' => 'Προμηθευτές',
                            'rest_url'      => 'suppliers', // search, sort, delete, insert
                            'rest_actions'  => [
                                'create'    => 'create',
                                'delete'    => 'delete', 
                                'sort'      => 'sort',
                                'search'    => 'search', 
                                ],
                            'items'         => $suppliers ,
                            'delete_text'   => 'Child Brands and products will be delete too !! Do you want to proceed? '
                            
                            ]) ?>
                    </div>
                    
                    <div class="col-1 pt-2">&nbsp;</div> 

                    <!-- Brand select -->
                    <div class="col-5">
                        <?= view('/components/select_live', [
                            'name'          => 'brand_id', 
                            'v_name'        => 'Κατηγορία', 
                            'v_name_plural' => 'Κατηγορίες',
                            'rest_url'      => 'brands', // search, sort, delete, insert
                            'rest_actions'  => [
                                'create'    => 'create',
                                'delete'    => 'delete', 
                                'sort'      => 'sort',
                                'search'    => '', 
                                ],
                            'depends_on_id' => 'supplier_id',
                            'items'         => $brands,
                            'delete_text'   => 'Είστε σίγουρος για την διαγραφή της μάρκας? '
                            
                            ]) ?>
                    </div>

                </div>

                <!-- Purchase moq / threshold -->
                <div class="row g-3 mb-3">
                
                        <?= session()->get('measuring_unit-remember-me') ?>
                    <!-- Measuring unit -->
                    <div class="col-4 form-floating">
                        <?= view('/components/select_live', [
                                'name'          => 'measuring_unit_id', 
                                'v_name'        => 'Μον. Μέτρησης',
                                'v_name_plural' => 'Μον. Μέτρησης',
                                'rest_url'      => 'measuring_units', // search, sort, delete, insert
                                'rest_actions'  => [
                                    'create'    => 'create',
                                    'delete'    => 'delete', 
                                    'sort'      => 'sort',
                                    'search'    => 'search', 
                                    ],
                                'depends_on_id' => '',
                                'depends_on_name' => '',
                                'items'         => $m_units
                                
                                
                                ]) ?>
                    </div>
                        
                        
                    <!-- reorder quantity -->
                    <div class="col-3 form-floating hide-on-raw-insert">
                        <?= view('components/input_number', [
                            'name'          => 'reorder_quantity',
                            'placeholder'   => 'Ποσότητα. αναπ/λίας',
                            'value'         => '',
                            'label'         => 'Ποσότητα. αναπ/λίας',
                            'disabled'      => false,
                            'remember_me'   => true,
                            'class'         => ' form-control '


                        ]);  ?>    
                    </div>

                    <!-- Selling price -->
                    <div class="col-3 form-floating">
                        <?= view('components/input_number', [
                                'name'          => 'selling_price',
                                'placeholder'   => 'Τιμή πώλησης (€)',
                                'value'         => '',
                                'label'         => 'Τιμή πώλησης (€)',
                                'disabled'      => false,
                                'remember_me'   => true,
                                'class'         => ' form-control '
                            ]);  ?>    
                    </div>

                     <!-- stock -->
                    <div class="col-2 form-floating">
                        <?= view('components/input_number', [
                                'name'          => 'show_stock',
                                'placeholder'   => 'Στοκ',
                                'value'         => '0',
                                'label'         => 'Στοκ',
                                'disabled'      => true,
                                'remember_me'   => false,
                                'add_delete_btn'=> false,
                                'class'         => ' form-control '
                            ]);  ?>    
                    </div>
                
                
                </div>
                
                <hr/>

                <!-- Purchase price / Retail price -->
                <div class="row g-3 mb-3 hide-on-raw-insert">
                    <div class="col form-floating">
                            <?=view('components/input_number', [
                                'name'          => 'quantity',
                                'placeholder'   => 'Ποσότητα/Τεμάχια',
                                'value'         => '',
                                'label'         => 'Ποσότητα/Τεμάχια',
                                'disabled'      => false,
                                'remember_me'   => false,
                                'add_delete_btn'=> true,
                                'class'         => ' form-control '
                            ]); ?>
                        </div>    
                    <div class="col form-floating">
                            
                            <?= view('components/input_number', [
                                'name'          => 'buying_price',
                                'placeholder'   => 'Τιμή αγοράς (€)',
                                'value'         => '',
                                'label'         => 'Τιμή αγοράς (€)',
                                'disabled'      => false,
                                'remember_me'   => true,
                                'class'         => ' form-control '
                            ]); ?>

                        
                    </div>
                    
                    <div class="col form-floating">
                         <?= view('components/input_number', [
                            'name'          => 'wholesale_discount',
                            'class'         => 'input-percentage form-control ',
                            'placeholder'   => 'Έκπτωση %',
                            'value'         => '0',
                            'label'         => 'Έκπτωση %',
                            'min'           => '0',
                            'max'           => '100',
                            'disabled'      => false,
                            'remember_me'   => true,

                        ]);  ?>
                    </div>
                    
                    <div class="col form-floating">
                        <input type="input" class="form-control text-end " id="sum" name="sum" disabled>
                        <label for="sum">Σύνολο</label>
                    </div>
                </div>

               
                <hr/>
                <!-- Save button & clear form -->
                <div class="row g-3 mb-3">
                    <!-- Save button -->
                    <div class="col-10 d-grid">
                        <button class="btn btn-primary btn-save pt-2 pb-2" type="submit"  value="Submit">
                            <span class="fs-4"> <i class="bi bi-save2"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Αποθήκευση</span>
                        </button>
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
    
    <!-- Toast messages -->
	<?= $this->include('common/toast') ?>

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



<script>

    //When document is ready .. init input number formats
    $(document).ready(function() {
        SFNumberFunctions._initInputFormats;
    });
    
    // before submitting the form check that the following inputs have input : barcode, brand, category, quantity
    $( "#productForm" ).submit(function( event ) {

        let required_fields = [ "#barcode", "#supplier_id_select",  "#brand_id_select",  "#measuring_unit_id_select", "input[name='quantity']", "input[name='name']" ];
        let submit_form = true;

        required_fields.forEach( function ( field ) {
            if ( $( field ).val() == '' ) {
                $( field ).addClass("is-invalid");
                event.preventDefault();
                submit_form = false;
            }
            else {
                $( field ).removeClass("is-invalid").addClass("is-valid");
            }
        })

        if ( !submit_form ) {
            alert("Πρεπει να συμπληρωσετε τα απαραιτητα πεδια");
            return false;   
        }
        
        $( "#productForm" ).submit();
        
    });

    

</script>

<!-- Calculate sum script -->
<script>

    // Cache elements for better performance
    const $quantity     = $("input[name='quantity']");
    const $buyingPrice  = $("input[name='buying_price']");
    const $discount     = $("input[name='wholesale_discount']");
    const $sum          = $("#sum");

    function calculateSum() {
        let quantity        = SFNumberFunctions._parseNumber($quantity.val());
        let buying_price    = SFNumberFunctions._parseNumber($buyingPrice.val());
        let discount        = SFNumberFunctions._parseNumber($discount.val());

        // Validate inputs
        if (quantity > 0 && buying_price > 0 && !isNaN(quantity) && !isNaN(buying_price)) {
            let sum = quantity * buying_price;
            
            // Apply discount if valid
            if (discount > 0 && discount <= 100) {
                sum = sum * (1 - discount / 100);
            }
            
            $sum.val(SFNumberFunctions._displayCurrency(sum, 2));
        } else {
            $sum.val(""); // Clear when invalid
        }
    }

    // Attach event listeners
    $quantity.add($buyingPrice).add($discount).on("input", calculateSum);

    // Optional: Calculate on page load if values exist
    calculateSum();

</script>

<!-- Fetch product if barcode exists -->
<script>
    $("input[name='barcode']").on('change',  function ( event ) {
        
        event.preventDefault(); 
        let barcode = $(this).val();
        if ( barcode === '' ) return;
        

        $.ajax({
            url: "<?= base_url('products?barcode=') ?>" + barcode,
            method: "get",
            dataType: "json",

            success: function(serverData) {
                __clearProductLogs ();

                if ( serverData.data != "" && serverData.data != null ) { 
                    __fillProductValues ( serverData.data ); 
                    __renderProductLogs ( serverData.log );
                }
                else { 
                    __clearProductValues (); 
                }
            }
        });
        
    });

    function __fillProductValues ( product ) {
        //console.log ( product );
        $("input[name='name']").val( product.name ).trigger('change');
        $("input[name='stock']").val( product.stock );
        $("input[name='show_stock']").val( SFNumberFunctions._displayNumber (product.stock, 2 ) );
        $("input[name='reorder_quantity']").val( SFNumberFunctions._displayNumber (product.reorder_quantity,2 ) ).trigger('change')
        $("input[name='selling_price']").val( SFNumberFunctions._displayNumber(product.selling_price, 2) ).trigger('change'); 
        $("input[name='buying_price']").val( SFNumberFunctions._displayNumber (product.buying_price, 2) ).trigger('change');
        $("input[name='wholesale_discount']").val( SFNumberFunctions._displayNumber  (product.wholesale_discount,2) ).trigger('change');

        $("select[name='measuring_unit_id']").val(product.measuring_unit_id ).trigger('change');
        $("select[name='supplier_id']").val(product.supplier_id ).trigger('change');
        $("select[name='supplier_id']").trigger('change');
        $("select[name='brand_id']").data ('ajaxPopulateList').call($("select[name='brand_id']"), function() {
            $("select[name='brand_id']").val(product.brand_id );
 
        });
    }

    function __clearProductValues () {
        $("input[name='name']").val("").trigger('change');
        $("input[name='stock']").val("").trigger('change');
        $("input[name='show_stock']").val("").trigger('change');
        $("input[name='reorder_quantity']").val("").trigger('change');
        $("input[name='selling_price']").val("").trigger('change');
        $("input[name='buying_price']").val("").trigger('change');
        $("input[name='wholesale_discount']").val("").trigger('change');
        $("select[name='supplier_id'] option:first").prop('selected', true)
        $("select[name='supplier_id']").trigger('change');
        $("select[name='measuring_unit_id']").val("").trigger('change');
    }

    function __clearProductLogs () {
        let $list = $(".product-log-list");
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
            else if ( log_entry.type_id == "<?=  PRODUCT_LOG_TYPE_SELLING ?>") {
                html += "<li class='text-sm bg-danger text-white px-2 py-1 rounded mb-1 opacity-75' style='font-size:0.8rem'>" + __toEuropeanDate ( log_entry.created_at );    
                html += " - ΠΩΛΗΣΗ : " ;
                html += log_entry.quantity + " " + log_entry.measuring_unit_name + " @ " + SFNumberFunctions._displayCurrency(log_entry.selling_price, 2);
                html += '</li>';
            }
            
        });

        $list.append(html);

    }

    function __toEuropeanDate(datetimeStr) {
        // Split date and time
        const [datePart, timePart] = datetimeStr.split(' ');
        const [year, month, day] = datePart.split('-');
        
        // Return in European format
        return `${day}-${month}-${year} ${timePart}`;
    }
</script>

<?=$this->endSection()?>


