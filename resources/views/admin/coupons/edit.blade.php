<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{___('Edit Coupon')}}</h2>
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
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
            @csrf
            @method('PUT')
            @if ($coupon->isExpiry())
                <div class="alert alert-danger">
                    {{ ___('This coupon has been expired') }}
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label" for="code">{{ ___('Coupon code') }} *</label>
                <div class="input-group mb-2">
                    <input id="couponCodeInput" type="text" name="coupon_code" class="form-control"
                           placeholder="{{ ___('Coupon code') }}" value="{{ $coupon->code }}" maxlength="20" required disabled>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="code">{{ ___('Discount') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="number" name="percentage" class="form-control" min="1"
                           max="100" value="{{ $coupon->percentage }}" placeholder="0" required disabled>
                    <span class="input-group-text"><i class="icon-feather-percent"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="uses_limit">{{ ___("Uses Limit") }} *</label>
                <input type="number" name="uses_limit" class="form-control" min="1"
                       placeholder="0" value="{{ $coupon->limit }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="expiry_at">{{ ___('Expiry at') }} *</label>
                <input type="datetime-local" name="expiry_at" id="expiry_at" class="form-control"
                       value="{{ \Carbon\Carbon::parse($coupon->expiry_at)->format('Y-m-d\TH:i') }}" required>
            </div>
        </form>
    </div>
</div>

