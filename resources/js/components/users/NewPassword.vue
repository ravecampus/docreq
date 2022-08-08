<template>
     <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-md-offset-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <div  class="col-md-12 text-center mb-5">
                            <h2>{{ title }}</h2>
                            <h6>Reset your password</h6>
                            
                        </div>
                        <!-- <div class=""> -->
                            
                            <div class="alert alert-danger p-0" v-if="errors.main">
                                <div class="alert errors-material m-0">
                                    <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" @keyup.enter="login" v-model="post.password" class="form-control">
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                              <div class="form-group">
                                <label>Confirmed Password</label>
                                <input type="password" @keyup.enter="login" v-model="post.password_confirmation" class="form-control">
                                <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                            </div>
                           
                            <button type="button" @click="requestPassword" :disabled="btndis" class="btn btn-success btn-block mt-4" >{{btn}}</button>
                            
                            <div class="mt-4 justify-content-center">
                                <router-link :to="{name:'signup'}" >Not yet register?</router-link>
                                <!-- <div class="mt-1">
                                    <a href="#">Forgot Password?</a>
                                </div> -->
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
            btn:'Reset Password',
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
