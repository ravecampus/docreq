<template>
    <div class="container-fluid" id="main-page">
            <flashmessage :message="message" :status="status"></flashmessage>
            <div class="fixed-top header-nav" >
                <nav class="navbar navbar-expand-md navbar-light navbar-main sm-navigation">

                    <div class="container">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a class="btn btn-default btn-brand-name"  @click="arrowBtn()" v-if="nav"> 
                            <i class="fa fa-arrow-left"></i>
                        </a>

                        <div class="navbar-nav m-auto" v-show="!nav">
                            <div class="nav-item">
                                <a class="nav-link "><strong></strong></a>
                            </div>
                        </div>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                             <ul class="navbar-nav ml-auto" v-if="auth">
                                <li class="nav-item">
                                    <router-link :to="{name:'userprofile'}" class="nav-link" v-if="user.first_name == null" >(@{{ user.email }})</router-link>
                                    <router-link :to="{name:'userprofile'}" class="nav-link" v-if="user.first_name != null">(@{{ user.first_name }} {{ user.middle_name }} {{ user.last_name }})</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{name:'request'}" class="nav-link" >Dashboard</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{name:'top'}" class="nav-link" >Top-10</router-link>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDrop1" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <!-- <i class="fa fa-gear"></i>  -->
                                        <span class="caret"> Options&nbsp; </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDrop1">
                                     
                                        <router-link class="dropdown-item" :to="{name:'topay'}">
                                            <i class="fa fa-list-alt"></i>
                                            Request Status
                                        </router-link>
                                        <a class="dropdown-item" @click="logout()" href="#">
                                            <i class="fa fa-sign-out"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li>
                            </ul>
                            <ul class="navbar-nav ml-auto"  v-if="!auth">
                               <li class="nav-item">
                                    <router-link :to="{name:'top'}" class="nav-link" >Top-10</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{name:'login'}" class="nav-link" >Login</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{name:'signup'}" class="nav-link" >Sign up</router-link>
                                </li>

                            </ul>
                        </div>
                    </div>
                </nav>

                 <div class="navbar navbar-secondary show-nav" v-show="nav">
                    <div class="container nav-lower-menu">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <router-link :to="{name:'items'}" class="brand-main">
                                    <img class="brand-logo" src="/img/orig.png" alt="">
                                    <div class="brand-site">
                                      {{title}}
                                    </div>
                                </router-link>
                                
                            </div>
                            <div class="col-md-7">
                                <div class="nav navbar-nav mx-auto sub-content row">
                                    <search-main 
                                        
                                        :items="items"
                                        :filterBy="filter" 
                                        :cart_count="lencart "  
                                        :cart_link="'cart'" 
                                                         
                                    ></search-main>                      
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <main class="main-body m-container-size">
                <div class="container-fluid">
                    <router-view @cartcount="cartCount" @show="flashMessage"></router-view>
                </div>
            </main>
            
            <!-- <div id="emailverify" class="modal"  data-backdrop="static">
                <div class="modal-dailog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    Please Verify your Email!
                                    <button type="button" id="resend" @click="resendVerify()" class="btn btn-item-default">Resend</button>
                                    <a class="pull-right" href="#" @click="logout()">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
       

        </div>
</template>

<script>
import Search from './search/Main.vue';
import Item from './items/Product.vue';
import FlashMessage from './FlashMessage.vue';

export default {
    components:{
        searchMain: Search,
        Item,
        flashmessage: FlashMessage,
    },
    data(){
        return{
            title:{},
            nav:true,
            auth:false,
            items:[],
            message:'',
            status:'',
            lencart:null,
            lencart_:0,
            filter:['item_name', 'description'],
        }
    },
    watch:{
        nav:(val)=>{
            let body = $('#main-page').parent().find('.main-body');
            if(val){
                
                body.addClass('m-container-size');   
            }else{
    
                body.removeClass('m-container-size'); 
            }
        },
        '$route' () {
            $('#navbarSupportedContent').collapse('hide');
        }, 
    },
    
    methods:{
        arrowBtn(){
            var vm = $('.btn-brand-name').find('.fa');
            var nav = $('.header-nav').parent().find('.navbar-secondary');
            var body = $('#main-page').parent().find('.main-body');

            if(nav.hasClass('show-nav')){
                vm.removeClass('fa-arrow-left').addClass('fa-arrow-right');
                nav.removeClass('show-nav').addClass('hide-nav');
                body.removeClass('m-container-size');
                setTimeout(()=>{
                    nav.addClass('on-close');
                }, 100);
            }else{
                vm.removeClass('fa-arrow-right').addClass('fa-arrow-left');
                nav.removeClass('hide-nav').addClass('show-nav');
                body.addClass('m-container-size');
                nav.removeClass('on-close');
            }
        },
        listOfItem(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/item/list').then(res=>{
                    this.items = res.data;
                });
            });
        },
        cartCount(data){
            let cc = 0;
            data.forEach(res => {
                cc += res.quantity;
            });
            this.lencart = cc;
        },
        cartDefault(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/user-cart').then(res=>{
                    let oncart = JSON.parse(res.data.js_data);
                    let cc_ = 0
                    oncart.forEach(res => {
                        cc_ += res.quantity;
                    });
                    this.lencart_ = cc_;
                });
            });
        },
        flashMessage(data){
             this.showMessage(data)
        },
        showMessage(data){
            this.message = data.message;
            if(data.status == 1){
                this.status = 'alert-success';
            }else if(data.status == 2){
                this.status = 'alert-warning';
            }else if(data.status == 3){
                this.status = 'alert-danger';
            }else if(data.status == 4){
                this.status = 'alert-secondary';
            }else if(data.status == 5){
                this.status = 'alert-dark';
            }else if(data.status == 6){
                this.status = 'alert-light';
            }else if(data.status == 7){
                this.status = 'alert-primary';
            }
            $('.fm-body').show();
            setTimeout(() => {
                $('.fm-body').fadeOut("slow");
            }, 3000);
        },
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        
    }, 
    mounted(){
        if(window.Laravel.isLoggedin){
            this.auth = true;
            // this.nav = false;
            this.user = window.Laravel.user;
        }

        this.listOfItem();
         if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            this.auth = true;
            if(user.role == 1){
                this.$router.push({name:'admindashboard'})
            }else if(user.role == 0){
            //    this.$router.push({name:'user'})
            }
        }else{
            
        }
        this.title = window.Title.app_name;

        // this.cartDefault();

    }
}
</script>

<style>

</style>
