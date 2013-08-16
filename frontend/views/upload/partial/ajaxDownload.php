<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="row-fluid template-download">
        <div class="span12">
            <div id="download-image-container">
                {% if (file.error) { %}
                    <div class="download-image-error">
                        <span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}
                    </div>
                {% } else { %}
                <img src="{%=file.thumbnail_url%}" width="200">           
                <span class='delete'>
                     <button class='' data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                        <i class="icon-trash"></i>                        
                    </button>
                    <input type="hidden" name="delete" value="1"> 
                </span>
                {% } %} 
            </div>
        </div>
    </div>
{% } %}  
</script>  