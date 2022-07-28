<template>
     <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-md-offset-4 mt-4">
                    <h4>Login</h4>
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
                    
                    <div class="mt-4">
                        <router-link :to="{name:'signup'}" >Not yet register?</router-link>
                    </div>
                    <div class="mt-1">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data(){
        return{
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
    }
}
</script>

<style>

</style>
