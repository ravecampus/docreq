<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        <h4 class="mb-4">Documents</h4>
        <div class="row">
            <div class="col-md-12">
                <button type="button" @click="addItem()" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Add Item</button>
                <div class="card mt-2">
                    <div class="card-body">
                         <div class="form-group">
                             <input type="text" class="form-control" v-model="tableData.search"  placeholder="Search ..." @keyup.enter="listOfItems()">
                        </div>
                        <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                                <tr v-for = "(list, index) in items" :key="index" class="linkTable">
                                    
                                    <td><strong>{{ list.item_name }}</strong></td>
                                    <td>{{ list.description }}</td>
                                    <td>&#8369; {{ list.price }}</td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <button type="button" @click="editItem(list)" class="btn btn-warning btn-sm">Edit</button>
                                            <button type="button" @click="deleteItem(list)" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" v-show="!noData(items)">
                                        No Result Found!
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <div class="table-footer pull-right">
                            <pagination :pagination="pagination"
                                @prev="listOfItems(pagination.prevPageUrl)"
                                @next="listOfItems(pagination.nextPageUrl)"
                                v-show="noData(items)">
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade items" ref="items">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" v-model="post.item_name" class="form-control">
                                    <span class="errors-material" v-if="errors.item_name">{{errors.item_name[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <!-- <input type="text" v-model="post.description" class="form-control"> -->
                                    <textarea v-model="post.description" class="form-control"></textarea>
                                    <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" v-model="post.price" class="form-control">
                                    <span class="errors-material" v-if="errors.price">{{errors.price[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button" :disabled="btn_dis"  @click="saveItem()"  class="btn btn-success ">{{ btn_save }}</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade delete-item">
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
            {label:'Item Name', name:'item_name'},
            {label:'Description', name:'description'},
            {label:'Price', name:null},
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
            items:[],
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
        addItem(){
            $('.items').modal('show');
        },
        editItem(data){
            this.post = data;
            $('.items').modal('show');
        },
        deleteItem(data){
            this.post = data;
            $('.delete-item').modal('show');
        },
        deleteItemConfirm(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.delete('api/items/'+this.post.id).then(res=>{
                    this.post = {};
                    $('.delete-item').modal('hide');
                    this.listOfItems();
                });
            });
        },
        saveItem(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_dis = true;
                this.btn_save = "Saving...";

                if(this.post.id > 0){
                    this.$axios.put('api/items/'+this.post.id, this.post).then(res=>{
                        this.btn_save = "Save";
                        this.post = {};
                        this.errors = [];
                        this.btn_dis = false;
                        $('.items').modal('hide');
                    }).catch(err=>{
                        this.btn_save = "Save";
                        this.btn_dis = false;
                        this.errors = err.response.data.errors
                    });
                }else{
                    this.$axios.post('api/items', this.post).then(res=>{
                        this.btn_save = "Save";
                        this.post = {};
                        this.errors = [];
                        this.btn_dis = false;
                        $('.items').modal('hide');
                    }).catch(err=>{
                        this.btn_save = "Save";
                        this.btn_dis = false;
                        this.errors = err.response.data.errors
                    });
                }
                this.listOfItems();
            });
        },
        listOfItems(url='api/items'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.items = data.data.data;
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
                this.listOfItems();
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
        $(this.$refs.items).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
        this.listOfItems();
    },

}
</script>

<style>

</style>
