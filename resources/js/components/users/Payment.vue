<template>
    <div class="container-fluid" id="main-page">
         
            <div class="fixed-top header-nav" >
                <nav class="navbar navbar-expand-md navbar-light navbar-main sm-navigation">

                    <div class="container">
                        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a class="btn btn-default btn-brand-name"  @click="arrowBtn()" v-if="nav"> 
                            <i class="fa fa-arrow-left"></i>
                        </a>

                        <div class="navbar-nav m-auto" v-show="!nav">
                            <div class="nav-item">
                                <a class="nav-link "><strong></strong></a>
                            </div>
                        </div> -->

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                             <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                   <a href="#" class="nav-link">&nbsp; </a>
                                </li>
                               
                            </ul>
                        </div>
                    </div>
                </nav>

               
            </div>
           
            <main class="mt-5">
                <div class="container">
                    <div class="row">
                        <h4 class="col-md-12 mt-5 border-bottom text-center">Paypal Payment</h4>
                        <div class="col-md-12"></div>
                        <div class="col-md-12 row border-bottom">
                            <div class="col-md-4 offset-md-4">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">TOTAL : <strong>100</strong> </li>
                                    <li class="list-group-item">DELIVERY FEE : <strong>111</strong></li>
                                    <li class="list-group-item">GRAND TOTAL : <strong>11111</strong></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success">Pay</button>
                        </div>

                    </div>
                </div>
            </main>
            
           

        </div>
</template>

<script>
export default {
    

    
}
</script>

<style>

</style>
