<style>
.inner_banner{position: relative;}
.innerbanner_img img{width: 100%;}
.innr_bnrcap{
    position: absolute;
    left: 0;
    top:47%;
    width: 100%;
    /*height: 100%;*/
    text-align: center;
}

.iner_capbox img{display: inline-block}
.iner_capbox h1{font-size: 48px; color: #fff; margin-top: 16px;}

.inner_sec1{padding: 40px 0px 90px; position: relative;}
.innerpage_wrap{width: 825px; margin: 0 auto; max-width: 100%;}
.pera_main{
    display: inline-block;
    width: 46%;
    margin-right: 7%;
    vertical-align: top;
}
.pera_main:nth-child(2n){
    margin-right: 0px;
}
.pera_main p{
    font-size: 14px;
    color: #515151;
    line-height: 28px;
    letter-spacing: 0;
    margin-bottom: 25px;
    font-family: 'AvenirMedium';
    
}
.ourstory_pera p strong{color: #000;
                  text-align: center;}

.innercenter_head{text-align: center;}
.innercenter_head .head_title{
    display: inline-block;
    position: relative;
}

</style>




<!DOCTYPE html>
<html>
   
    <body>
        <!-- <div class="app-cross"> -->
        <div id="content">
       
        <!-- <header>
            <div id="logo">  <a href="" class="dark-logo"><img width="274" height="79" src="<?php echo base_url().  getConfig('site_logo'); ?>" class="img-responsive" alt="" /></a> </div>
        </header> -->
          

          <section class="inner_banner">
            <!--  <div class="innerbanner_img">
               <img src="<?php echo (isset($response->image)) ? base_url().'uploads/cms/'.$response->image : "";?>" class="img-responsive">
             </div> -->
             <div class="innr_bnrcap">
               <div class="container">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="iner_capbox">
                     
                      <h1>About Us</h1>
                    </div>
                  </div>
                </div>
              </div>
             </div>
     
   </section>



    <section class="inner_sec1 bg_sec1">
     <div class="container">
       <div class="row">
         <div class="col-sm-12">
           <div class="innerpage_wrap">
             <div class="innercenter_head">
              <div class="head_title">
                  <div class="text-center">
                   <img width="50px;"src="<?php echo base_url().  getConfig('site_logo'); ?>" class="img-responsive" alt="" />
                  </div>
                  <h1>OUR HISTORY</h1>
                  <!-- <span class="welcome">Welcome to Self Assessment</span> -->
              </div>
             </div>
             <div class="ourstory_pera">
               
                    <p><?php echo (isset($response->description)) ? ucfirst($response->description) : "";?></p>
               
             </div>
           </div>
           
         </div>
       </div>
     </div>
   </section>

 </div>


    </body>
</html>