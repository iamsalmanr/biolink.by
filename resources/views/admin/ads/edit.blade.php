<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ $advertisement->title }}</h2>
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
        <form action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
            @csrf
            @method('PUT')
            <div class="mb-3">
                {{quick_switch(___('Status'), 'status', $advertisement->status == '1')}}
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Code') }} *</label>
                <textarea id="jsContent" name="code" class="form-control" rows="10">{{ $advertisement->code }}</textarea>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    "use strict";
    var element = document.getElementById("jsContent");
    var editor = CodeMirror.fromTextArea(element, {
        lineNumbers: true,
        mode: "htmlmixed",
        theme: "monokai",
        keyMap: "sublime",
        autoCloseBrackets: true,
        matchBrackets: true,
        showCursorWhenSelecting: true,
    });
    editor.setSize(null, 400);
    editor.on('change', (editor) => {
        const text = editor.doc.getValue()
        $("#jsContent").val(text)
    });
</script>
