<template>
    <div>
        <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
                <h1><a href="index.html" class="logo">{{ title }}</a></h1>
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
        
        <router-view></router-view>
        
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
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
