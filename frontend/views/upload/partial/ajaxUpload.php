<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="row-fluid template-upload">
        <div class="span12">
            <div id="upload-image-container">
                {% if (file.error) { %}
                    <div class="upload-image-error">
                        <span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}
                    </div>
                {% } else { %}
                    <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
                {% } %}  
            </div>
        </div>
    </div>
{% } %}  
</script>  