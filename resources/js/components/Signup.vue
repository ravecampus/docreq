<template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-md-offset-4 mt-4">
                
                    <div class="card">
                    <div class="card-body">
                        <div  class="col-md-12 text-center mb-5">
                            <h2>{{ title }}</h2>
                        </div>
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
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" v-model="post.password_confirmation" class="form-control">
                            <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                        </div>
                        <button type="button" @click="signup" :disabled="btndis" class="btn btn-success btn-block mt-4" >{{btn}}</button>
                        <div class="mt-4">
                            <router-link :to="{name:'items'}" >Back to home</router-link>
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
            title:{},
            post:{},
            errors:[],
            btn:'Sign up',
            btndis: false,
        }
    },
    methods:{
        signup(){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.btn = 'Processing...'
                this.btndis = true
                this.$axios.post('api/signup', this.post).then(res=>{
                    this.btndis = false
                    this.btn = 'Sign up'
                    this.$router.push({name:'login'});
                    this.post = {}
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Sign up'
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
