<template>
    <div class="container mar-main">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card mt-5" v-if="oncarts.length == 0">
                    <div class="card-body  text-center">
                        <h6>Cart is Empty!</h6>
                        <router-link :to="{name:'items'}" class="link">shop</router-link>
                    </div>
                </div>
                <div class="card" v-if="oncarts.length > 0">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa fa-shopping-bag"></i> Order Cart</h4>
                     <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Quantity</th>
                                    <th></th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(cart, index) in oncarts" :key="index">
                                    <td class="col-md-6">
                                        <img class="img-thumbnail img-cart" :src="'/img/default.png'">
                                        <strong class="ml-2">{{ cart.item_name }}</strong>
                                        <p>
                                           
                                            {{truncate(cart.description , 150, '...' ) }}
                                        </p>
                                    </td>
                                    <td class="col-md-2">
                                    <div class="group-quantit-btn ">
                                        <button type="button" @click="deductQuantity(cart)" class="btn btn-default btn-sm d-inline-block"><i class="fa fa-minus"></i></button>
                                        <input type="text" :value="cart.quantity" readonly>
                                        <button type="button" @click="addQuantity(cart)" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                                        <!-- <span class="mt-1 tiny-label">Only {{ extractQuantity(cart) }} items left</span> -->
                                    </div>
                                    </td>
                                    <td class="col-md-2  "> 
                                        <div class="btn-group text-center">
                                            <button type="buttton" @click="removeFromCart(cart.item_id)" class="btn btn-sm btn-warning "><i class="fa fa-remove"></i> remove</button>
                                        </div>
                                    </td>
                                    <td class="col-md-2"><strong>&#8369; {{ priceWithQuantity(cart) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="pull-right">
                                            Subtotal :
                                        </div>
                                    </td>
                                    <td>
                                        <strong>&#8369; {{ formatAmount(totalPrice(oncarts)) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="x-border">
                                        <div class="pull-right">
                                            Delivery Fee :
                                        </div>
                                    </td>
                                    <td>
                                        <strong>&#8369; {{ formatAmount( deliveryCharges() ) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"  class="x-border">
                                        <div class="pull-right">
                                            <strong>Grand Total :</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>&#8369; {{ formatAmount(grandTotal()) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                     </div>
                       <div class="pull-right">
                           <button type="button" @click="addMore()" class="btn btn-success mr-2">Add more </button>
                           <button type="button"  @click="checkout()" class="btn btn-success">Proceed to Checkout</button>
                       </div>
                  </div>
                </div>
            </div>
        </div>

            <!-- modal -->
            <div class="modal modal-login">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Unauthenticated</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
   
</template>

<script>

export default {
    data(){
        return{
            oncarts: [],
            not_found: false,
            list_item : [],
            delivery:{},
            payment:{},
            order:{
                quantity:1
            },
            add_ons:[]
        }
    },
    methods:{
        onCart(){
            // let storage = localStorage.getItem('oncart');
            // if(storage){

            //     let oncart = JSON.parse(decodeURIComponent(escape(window.atob(storage))));
            //     this.oncarts = oncart;
            // }

            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/user-cart').then(res=>{
                    let oncart = JSON.parse(res.data.js_data);
                    this.oncarts = oncart;
                });
            });
            // this.sellerAddOns();
        },
        listItem(){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.$axios.get('api/item/list').then(res=>{
                    this.list_item = res.data;
                });
            });
        },
        priceWithQuantity(data){
            let num = data.quantity * data.price;
            let wper = this.paymentCharges(num);
            return this.formatAmount(wper);
        },
        formatAmount(num){
            return num.toLocaleString(undefined, {maximumFractionDigits:2});
        },
        totalPrice(data){
            let subtotal_ = 0;
            let subtotal = 0;
            data.forEach((val, index)=>{
                subtotal_ = val.quantity * this.paymentCharges(val.price);
                subtotal = subtotal + subtotal_;
            });
            return subtotal;
        },
     
        removeFromCart(id){
            this.oncarts.forEach((val, index)=>{
                if(id == val.item_id){
                    this.oncarts.splice(index, 1);
                }
            });
            this.$emit('cartcount', this.oncarts);
            this.saveToLocal(this.oncarts);
        },
        deductQuantity(cart){
            let qty =  this.extractQuantity(cart);
            let result = (cart.quantity == 1) ? 1 : cart.quantity - 1;
            let data = {'quantity': result};
            let item = this.oncarts.find(e =>e.item_id === cart.item_id);
            let idx = this.oncarts.indexOf(item);
            this.oncarts[idx].quantity = result;      
            this.saveToLocal(this.oncarts);
        },
        addQuantity(cart){
            let result = 0;
            let qty = this.extractQuantity(cart);
            // if(qty == 0 ) return;
            // if(qty <= cart.quantity){
            //     result = qty;
            // }else{
                result = cart.quantity + 1;
            // }
            let data = {'quantity': result};
            let item = this.oncarts.find(e =>e.item_id === cart.item_id);
            let idx = this.oncarts.indexOf(item);
            this.oncarts[idx].quantity = result;      
            this.saveToLocal(this.oncarts);
        },
        saveToLocal(data){
            // localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.$emit('cartcount', data);
            this.cartSave({'js_data':JSON.stringify(data)});
        },
        checkout(){
            if(window.token){
                if(this.oncarts.length  <= 0){
                    this.$root.$emit('show',{'message':"No more Items! Can't proceed!", 'status':2});
                }else{
                    this.$router.push({name:'checkout'});
                }
            }else{
                this.$router.push({name:'checkout'});
                // this.$router.push({name:'login', query:{redir:'/cart/checkout'}});
            }
        },
        addMore(){
            this.$router.push({name:'items'});
            
        },
        deliveryCharges(data){
            let ret = {};
            ret = this.delivery
            return Number(ret.amount);
        },
        paymentCharges(amount){
            let per = this.payment.percentage;
            let num = per/100;
            let res = amount * num;
            return amount + res;
        },
        grandTotal(){
            let oncarts = this.oncarts;
            let totalprice =  this.totalPrice(oncarts);
            let delivery = this.deliveryCharges();
            return Number(totalprice) + delivery;
        },
        extractQuantity(data){
            let ret = {};
            let items = this.list_item;
            items.forEach(val=>{
                if(val.id == data.item_id){
                    ret = val;
                }
            });
            return this.totalQuantity(ret);
        },
        totalQuantity(data){

            let qty = data.quantity;
            let orders = data.order_items;
            let item_qty = data.item_quantity;
            let result = 0;

            let total_orders_qty = 0;
            let total_item_qty = 0;
            if(orders){
                orders.forEach(val=>{
                    total_orders_qty  += val.quantity;
                });
            }
            if(item_qty){
                item_qty.forEach(val=>{
                    total_item_qty += val.quantity;
                });
            }
            
            result = (qty + total_item_qty) - total_orders_qty;
            return result;
           
        },
        truncate(text, length, clamp){
            clamp = clamp || '...';
            var node = document.createElement('div');
            node.innerHTML = text;
            var content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        },
        getChargesDelivery(id = 1){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.delivery = res.data;
                });
            });
        },
        getChargesPayment(id = 2){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.payment = res.data;
                });
            });
        },
        cartSave(data){
              this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  this.$axios.post('api/user-cart', data).then(res=>{

                  }).catch(err=>{

                  });
              });
        }
    },
    mounted(){
        this.listItem();
        if(window.Laravel.isLoggedin){
            this.onCart();
        }
        this.getChargesDelivery();
        this.getChargesPayment();
     
        
    }
}
</script>
