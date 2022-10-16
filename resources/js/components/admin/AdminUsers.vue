<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        <h4 class="mb-4">Administrators</h4>
        <div class="row">
            <div class="col-md-12">
                <button type="button" @click="addUser()" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Add User</button>
                <div class="card mt-2">
                    <div class="card-body">
                         <div class="form-group">
                             <input type="text" class="form-control" v-model="tableData.search"  placeholder="Search ..." @keyup.enter="listOfUsers()">
                        </div>
                        <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                                <tr v-for = "(list, index) in users" :key="index" class="linkTable">
                                    
                                    <td><strong>{{ list.first_name }} {{ list.middle_name }} {{ list.last_name }}</strong></td>
                                    <td>{{ list.email }}</td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <button type="button" @click="editUser(list)" class="btn btn-warning btn-sm">Edit</button>
                                            <button type="button" @click="changepass(list)" class="btn btn-success btn-sm">Change password</button>
                                            <!-- <button type="button" @click="deleteUser(list)" class="btn btn-danger btn-sm">Delete</button> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" v-show="!noData(users)">
                                        No Result Found!
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <div class="table-footer pull-right">
                            <pagination :pagination="pagination"
                                @prev="listOfUsers(pagination.prevPageUrl)"
                                @next="listOfUsers(pagination.nextPageUrl)"
                                v-show="noData(users)">
                            </pagination>
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
            {label:'Name', name:'first_name'},
            {label:'Email', name:'email'},
            {label:'Action', name:null},
            ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btn_save: "Save",
            btn_pass: "Save",
            btn_dis: false,
            post:{},
            errors:[],
            users:[],
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
                         this.$emit('admess',{'message':'User has been Modified!', 'status':6});
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
                        this.$emit('admess',{'message':'User has been Saved!', 'status':6});
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
        listOfUsers(url='api/users'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.users = data.data.data;
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
                this.listOfUsers();
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
        $(this.$refs.users).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
        this.listOfUsers();
    },

}
</script>

<style>

</style>
