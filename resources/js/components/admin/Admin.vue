<template>
    <div>
        <div class="wrapper d-flex align-items-stretch">
        <flashmessage :message="message" :status="status"></flashmessage>
        <nav id="sidebar">
            <div class="custom-menu d-print-none">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
                <h1><a href="#" class="logo">{{ title }}</a></h1>
                <p class="ml-4">@{{ user.first_name }} {{ user.last_name }}</p>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                <router-link :to="{name:'admindashboard'}"><span class="fa fa-tachometer mr-3"></span> Dashboard</router-link>
                </li>
                <li>
                    <router-link :to="{name:'aprofile'}"><span class="fa fa-user mr-3"></span> Profile</router-link>
                </li>
                <li>
                    <router-link :to="{name:'adminuser'}"><span class="fa fa-users mr-3"></span> Users</router-link>
                </li>
                <!-- <li>
                    <router-link :to="{name:'adminclient'}"><span class="fa fa-users mr-3"></span> Clients</router-link>
                </li> -->
                <li>
                    <router-link :to="{name:'adminitem'}"><span class="fa fa-list-alt mr-3"></span> Setup Items</router-link>
                </li>
                <li>
                    <router-link :to="{name:'charges'}"><span class="fa fa-money mr-3"></span>Charges</router-link>
                </li>
                  <li>
                    <router-link :to="{name:'adminpurpose'}"><span class="fa fa-question mr-3"></span>Setup Purpose</router-link>
                </li>
                <!-- <li>
                <a href="#"><span class="fa fa-sticky-note mr-3"></span> Friends</a>
                </li>
                <li>
                <a href="#"><span class="fa fa-sticky-note mr-3"></span> Subcription</a>
                </li>
                <li>
                <a href="#"><span class="fa fa-paper-plane mr-3"></span> Settings</a>
                </li> -->
                <li>
                    <a @click="logout()" href="#"><span class="fa fa-sign-out mr-3"></span> Logout</a>
                </li>
            </ul>

        </nav>

        <!-- Page Content  -->
        
        <router-view @admess="Message"></router-view>
        
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
        return {
            user:{},
            message:'',
            title:'',
            status:''
        }
    },
    methods:{
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                     
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
