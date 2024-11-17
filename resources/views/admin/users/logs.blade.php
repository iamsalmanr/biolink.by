@extends('admin.layouts.main')
@section('title', request()->ip . ' '. ___('logs'))
@section('content')
        <div class="card">
            <div class="card-body">
                <div class="dataTables_wrapper">
                    <table id="ajax_datatable" class="table table-striped" data-jsonfile="{{ route('admin.users.logsbyip', $ip) }}">
                        <thead>
                        <tr>
                            <th>{{ ___('IP') }}</th>
                            <th class="no-sort">{{ ___('User') }}</th>
                            <th>{{ ___('Browser') }}</th>
                            <th>{{ ___('OS') }}</th>
                            <th>{{ ___('Location') }}</th>
                            <th>{{ ___('Timezone') }}</th>
                            <th>{{ ___('Latitude') }}</th>
                            <th>{{ ___('Longitude') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
