<template>
    <div class="mt-5 container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4  class="text-center d-print-none">{{ message }}</h4>
                <router-link  class="d-print-none" :to="{name:'toship'}" >Check your request status</router-link>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 col-md-offset-4 card card-body">
                <h4 class="mb-4 text-center">{{ title }}</h4>
                <h6>RECEIPT</h6>
                <p class="small">ID: {{data.payment == null ? "" : data.payment.payment_id }}</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item small">TOTAL : 
                        <strong>
                            {{ data.order == null ? 0 : formatAmount(data.order.total) }}
                        </strong> 
                    </li>
                    <li class="list-group-item small">DELIVERY FEE : 
                        <strong>
                            {{  data.order == null ? 0 : formatAmount(data.order.delivery_fee) }}
                        </strong>
                    </li>
                    <li class="list-group-item">GRAND TOTAL : 
                        <strong>
                            {{  data.order == null ? 0 : formatAmount(data.order.grand_total) }}
                        </strong>
                    </li>
                </ul>
                <div class="card-footer border-top">
                    <strong>TOTAL PAID :  {{  data.order == null ? 0 : formatAmount(data.order.grand_total) }}</strong>
                </div>
                <div class="small mt-1">
                    Email : {{ data.payment == null ? "" : data.payment.payer_email }}
                </div>
                <button type="button" @click="printReceipt" class="btn btn-success btn-sm mt-4 d-print-none"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
        
    </div>
   
</template>

<script>
export default {
    data(){
        return{
            post:{},
            message:"",
            data:" ",
            title:  ""

        }
    },
    methods:{
        setPaymentSuccess(query, id){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.message = "Processing ...";
                this.$axios.get('api/paypal/success/'+id, {params:query}).then(res=>{
                //    this.$router.push({name:'toship'});
                    console.log(res)
                    this.message = " ";
                    this.data = res.data;
                });
            });
        },
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            // return Number(num).toLocaleString(undefined, {maximumFractionDigits:2});
        },
        printReceipt(){
            window.print();
        }
    },
    mounted(){
        
        let query = this.$route.query;
        let id = this.$route.params.order_id;
        this.setPaymentSuccess(query, id)
        this.title = window.Title.app_name;
    }
}
</script>

<style>

</style>
