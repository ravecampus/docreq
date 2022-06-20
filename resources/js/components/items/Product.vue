<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-footer pull-right">
                    <pagination :pagination="pagination"
                        @prev="listOfItem(pagination.prevPageUrl)"
                        @next="listOfItem(pagination.nextPageUrl)"
                        v-show="noData(items)">
                    </pagination>
                </div>
            </div>
            <div class="col-md-12">
                <div class="d-flex flex-wrap justify-content-around items-main">
                    <div class="col-md-12">
                        <h4>Documents</h4>
                    </div>
                    <div class="col-md-12 box-loading" v-if="items.length == 0">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div> 
                    
                    <div v-for="(item, index) in items" :key="index" class="body-item wo-pad">
                        <div class="item">
                            <!-- <a href=""> -->
                                 <img class="img-item" :src="'/img/default.png'"/>
                            <!-- </a> -->
                            <!-- <router-link :to="{name:'item', params:{itemid:item.id}}">
                                <img class="img-item" :src="item.main_image != null ? '/storage/items/'+extractImage(item) :'/css/default.png'"/>
                            </router-link> -->
                            <div class="item-description">
                                <div class="item-title">
                                    <a href="">{{ truncate(item.item_name , 15, '...' ) }}</a>
                                    <!-- <router-link :to="{name:'item', params:{itemid:item.id}}">
                                    {{ item.item_name | truncate(25) }}
                                    </router-link> -->
                                </div>
                                <p>{{ truncate(item.description , 25, '...' ) }}</p>
                                <div class="item-price">&#8369;
                                    {{ (item.price == null ? 0 : item.price ).toFixed(2) }}
                                    <!-- {{ chargesOnPercentage(item).toFixed(2) }} -->
                                    </div>
                                <div class="item-discount"></div>
                                <div class="on-cart">
                                    <button type="button" @click="addToCart(item)" class="btn btn-sm btn-on-cart">Add to Cart</button>
                                </div>
                            </div>
                            <div class="star-item">
                                <!-- <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i> -->
                                <div class="item-region">
                                   <!-- {{ setCountry(item) }} -->
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
import PaginationVue from '../../table/Pagination';

export default {
     components:{
        pagination:PaginationVue
    },
    data(){
        return{
            items:[],
            carts:[],
            tableData:{
                draw:0,
                length:10,
                search:'',
                archive:0,
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
        listOfItem(url='api/item/'){
            axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                axios.get(url,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.items  = data.data.data;
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

        truncate(text, length, clamp){
            clamp = clamp || '...';
            var node = document.createElement('div');
            node.innerHTML = text;
            var content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        addToCart(data){
          
            if(this.carts.length > 0){
              let cn =  this.carts.filter(res=>res.item_id == data.id);
            //   console.log(cn[0])
              let ck = cn[0] == undefined ? 0 : cn[0].item_id;
              if(ck == data.id){
                    let result = 0;
                    result = cn[0].quantity + 1;
                    let data = {'quantity': result};
                    let item = this.carts.find(e =>e.item_id === cn[0].item_id);
                    let idx = this.carts.indexOf(item);
                    this.carts[idx].quantity = result;      
                    this.saveToLocal(this.carts);
              }else{
                   this.item = {
                    'item_id': data.id,
                    'item_name': data.item_name,
                    'description': data.description,
                    // 'discount': data.discount,
                    'price': data.price,
                    // 'price': this.chargesOnPercentage(data),
                    'quantity': 1,
                    // 'item_gallery':data.item_gallery,
                    // 'user_id':data.user_id,
                };
                this.carts.push(this.item);
                this.saveToLocal(this.carts);
              }
        
            }else{
                 this.item = {
                    'item_id': data.id,
                    'item_name': data.item_name,
                    'description': data.description,
                    // 'discount': data.discount,
                    'price': data.price,
                    // 'price': this.chargesOnPercentage(data),
                    'quantity': 1,
                    // 'item_gallery':data.item_gallery,
                    // 'user_id':data.user_id,
                };
                this.carts.push(this.item);
                this.saveToLocal(this.carts);
            }
            
        },
        saveToLocal(data){
            localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.$emit('cartcount', data);
        },
        onCart(){
            let storage = localStorage.getItem('oncart');
            if(storage){
                let oncart = JSON.parse(decodeURIComponent(escape(window.atob(storage))));
                this.carts = oncart;
            }
      },
    },
    mounted() {
        this.onCart();
        this.listOfItem();
    },
}
</script>

<style>

</style>
