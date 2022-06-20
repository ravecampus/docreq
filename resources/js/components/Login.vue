<template>
     <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-md-offset-4 mt-4">
                    <h6>Login</h6>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" v-model="post.email" class="form-control">
                        <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" v-model="post.password" class="form-control">
                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                    </div>
                    <div class="btn-group">
                        <button type="button" @click="login" :disabled="btndis" class="btn btn-primary" >{{btn}}</button>
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
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                console.log(response)
                this.btndis = true
                this.btn = "Logging..."
                this.$axios.post('api/login', this.post).then(res=>{
                    this.btndis = false
                    this.btn = "Login"
                    window.location.href = "/"
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
