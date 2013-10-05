<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="row-fluid template-upload">
        <div class="span12">
            <div id="upload-image-container center">
                {% if (file.error) { %}
                    <div class="upload-image-error">
                        <span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}
                    </div>
                {% } else { %}
                    <div class="row-fluild" style="float:none;text-align:center;">
                            <div class="progress progress-success progress-striped active" style="display:inline-block; text-align:center;">
                                <div class="bar" style="width:0%;text-align:center;"></div>
                            </div>
                    </div>
                {% } %}  
            </div>
        </div>
    </div>
{% } %}  
</script>  