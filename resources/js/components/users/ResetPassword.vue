<template>
     <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-md-offset-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <div  class="col-md-12 text-center mb-5">
                            <h2>{{ title }}</h2>
                            <h6>Forgot your password?</h6>
                            <p>Enter your email address and we will send you instructions on how to reset your password.</p>
                        </div>
                        <!-- <div class=""> -->
                            
                            <div class="alert alert-success p-0" v-if="errors.main">
                                <div class="alert m-0">
                                    <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" @keyup.enter="requestPassword" v-model="post.email" class="form-control">
                                <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                            </div>
                           
                            <button type="button" @click="requestPassword" :disabled="btndis" class="btn btn-success btn-block mt-4" >{{btn}}</button>
                            
                            <div class="mt-4 justify-content-center">
                                <router-link :to="{name:'signup'}" >Not yet register?</router-link>
                                <div class="mt-1">
                                    <router-link :to="{name:'login'}">Log in</router-link>
                                </div>
                            </div>
                        
                        <!-- </div> -->
                    </div>
                </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data(){
        return{
            title:{},
            post:{},
            errors:[],
            btn:'Request Password',
            btndis:false
        }
    },
    methods:{
        requestPassword(){
            let route = this.$route.query;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true
                this.btn = "Requesting..."
                this.$axios.post('api/reset-password', this.post).then(res=>{
                    this.btndis = false
                    this.btn = "Request Password"
                    this.$emit('show',{'message':'Please check your Email!', 'status':6});
                    this.errors = res.data.errors;
                    // console.log(res.data.errors)
                    this.post = {};
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Request Password'
                    this.errors = err.response.data.errors
                });
            });
        }
    },
    mounted(){
         this.title = window.Title.app_name;
    }
}
</script>

<style>

</style>
