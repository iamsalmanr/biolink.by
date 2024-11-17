<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{___('Add Coupon')}}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{___('Save')}}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-icon btn-default slidePanel-close" title="{{___('Close')}}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.coupons.store') }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="code">{{ ___('Coupon code') }} *</label>
                <div class="input-group mb-2">
                    <input id="couponCodeInput" type="text" name="code" class="form-control"
                           placeholder="{{ ___('Coupon code') }}" maxlength="20" required>
                    <button id="generateCouponBtn" class="btn btn-primary" type="button"><i
                            class="fas fa-sync me-2"></i>{{ ___('Generate') }}</button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="code">{{ ___('Discount') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="number" name="discount_percentage" class="form-control" min="1"
                           max="100" placeholder="0" required>
                    <span class="input-group-text"><i class="icon-feather-percent"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="uses_limit">{{ ___("Uses Limit") }} *</label>
                <input type="number" name="uses_limit" class="form-control" min="1"
                       placeholder="0" value="1" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="expiry_at">{{ ___('Expiry at') }} *</label>
                <input type="datetime-local" name="expiry_at" id="expiry_at" class="form-control"
                       value="" required>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    "use strict";

    var couponCodeInput = $('#couponCodeInput'),
        generateCouponBtn = $('#generateCouponBtn');
    if (couponCodeInput.length) {
        couponCodeInput.val(generateCoupon(12));

        function generateCoupon(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }
        $(document).on("click", "#generateCouponBtn", function (e) {
            e.preventDefault();
            couponCodeInput.val(generateCoupon(12));
        });
    }
</script>
