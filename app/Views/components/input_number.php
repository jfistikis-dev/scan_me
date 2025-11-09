<?php 
    $placeholder    = isset($placeholder) ? $placeholder : '';
    $name           = isset($name) ? esc($name) : 'number-input';
    
    $label          = isset($label) ? $label : '';
    $size           = isset($size) ? $size : 12;
    $class          = isset($class) ? $class : '';
    $disabled       = (isset($disabled) && $disabled) ? 'disabled' : '';
    $remember_me    = (isset($remember_me) && $remember_me);
    $add_delete_btn = (isset($add_delete_btn) && $add_delete_btn);
    $is_floating    = $label != '';
    
    $min   = isset($min) ? 'data-min="'.$min.'"' : '';
    $max   = isset($max) ? 'data-max="'.$max.'"' : '';
    
    if ( esc(session($name. '-remember-me')) != null ) {
        $value = esc(session($name. '-remember-me'));
    } else if ( isset($value) ) {
        $value   = esc( $value );
    } else {
        $value = '';
    }
    // Generate a unique identifier for this instance
    $uniqueId = $name . '_' . uniqid();
?>

<?php if ( $label != '' ): ?>
    <div class="input-group">
<?php endif; ?>

    <?php if ( $remember_me || $is_floating   ): ?>
        <div class="<?=  $is_floating  ? 'form-floating' : '' ?> position-relative">
    <?php endif; ?>

            <!-- Only active checkbox -->
            <?php if ($remember_me): ?>
                <div class="position-absolute top-0 start-0" style="z-index:100;margin-left:-5px;margin-top:-10px">
                    <input type="checkbox" class="form-check-input mt-n2" id="<?= $name ?>-remember-me-checkbox" name="<?= $name ?>-remember-me-checkbox"
                    <?php if (session()->get($name . '-remember-me')) echo 'checked'; ?> >
                </div>
            <?php endif; ?>

            <input type="text"
                id="<?= $uniqueId ?>"
                name="<?= $name ?>"
                value="<?= $value ?>"
                class="number-input <?= $class ?>" 
                autocomplete="off"
                placeholder="<?= $placeholder ?>"
                style="text-align: right;"
                size="<?= $size ?>" 
                <?= $min ?> 
                <?= $max ?>
                <?= $disabled ?>
                >
            <?php if ( $label != '' ): ?>
            <label for="<?= $uniqueId ?>"><?= $label ?></label>
            <?php endif; ?>
        
    <?php if ( $remember_me || $is_floating ): ?>
        </div>
    <?php endif; ?>
        
        <?php if ( $add_delete_btn ): ?>
            <!-- Delete text input button -->
            <button class="btn btn-outline-secondary btn-<?= $name ?>-delete" type="button" id="btn-<?= $name ?>-delete" type="button"><i class="bi bi-arrow-left"></i></button>
        <?php endif; ?>

<?php if ( $label != '' ): ?>
    </div>
<?php endif; ?>


<?php if ( $add_delete_btn ): ?>
    <script>
        $(function () {
            // Clear barcode button
            $('.btn-<?= $name ?>-delete').on('click', function() {
                $(this).parents('.input-group').find('input[type="text"]').val('') 
                $(this).removeClass('btn-danger').addClass('btn-outline-secondary');
            });

            //change color on button IF text input is empty
            $("input[name='<?= $name ?>']").on('input change', function() {
                var button = $(this).parents('.input-group').find('.btn-<?= $name ?>-delete');
                //console.log( button );
                if ($(this).val() == '') {
                    button.removeClass('btn-danger').addClass('btn-outline-secondary');
                } else {
                    button.removeClass('btn-outline-secondary').addClass('btn-danger');
                    $(this).removeClass('is-invalid');
                }
            });
            
        });
    </script>
<?php endif; ?>

<script>
    (function ($) {
        // ... your existing sanitizeAndFormat, parseToNumber, clampValue functions ...
        function sanitizeAndFormat(raw) {
            if (typeof raw !== 'string') raw = String(raw);
            raw = raw.replace(/[^0-9.,-]/g, '');

            
            // Αν ξεκινάει με κόμμα ή τελεία -> βάλε 0 μπροστά
            if (raw.startsWith(',') || raw.startsWith('.')) raw = '0' + raw;


            // Κράτα μόνο το πρώτο κόμμα
            const commaIndex = raw.indexOf(',');
            let intPart = '', decPart = '';

            if (commaIndex === -1) {
                intPart = raw;
            } else {
                intPart = raw.substring(0, commaIndex);
                decPart = raw.substring(commaIndex + 1).replace(/,/g, '');
            }

            intPart = intPart.replace(/\./g, '');
            intPart = intPart.replace(/^0+(?=\d)/, '');
            intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            if (decPart.length > 2) decPart = decPart.slice(0, 2);

            return commaIndex !== -1 ? intPart + ',' + decPart : intPart;
        }

        function parseToNumber(val) {
            if (!val) return null;
            return parseFloat(val.replace(/\./g, '').replace(',', '.'));
        }

        function clampValue($input) {
            const val = parseToNumber($input.val());
            const min = parseFloat($input.data('min'));
            const max = parseFloat($input.data('max'));

            if (isNaN(val)) return;

            let clamped = val;
            if (!isNaN(min) && val < min) clamped = min;
            if (!isNaN(max) && val > max) clamped = max;

            if (clamped !== val) {
                let formatted = clamped.toLocaleString('el-GR', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                });
                formatted = formatted.replace('.', ','); // fallback just in case
                $input.val(sanitizeAndFormat(formatted));
            }
        }

        $(document).on('input', "#<?= $uniqueId ?>", function ( event ) {
            const $el   = $(this);
            let val     = $el.val();
    
            if (val.endsWith('.')) { 
                val = val.slice(0, -1) + ","; 
                event.preventDefault();
                $el.val(val);
            }

            if (val === ',') val = '0,';
            const formatted = sanitizeAndFormat( val );

            if (formatted !== val) {
                $el.val(formatted);
                const endPos = formatted.length;
                this.setSelectionRange(endPos, endPos);
            }

            clampValue($el);
        });

        $(document).on('blur', "#<?= $uniqueId ?>", function () {
            const $el = $(this);
            const val = $el.val();
            if (val) $el.val(sanitizeAndFormat(val));
            clampValue($el);
        });

        $(document).on('paste', "#<?= $uniqueId ?>", function (e) {
            e.preventDefault();
            const text = (e.originalEvent || e).clipboardData.getData('text');
            const $el = $(this);
            $el.val(sanitizeAndFormat(text));
            clampValue($el);
        });

        $(document).on('focus click', "#<?= $uniqueId ?>", function() {
            const el = this;
            const len = el.value.length;

            // For input types that support cursor positioning
            if (typeof el.setSelectionRange === 'function') {
                setTimeout(() => el.setSelectionRange(len, len), 0);
            }
        });

        // Convert to dot-decimal format on submit
        $(document).on('submit', 'form', function () {
            
            let v = $("#<?= $uniqueId ?>").val();
            if (v) v = v.replace(/\./g, '').replace(',', '.');
            $("#<?= $uniqueId ?>").val(v);

        });

    })(jQuery);
</script>