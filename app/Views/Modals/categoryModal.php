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
