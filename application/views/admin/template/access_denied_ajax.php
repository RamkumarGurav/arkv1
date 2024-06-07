<style>
.cartfl_list {
background: #fff;
font-family: arial!important;
padding: 20px;
float: left;
width: 100%;
border: 1px solid #ebebeb;
}
.cartfl_list center i {    font-size: 60px;
color: #f00;}
.cartfl_list h1 {position:relative;padding-bottom:10px;}
.cartfl_list h1:after 	{content:"";    content: "";
position: absolute;
left: 50%;
width: 80px;
height: 2px;
background: #f00;
margin-left: -40px;
bottom: 0;}
.cartfl_list .cart-indi p {
text-align: center;
font-size: 18px;
margin-top: 10px;
display: block;
text-transform: uppercase;
}
img {
vertical-align: middle;
}
</style> 

<div class="modal-content">
<div class="modal-header"><h4 class="modal-title">ACCESS DENIED!!!</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
<div class="modal-body" id="'+modal_id+'-body-templete">



 <div class="cartfl_list">

<article class="clearfix col-lg-12 cart-indi">

<center><i class="fa fa-ban"></i><h1>ACCESS <span style="color:#FF0000">DENIED!!!</span></h1></center>

<p>You Are Not Authorized To Access This Module</p>
<?
$no_access_flash_message = $this->session->flashdata('no_access_flash_message');
?>
<p><center><?=$no_access_flash_message?></center></p>
<?
if(!empty($no_access_message)){
?>
<p><center><div class="alert alert-info"><strong><?=$no_access_message?></strong></div></center></p>
<? } ?>
</article>

</div>


<div class="modal-footer justify-content-between"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>