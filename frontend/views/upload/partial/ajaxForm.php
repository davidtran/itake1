<!-- The file upload form used as target for the file upload widget -->
<?php
if ($this->showForm)
{
    echo CHtml::beginForm($this->url, 'post', $this->htmlOptions);
}
?>

<div class="row-fluid fileupload-buttonbar">
    <div class="span12">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="fileinput-button">

            <div class="fileupload fileupload-new" style="text-align: center;" data-provides="fileupload">

                <?php echo CHtml::link('<i class="icon-cloud-upload"></i>  '.LanguageUtil::t('Upload images'),'#',array(
                        'class'=>'btn btn-success btn-large',
                        'style'=>'width:200px;'
                    ));?>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 200px; line-height: 20px;"></div>        
            </div>
            <?php
            if ($this->hasModel()) :
                echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
            endif;
            ?>
        </span>  

    </div>
    <div class="span12" style="text-align: center;">
        <!-- The global progress bar -->
        <div class="progress progress-success progress-striped active fade">
            <div class="bar" style="width:0%;"></div>
        </div>
    </div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
    <table class="table table-striped">
        <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
    </table>

<?php if ($this->showForm) echo CHtml::endForm(); ?>
