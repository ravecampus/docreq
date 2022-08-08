<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        
    <h4>Request</h4>
        <div class="row justify-content-center">
            <div class="col-md-12 text-center" v-if="orders.lenght < 0">
                <h6> No result found!</h6>
            </div>
            <div class="col-md-12">
            <div class="card shadow-0 border rounded-3 mb-3" v-for = "(list, index) in orders" :key="index">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-1" v-for="(lst, idx) in list.order_items" :key="idx">
                                <div class="card-body">
                                    
                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                        <img  class="img-thumbnail img-cart" :src="'/img/default.png'">
                                        <a href="#!">
                                            <div class="hover-overlay text-muted">
                                            : {{ lst.quantity }} X {{ paymentCharges(lst.price) }} = {{ formatAmount(lst.quantity * paymentCharges(lst.price)) }}
                                            <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                            </div>
                                             <strong>{{ lst.item_name }}</strong>
                                             <p>{{ lst.description }}</p>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <h5>{{ list.trucking_number }}</h5>
                            <!-- <div class="d-flex flex-row">
                            <div class="text-danger mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <span>310</span>
                            </div> -->
                            <div class="mb-1 mb-0 text-muted small">
                            <span>{{ list.email }}</span>
                            <span class="text-primary">  </span>
                            </div>
                            <div class="mb-2 text-muted small">
                            <span>{{ list.delivery_address }}</span>
                            <span class="text-primary">  </span>
                            </div>
                            <div class="mb-1 mb-0 text-muted small">
                            <span>{{ setStatus(list.status) }}</span>
                            <div class="text-primary">Requested date: {{ formatDate(list.created_at) }} </div>
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
                            <div class="d-flex flex-column mt-4" >
                                <button  v-if="list.payment == null" class="btn btn-success btn-sm" @click="payOrder(list)" type="button">Pay</button>
                            <!-- <button class="btn btn-primary btn-sm" type="button">Details</button>
                            <button class="btn btn-outline-primary btn-sm mt-2" type="button">
                                Add to wishlist
                            </button> -->
                                <h5 v-if="list.payment != null"><span class="fa fa-paypal"></span> PAID WITH PAYPAL</h5>
                                <p v-if="list.payment != null">Payment ID: {{list.payment.payment_id}}</p>
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
        let sortOrders = {};
        let columns =[
            {label:'Trucking Number', name:'trucking_name'},
            {label:'Items' , name:null},
            {label:'Fees', name:null},
            {label:'Status', name:null},
            {label:'Order Date', name:null},
            ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            orders:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            payment:{},
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
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
         listOfOrder(url='api/auth-order'){
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
            return (data == 0) ? "To pay" : (data == 1) ? "To ship" : (data==2) ? "To receive" : "Received";
        },
        payOrder(data){
            this.$router.push({name:'payment',params:{'order_id':data.id}})
        }

    },
    mounted(){
        this.listOfOrder();
        this.getChargesPayment();
    }
}
</script>

<style>

</style>
