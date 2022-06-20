<template>
    <div class="container mar-main"> 
        <div class="row">
            <div class="col-md-7">
              <div class="list-group list-group-flush">
                  <div class="list-group-item d-none d-sm-block">
                      <div class="row">
                            <div class="col-md-3 col-sm-3">
                               <strong>Item</strong> 
                            </div>
                             <div class="col-md-3 col-sm-3">
                                <strong>Price</strong>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <strong>Quantity</strong>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <strong>Total</strong>
                            </div>
                      </div>
                  </div>
                  <div class="list-group-item" v-for="(chk ,index) in forCheckout" :key="index">
                      <div class="row">
                            <div class="col-md-3 col-sm-3">
                             <img  class="img-thumbnail img-cart" :src="'/img/default.png'">
                             {{ chk.item_name }}
                            </div> 
                            <div class="col-md-3 col-sm-3">
                                {{ chk.price }}
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <strong class="d-sm-none">Quantity: </strong>
                                {{ chk.quantity }}
                                <div class="btn-group text-primary">
                                    <a href="#" class="text-warning" @click="editQuantity(chk)">edit</a>|
                                    <a href="#" class="text-danger" @click="removeItem(chk)">remove</a>
                                </div>
                                
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <strong class="d-sm-none">Total:</strong>
                                {{ priceWithQuantity(chk).toFixed(2) }}
                            </div>
                      </div>
                  </div>
              </div>
            </div> 
           <div class="col-md-5">
               <div class="row">
                   <div class="col-md-12">
                       <div class="card">
                           <div class="card-content">
                               <div class="card-header">
                                    <h5><strong>ORDER SUMMARY</strong></h5>
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item ">
                                            <!-- Subtotal: <strong>{{totalPrice(forCheckout).toFixed(2) }}</strong> -->
                                        </div>
                                        <!-- <div class="list-group-item" v-if="deliveryCharges(forCheckout) != 0">
                                            Delivery Charge: {{ deliveryCharges(forCheckout) }}
                                            <input type="hidden" v-model="to_order.delivery_charges" >
                                        </div> -->
                                        <!-- <div class="list-group-item">
                                           <strong>Grand Total: {{ grandTotal().toFixed(2) }}</strong>
                                        </div> -->
                                    </div>

                               </div>
                               <div class="card-body">
                                   <div class="row">
                                       <div class="col-md-12">
                                           <textarea v-model="to_order.remarks" class="form-control" placeholder="(Optional) Remarks...."></textarea>
                                       </div>
                                   </div>
                                   <!-- <button type="button" class="btn btn-item-default">Next</button> -->
                               </div>
                               <div class="card-footer">
                                   <div class="row">
                                       <div class="col-md-12">
                                            <h5><strong>DELIVERY INFORMATION</strong></h5>
                                            <div class="list-group list-group-flush">
                                                <div class="list-group-item">
                                                    Delivery to: <strong>{{ user.full_name }}</strong>
                                                </div>
                                                <div class="list-group-item">
                                                    Mobile Number: <strong>{{ (set_number != null) ? set_number : mobile  }}</strong>
                                                    <span class="errors" v-if="errors.mobile_number">{{ errors.mobile_number[0]}}</span>
                                                </div>
                                                <div class="list-group-item">
                                                    Adddress :
                                                    <a class="text-primary" @click="showAddress()" href="#"><i class="fa fa-plus"></i></a>
                                                    <div class="form-material">
                                                        <select v-model="to_order.address" class="form-control" @change="resetValidate(to_order.address)">
                                                            <option v-for="(ab, index) in user.address_book" :key="index" :value="ab.id">{{ ab.street + ', '+ab.barangay+', '+ab.city_or_municipality+', '+ab.province}}</option>
                                                        </select>
                                                        <span class="errors-material" v-if="errors.address">{{ errors.address[0]}}</span>
                    
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    Email Address : <strong>{{ this.user.email }}</strong>
                                                </div>
                                                <!-- <div class="list-group-item">
                                                    Cash Delivery:
                                                    <div class="form-material">
                                                        <input type="number" min="1" class="form-control" v-model="to_order.cash_delivery" @keyup="checkCash(to_order,forCheckout)" required>
                                                        <label>Change for:</label>
                                                        <span class="errors-material" v-if="errors.cash_delivery">{{ errors.cash_delivery[0]}}</span>
                                                    </div>
                                                </div> -->
                                                <div class="list-group-item">
                                                    <button type="button" :disabled="btn_place_order" @click="placeOrder()" class="btn btn-success">{{ place_order }}</button>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div> 
        </div>

        <div class="modal edit-quantity">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div clas="row justify-content-md-center">
                            <div class="col-md-12">
                                 <h4>Modify Quantity</h4>
                                 <!-- <div class="col-md-12">
                                     Items available : {{ extractQuantity(item) }} 
                                 </div> -->
                                 <div class="text-default">
                                    <strong>{{ item.item_name }}</strong>
                                 </div>
                                 <div class="group-quantit-btn">
                                    <button type="button" @click="deductQuantity(item)" class="btn btn-default btn-sm"><i class="fa fa-minus"></i></button>
                                    <input type="text" :value="item.quantity" readonly>
                                    <button type="button" @click="addQuantity(item)" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal remove-item">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                               <h4>Remove Item</h4>
                               <strong> Do you want to delete <strong>{{ item.item_name }}</strong>?</strong>
                                <div class="btn-group pull-right mt-2">
                                    <button type="button" @click="confirmRemoveItem(item)" class="btn btn-sm btn-success">Confirm</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Cancel</button>
                                </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>

       <div class="modal add-addressbook">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="saveAddressBook()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <label>Add Address Book</label>
                                <div class="form-group">
                                    <label>Full name...</label>
                                    <input type="text" class="form-control" v-model="add_abook.fullname">
                                     <span class="errors-material" v-if="errors.fullname">{{errors.fullname[0]}}</span>
                                </div>
                               
                                <div class="form-group">
                                    <label>Mobile number...</label>
                                    <input type="text" class="form-control" v-model="add_abook.mobile_number">
                                     <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label>Notes...</label>
                                    <textarea class="form-control" v-model="add_abook.note"></textarea>
                                     <span class="errors-material" v-if="errors.note">{{errors.note[0]}}</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Street...</label>
                                            <input type="text" class="form-control" v-model="add_abook.street">
                                            <span class="errors-material" v-if="errors.street">{{errors.street[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Province...</label>
                                            <input type="text" class="form-control" v-model="add_abook.province">
                                          
                                            <span class="errors-material" v-if="errors.province">{{errors.province[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City / Municipality ...</label>
                                            <input type="text" class="form-control" v-model="add_abook.city_or_municipality">
                                            <span class="errors-material" v-if="errors.city_or_municipality">{{errors.city_or_municipality[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Barangay...</label>
                                            <input type="text" class="form-control" v-model="add_abook.barangay">
                                            <span class="errors-material" v-if="errors.barangay">{{errors.barangay[0]}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pull-right">
                                    <button type="submit" :disabled="btn_add_address" class="btn btn-sm btn-success mr-2">{{ add_address }}</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-success">Cancel</button>
                                </div>
                           </div>
                       </div>
                    </div>  
                    </form>
                </div>
            </div>
        </div>

    </div>   
</template>

<script>
export default {
    data(){
        return {
            forCheckout:[],
            list_item:[],
            item:{},
            user:{},
            to_order:{},
            errors:[],
            add_abook:{},
            errors:[],
            set_number: null,
            mobile: null,
            place_order:'Place Order',
            btn_place_order: true,
            add_address:'Submit',
            btn_add_address: false,
            add_ons:[],
            
        }
    },
    methods:{
        onCart(){
            // this.sellerAddOns();
            let oncart = JSON.parse(window.atob(localStorage.getItem('oncart')));
            this.forCheckout = oncart;  
        },
        listItem(){
            this.$axios('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/item/list').then(res=>{
                    this.list_item = res.data;
               })
            })
        },
        priceWithQuantity(data){
            return data.quantity * data.price;
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
        extractImages(data){
            let ret = null;
            this.list_item.forEach((val, index)=>{
                if(val.id == data.item_id){
                    ret = this.imageSelector(val.item_gallery, val.main_image)
                }
            });
            return ret;
        },
        imageSelector(data, img_id){
            let ret = null;
            data.forEach((val, index)=>{
                if(val.id  == img_id){
                    ret = val.images;
                }
            });
            return ret;
        }, 
        removeItem(data){
            this.item = data;
            $('.remove-item').modal('show');
        },
        confirmRemoveItem(data){
            this.forCheckout.forEach((val, index)=>{
                if(data.item_id == val.item_id){
                    this.forCheckout.splice(index, 1);
                }
            });
            this.saveToLocal(this.forCheckout);
            $('.remove-item').modal('hide');
            this.$root.$emit('show',{'message':'Item Remove Successfully!', 'status':6});
            if(this.forCheckout.length <= 0){
                this.$router.push({name:'items'});
            }
        },
        editQuantity(data){
            console.log(data);
            this.item = data;
            $('.edit-quantity').modal('show');
        },
        deductQuantity(cart){
            this.resetCashDelivery();
            let result = (cart.quantity == 1) ? 1 : cart.quantity - 1;
            let data = {'quantity': result};
            let item = this.forCheckout.find(e =>e.item_id === cart.item_id);
            let idx = this.forCheckout.indexOf(item);
            this.forCheckout[idx].quantity = result;      
            this.saveToLocal(this.forCheckout);
        },
        addQuantity(cart){
            this.resetCashDelivery();
            let result = 0;
            let qty = this.extractQuantity(cart);
            // if(qty == 0 ) return;
            // if(qty <= cart.quantity){
            //     result = qty;
            // }else{
                result = cart.quantity + 1;
            // }
         
            let data = {'quantity': result};
            let item = this.forCheckout.find(e =>e.item_id === cart.item_id);
            let idx = this.forCheckout.indexOf(item);
            this.forCheckout[idx].quantity = result;      
            this.saveToLocal(this.forCheckout);
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
        saveToLocal(data){
            localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.$emit('cartcount', data);
        },
        resetValidate(id){
            let data = this.user.address_book;
            if(data){
                data.forEach((val, idx)=>{
                    if(id == val.id){
                      this.set_number = val.mobile_number;
                    }
                });
            }
            if(id != null){
                this.errors.address ={};
            }
        },
        placeOrder(){
            this.place_order = 'Placing ...';
            this.btn_place_order = true;
            let data =  JSON.parse(decodeURIComponent(escape(window.atob(localStorage.getItem('oncart')))));
            let mob = (this.set_number != null) ? this.set_number : this.mobile;
            this.to_order.checkout = data;
            this.to_order.mobile_number = mob;
            this.to_order.total = this.totalPrice(this.forCheckout);
            this.to_order.delivery_charges = this.deliveryCharges(this.forCheckout);
    
            axios.post('/orders', this.to_order).then(res=>{
                this.place_order = 'Place Order';
                this.btn_place_order = false;
                this.errors = [];
                this.saveToLocal([]);
                this.$root.$emit('on-cart',[]);
                this.$root.$emit('show',{'message':'Your order has been placed!', 'status':6});
                this.$router.push({name:'ordered', params:{order_id:res.data}});
            }).catch(err=>{
                this.place_order = 'Place Order';
                this.btn_place_order = false;
                this.errors = err.response.data.errors;
            });
        },
        showAddress(){
            $('.add-addressbook').modal('show');
        },
        saveAddressBook(){
            this.add_address = 'Saving...';
            this.btn_add_address = true;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/address-book', this.add_abook).then(res=>{
                    this.add_address = 'Submit';
                    this.btn_add_address = false;
                    this.errors = [];
                    $('.add-addressbook').modal('hide');
                    this.add_abook = {};
                    this.$emit('show',{'message':'Address Book Added Successfully!', 'status':6});
                }).catch(err=>{
                    this.add_address = 'Submit';
                    this.btn_add_address = false;
                    this.errors = err.response.data.errors;
                });
            })
           
        },
        defaultAddress(){
            let data = this.user.address_book;
            if(data){
                data.forEach((val, idx)=>{
                    if(val.selected == 1){
                       this.to_order.address = val.id;
                    }
                });
            }
        },
        defaultMobileNo(){
            let data = this.user.address_book;
            if(data){
                data.forEach((val, idx)=>{
                    if(val.selected == 1){
                        this.mobile = val.mobile_number;
                    }
                });
            }
        },

        // sellerAddOns(){
        //   axios.get('/seller-add-ons').then(res=>{
        //       this.add_ons = res.data;
        //   });
        // },
        // deliveryCharges(data){
        //     let ret = 0;
        //     let items = data;
        //     items.forEach(val=>{
        //         let addon = this.extractAddOns(val);
        //         let unit = addon.unit;
        //         if(unit == 3){
        //             ret = addon.charges;
        //         }
        //     });
        //     return ret;
        // },
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
           let oncarts = this.forCheckout;
           let totalprice =  this.totalPrice(oncarts);
        //    let delivery = this.deliveryCharges(oncarts);
        //    return Number(totalprice) + Number(delivery);
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
        checkCash(val, chk){
            let cash = Number(val.cash_delivery);
            let total = this.totalPrice(chk);
            let deliveryc = this.deliveryCharges(chk);
            let gtotal = Number(total) + Number(deliveryc);
            (cash >= gtotal) ? this.btn_place_order = false : this.btn_place_order = true;
        },
        resetCashDelivery(){
            this.to_order.cash_delivery = '';
            this.btn_place_order = true;

        }

    },
    created(){
      
        setTimeout(()=>{
            this.onCart();
            this.listItem();
            this.defaultAddress();
            this.defaultMobileNo(); 
        },2000);
    }
}
</script>
