<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
   <div class="productItemUpload isotope-item">
        <div class="row-fluid">
            <div class="product-detail">
                <div class="productImageLink">

                    <img class="productImage" src="{%=file.thumbnail_url%}" alt="Test SP">        

                </div>                

            </div>
            <div class="row-buttons" >        
                <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                    <i class="icon-trash icon-white"></i>
                    <span>{%=locale.fileupload.destroy%}</span>
                </button>               
            </div>
        </div>
    </div>
   
{% } %}
</script>

