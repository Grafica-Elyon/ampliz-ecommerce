<?php
use MisterPrint\Support\View;
$data = $this->data['all'];
$grupos = $this->data['grupos'];
?>
	<div class="nav-column menu">
		<div class="nav-groups_wrapper">
			<?php foreach($grupos as $grupo){ ?>
			<div class="group_tab" group="<?= $grupo['id'] ?>">
				<span><?= $grupo['nome'] ?>
				<?php if($grupo['badge'] != ""){
					echo "<sup class=\"badge\" style=\"background:{$grupo['badge_color']}\">{$grupo['badge']}</sup>";
				} ?>
				</span>
			</div>
			<?php } ?>
		</div>			
		<div class="nav-products_wrapper">
		<?php foreach($grupos as $grupo){ ?>
		<div class="nav-product_wrapper" group="<?= $grupo['id'] ?>">
			<?php $produtos = $data ?>
			<?php  foreach($produtos as $produto){
				$lista_grupos = explode(",", str_replace(" ","",$produto['grupo']));
				if(in_array($grupo['id'], $lista_grupos)){
					if (isset($produto['special_product']) && $produto['special_product']) {
						$url = '/produto-fechado/'.sanitize_title($produto['name']).'/'.$produto['id'];
						$urlConfiguration = $url;
					} else {
						$url = get_category_url($produto['id'],$produto['slug']);
						//home_url("/product/{}");
					}
					if($produto['label'] != null){?>
					<div group="<?= $grupo['id'] ?>" class="product-tab 
						<?php echo $produto['gray_scale']?'is_grey':'' ?>
						<?php echo $produto['is_master'] == 1 ?'master':'' ?> 
						<?php echo $produto['master_id'] > 0 ?'slave':'' ?> 
						 has_label" label="<?php echo $produto['label'];?>"> 
						<a href="<?php echo $url ?>" >
							<?php echo str_replace("*","",$produto['name']); ?>
							<span class="badge" style="background:<?php echo $produto['label_colors'];?>;"><?php echo $produto['label'];?></span>
						</a>
					<?php }else{ ?>
					<div class="product-tab
					<?php echo $produto['is_master'] == 1 ?'master':'' ?> 
					<?php echo $produto['master_id'] > 0 ?'slave':'' ?> 
					">
						<a href="<?php echo $url ?>" ><?php echo str_replace("*","",$produto['name']); ?></a>
					<?php } ?>
						<div class="product-img">
							<?php if(!empty($produto['image'])) { ?>
								<div
									<?php echo $produto['label'] == null ?:'label="'.$produto['label'].'"'; ?>
									class="product-img-wrapper
									<?php echo $produto['label'] == null ?:'has_img_label'; ?>"
									<?php echo $produto['label'] == null ?:'style="background:'.$produto['label_colors'].';"'; ?>
									>
									<img src="<?php echo $produto['image']; ?>" class="img-fluid"  />
								</div>
								<div>
									<h3 class="mp-card-title"><?php echo $produto['name'] ?></h3>
									<p class="mp-card-description" ><i><?php echo $produto['description'] ?></i></p>
								</div>
							<?php } else { ?>
								<div <?php echo $produto['label'] == null ?:'label="'.$produto['label'].'"'; ?> class="product-img-wrapper <?php echo $produto['label'] == null ?:'has_img_label'; ?>" <?php echo $produto['label'] == null ?:'style="background:'.$produto['label_colors'].';"'; ?>>
									<img src="<?php echo config('plugin', 'url') ?>front/assets/imgs/logo.png" class="img-fluid" />
								</div>
								<div>
									<h3 class="mp-card-title"><?php echo $produto['name'] ?></h3>
									<p class="mp-card-description" ><i><?php echo $produto['description'] ?></i></p>
								</div>
								
							<?php } ?>
						</div> 
					</div>
				<?php } ?>
			<?php } ?>
			<div class="product-tab-default">
				<div class="product-img product-default-img">
					<div class="product-img-wrapper ">
						<img src="<?php echo config('plugin', 'url') ?>front/assets/imgs/logo.png" class="img-fluid" />
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		</div>
	</div>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous">

<style type="text/css">
	:root{
		--cores:#afafaf;
	}
	#products a{
		color: #777;
	}
	.badge{
	    color: #fff;
	    padding: 3px 10px;
	    border-radius: 10px;
	    margin: 8px 0px 0px 10px;
	    line-height: 8px;
	    font-weight: bold;
	}
	#products:hover{
		box-shadow: inset 0px -2px 0px var(--primary-color);
	}
	#products:hover > .nav-column,.nav-column:hover{
		display: flex;
		background: #fff;
	}

	.product-tab:hover > a{
		color: var(--primary-color) !important;
	}
	.product-tab:hover > .product-img{
		display: flex;
		background: none;
	}
	.product-tab:hover~.product-tab-default{
		display: none;
	}
	.nav-column{
		position: absolute;
		z-index: 9999;
		background: #fff;
		width:100%;
		min-width:95vw;
		height: max-content;
		left:50%;
		transform: translateX(-50%);
		display: none;
		flex-flow: row wrap;
		-ms-overflow-style: none;
		box-shadow: 0px 14px 15px #5553;
		border-radius: 0px 0px 10px 10px;
		border-top: 1px solid #5553;
		font-size: 1.2rem;
	}
	.nav-column::-webkit-scrollbar{
		display: none;
	}
	.nav-groups_wrapper {
    	width: 12%;
    	position: relative;
    	height: min-content;
    	min-height: 600px;
    	float: left;
    	padding: 15px 0px;
	}
	.group_tab {
	    width: 100%;
	}
	.group_tab span {
	    display: flex;
	    flex-flow: row nowrap;
	    justify-content: flex-start;
	    align-items: center;
	    align-content: center;
	    padding: 10px 25px;
	    width: 100%;
	    text-align: center;
	    position: relative;
	}
	.group_tab span:after {
	    content: "❭";
	    position: absolute;
	    right: 15px;
	}
	.nav-product_wrapper:last-child{
		display: block;
	}
	.nav-product_wrapper:hover {
		display: block !important;
		pointer-events: all;
	}

	.group_tab span:hover {
	    color: var(--primary-color);
	    cursor: pointer;
	}
	.nav-products_wrapper{
		width: 88%;
	}
	/*.nav-product_wrapper:before {
	    content: "";
		border-left: 2px solid #eee;
	    position: absolute;
	    left: 0;
	    top: 50%;
	    height: 80%;
	    transform: translate3d(-50%, -50%, 0px);
	    display: block;
	}*/
	/*.nav-product_wrapper:after {
	    content: "❭";
	    position: absolute;
	    left: 0;
	    top: 50%;
	    transform: translate3d(-50%, -50%, 0px);
	    line-height:30px;
	    background:#fff;
	}*/
	.nav-product_wrapper {
		padding: 18px 2%;
		display: none;
		background: #fff;
		columns: 6;
		column-gap: 0px;
		column-fill: auto;
		width: 100%;
		position: relative;
		height: 100%;
		max-height: 600px;
		overflow-x: auto;
	}
	.product-tab {
		position: static;
		padding: 5px 0px 0px 0px;
		text-align: left;
	}
	.product-tab.master {
		font-family: "Arial";
		font-weight: bolder;
		margin-top: 10px;
	}
	.product-tab.slave {
		padding: 5px 0px 0px 12px;
	}
	.product-tab-default{
		position: static;
		padding: 0px;
		text-align: left;
		height: 0;
		width: 100%;
	}
	.product-tab a{
		width: 100%;
		text-align: left !important;
		word-wrap: break-word;
	}
	.product-img {
		position: absolute;
		right: -20%;
		top: 0px;
		height: 100%;
		min-height: 400px;
		width: 25%;
		display: none !important;
		background: #fff;
		flex-flow: row wrap;
		align-content: space-between;
		justify-content: center;
		text-align: center;
		font-weight: bold;
		padding: 5% 0px 5% 0px;
	}
	.product-default-img{
		display: flex;
	}
	.product-img-wrapper {
		width: auto;
		height: auto;
		max-height: calc(100% - 40px);
		max-width: 100%;
		display: flex;
		margin: auto;
		box-shadow: 0px 5px 10px -5px #3337;
		overflow:hidden;
		position:relative;
	}
	.product-img-wrapper img {
	    width: 100%;
	}

	.has_label .badge {
		color: #fff;
		font-size: 0.8em;
		padding: 2px 10px;
		border-radius: 10px;
		margin-left: 5px;
		text-shadow: 0px 0px 2px #333;
	}
	.has_img_label{
		border:none !important;
	}
	.has_img_label:before {
	    content: attr(label);
	    position: absolute;
	    background:inherit;
	    top: 0;
	    width: 100%;
	    height: 10%;
	    left: 0;
	    color: #fff;
	    text-shadow: 0px 0px 2px #333;
	    text-align: center;
	    transform: rotate(-45deg) translate3d(-30%,-100%,0);
	    box-shadow: 0px 3px 7px #3337;
	    display: flex;
	    flex-flow: row wrap;
	    justify-content: center;
	    align-items: center;
	    z-index: 999;
	}
	.has_img_label:after {
	    content: "";
	    position: absolute;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background: #fff;
	    z-index: 0;
	}
	.has_img_label>img{
		position: relative;
		z-index: 1;
	}
	.has_img_label .mp-card-overlay{
		z-index:2;
	}
	@media (max-width:1280px){
		.nav-product_wrapper{
			columns: 3;
			column-gap: 0px;
			column-fill: auto;
			width: 100%;
			padding: 10px 0px 10px 0px;
		}
		.product-tab{
			font-size: 1.2rem;
			padding: 5px;
		}
		.product-tab:hover > .product-img{
			display: none;
		}
		.product-img {
			display: none;
		}
		.has_label .badge {
			color: #fff;
			font-size: 0.5em;
			padding: 2px 10px;
			border-radius: 10px;
			margin-left: 5px;
			text-shadow: 0px 0px 2px #333;
		}
		.has_img_label:before {
			font-size: 1.2rem;
		}

	}@media (max-width:700px){
		.product-tab{
			font-size: 1.9vw;
		}
		.has_label .badge {
		    color: #fff0;
		    font-size: 1px;
		    padding: 2px;
		    border-radius: 10px;
		    margin-left: 5px;
		    text-shadow: 0 0 2px #333;
		    display: inline-flex;
		    position: absolute;
		    transform: translateY(50%);
		    height: 11px;
		}
		.has_img_label:before {
			font-size: 1.4rem;
		}
		.group_tab span {
			padding: 10px 12px;
			text-align: left;
		}
	}
</style>
<script type="text/javascript">
	$ = jQuery;
	$('.group_tab').on("mouseover",function(){
		var id = $(this).attr('group');
		$('.nav-product_wrapper').css('display', 'none');
		$('.nav-product_wrapper[group="'+id+'"]').css('display', 'block');
	});

	$('.nav-product_wrapper').on("mouseover",function(){
		$('.nav-product_wrapper').css('display', 'none');
		$(this).css('display', 'block');
	});
	$('.nav-product_wrapper').on("mouseout",function(){
		$(this).css('display', 'none');
		$('.nav-product_wrapper:last-child').css('display', 'block');
	});
</script>