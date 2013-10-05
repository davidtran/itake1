<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="row-fluid template-download ">
        <div class="span12 center margin-top-10">
                {% if (file.error) { %}
                    <div class="download-image-error">
                        <span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}
                    </div>
                {% } else { %}
                <div class="row-fluid" >
                    <img  class="img-polaroid" src="{%=file.thumbnail_url%}" width="200">
                </div>
                <div class="row-fluid" style="height:1px;">
                    <span class='delete' style="position: relative;top: -60px;">
                         <button class='' data-toggle="tooltip" title="Click vào để xóa hình này" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" style="background:transparent;border:none;">
                            <span class="icon-stack icon-2x" style="color:rgba(0,0,0,.4)">
                              <i class="icon-circle icon-stack-base"></i>
                              <i class="icon-remove icon-light"></i>
                            </span>
                        </button>
                        <input type="hidden" name="delete" value="1">
                    </span>
                </div>
                {% } %}
        </div>
    </div>
{% } %}  
</script>  