<div class="tab-pane" id="quick_purchase_code">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Purchase Code') }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="quick_purchase_code">{{ ___('Purchase Code') }}</label>
                    <input id="quick_purchase_code" class="form-control" type="text" name="purchase_key">
                    <small class="form-text"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">{{ ___('Do not know your purchase code? Find here.') }}</a></small>
                </div>
                <div>
                    <label class="form-label" for="buyer_email">{{ ___('Buyer Email') }}</label>
                    <input id="buyer_email" class="form-control" type="text" name="buyer_email">
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="purchase_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
