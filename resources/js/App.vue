<template>
    <div>
        <router-view></router-view>
        <footer class="page-footer font-small bg-footer pt-4">
            <div class="container">

            <ul class="list-unstyled list-inline text-center p-0">
            </ul>

            </div>
            <div class="footer-copyright text-center py-3 bg-sub">© 2022 Copyright:
                <a href="#">{{ this.title}}</a>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    data(){
        return{
            title:'',
        }
    },
    mounted(){
          this.title = window.Title.app_name;
    }
}
</script>

<style>

</style>
