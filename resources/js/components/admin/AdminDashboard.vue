<template>
     <div id="content" class="p-4 p-md-5 pt-5">
         <div class="row">
             <div class="col-md-12">
                 <div class="mb-3 row">
                    <div class="mb-4 col-md-4">
                        <div class="h-100 card">
                            <div class="d-flex align-items-center justify-content-between card-body">
                                 <div>
                                     <h4 class="fw-normal text-red">Orders</h4><p class="subtitle text-sm text-muted mb-0">Orders</p>
                                 </div>
                                 <div class="flex-shrink-0 ms-3">
                                     <svg class="svg-icon text-red"><use xlink:href="#speed-1"></use></svg>
                                 </div>
                            </div>
                            <div class="py-3 bg-red-light card-footer">
                                <div class="align-items-center text-red row">
                                    <div class="col-10"><p class="mb-0">List of orders</p>
                                    </div>
                                    <div class="text-end col-2">
                                        <router-link :to="{name:'adminorderlist'}" > <span class="fa fa-arrow-right"></span></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col-md-4">
                        <div class="h-100 card">
                            <div class="d-flex align-items-center justify-content-between card-body">
                                 <div>
                                     <h4 class="fw-normal text-red">Order Status</h4><p class="subtitle text-sm text-muted mb-0">To Ship</p>
                                 </div>
                                 <div class="flex-shrink-0 ms-3">
                                     <svg class="svg-icon text-red"><use xlink:href="#speed-1"></use></svg>
                                 </div>
                            </div>
                            <div class="py-3 bg-red-light card-footer">
                                <div class="align-items-center text-red row">
                                    <div class="col-10"><p class="mb-0">20% increase</p>
                                    </div>
                                    <div class="text-end col-2"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-up" class="svg-inline--fa fa-caret-up fa-w-10 " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M288.662 352H31.338c-17.818 0-26.741-21.543-14.142-34.142l128.662-128.662c7.81-7.81 20.474-7.81 28.284 0l128.662 128.662c12.6 12.599 3.676 34.142-14.142 34.142z"></path></svg>
                                    </div>
                                </div>
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

}
</script>

<style>

</style>
