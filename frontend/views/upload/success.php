<div class="row-fluid upload">
    <div class="span12" style="margin-left: 40%;overflow: hidden;">        
        <h1 style="text-align: left;">Đăng tin thành công</h1>
          <?php echo $product->renderHtml('home-'); ?>
        <p>
        Chia sẻ tin đăng của bạn qua Facebook
        </p>        
        <p>
        Xem chi tiết tin đăng của bạn tại đây
        <?php echo CHtml::link($product->title,$product->getDetailUrl()); ?>
        </p>        
    </div>
</div>