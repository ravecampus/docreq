<template>
     <div id="content" class="p-4 p-md-5 pt-5">
         <h4 class="mb-4">Dashboard</h4>
         <div class="row">
             <div class="col-md-12">
                 <div class="mb-3 row mt-3">

                    <div class="mb-4 col-md-4">
                        <div class="h-100 card">
                            <div class="d-flex align-items-center justify-content-between card-body">
                                 <div>
                                     <h4 class="fw-normal text-red">ORDERS</h4>
                                     <p class="subtitle text-sm text-muted mb-0">Provide information coming out from customers</p>
                                 </div>
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
                    <div class="mb-4 col-md-4">
                        <div class="h-100 card">
                            <div class="d-flex align-items-center justify-content-between card-body">
                                 <div>
                                     <h4 class="fw-normal text-red">REPORTS</h4>
                                     <p class="subtitle text-sm text-muted mb-0">Sales Information</p>
                                 </div>
                            </div>
                            <div class="p-1 bg-red-light card-footer small">
                                <router-link :to="{name:'adminreport'}" >
                                <div class="align-items-center text-red row">
                                    <div class="col-10"><p class="mb-0">Generate Report</p>
                                    </div>
                                    <div class="text-end col-2">
                                         <span class="fa fa-arrow-right"></span>
                                    </div>
                                </div>
                                </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col-md-4">
                        <div class="h-100 card">
                            <div class="d-flex align-items-center justify-content-between card-body">
                                 <div>
                                     <h4 class="fw-normal text-red">CLIENTS</h4>
                                     <p class="subtitle text-sm text-muted mb-0">Customer's Information</p>
                                 </div>
                            </div>
                            <div class="p-1 bg-red-light card-footer small">
                                <router-link :to="{name:'adminclient'}" >
                                <div class="align-items-center text-red row">
                                    <div class="col-10"><p class="mb-0">Check Details</p>
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
