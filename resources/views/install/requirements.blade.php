@extends('install.layout')
@section('content')
<div class="quick-card card">
    <div class="card-header">
        <h5 class="text-center">{{ ___('Requirements') }}</h5>
    </div>
    <div class="card-body">
        <div id="install" class="step" style="display: block;">
            <div class="subsection">
                <table>
                    <tbody>
                    @foreach($results['extensions'] as $type => $extension)
                        <tr>
                            <td><span class="fw-bold">{{ mb_strtoupper($type) }}</span>
                                @if($type == 'php')
                                    {{ config('install.php_version') }}+
                                @endif
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
                        @foreach($extension as $name => $enabled)
                            <tr>
                                <td><span>{{ $name }}</span></td>
                                <td class="status">
                                    @if($enabled)
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
                <a href="{{ route('install.permissions') }}" class="btn btn-primary">{{ ___('Next') }}</a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
