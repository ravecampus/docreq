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
                            
                            <div class="alert alert-success p-0" v-if="errors.main">
                                <div class="alert m-0">
                                    <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" @keyup.enter="resetPassword" v-model="post.password" class="form-control">
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                              <div class="form-group">
                                <label>Confirmed Password</label>
                                <input type="password" @keyup.enter="resetPassword" v-model="post.password_confirmation" class="form-control">
                                <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                            </div>
                           
                            <button type="button" @click="resetPassword" :disabled="btndis" class="btn btn-success btn-block mt-4" >{{btn}}</button>
                            
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
            btn:'Reset Password',
            btndis:false
        }
    },
    methods:{
        resetPassword(){
            let id = this.$route.params.id;
            let code = this.$route.params.token;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true
                this.btn = "Resetting..."
                this.post.id = id;
                this.post.code = code;
                this.$axios.post('api/new-password',this.post).then(res=>{
                    this.btndis = false
                    this.btn = "Reset Password"
                    this.$emit('show',{'message':'Please check your Email!', 'status':6});
                    this.errors = res.data.errors;
                    this.post = {};
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Reset Password'
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
