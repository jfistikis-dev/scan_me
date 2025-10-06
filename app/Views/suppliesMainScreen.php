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


            ?>
            <form id="productForm" action="<?= base_url('supplies' ) ?>" method="post"  enctype="multipart/form-data">

                <?= csrf_field() ?>
                <?php foreach ( $hiddenFormFields as $key => $value ) : ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
                <?php endforeach; ?>

                <!-- Barcode & Textcode -->
                <div class="row mb-3 mt-2">
                    <?= view('/components/input_barcode', ['name'=> 'barcode']) ?>
                </div>

                <!-- Supplier & brand select -->
                <div class="row g-3 mb-3 ">

                    <?php if ( $suppliers ) : ?>
                    
                        <div class="col-4 form-floating">
                            <select class="form-select" id="supplierSelect" name="supplier" aria-label="Floating label select example">
                                <option selected>Open this select menu</option>
                                <?php foreach ( $suppliers as $supplier ) : ?>
                                    <option value="<?= $supplier['id'] ?>"><?= $supplier['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>
                    
                    <?php else : ?>


                        <div class="col-4 form-floating">
                            <input type="input" class="form-control" id="supplierInput" name="supplier" placeholder="Προμηθευτής" readonly>
                            <label for="supplier">Προμηθευτής</label>
                        </div>
                    <?php endif; ?>

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
<?php @include('Modals/supplierModal'); ?>

<!-- Βrand select -->
<?php @include( 'Modals/brandModal.php' ); ?>

<!-- Category modal -->
<?php @include( 'Modals/categoryModal.php' ); ?>

<!-- Barcode modal -->
<?php @include( 'Modals/barcodeModal.php' ); ?>

<!-- Invoice selection modal -->
<?php @include( 'Modals/supplyTypeModal.php' ); ?>

<!-- Add scanner script -->
<script type="module">
    import { initBarcodeScanner } from '/js/modules/barcodeScanner.js';
    $(function () { initBarcodeScanner('#barcode'); });
</script>



<?=$this->endSection()?>


