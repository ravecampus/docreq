<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        <h4 class="mb-4 d-print-none">Report</h4>
        <div class="row">
            <div class="col-md-12">
                <!-- <button type="button" @click="addUser()" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Add User</button> -->
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="form-group d-print-none row">
                            <div class="col-md-4 pr-0">
                                <input type="text" class="form-control" v-model="tableData.search" placeholder="Search ..." @keyup.enter="listOfOrders()">
                            </div>
                            <div class="col-md-3 pr-0">
                                <Datepicker v-model="tableData.from" placeholder="From" :format="format"/>
                            </div>
                            <div class="col-md-3 pr-0">
                                 <Datepicker v-model="tableData.to" placeholder="To" :format="format"/>
                            </div>
                            <div class="col-md-2 pr-0">
                                <button type="button" @click="dateFitler" class="btn btn-success"> <i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                        <div class="text-center d-none d-print-block mb-5">
                            <h4>University Southern Mindanao</h4>
                            <h5>Online Document Request System</h5>
                        </div>
                        <div class="">
                            <h6>Sales Report</h6>
                            <p class="pull-right d-none d-print-block">Print Date: {{ formatDate(Date()) }}</p>
                        </div>
                        <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                                <tr v-for = "(list, index) in orders" :key="index" class="linkTable">
                                    <td>{{ list.trucking_number }}</td>
                                    <td>{{ formatDate(list.created_at) }}</td>
                                    <td><strong>{{ list.first_name }} {{ list.middle_name }} {{ list.last_name }}</strong></td>
                                    <td> &#8369; {{ formatAmount(list.grand_total) }}</td>
                                    <td>
                                        {{ setStatus(list.status) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        Total:
                                    </td>
                                    <td colspan="2">
                                        <strong>
                                        &#8369; {{ formatAmount(totalAmount(orders)) }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" v-show="!noData(orders)">
                                        No Result Found!
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        
                        <div class="table-footer d-print-none">
                            <button type="button" class="btn btn-success" @click="printReport()">
                                <i class="fa fa-print"></i> Print Report
                            </button>
                            <!-- <pagination :pagination="pagination"
                                @prev="listOfOrders(pagination.prevPageUrl)"
                                @next="listOfOrders(pagination.nextPageUrl)"
                                v-show="noData(orders)">
                            </pagination> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade users" ref="users">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <h4> Administrator</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label> First Name</label>
                                        <input type="text" v-model="post.first_name" class="form-control">
                                        <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Middle Name</label>
                                        <input type="text" v-model="post.middle_name" class="form-control">
                                        <span class="errors-material" v-if="errors.middle_name">{{errors.middle_name[0]}}</span>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="form-group col-md-12">
                                        <label> Last Name</label>
                                        <input type="text" v-model="post.last_name" class="form-control">
                                        <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                    </div>
                
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label> Email</label>
                                        <input type="text" v-model="post.email" class="form-control">
                                        <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                    </div>
                
                                </div>
                               <div class="row" v-if="post.id == null">
                                    <div class="form-group col-md-6">
                                        <label> Password</label>
                                        <input type="password" v-model="post.password" class="form-control">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Password Confirmation</label>
                                        <input type="password" v-model="post.password_confirmation" class="form-control">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button" :disabled="btn_dis"  @click="saveUser()"  class="btn btn-success ">{{ btn_save }}</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade cpassword" ref="cpassword">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <h4> Administrator</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>New Password</label>
                                        <input type="password" v-model="post.password" class="form-control">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Confirm Password</label>
                                        <input type="password" v-model="post.password_confirmation" class="form-control">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                                    </div>
                                </div>
                                <button type="button" @click="savePassword" class="btn btn-success mt-3">{{btn_pass}}</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button" :disabled="btn_dis"  @click="saveUser()"  class="btn btn-success ">{{ btn_save }}</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default">Cancel</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="modal fade delete-users">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Do you want to Delete <strong>{{ post.item_name }} </strong>?
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button"  @click="deleteItemConfirm(post)"  class="btn btn-danger btn-sm">Yes</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default btn-sm">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import DataTable from '../../table/DataTable'
import PaginationVue from '../../table/Pagination';

export default {
     components:{
        dataTable:DataTable,
        pagination:PaginationVue,
        Datepicker
    },

    setup() {
        // In case of a range picker, you'll receive [Date, Date]
        const format = (d) => {
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();

            return  month+ "-" + day  + "-" + year;
        }
        
        return {
            format,
        }
    },
    data(){
        let sortOrders = {};
        let columns =[
            {label:'Order Number', name:'first_name'},
            {label:'Date', name:null},
            {label:'Client', name:null},
            {label:'Amount', name:null},
            {label:'Status', name:null},
            ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btn_save: "Save",
            btn_pass: "Save",
            btn_dis: false,
            filter:{},
            post:{},
            errors:[],
            orders:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                from:null,
                to:null,
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
    methods: {
        addUser(){
            $('.users').modal('show');
        },
        editUser(data){
            this.post = data;
            $('.users').modal('show');
        },
        deleteUser(data){
            this.post = data;
            $('.delete-users').modal('show');
        },
        changepass(data){
            this.post = data;
            $('.cpassword').modal('show');
        },
        deleteItemConfirm(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.delete('api/items/'+this.post.id).then(res=>{
                    this.post = {};
                    $('.delete-users').modal('hide');
                    this.listOfItems();
                });
            });
        },
        saveUser(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_dis = true;
                this.btn_save = "Saving...";

                if(this.post.id > 0){
                    this.$axios.put('api/users/'+this.post.id, this.post).then(res=>{
                        this.btn_save = "Save";
                        this.post = {};
                        this.errors = [];
                        this.btn_dis = false;
                        $('.users').modal('hide');
                    }).catch(err=>{
                        this.btn_save = "Save";
                        this.btn_dis = false;
                        this.errors = err.response.data.errors
                    });
                }else{
                    this.$axios.post('api/users', this.post).then(res=>{
                        this.btn_save = "Save";
                        this.post = {};
                        this.errors = [];
                        this.btn_dis = false;
                        $('.users').modal('hide');
                    }).catch(err=>{
                        this.btn_save = "Save";
                        this.btn_dis = false;
                        this.errors = err.response.data.errors
                    });
                }
                this.listOfUsers();
            });
        },
        savePassword(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_pass = "Saving..."
                this.$axios.post('api/users/pass', this.post).then(res=>{
                    this.post = {};
                    this.btn_pass = "Save";
                    $('.cpassword').modal('hide');
                }).catch(err=>{
                    this.btn_pass = "Save";
                    this.errors = err.response.data.errors
                });
            });
        },
        listOfOrders(url="api/report"){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.orders = data.data;
                    //     // this.configPagination(data.data);
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
                this.listOfOrders();
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
        setStatus(data){
            return (data == 0) ? "TO PAY" : (data == 1) ? "ON PROCESS" : (data==2) ? "APPROVED & PACKED TO SHIP" : ( data== 3) ? "DEPARTED": ( data== 4) ? "RECEIVED": "CANCELED";
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        printReport(){
            window.print();
        },
        totalAmount(data){
            let ret = 0;
            // console.log(data)
            data.forEach((item)=>{
                ret += item.grand_total;
            });

            return ret;
        },
        dateFitler(){
            this.listOfOrders();
        }

    },
    mounted() {
        $(this.$refs.users).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
        this.listOfOrders();
    },

}
</script>

<style>

</style>
