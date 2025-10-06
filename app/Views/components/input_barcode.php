<!-- Barcode -->
<div class="col input-group <?= $name ?>-input-div">
    <button class="btn btn-secondary input-group-text fs-5" type="button" data-bs-toggle="modal" data-bs-target="#barcodeModal" ><i class="bi bi-upc-scan p-1"></i></button>
    <input type="input" class="form-control only-number" id="<?= $name ?>" name = "<?= $name ?>" placeholder="barcode" readonly>
    <button class="btn btn-outline-secondary btn-delete-barcode" type="button"><i class="bi bi-arrow-left"></i></button>
</div>


<!-- Generate button -->
<div class="col-3 pt-1">
    <button type="button" class="btn btn-secondary " id="btn-bardode">
        <i class="bi bi-upc-scan"></i> - Δημιουργία
    </button>
</div>

<script type="module">
    import { initBarcodeScanner } from '<?= base_url('/js/modules/barcodeScanner.js'); ?>';

    // initialize for your input 
    $(function () { initBarcodeScanner('#<?= $name ?>');  });
</script>

<script>
    $(function () {
        // Clear barcode button
        $('.<?= $name ?>-input-div .btn-delete-barcode').on('click', function() {
            $(this).siblings('input').val('');
        });
    });
</script>




