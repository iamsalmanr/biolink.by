@extends('admin.layouts.main')
@section('title', ___('Translate').' ' . $language->name)

@section('content')

    <div class="card">
        <form
            action="{{ route('admin.languages.translates.update', $language->id) }}" method="POST">
            @csrf
            <div class="card-header d-flex align-items-center justify-content-between position-sticky top-0">
                <h5>{{___('Translate').' ' . $language->name}}</h5>
                <div>
                    <button class="btn btn-primary ms-2">{{ ___('Save Changes') }}</button>
                </div>
            </div>
            <div class="card-body my-1">
                <table class="table">
                    <tr>
                        <th>{{ ___('Key') }}</th>
                        <th>{{ ___('Value') }}</th>
                    </tr>
                    @foreach ($translates as $file => $trans)
                        @foreach ($trans as $key1 => $value1)
                            @if (is_array($value1))
                                @foreach ($value1 as $key2 => $value2)
                                    @if (is_array($value2)) @continue @endif
                                    @if (empty($defaultLanguage[$file][$key1][$key2])) @continue @endif

                                    <tr>
                                        <td><textarea class="form-control bg-label-secondary"
                                                      readonly>{{ $defaultLanguage[$file][$key1][$key2] }}</textarea></td>
                                        <td><textarea name="translates[{{ $file }}][{{ $key1 }}][{{ $key2 }}]"
                                                      class="form-control"
                                                      placeholder="{{ $value2 }}">{{ $value2 }}</textarea></td>
                                    </tr>
                                @endforeach
                            @else
                                @if (empty($defaultLanguage[$file][$key1])) @continue @endif
                                <tr>
                                    <td><textarea class="form-control bg-label-secondary"
                                                  readonly>{{ $defaultLanguage[$file][$key1] }}</textarea></td>
                                    <td><textarea name="translates[{{ $file }}][{{ $key1 }}]" class="form-control"
                                                  placeholder="{{ $value1 }}">{{ $value1 }}</textarea></td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </table>
            </div>
        </form>
    </div>
    @push('scripts_at_top')
        <script>
            "use strict";
            var QuickMenu = {"page": "languages"};
        </script>
    @endpush
@endsection
