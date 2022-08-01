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
                        <h4 class="col-md-12 mt-5 border-bottom text-center">Payment Request</h4>
                        <div class="col-md-12">Invoice</div>
                        <div class="col-md-12 row border-bottom">
                            <div class="col-md-4 offset-md-4">
                                
                                <p class="border-bottom">Order #: <strong>{{ orderpay.trucking_number}}</strong></p>
                                <p class="border-bottom">Name #: <strong>{{ user.first_name }} {{ user.middle_name }} {{ user.last_name }}</strong></p>
                                <p class="border-bottom">Address #: <strong>{{ orderpay.delivery_address }}</strong></p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">TOTAL : <strong>{{ formatAmount(orderpay.total) }}</strong> </li>
                                    <li class="list-group-item">DELIVERY FEE : <strong>{{ formatAmount(orderpay.delivery_fee) }}</strong></li>
                                    <li class="list-group-item">GRAND TOTAL : <strong>{{ formatAmount(orderpay.grand_total) }}</strong></li>
                                </ul>
                            </div>
                            <div class="col-md-4 offset-md-4 mb-2 p-4">
                                <button type="button" :disabled="btndis" @click="payByPaypal" class="btn btn-success"><span class="fa fa-paypal"></span> {{btn_cap}}</button>
                            </div>
                        </div>
                       

                    </div>
                </div>
            </main>
            
           

        </div>
</template>

<script>
export default {
    data(){
        return{
            post:{},
            btn_cap:'Pay with Paypal',
            btndis:false,
            orderpay:{},
            user:{}
        }
    }, 
    methods:{
        payByPaypal(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_cap = "Proccessing..."
                this.btndis = true;
                this.post = this.orderpay;
                this.$axios.post('api/paypal/charges', this.post).then(res=>{
                    this.btn_cap = "Pay by Paypal"
                    this.btndis = false;
                    window.location.href = res.data;
                });
            });
        },
        getPayOrder(id){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/order/pay/'+id).then(res=>{
                    console.log(res.data)
                    this.orderpay = res.data;
                });
            });
        },
        formatAmount(num){
            let num_ = new Number(num);
            return num_.toLocaleString(undefined, {maximumFractionDigits:2});
        },
    },
    mounted(){
        if(window.Laravel.isLoggedin){
            this.auth = true;
            this.user = window.Laravel.user;
        }
        let id = this.$route.params.order_id;
        this.getPayOrder(id);
    }
    
}
</script>

<style>

</style>
