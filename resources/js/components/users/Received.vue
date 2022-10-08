<template>
   <div class="tab-pane fade show active p-2">
       <h5 class="mt-5 mb-2">Received <span class="badge badge-success">{{ orders.length }}</span></h5>
       <div class="row justify-content-center mt-2">
            <div class="col-md-12">
            <div class="card shadow-0 border rounded-3 mb-3" v-for = "(list, index) in orders" :key="index">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-1" v-for="(lst, idx) in list.order_items" :key="idx">
                                <div class="card-body">
                                    
                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                        <img  class="img-thumbnail img-cart" :src="lst.image == null ? '/img/logo.png' :'../../storage/items/'+lst.image">
                                        <a href="#!">
                                            <div class="hover-overlay text-muted">
                                            : {{ lst.quantity }} X {{ paymentCharges(lst.price) }} = {{ formatAmount(lst.quantity * paymentCharges(lst.price)) }}
                                            <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                            </div>
                                             <strong class="text-muted">{{ lst.item_name }}</strong>
                                             <p class="text-muted">{{ lst.description }}</p>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <h5>{{ list.trucking_number }}</h5>
                            <div class="mb-1 mb-0 text-muted small">
                            <span>{{ list.email }}</span>
                            <span class="text-primary">  </span>
                            </div>
                            <div class="mb-2 text-muted small">
                            <strong>{{ list.full_name }}</strong>&nbsp;
                            <span>{{ list.delivery_address }}</span>&nbsp;
                            <span class="text-primary"> ({{ list.mobile_number }})</span>
                            </div>
                            <div class="mb-1 mb-0 text-muted small">
                            <span><strong>{{ setStatus(list.status) }}</strong></span>
                            <div class="text-success">Requested date: {{ formatDate(list.created_at) }} </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-3 border-sm-start-none border-start">
                            <div class="d-flex flex-row align-items-center mb-1">
                                Total: &nbsp;
                                <h4 class="mb-1 me-1">&#8369; {{ formatAmount(list.total) }}</h4>
                            
                            </div>
                            <div class="d-flex flex-row align-items-center mb-1">
                                Delivery Fee: &nbsp;
                                <h5 class="mb-1 me-1">&#8369; {{ formatAmount(list.delivery_fee) }}</h5>
                            </div>
                            <div class="d-flex flex-row align-items-center mb-1">
                                Grand Total: &nbsp;
                                <h5 class="mb-1 me-1">&#8369; {{ formatAmount(list.grand_total) }}</h5>
                            </div>
                            <h6 class="text-success">{{ list.trucking_number }}</h6>
                            <div class="d-flex flex-column mt-4 text-success">
                                <h5><span class="fa fa-paypal"></span>  PAID WITH PAYPAL</h5>
                                <p>Payment ID: {{ list.payment.payment_id }}</p>
                                <div class="small">Date Paid : {{ formatDate( list.payment.created_at ) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-footer pull-right">
                <pagination :pagination="pagination"
                    @prev="listOfOrder(pagination.prevPageUrl)"
                    @next="listOfOrder(pagination.nextPageUrl)"
                    v-show="noData(orders)">
                </pagination>
            </div>
        

                        
                            
            </div>    
        </div>
   </div>
</template>

<script>
import DataTable from '../../table/DataTable'
import PaginationVue from '../../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        return{
            payment:{},
            orders:[],
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                status:4,
            },
            pagination:{
                lastPage:'',
                currentPage:'',
                total:'',
                lastPageUrl:'',
                nextPageurl:'',
                prevPageUrl:'',
                from:'',
                to:''
            },
        }
    },
    methods:{
        listOfOrder(url='api/order-status'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.orders = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                
                }).catch(err=>{
                
                });
            });
        },
        configPagination(data){
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key){
            if(key != null){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.listOfOrder();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        formatAmount(num){
            return Number(num).toLocaleString(undefined, {maximumFractionDigits:2});
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        paymentCharges(amount){
            let per = this.payment.percentage;
            let num = per/100;
            let res = amount * num;
            return amount + res;
        },
        getChargesPayment(id = 2){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.payment = res.data;
                });
            });
        },
        setStatus(data){
            return (data == 0) ? "TO PAY" : (data == 1) ? "ON PROCESS" : (data==2) ? "APPROVED & PACKED TO SHIP" : ( data== 3) ? "DEPARTED": ( data== 4) ? "RECEIVED": "CANCELED";
        },
    },
    mounted(){
        this.listOfOrder();
        this.getChargesPayment();
    }
}
</script>

<style>

</style>
