<div class="row-fluid">    
    <div class="modal hide fade" id='addAddressDialog' style="top:50%;">        
        <div class="modal-body" >           
            <?php 
            $address  = new Address(); 
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'enableClientValidation'=>true,
                'type'=>'horizontal',
                'htmlOptions'=>array(
                    'id'=>'addressForm'
                    )
                ));
                ?>
                <div class="row-fluid">
                    <div class="span12">       
                     <h3>NHẬP THÔNG TIN LIÊN HỆ</h3>
                     <?php echo $form->dropDownListRow($address, 'city', CityUtil::getCityListData(true), array('style' => 'min-width:274px;')); ?>

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
                    </div>
                    <div class='row-fluid'>
                        <div id='mapContainer'>
                            <div id="map" style="max-height:200px;"></div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn flat" data-dismiss="modal">Đóng</a>
                    <a href="#" class="btn flat btn-primary" id="btnSaveAddress">Lưu lại</a>
                </div>
            </div>
        </div>