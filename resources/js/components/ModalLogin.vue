<template>
     <div class="modal fade modal-login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h6>Login</h6>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" v-model="post.email" class="form-control" placeholder="Email">
                                <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" v-model="post.password" class="form-control" placeholder="Password">
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="login" :disabled="btndis" class="btn btn-success btn-block" >{{ btn }}</button>  
                    <div class="mt-4 justify-content-center">
                        <a href="#" @click="signup" >Not yet register?</a>
                        <div class="mt-1">
                            <a href="#"  @click="resetpassword">Forgot Password?</a>
                        </div>
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
            post:{},
            errors:[],
            btn:'Login',
            btndis:false,
        }
    },
    methods:{
        login(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
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
        },
        signup(){
            $('.modal-login').modal('hide');
            this.$router.push({name:'signup'});
        },
        resetpassword(){
            $('.modal-login').modal('hide');
            this.$router.push({name:'resetpassword'});
            
        }
    }
}
</script>

<style>

</style>
