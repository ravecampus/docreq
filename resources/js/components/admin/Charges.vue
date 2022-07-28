<template>
     <div id="content" class="p-4 p-md-5 pt-5">
         <h4 class="mb-4">Charges</h4>
         <div class="row">
             <div class="col-md-12">
                 <div class="card mb-2">
                     <div class="card-body ">
                         <h5 class="text-muted">Delivery Charges</h5>
                         <div class="form-group">
                            <label>Title</label>
                            <input type="text" v-model="delivery.title" class="form-control">
                            <span class="errors-material" v-if="errors.title">{{errors.title[0]}}</span>
                         </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" v-model="delivery.amount" class="form-control">
                            <span class="errors-material" v-if="errors.amount">{{errors.amount[0]}}</span>
                         </div>
                         <!-- <div class="form-group">
                            <label>Percentage</label>
                            <input type="text" v-model="delivery.percentage" class="form-control">
                            <span class="errors-material" v-if="errors.amount">{{errors.amount[0]}}</span>
                         </div> -->
                         <button type="button" :disabled="btn_del" @click="saveDeliveryCharges()" class="btn btn-success btn-sm">{{ btn_delivery }}</button>
                     </div>
                 </div>
                 <div class="card">
                     <div class="card-body">
                         <h5 class="text-muted">Other Charges</h5>
                         
                         <div class="form-group">
                            <label>Title</label>
                            <input type="text" v-model="payment.title" class="form-control">
                            <span class="errors-material" v-if="errors1.title">{{errors1.title[0]}}</span>
                         </div>
                        <!-- <div class="form-group">
                            <label>Amount</label>
                            <input type="text" v-model="payment.amount" class="form-control">
                            <span class="errors-material" v-if="errors.amount">{{errors.amount[0]}}</span>
                         </div> -->
                         <div class="form-group">
                            <label>Percentage</label>
                            <input type="number" v-model="payment.percentage" class="form-control">
                            <span class="errors-material" v-if="errors1.percentage">{{errors1.percentage[0]}}</span>
                         </div>
                         <button type="button" :disabled="btn_pay" @click="savePaymentCharges()" class="btn btn-success btn-sm">{{ btn_payment }}</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
</template>

<script>
export default {
    data(){
        return {
            errors:[],
            btn_delivery:"Set up",
            btn_del: false,
            btn_payment:"Set up",
            btn_pay: false,
            errors1:[],
            delivery:{
                amount:0
            },
            payment:{
                percentage:0
            },
        }
    },
    methods:{
        saveDeliveryCharges(){
            this.delivery.id = 1;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_delivery = "Setting up..."
                this.btn_del = true;
                this.$axios.put('api/charges/delivery/'+this.delivery.id, this.delivery).then(res=>{
                    this.btn_delivery = "Set up";
                    this.btn_del = false;
                }).then(err=>{
                    this.btn_delivery = "Set up";
                    this.btn_del = false;
                    this.errors = err.response.data.errors
                });
            })
        },
        savePaymentCharges(){
            this.payment.id = 2;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_payment = "Setting up..."
                this.btn_pay = true;
                this.$axios.put('api/charges/payment/'+this.payment.id, this.payment).then(res=>{
                    this.btn_payment = "Set up"
                    this.btn_pay = false;
                }).catch(err=>{
                    this.btn_payment = "Set up"
                    this.btn_pay = false;
                    this.errors1 = err.response.data.errors;
                });
            });
        }, 
        getChargesDelivery(id = 1){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.delivery = res.data;
                });
            });
        },
        getChargesPayment(id = 2){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.payment = res.data;
                });
            });
        },
    },
    mounted() {
        this.getChargesDelivery();
        this.getChargesPayment();
    },
}
</script>

<style>

</style>
