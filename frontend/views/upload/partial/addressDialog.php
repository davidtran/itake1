<div class="row-fluid">    
    <div class="modal hide fade" id='addAddressDialog' style="top:50%;">        
        <div class="modal-body" >           
            <?php             
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
                     <h3>Người mua sẽ liên hệ với bạn qua</h3>
                     <?php echo $form->dropDownListRow($address, 'city', CityUtil::getCityListData(true), array('style' => 'min-width:274px;')); ?>

                     <div id="advanceFeature">  
                         <div class="control-group success">
                             <label class="control-label" for="Address_address">Địa chỉ</label>
                             <div class="controls">
                                 <input placeholder="Nhập vào địa chỉ và nhấn tìm kiếm" style="min-width:260px;" name="Address[address]" id="Address_address" type="text" maxlength="200">
                                 <?php
                            echo CHtml::link('<i class="icon-map-marker"></i> Tìm vị trí', '#', array(
                                'class' => 'btn btn-success',
                                'id' => 'btnSearchLocation'
                                ));
                                ?>
                                 <span class="help-inline error" id="Address_address_em_" style="display: none;"></span>
                             </div>
                         </div>
                        <?php echo $form->textFieldRow($address,'phone',array(
                            'placeholder'=>'Điện thoại liên hệ',
                            'style' => 'min-width:260px;'
                            )); ?>
                            
                         
                        
                        
                            
                            
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