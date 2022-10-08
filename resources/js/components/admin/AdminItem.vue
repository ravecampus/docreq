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
                                    
                                    <td>
                                        <img class="img-thumbnail w-25" :src="list.image == null ? '/img/logo.png' :'../storage/items/'+list.image"/>
                                        &nbsp;<a href="#" @click="itemIcon(list)">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td><strong>{{ list.item_name }}</strong></td>
                                    <td>{{ list.description }}</td>
                                    <td>&#8369; {{ list.price }}</td>
                                    <td>{{ list.note }}</td>
                                    <td>
                                        <a class="small" @click="showAPurpose(list.id)" href="#">add</a>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item" v-for="(ls,idx) in list.purpose" :key="idx">
                                                {{ xtractPurpose(ls.purpose_id) }}

                                                <a class="small" @click="showRPurpose(ls)" href="#">remove</a>
                                            </li>
                                        </ul>

                                    </td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <button type="button" @click="editItem(list)" class="btn btn-warning btn-sm">Edit</button>
                                            <button type="button" @click="deleteItem(list)" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" v-show="!noData(items)">
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
                                <div class="form-group">
                                    <label>Note (for requirements ) </label>
                                    <textarea v-model="post.note" class="form-control h-100"></textarea>
                                    <span class="errors-material" v-if="errors.note">{{errors.note[0]}}</span>
                                </div>
                                <div class="form-group" v-if="post.id == null">
                                    <label>Purpose</label>
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="(lst,idx) in purposes" :key="idx">
                                    
                                            <input type="checkbox" v-model="other_post.purpose[lst.id]"> &nbsp;
                                            <label> {{ lst.name }}</label>
                                        </li>
                                    </ul>
                                    <span class="errors-material" v-if="errors.purpose">{{errors.purpose[0]}}</span>
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

         <div class="modal fade remove-purpose">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Do you want to remove <strong>{{ xtractPurpose(purpose.purpose_id) }} </strong>?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button"  @click="removePurpose(purpose)"  class="btn btn-danger btn-sm">Yes</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default btn-sm">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="modal fade add-purpose">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4>ORGANIZATION CATEGORY</h4>
                    </div> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label>Purpose</label>
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="(lst,idx) in purposes" :key="idx">
                                    
                                            <input type="checkbox" v-model="other_post.purpose[lst.id]"> &nbsp;
                                            <label> {{ lst.name }}</label>
                                        </li>
                                    </ul>
                                    <span class="errors-material" v-if="errors.purpose">{{errors.purpose[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="btn-group">
                            <button type="button"  @click="addPurpose(purpose)"  class="btn btn-success btn-sm">Save</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-default btn-sm">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="modal modify-logo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="logo-view text-center">
                                    <img :src="upload.image == null ? '/img/logo.png' :'../storage/items/'+upload.image">
                                    <!-- <a href="#" @click="resetLogo()">Reset Default</a> -->
                                </div>
                                <div class="text-center">
                                    <input type="file" id="uploader" accept="image/gif, image/jpeg" @change="uploadImage" class="hidden">
                                    <button type="button" @click="browseImg()" class="btn btn-success mt-3">Browse Image</button>
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
            {label:'Image', name:null},
            {label:'Item Name', name:'item_name'},
            {label:'Description', name:'description'},
            {label:'Price', name:null},
            {label:'Note', name:null},
            {label:'Purpose', name:null},
            {label:'Action', name:null},
            ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            purpose:{},
            btn_save: "Save",
            btn_dis: false,
            post:{
               
            },
            other_post:{
                 purpose:[]
            },
            img:'',
            upload:{},
            errors:[],
            items:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            purposes:[],
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
            form: new FormData,
            uploadPercentage_:0,
            showbar:false,
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

            let pur =[];
            this.other_post.purpose.forEach((val,indx)=>{
                if(val == true){
                    pur.push({'purpose_id':indx});
                }
            });
            this.post.purpose = pur;
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
        xtractPurpose(id){
            let ret = "";
            this.purposes.forEach((val)=>{
                if(id == val.id){
                    ret = val.name;
                }
            });

            return ret;
        },
        listOfPurpose(){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.$axios.get('api/purpose/list').then(res=>{
                    this.purposes = res.data;
                });
            });
        },
        showRPurpose(data){
            this.purpose = data;
            $('.remove-purpose').modal('show');
        },
        removePurpose(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.delete('api/item-purpose/'+this.purpose.id).then(res=>{
                    this.purpose = {};
                    this.listOfItems();
                     $('.remove-purpose').modal('hide');
                });
            });
        }, 
        showAPurpose(id){
            this.purpose.item_id = id
            $('.add-purpose').modal('show');
        },
        addPurpose(){
            let pur =[];
            this.other_post.purpose.forEach((val,indx)=>{
                if(val == true){
                    pur.push({'purpose_id':indx});
                }
            });
            this.purpose.purpose = pur;

            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/item-purpose', this.purpose).then(res=>{
                    this.purpose = {};
                    this.listOfItems();
                     $('.add-purpose').modal('hide');
                });
            });
        },
        itemIcon(data){
            this.upload = data;
            $('.modify-logo').modal('show');
        },
        browseImg(){
            $('#uploader').click();
        },

        uploadImage(e){
            this.img = e.target.files[0];
            this.uploadLogo();
        },
        uploadLogo(){
            this.form.append('image', this.img);
            this.form.append('id',  this.upload.id);
             const config = {
                header:{'Content-Type':'multipart/form-data'},
                    onUploadProgress:(e)=>{
                        this.uploadPercentage_ = parseInt(Math.round((e.loaded * 100)/ e.total));
                        this.showbar = true;
                    }
                };
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/item-upload',this.form, config).then(res=>{
                    this.showbar = false;
                    this.uploadPercentage_ = 0;
                    this.listOfItems();
                    $('.modify-logo').modal('hide');
                }).catch(err=>{
                    this.uploadPercentage_ = 0;
                });
            });
           
        },
    
    },
    mounted() {
        $(this.$refs.items).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
        this.listOfItems();
        this.listOfPurpose();
       
    },

}
</script>

<style>

</style>
