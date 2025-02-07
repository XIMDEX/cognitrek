<script src="{{url('lib/tinymce')}}/tinymce.min.js"></script>

<textarea name="editor1" class="" style="padding: 200px;">
    {!! $content !!}
</textarea>

@include('visor::js.editorJS')
