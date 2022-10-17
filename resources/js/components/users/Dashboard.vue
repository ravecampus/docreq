<template>
    <div>
        <div class="wrapper d-flex align-items-stretch">
        <flashmessage :message="message" :status="status"></flashmessage>
        <nav id="sidebar">
            <div class="custom-menu">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
                <h1><router-link :to="{name:'items'}" class="logo">{{ title }}</router-link></h1>
                <p class="ml-4">@{{ user.first_name }} {{ user.last_name }}</p>
            <ul class="list-unstyled components mb-5">
                <li>
                    <router-link :to="{name:'request'}"><span class="fa fa-clipboard mr-3"></span>Request</router-link>
                </li>
                <li>
                    <router-link :to="{name:'topay'}"><span class="fa fa-list-alt mr-3"></span>Request Status</router-link>
                </li>
                <li>
                    <router-link :to="{name:'userprofile'}"><span class="fa fa-user mr-3"></span>Profile</router-link>
                </li>
                <li>
                    <router-link :to="{name:'bookaddress'}"><span class="fa fa-address-book mr-3"></span>Address Book</router-link>
                </li>
                <li>
                    <router-link :to="{name:'items'}"><span class="fa fa-shopping-bag mr-3"></span>Shop</router-link>
                </li>
                <li>
                    <a @click="logout()" href="#"><span class="fa fa-sign-out mr-3"></span> Logout</a>
                </li>
            </ul>

        </nav>

        <!-- Page Content  -->
        
        <router-view @note="Message"></router-view>
        
        </div>
    </div>
</template>

<script>
import FlashMessage from './../FlashMessage.vue';
export default {
   components:{
        flashmessage: FlashMessage,
    },
    data(){
        return{
            message:'',
            status:'',
            user:{},
            title:''
        }
    },
    methods:{
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(res => {
                        if (res.data.success) {
                           
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
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
            }, 500);
        },
        Message(data){
             this.showMessage(data)
        },
       
    },
    mounted() {
        var fullHeight = function() {

            $('.js-fullheight').css('height', $(window).height());
            $(window).resize(function(){
                $('.js-fullheight').css('height', $(window).height());
            });

        };
        fullHeight();

            $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        if(window.Laravel.isLoggedin){
            this.user = window.Laravel.user;
        }
        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
