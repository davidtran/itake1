<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row-fluid">
    <div class="span12">
        <i class="icon-plus icon-white"></i>
        <span>Thêm ảnh</span>
        <?php echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions); ?>
        <div class="fileupload-loading"></div>
        <br>
        <table class="table table-striped">
            <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
        </table>    
    </div>
</div>
<?php if ($this->showForm) echo CHtml::endForm();?>