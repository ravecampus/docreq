<template>
     <div class="container with-logo p-4">
            <div class="row justify-content-center">
                <div class="col-md-4 col-md-offset-4">
                <div class="card mt-5 bgo">
                    <div class="card-body">
                        <div  class="col-md-12 text-center mb-5">
                            <h2>{{ title }}</h2>
                        </div>
                        <!-- <div class=""> -->
                            
                            <div class="alert alert-danger p-0" v-if="errors.main">
                                <div class="alert errors-material m-0">
                                    <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" @keyup.enter="login" v-model="post.email" class="form-control">
                                <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" @keyup.enter="login" v-model="post.password" class="form-control">
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                            <button type="button" @click="login" :disabled="btndis" class="btn btn-success btn-block mt-4" >{{btn}}</button>
                            
                            <div class="mt-4 justify-content-center">
                                <router-link :to="{name:'signup'}" >Not yet register?</router-link>
                                <div class="mt-1">
                                    <router-link :to="{name:'resetpassword'}">Forgot Password?</router-link>
                                </div>
                                 <div class="mt-1">
                                   <router-link :to="{name:'items'}" >Back to home</router-link>
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
            btn:'Login',
            btndis:false
        }
    },
    methods:{
        login(){
            let route = this.$route.query;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                console.log(response)
                this.btndis = true
                this.btn = "Logging..."
                this.$axios.post('api/login', this.post).then(res=>{
                    this.btndis = false
                    this.btn = "Login"
                    // window.location.href = "/"
                    if(route.redir == undefined){
                        window.location.href = "/";
                    }else{
                        window.location.href = route.redir;
                    }
                    this.post = {};
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Login'
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
