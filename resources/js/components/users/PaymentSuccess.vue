<template>
    <div class="mt-5 container text-center">
        <h4  class="text-center">{{ message }}</h4>
        <router-link :to="{name:'toship'}" >Check your request status</router-link>
    </div>
   
</template>

<script>
export default {
    data(){
        return{
            post:{},
            message:" "

        }
    },
    methods:{
        setPaymentSuccess(query, id){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.message = "Processing ...";
                this.$axios.get('api/paypal/success/'+id, {params:query}).then(res=>{
                //    this.$router.push({name:'toship'});
                    this.message = res.data;
                });
            });
        }
    },
    mounted(){
        
        let query = this.$route.query;
        let id = this.$route.params.order_id;
        this.setPaymentSuccess(query, id)
    }
}
</script>

<style>

</style>
