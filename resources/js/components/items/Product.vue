<template>
    <div class="container">
        <div class="row">
            <div claass="col-md-12 row">
                <div class="row">
                <div class="col-md-9">
                    <div class="d-flex flex-wrap justify-content-around items-main pb-5">
                        <h4>Admission and Records Office Document Request Recommender System</h4>
                        <h6 class="mt-2 text-center">DUE TO THE LIMITED MANPOWER AND RESTRICTED ACCESS TO CAMPUS, KINDLY BE ADVISED ON THE FOLLOWING:</h6>
                        <div class="col-md-12 mt-5 small">
                        
                            <p>1. THE SYSTEM WILL BE ACCESSIBLE EVERY THURSDAY, FRIDAY, AND SATURDAY EXCEPT HOLIDAYS.</p>
                            <p>2. DUE TO THE LIMITED NUMBER OF REQUEST THAT CAN BE HANDLED, THE FACILITY WILL START RECEIVING REQUEST AT
                                9AM, BUT WILL CLOSE ONCE THE DAILLY LIMIT HAS BEEN REACHED.</p>
                            <p>3. REQUEST SHALL BE FOR REGULAR PROCCESSING ONLY. EXPRESS PROCESSING SHALL BE TEMPORARILY
                            UNAVAILABLE DUE TO LIMITED MANPOWER TO PRODUCE THE DOCUMENTS IN CAMPUS.</p>
                            <p>4. DUE TO LIMITED MANPOWER AND TO ENSURE SAFETY OF CLIENTS AND OFFICE PERSONEL,
                                MANUAL PICK-UP OF DOCUMENTS AT THE OFFICE OF THE REGISTRAR IS TEMPORARILY SUSPENDED.</p>
                            <p>5. THE PROCESSING PERIOD INDICATED HEREIN IS DIFFERENT AND DISTINCT FROM THE DELIVERY
                            PERIOD WHICH IS DEPENDENT ON THE LOCATION YOU HAVE SPECIFIED, KINDLY EXPECT THAT
                            DELIVERY OF DOCUMENTS VIA COURIER MAY TAKE 1 TO 2 WEEKS DEPENDING ON THE DELIVERY AREA</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="d-flex flex-wrap justify-content-around items-main">
                        <div class="col-md-12">
                            <h4>Just for you</h4>
                        </div>
                        <div class="col-md-12 box-loading" v-if="loading">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                        </div> 
                        
                        <div v-for="(item, index) in getUniq.slice(0, 2)" :key="index"  class="body-item wo-pad">
                            <div class="item item-recomend"  v-if="!loading">
                                <img class="img-item" :src="'/img/default.png'"/>
                            
                                <div class="item-description">
                                    <div class="item-title">
                                        <a href="">{{ item.item_name }}</a>
                                    
                                    </div>
                                    <p>{{ truncate(item.description , 20, '...' ) }}</p>
                                    <div class="item-price">&#8369;
                                        {{ formatAmount(paymentCharges(item.price == null ? 0 : item.price )) }}
                                    
                                        </div>
                                    <div class="item-discount"></div>
                                    <div class="on-cart-ov">
                                        <button type="button" @click="addToCart(item)" class="btn btn-sm btn-on-cart"> Add to Cart <i class="fa fa-shopping-bag"></i></button>
                                    </div>
                                </div>
                                <div class="star-item">
                                    <div class="item-region">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
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
                <div class="d-flex flex-wrap justify-content-around items-main pb-5">
                    <div class="col-md-12">
                        <h4>Documents</h4>
                    </div>
                    <div class="col-md-12 box-loading" v-if="loading_">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div> 
                    
                    <div v-for="(item, index) in items" :key="index" class="body-item wo-pad">
                        <div class="item" v-if="!loading_">
                            <img class="img-item" :src="item.image == null ? '/img/logo.png' :'../storage/items/'+item.image"/>
                           
                            <div class="item-description">
                                <div class="item-title">
                                    <a href="">{{ item.item_name }}</a>
                                  
                                </div>
                                <p>{{ truncate(item.description , 20, '...' ) }}</p>
                                <div class="item-price">&#8369;
                                    {{ formatAmount(paymentCharges(item.price == null ? 0 : item.price )) }}
                                 
                                    </div>
                                <div class="item-discount"></div>
                                <div class="on-cart">
                                    <button type="button" @click="addToCart(item)" class="btn btn-sm btn-on-cart">Add to Cart <i class="fa fa-shopping-bag"></i></button>
                                </div>
                            </div>
                            <div class="star-item">
                                <div class="item-region">
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center" v-if="items.length <= 0">
                                No Documents Found!
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" v-if="getUniq.slice(0, 5).length > 0">
                <h4 class="text-center text-success">Most Requested Documents</h4>
                <div class="d-flex flex-wrap justify-content-around items-main">

                    <div class="col-md-12 box-loading" v-if="loading_">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div> 
                    
                    <div v-for="(item, index) in getUniq.slice(0, 10)" :key="index" class="body-item wo-pad">
                        <div class="item item-recomend" v-if="!loading_">
                            <img class="img-item" :src="'/img/default.png'"/>
                        
                            <div class="item-description">
                                <div class="item-title">
                                    <a href="">{{  item.item_name }}</a>
                                
                                </div>
                                <p>{{  truncate(item.description, 40,'...') }}</p>
                                <div class="item-price">&#8369;
                                    {{ formatAmount(item.price) }}
                                
                                    </div>
                                <div class="item-discount"></div>
                                <div class="on-cart-ov">
                                    <button type="button" @click="addToCart(item)" class="btn btn-sm btn-on-cart"> Add to Cart <i class="fa fa-shopping-bag"></i></button>
                                </div>
                              
                            </div>
                            <div class="star-item">
                                <div class="item-region">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" v-if="getUniq.slice(0, 5).length <= 0 & !loading_">
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-md-12">
                                        No Documents Founds!
                                </div>
                            </div>
                        </div>   
                    </div>      
                </div>
            </div>

        </div>
        <modlogin></modlogin>
    </div>
</template>

<script>
import ModalLogin from '../ModalLogin';
import PaginationVue from '../../table/Pagination';

export default {
     components:{
        pagination:PaginationVue,
        modlogin:ModalLogin
    },
    data(){
        return{
            loading:true,
            loading_:true,
            items:[],
            carts:[],
            recommends:[],
            payment:{},
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
        modalLogin(){
            $('.modal-login').modal('show');
        },
        listOfItem(url='api/item/'){
            axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.loading_ = true;
                axios.get(url,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.items  = data.data.data;
                        this.loading_ = false;
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
            if(!window.Laravel.isLoggedin){
                this.modalLogin();
                return;
            }
          
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
                    'note': data.note,
                    'image': data.image,
                    'price': data.price,
                    'quantity': 1,
                };
                this.carts.push(this.item);
                this.saveToLocal(this.carts);
              }
        
            }else{
                 this.item = {
                    'item_id': data.id,
                    'item_name': data.item_name,
                    'description': data.description,
                    'note': data.note,
                    'image': data.image,
                    'price': data.price,
                    'quantity': 1,
                };
                this.carts.push(this.item);
                this.saveToLocal(this.carts);
            }
            
        },
        saveToLocal(data){
            // localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.$emit('cartcount', data);
            this.$emit('show',{'message':'Document has been added to your Cart!', 'status':6});
            this.cartSave({'js_data':JSON.stringify(data)});
        },
        onCart(){
            // let storage = localStorage.getItem('oncart');
            // if(storage){
            //     let oncart = JSON.parse(decodeURIComponent(escape(window.atob(storage))));
            //     this.carts = oncart;
            // }

            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/user-cart').then(res=>{
                    let oncart = JSON.parse(res.data.js_data);
                    this.carts  = oncart;
                });
            });
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
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            // return num.toLocaleString(undefined, {maximumFractionDigits:2});
        },
        cartSave(data){
              this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  this.$axios.post('api/user-cart', data).then(res=>{

                  }).catch(err=>{

                  });
              });
        },
        loadRecommend(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.loading = true;
                this.$axios.get('api/purpose/recommend').then(res=>{
                    this.loading = false;
                    this.recommends = res.data;
                    // console.log(this.recommends)
                });
            });

        },
    },
    computed: {
        getUniq() {
            let ret = [];
            ret =  this.recommends.reduce((seed, current) => {
                return Object.assign(seed, {
                [current.id]: current
                });
            }, {});
            return _.orderBy(ret, 'rate', 'desc');
        }
    },
    mounted() {
        if(window.Laravel.isLoggedin){
            this.onCart();
        }
        this.listOfItem();
        this.getChargesPayment();
        this.loadRecommend();
    },
}
</script>

<style>

</style>
