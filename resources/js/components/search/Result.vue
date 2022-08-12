<template>
    <div class="row">
        <div class="col-md-2">
            <div class="d-flex flex-wrap justify-center" >
                <h5> Search Result</h5>
              
            </div>
            <div class="row">
                <div class="col-md-12">
                   <div>: <strong>{{ $route.query.q }}</strong></div> 
                    <p>{{ items.length }} items found for "{{ $route.query.q }}"</p>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="d-flex flex-wrap justify-content-around items-main">
                <div class="col-md-12">
                    <h4>Documents</h4>
                </div>
                <div class="col-md-12 box-loading" v-if="loadi">
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
                            <div class="item-description">
                                <div class="item-title">
                                    <a href="">{{ truncate(item.item_name , 15, '...' ) }}</a>
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
                <div v-show="noData(items)">
                    No Result Found! <router-link :to="{name:'items'}">Back to Home</router-link>
                </div>
            </div>
        </div>
        <modlogin></modlogin>
    </div>
</template>

<script>
import ModalLogin from '../ModalLogin';
import uniq from 'lodash/uniq'
export default {
    components:{
        modlogin:ModalLogin
    },
    data(){
        return{
            items_:[],
            searchtext:'',
            payment:{},
            data:[],
            item:{},
            filterBy:['item_name', 'description'],
            loadi:false,
        }
    },
    watch:{
        $route (to, from){
           this.searchtext = to.query.q;
        }
    },
    methods:{
        modalLogin(){
            $('.modal-login').modal('show');
        },
        setList(data){
             this.loadi = true;
            if(data.length > 0){
                this.items_= data;   
            }
            
        },
        setSearch(data){
            this.searchtext = data;
            this.loadi = false;
        },
        extractImage(data){
          let data_ = data;
          let items = data.item_gallery;
          let ret = null;
          items.forEach((val, indx)=>{
              if(val.id == data_.main_image){
                  ret = val.images;
              }
          });
          return ret;
      },
      noData(items){
          let ret = false;
          let data = (items == undefined) ? [] : items;
         
          if(data.length <= 0){
             ret = true;
          }
          return ret;
      },
      chargesOnPercentage(data){
        let ret = data.price;
        let user = data.user_id;
        let add_ons = this.extractAddOns(user);

        if(add_ons.unit == 1){
            let num = Number(add_ons.charges) / Math.pow(10, 2);
            let result = data.price * num;
            ret = result + data.price;
        } 
        return ret;
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
            // localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.$emit('cartcount', data);
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
                    console.log(res.data)
                    let oncart = JSON.parse(res.data.js_data);
                    this.carts = oncart;
                });
            });
        },
      
        truncate(text, length, clamp){
            clamp = clamp || '...';
            var node = document.createElement('div');
            node.innerHTML = text;
            var content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
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
            return num.toLocaleString(undefined, {maximumFractionDigits:2});
        },
        cartSave(data){
              this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  this.$axios.post('api/user-cart', data).then(res=>{

                  }).catch(err=>{

                  });
              });
        }
        
    },
    computed:{
        items(){
            let items = [];
            let search = this.searchtext == undefined ? "" : this.searchtext.toLowerCase();  
            let ret = this.items_.filter((item)=>{
                return (item[this.filterBy[0]].toLowerCase().includes(search) 
                || item[this.filterBy[1]].toLowerCase().includes(search));
            });
            if(search != ''){
                items = ret;
            }else{
                return []
            }
            let data = items;
            // console.log(items)
            return uniq(data);
             
        },
    },
    beforeRouteEnter (to, from, next) {
       listItems : {
            axios.get('sanctum/csrf-cookie').then(response=>{
                axios.get('api/item/list').then(res=>{
                    next(vm=>{
                        vm.setList(res.data);
                         setTimeout(() => {
                            vm.setSearch(to.query.q);
                        }, 500);
                    });
              
                });
            });
        }
    },
    mounted(){
        if(window.Laravel.isLoggedin){
            this.onCart();
        }
        this.getChargesPayment();
      
    }
}
</script>

<style>

</style>
