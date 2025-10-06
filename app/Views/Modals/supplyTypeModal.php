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