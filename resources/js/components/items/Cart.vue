<template>
    <div class="container mar-main">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
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
                                    <td class="col-md-2"><strong>{{ priceWithQuantity(cart) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="pull-right">
                                            Subtotal :
                                        </div>
                                    </td>
                                    <td>
                                        <!-- <strong>{{ totalPrice(oncarts).toFixed(2) }}</strong> -->
                                    </td>
                                </tr>
                                <!-- <tr v-if="deliveryCharges(oncarts) != 0">
                                    <td colspan="3" class="x-border">
                                        <div class="pull-right">
                                            Delivery Charge :
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ deliveryCharges(oncarts).toFixed(2) }}</strong>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td colspan="3"  class="x-border">
                                        <div class="pull-right">
                                            <strong>Grand Total :</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- <strong>{{ grandTotal().toFixed(2) }}</strong> -->
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
            order:{
                quantity:1
            },
            add_ons:[]
        }
    },
    methods:{
        onCart(){
            let storage = localStorage.getItem('oncart');
            if(storage){

                let oncart = JSON.parse(decodeURIComponent(escape(window.atob(storage))));
                this.oncarts = oncart;
            }
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
            return num.toLocaleString(undefined, {maximumFractionDigits:2});
        },
        totalPrice(data){
            let subtotal_ = 0;
            let subtotal = 0;
            data.forEach((val, index)=>{
                subtotal_ = val.quantity * val.price;
                subtotal = subtotal + subtotal_;
            });
            return subtotal;
        },
        // extractImages(data){
        //     let ret = null;
        //     this.list_item.forEach((val, index)=>{
        //         if(val.id == data.item_id){
        //             ret = this.imageSelector(val.item_gallery, val.main_image)
        //         }
        //     });
        //     return ret;
        // },
        // imageSelector(data, img_id){
        //     let ret = null;
        //     data.forEach((val, index)=>{
        //         if(val.id  == img_id){
        //             ret = val.images;
        //         }
        //     });
        //     return ret;
        // }, 
        removeFromCart(id){
            this.oncarts.forEach((val, index)=>{
                if(id == val.item_id){
                    this.oncarts.splice(index, 1);
                }
            });
            this.saveToLocal(this.oncarts);
            this.$emit('cartcount', this.oncarts);
            this.$root.$emit('show',{'message':'Item Remove Successfully!', 'status':6});
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
            // localStorage.setItem('oncart', window.btoa(JSON.stringify(data)));
            localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.$emit('cartcount', data);
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
        // sellerAddOns(){
        //   axios.get('/seller-add-ons').then(res=>{
        //       this.add_ons = res.data;
        //   });
        // },
        deliveryCharges(data){
            let ret = 0;
            let items = data;
            items.forEach(val=>{
                // let addon = this.extractAddOns(val);
                // let unit = addon.unit;
                if(unit == 3){
                    // ret = addon.charges;
                }
            });
            return Number(ret);
        },
        // extractAddOns(data){
        //     let ret = {};
        //     let id = data.user_id;
        //     this.add_ons.forEach(val=>{
        //         if(val.user_id == id){
        //             ret = val;
        //         }
        //     });
        //     return ret;
        // },
        grandTotal(){
           let oncarts = this.oncarts;
           let totalprice =  this.totalPrice(oncarts);
        //    let delivery = this.deliveryCharges(oncarts);
        //    return Number(totalprice) + Number(delivery);
           return Number(totalprice);
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
    },
    created(){
        this.onCart();
        this.listItem();
    }
}
</script>
