<div class="row-fluid">    
    <div class="modal hide fade" id='showbuyinginstruction' style="top:50%;">        
        <div class="modal-body" > 
            <div class="row-fluid">
                <h3 class="intro_font center">
                	<span class="icon-stack">
					  <i class="icon-circle icon-stack-base"></i>
					  <i class="icon-shopping-cart icon-light"></i>
					</span>   
					How to buy?
				</h3>
                <p>You could contact <?php echo $product->user->getUserProfileLink(); ?> via mobile phone number: <?php echo $product->phone ?></p>
                <br>
                <p class="alert-info">ITAKE is offering a payment and delivery feature in next version. Current version only support the phone number for call to buy method</p>
            </div>
        </div>
    </div>
</div>
