<div class="modal hide fade" id='addAddressDialog'>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Them dia chi</h3>
    </div>
    <div class="modal-body">
        <p>Dia chi ban hang cua ban</p>
        <?php 
        $address  = new Address(); 
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'enableClientValidation'=>true,
            'htmlOptions'=>array(
                'id'=>'addressForm'
            )
        ));
        ?>
        <div class="row-fluid">
            <div class='span12'>                
               
                    <?php echo $form->dropDownListRow($address, 'city', CityUtil::getCityListData(true), array('style' => 'min-width:300px;')); ?>

                    <div id="advanceFeature">                    
                        <?php echo $form->textFieldRow($address,'phone',array(
                            'placeholder'=>'Điện thoại liên hệ',
                            'style' => 'min-width:260px;'
                        )); ?>
                        
                        <?php
                        echo $form->textFieldRow($address, 'address', array(
                            'placeholder' => 'Nhập vào địa chỉ và bấm enter',
                            'style' => 'min-width:260px;'
                        ));
                        ?>                               
                        <?php
                        echo CHtml::link('<i class="icon-map-marker"></i>', '#', array(
                            'class' => 'btn btn-success',
                            'id' => 'btnSearchLocation'
                        ));
                        ?>
                    </div>
                    <?php echo $form->hiddenField($address,'lat'); ?>
                    <?php echo $form->hiddenField($address,'lon'); ?>

                    <label><span  class="label label-info"><i class="icon-info"></i></span>  Bạn có thể nhập vào địa chỉ và bấm Enter hoặc chọn trực tiếp trên bản đồ bằng cách nhấp chuột lên địa điểm trên bản đồ</label>
                </div>
                <div id='mapContainer'>
                    <div id="map"></div>
                </div>
        
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="#" class="btn btn-primary" id="btnSaveAddress">Save changes</a>
    </div>
</div>