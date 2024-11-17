@extends('install.layout')
@section('content')
    <div class="quick-card card">
        <div class="card-header">
            <h5 class="text-center">{{ ___('Permissions') }}</h5>
        </div>
        <div id="install" class="card-body">
            <div class="step" style="display: block;">
                <div class="subsection">
                    <table>
                        <tbody>
                        @foreach($results['permissions'] as $type => $files)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $type }}</span>
                                </td>
                                <td class="status">
                                    @if($type == 'php')
                                        @if(version_compare(PHP_VERSION, config('installer.php_version')) >= 0)
                                            <i class="far fa-check text-success"></i>
                                        @else
                                            <i class="far fa-close text-danger"></i>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @foreach($files as $file => $writable)
                                <tr>
                                    <td><span>{{ $file }}</span></td>
                                    <td class="status">
                                        @if($writable)
                                            <i class="far fa-check text-success"></i>
                                        @else
                                            <i class="far fa-close text-danger"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if(isset($results['errors']) == false)
                    <div class="text-center">
                        <a href="{{ route('install.database') }}" class="btn btn-primary">{{ ___('Next') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
