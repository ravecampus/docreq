<template>
<div id="content" class="p-4 p-md-5 pt-5">
    <h4 class="mt-3">Request Status</h4>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'topay'}">To Pay</router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'toship'}">To Ship</router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'toreceive'}">To Receive</router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'received'}">Received</router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'cancelled'}">Cancelled</router-link>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
       <router-view></router-view>
    </div>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>
