<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        <h4 class="mb-4">Address Book</h4>
        <div class="row">
            <div class="col-md-12">
                <button type="button" @click="addAddressBook()" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Add</button>
                <div class="card mt-2">
                    <div class="card-body">
                        <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                                <tr v-for = "(list, index) in addressbooks" :key="index" class="linkTable">
                                    
                                    <td>
                                        <strong>
                                            {{ list.first_name }}
                                            {{ list.middle_name }}
                                            {{ list.last_name }}
                                        </strong>
                                        <p>{{ list.mobile_number }}</p>  
                                    </td>
                                    <td>
                                        {{ list.street }}, {{ list.barangay }}, {{ list.city_or_municipality }} {{ list.province }}
                    
                                    </td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <button type="button" @click="editItem(list)" class="btn btn-warning btn-sm">Edit</button>
                                            <button type="button" @click="deleteItem(list)" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" v-show="!noData(addressbooks)">
                                        No Result Found!
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <div class="table-footer pull-right">
                            <pagination :pagination="pagination"
                                @prev="listOfaAddressBook(pagination.prevPageUrl)"
                                @next="listOfaAddressBook(pagination.nextPageUrl)"
                                v-show="noData(addressbooks)">
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade address-book" ref="addressbook">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" v-model="post.first_name">
                                            <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" v-model="post.middle_name">
                                            <span class="errors-material" v-if="errors.middle_name">{{errors.middle_name[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" v-model="post.last_name">
                                            <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input type="text" class="form-control" v-model="post.mobile_number">
                                            <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Street</label>
                                            <input type="text" class="form-control" v-model="post.street">
                                            <span class="errors-material" v-if="errors.street">{{errors.street[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province</label>
                                            <input type="text" class="form-control" v-model="post.province">
                                          
                                            <span class="errors-material" v-if="errors.province">{{errors.province[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City / Municipality</label>
                                            <input type="text" class="form-control" v-model="post.city_or_municipality">
                                            <span class="errors-material" v-if="errors.city_or_municipality">{{errors.city_or_municipality[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Barangay</label>
                                            <input type="text" class="form-control" v-model="post.barangay">
                                            <span class="errors-material" v-if="errors.barangay">{{errors.barangay[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button" :disabled="btn_dis"  @click="saveAddressBook()"  class="btn btn-success ">{{ btn_save }}</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade delete-address-book">
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
            {label:'Delivery info.', name:null},
            {label:'Address', name:null},
            {label:'Action', name:null},
            ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btn_save: "Save",
            btn_dis: false,
            post:{},
            errors:[],
            addressbooks:[],
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
        addAddressBook(){
            $('.address-book').modal('show');
        },
        editItem(data){
            this.post = data;
            $('.address-book').modal('show');
        },
        deleteItem(data){
            this.post = data;
            $('.delete-address-book').modal('show');
        },
        deleteItemConfirm(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.delete('api/address-book/'+this.post.id).then(res=>{
                    this.post = {};
                    this.$emit('note',{'message':'Address Book has been Deleted!', 'status':6});
                    $('.delete-address-book').modal('hide');
                    this.listOfaAddressBook();
                });
            });
        },
        saveAddressBook(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_dis = true;
                this.btn_save = "Saving...";

                if(this.post.id > 0){
                    this.$axios.put('api/address-book/'+this.post.id, this.post).then(res=>{
                        this.btn_save = "Save";
                        this.post = {};
                        this.errors = [];
                        this.btn_dis = false;
                        this.$emit('note',{'message':'Address Book has been Modified!', 'status':6});
                        $('.address-book').modal('hide');
                    }).catch(err=>{
                        this.btn_save = "Save";
                        this.btn_dis = false;
                        this.errors = err.response.data.errors
                    });
                }else{
                    this.$axios.post('api/address-book', this.post).then(res=>{
                        this.btn_save = "Save";
                        this.post = {};
                        this.errors = [];
                        this.btn_dis = false;
                         this.$emit('note',{'message':'Address Book has been Saved!', 'status':6});
                        $('.address-book').modal('hide');
                    }).catch(err=>{
                        this.btn_save = "Save";
                        this.btn_dis = false;
                        this.errors = err.response.data.errors
                    });
                }
                
            });
        },
        listOfaAddressBook(url='api/address-book'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.addressbooks = data.data.data;
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
                this.listOfaAddressBook();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },

    },
    mounted() {
        $(this.$refs.addressbook).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
        this.listOfaAddressBook();
    },

}
</script>

<style>

</style>
