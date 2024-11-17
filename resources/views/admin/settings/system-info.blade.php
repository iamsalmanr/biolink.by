<div class="tab-pane" id="quick_system_info">
    <form class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" method="POST">
        <div class="card">
            <div class="card-header">
                <h5>{{ ___('System Info') }}</h5>
            </div>
            <div class="card-body">
                <h5 class="fw-bold">{{ ___('App Details') }}</h5>
                <table class="table table-sm table-borderless text-nowrap mb-5">
                    <tr>
                        <td class="w-50">{{ ___('Name') }}</td>
                        <td class="fw-medium text-heading text-end">{{ config('appinfo.name') }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Version') }}</td>
                        <td class="fw-medium text-heading text-end">{{ config('appinfo.version') }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Laravel Version') }}</td>
                        <td class="fw-medium text-heading text-end">{{ app()->version() }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Default Language') }}</td>
                        <td class="fw-medium text-heading text-end text-uppercase">{{ config('app.locale') }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Timezone') }}</td>
                        <td class="fw-medium text-heading text-end">{{ config('app.timezone') }}</td>
                    </tr>
                </table>

                <h5 class="fw-bold">{{ ___('Server Details') }}</h5>
                <table class="table table-sm table-borderless text-nowrap mb-5">
                    <tr>
                        <td class="w-50">{{ ___('PHP Version') }}</td>
                        <td class="fw-medium text-heading text-end">{{ phpversion() }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Software') }}</td>
                        <td class="fw-medium text-heading text-end">{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Protocol') }}</td>
                        <td class="fw-medium text-heading text-end text-uppercase">{{ $_SERVER['SERVER_PROTOCOL'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('HTTP Host') }}</td>
                        <td class="fw-medium text-heading text-end">{{ $_SERVER['HTTP_HOST'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('Port') }}</td>
                        <td class="fw-medium text-heading text-end">{{ $_SERVER['SERVER_PORT']}}</td>
                    </tr>
                    <tr>
                        <td class="w-50">{{ ___('IP Address') }}</td>
                        <td class="fw-medium text-heading text-end">{{ $_SERVER['SERVER_ADDR'] }}</td>
                    </tr>
                </table>

                <h5 class="fw-bold">{{ ___('System Cache') }}</h5>
                <div class="alert bg-label-info mb-3" role="alert">
                    {{___("Clear all caches and error logs")}}
                </div>

                <input type="hidden" name="clear_cache" value="1">
                <button type="submit" class="btn btn-lg btn-label-danger w-100"><i
                        class="fas fa-broom me-2"></i> {{ ___('Clear Cache') }}</button>
            </div>
        </div>
    </form>
</div>
