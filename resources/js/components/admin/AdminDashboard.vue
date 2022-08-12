<template>
     <div id="content" class="p-4 p-md-5 pt-5">
         <div class="row">
             <div class="col-md-12">
                 <div class="mb-3 row">
                    <div class="mb-4 col-md-4">
                        <div class="h-100 card">
                            <div class="d-flex align-items-center justify-content-between card-body">
                           
                                 <div>
                                     <h4 class="fw-normal text-red">Orders</h4>
                                     <p class="subtitle text-sm text-muted mb-0">Provide information coming out from customers</p>
                                 </div>
                                 <!-- <div class="flex-shrink-0 ms-3">
                                     <span class="fa fa-list"></span>
                                 </div> -->
                                
                            </div>
                            <div class="p-1 bg-red-light card-footer small">
                                <router-link :to="{name:'adminorderlist'}" >
                                <div class="align-items-center text-red row">
                                    <div class="col-10"><p class="mb-0">List of orders</p>
                                    </div>
                                    <div class="text-end col-2">
                                         <span class="fa fa-arrow-right"></span>
                                    </div>
                                </div>
                                </router-link>
                            </div>
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

        }
    },
    methods:{
        
    }

}
</script>

<style>

</style>
