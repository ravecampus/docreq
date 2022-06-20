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
            <h1><a href="index.html" class="logo">Doc.Req.</a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="active">
            <router-link :to="{name:'admindashboard'}"><span class="fa fa-home mr-3"></span> Dashboard</router-link>
            </li>
            <li>
                <router-link :to="{name:'adminitem'}"><span class="fa fa-user mr-3"></span> Setup Items</router-link>
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
                <a @click="logout()" href="#"><span class="fa fa-paper-plane mr-3"></span> Logout</a>
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
    },
}
</script>

<style>

</style>
