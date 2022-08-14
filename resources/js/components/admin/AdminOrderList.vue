<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>List of Orders</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="tableData.search"  placeholder="Search ..." @keyup.enter="listOfOders()">
                    </div>
                    <div class="card mt-2" v-for="(list, index) in orders" :key="index">
                        <div class="card-body row">
                            <div class="col-md-4">
                                <h5>{{ list.first_name }} {{ list.middle_name }} {{ list.last_name }}</h5>
                                <div class="mb-1 mb-0 text-muted small">
                                    <span>{{ list.email }}</span>
                                    <p class="text-success"> {{ list.gender == 2 ? 'Female' : 'Male' }} </p>
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <h5>{{ list.delivery_address }} </h5>
                                <div class="mb-1 mb-0 text-muted small">
                                    <span>ORDER #: <strong> {{ list.trucking_number }}</strong></span>
                                    <p class="text-success">ORDER DATE: <strong>{{ formatDate(list.created_at) }}</strong> </p>
                                    <p><strong>{{ setStatus(list.status) }}</strong></p>
                                </div>
                                <div class="col-md-12" v-if="list.status == 1">
                                    <p><strong>Packed for shipment</strong></p>
                                    <button type="button" @click="shippedStatus(list)" class="btn btn-primary">{{ btn_ship }}</button>
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="small bold">Docs.</div>
                                <li v-for="(lst, idx) in list.order_items" :key="idx">
                                    {{ lst.item_name }}
                                </li>
                                <div class="card card-body p-1 border-top mt-2">
                                    <div>Total : &#8369; {{ formatAmount(list.total) }}</div>
                                    <div>Delivery Fee : &#8369; {{ formatAmount(list.delivery_fee) }}</div>
                                    <div class="text-success"><strong>Grand Total : &#8369; {{ formatAmount(list.grand_total) }}</strong></div>
                                </div>
                                <div class="border-top mt-2 small">
                                   <h6>Paid with Paypal</h6>
                                   <p>Payment ID: <strong class="text-success">{{ list.payment_id }}</strong></p>
                                </div>

                            </div>    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-footer pull-right">
                            <pagination :pagination="pagination"
                                @prev="listOfOders(pagination.prevPageUrl)"
                                @next="listOfOders(pagination.nextPageUrl)"
                                v-show="noData(orders)">
                            </pagination>
                        </div>
                    </div>
                    <div class="card mt-2" v-show="!noData(orders)">
                        <div class="card-body row">
                            <div class="col-md-12">No result found!</div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PaginationVue from '../../table/Pagination';
export default {

    components :{
        pagination:PaginationVue
    },
    data(){
        return {
            btn_ship:"Shipped",
            orders:[],
             tableData:{
                draw:0,
                length:5,
                search:'',
                column:0,
                dir:'asc',
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
        listOfOders(url='api/order-list'){
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
                this.listOfOders();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },

        formatAmount(num){
            return Number(num).toLocaleString(undefined, {maximumFractionDigits:2});
        },
        shippedStatus(data){
            this.$axios.get('sanctum/crsf-cookie').then(response=>{
                // this.btn_ship = "Setting up...";
                this.$axios.put('api/order-status/action/'+data.order_id,{'status':2}).then(res=>{
                    this.$emit('note',{'message':"Status has been Changed ", 'status':2});
                    this.listOfOders();
                    this.btn_ship = "Shipped"
                });
            });
        },
        setStatus(data){
            return (data == 0) ? "To pay" : (data == 1) ? "To ship" : (data==2) ? "To receive" : "Received";
        },
    },
    mounted(){
        this.listOfOders();
    }
}
</script>

<style>

</style>
