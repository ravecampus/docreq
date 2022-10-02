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
                             <img  class="img-thumbnail img-cart" :src="'/img/logo.png'">
                             {{ chk.item_name }}
                            </div> 
                            <div class="col-md-3 col-sm-3">
                               &#8369; {{ formatAmount(paymentCharges(chk.price)) }}
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
                                <strong class="d-sm-none">Total:</strong> &#8369;
                                {{ formatAmount(priceWithQuantity(chk)) }}
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
                                            Subtotal: <strong>&#8369; {{ formatAmount(totalPrice(forCheckout)) }}</strong>
                                        </div>
                                        <div class="list-group-item">
                                            Delivery Charge: <strong>&#8369; {{ formatAmount(deliveryCharges(forCheckout)) }}</strong>
                                            <input type="hidden" v-model="to_order.delivery_charges" >
                                        </div>
                                        <div class="list-group-item">
                                           <strong>Grand Total: &#8369; {{ formatAmount(grandTotal()) }}</strong>
                                        </div>
                                    </div>

                               </div>
                               <div class="card-body">
                                   <div class="row p-1">
                                       <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Delivery Option</label>
                                                <select class="form-control" v-model="other_info.delivery_option">
                                                    <option value="1">Deliver</option>
                                                    <option value="2">Pick up</option>
                                                </select>
                                                <span class="errors-material" v-if="errors.delivery_option">{{ errors.delivery_option[0]}}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Request Details</label>
                                                <textarea v-model="other_info.request_detail" class="form-control h-100" placeholder="Request Details"></textarea>
                                                <span class="errors-material" v-if="errors.request_detail">{{ errors.request_detail[0]}}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Purpose</label>
                                                <ul class="list-group">
                                                    <li class="list-group-item" v-for="(lst,idx) in purposes" :key="idx">
                                                
                                                        <input type="checkbox" v-model="other_info.purpose[lst.id]"> &nbsp;
                                                        <label> {{ lst.name }}</label>
                                                    </li>
                                                </ul>
                                                <span class="errors-material" v-if="errors.price">{{errors.price[0]}}</span>
                                            </div>
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
                                                   
                                                    Delivery to:  <strong>{{ user.first_name  }} {{ user.middle_name  }} {{ user.last_name  }} <a class="text-primary" @click="showPersonal(user)" href="#"><i class="fa fa-pencil"></i></a></strong>
                                                    &nbsp;<span class="errors-material" v-if="errors.account">{{ errors.account[0]}}</span>
                                                </div>
                                                <!-- <div class="list-group-item">
                                                    Mobile Number: <strong>{{ addr.mobile_number  }}</strong>
                                                    <span class="errors" v-if="errors.mobile_number">{{ errors.mobile_number[0]}}</span>
                                                </div> -->
                                                <div class="list-group-item">
                                                    Adddress :
                                                    <a class="text-primary" @click="showAddress()" href="#"><i class="fa fa-plus"></i></a>
                                                    <div class="form-material">
                                                        <select v-model="to_order.address" class="form-control" @change="resetValidate(to_order.address)">
                                                            <option v-for="(ab, index) in address_book" :key="index" :value="ab.id">{{ ab.street + ', '+ab.barangay+', '+ab.city_or_municipality+', '+ab.province}}</option>
                                                        </select>
                                                        <span class="errors-material" v-if="errors.delivery_address">{{ errors.delivery_address[0]}}</span>
                    
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    Email Address : <strong>{{ user.email }}</strong>
                                                </div>
                                                <div class="list-group-item">
                                                    <button type="button" @click="placeOrder()" class="btn btn-success">{{ place_order }}</button>
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
                                <!-- <div class="form-group">
                                    <label>Full name...</label>
                                    <input type="text" class="form-control" v-model="add_abook.fullname">
                                     <span class="errors-material" v-if="errors.fullname">{{errors.fullname[0]}}</span>
                                </div> -->
                               
                                <!-- <div class="form-group">
                                    <label>Mobile number...</label>
                                    <input type="text" class="form-control" v-model="add_abook.mobile_number">
                                     <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label>Notes...</label>
                                    <textarea class="form-control" v-model="add_abook.note"></textarea>
                                     <span class="errors-material" v-if="errors.note">{{errors.note[0]}}</span>
                                </div> -->
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

         <div class="modal personal-info">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form @submit.prevent="savePersonalInfo()">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-12">
                                <label>Personal Info.</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" v-model="personal.first_name">
                                            <span class="errors-material" v-if="errors1.first_name">{{errors1.first_name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" v-model="personal.middle_name">
                                        <span class="errors-material" v-if="errors1.middle_name">{{errors1.middle_name[0]}}</span>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" v-model="personal.last_name">
                                            <span class="errors-material" v-if="errors1.last_name">{{errors1.last_name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" v-model="personal.gender">
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                            <span class="errors-material" v-if="errors1.gender">{{errors1.gender[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile (Option)</label>
                                            <input type="text" class="form-control" v-model="personal.mobile">
                                            <span class="errors-material" v-if="errors1.mobile">{{errors1.mobile[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" v-model="personal.address">
                                            <span class="errors-material" v-if="errors1.address">{{errors1.address[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Place</label>
                                            <input type="text" class="form-control" v-model="personal.birth_place">
                                            <span class="errors-material" v-if="errors1.birth_place">{{errors1.birth_place[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Date</label>
                                             <Datepicker v-model="personal.birth_date" :format="format"/>
                                            <!-- <input type="text" class="form-control" v-model="personal.birth_date"> -->
                                            <span class="errors-material" v-if="errors1.birth_date">{{errors1.birth_date[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Academic Program</label>
                                            <input type="text" class="form-control" v-model="personal.academic_program">
                                            <span class="errors-material" v-if="errors1.academic_program">{{errors1.academic_program[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Current Enrolled</label>
                                            <select class="form-control" v-model="personal.current_enrolled">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <span class="errors-material" v-if="errors1.current_enrolled">{{errors1.current_enrolled[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Year Graduated</label>
                                            <select v-model="personal.year_graduated" class="form-control">
                                                <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                            </select>
                                            <span class="errors-material" v-if="errors1.year_graduated">{{errors1.year_graduated[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last School Year</label>
                                            <select v-model="personal.last_sy" class="form-control">
                                                <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                            </select>
                                            <span class="errors-material" v-if="errors1.last_sy">{{errors1.last_sy[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Father's Name</label>
                                            <input type="text" class="form-control" v-model="personal.fathers_name">
                                            <span class="errors-material" v-if="errors1.fathers_name">{{errors1.fathers_name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mother's Name</label>
                                            <input type="text" class="form-control" v-model="personal.mothers_name">
                                            <span class="errors-material" v-if="errors1.mothers_name">{{errors1.mothers_name[0]}}</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="pull-right">
                                    <button type="submit" :disabled="btn_personal" class="btn btn-sm btn-success mr-2">{{ personal_cap }}</button>
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

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    components:{
        Datepicker,
    },
    setup() {
        // In case of a range picker, you'll receive [Date, Date]
        const format = (d) => {
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();

            return  month+ "-" + day  + "-" + year;
        }
        
        return {
            format,
        }
    },
    data(){
        return {
            forCheckout:[],
            list_item:[],
            payment:{},
            delivery:{},
            address_book:[],
            personal:{},
            other_info:{
                purpose:[],
            },
            item:{},
            user:{},
            to_order:{},
            errors:[],
            errors1:[],
            add_abook:{},
            errors:[],
            addr:{},
            place_order:'Place Order',
            btn_place_order: true,
            add_address:'Submit',
            personal_cap:'Submit',
            btn_add_address: false,
            btn_personal: false,
            add_ons:[],
            purposes:[],
            
        }
    },
    computed : {
        years () {
            const year = new Date().getFullYear()
            const date_ = 2000;
            return Array.from({length: year - date_}, (value, index) => (date_+ 1) + index)
        }
    },
    methods:{
        showPersonal(data){
            this.personal = data;
            $('.personal-info').modal('show');
        },
        savePersonalInfo(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_personal = true;
                this.personal_cap = "Submitting...";
                this.$axios.post('api/user/fillup', this.personal).then(res=>{
                    this.user = res.data;
                    this.btn_personal = false;
                    this.personal_cap = "Submit";
                    $('.personal-info').modal('hide');
                }).catch(err=>{
                    this.btn_personal = false;
                    this.personal_cap = "Submit";
                    this.errors1 = err.response.data.errors;
                })
            });
        },
        onCart(){
            // this.sellerAddOns();
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/user-cart').then(res=>{
                    let oncart = JSON.parse(res.data.js_data);
                    this.forCheckout  = oncart;
                });
            });
            // let oncart = JSON.parse(window.atob(localStorage.getItem('oncart')));
            // this.forCheckout = oncart;  
        },
        listItem(){
            this.$axios('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/item/list').then(res=>{
                    this.list_item = res.data;
               })
            })
        },
        priceWithQuantity(data){
            if(data != NaN){
               let qt =  data.quantity * this.paymentCharges(data.price)
               this.forCheckout.total = qt;
               return qt;
            }
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
            // this.$root.$emit('show',{'message':'Item Remove Successfully!', 'status':6});
            if(this.forCheckout.length <= 0){
                this.$router.push({name:'items'});
            }
        },
        editQuantity(data){
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
        // totalPrice(data){
        //     let subtotal_ = 0;
        //     let subtotal = 0;
        //     data.forEach((val, index)=>{
        //         subtotal_ = val.quantity * this.paymentCharges(val.price);
        //         subtotal = subtotal + subtotal_;
        //     });
        //     return subtotal;
        // },
        saveToLocal(data){
            this.$emit('cartcount', data);
            // localStorage.setItem('oncart', window.btoa(unescape(encodeURIComponent(JSON.stringify(data)))));
            this.cartSave({'js_data':JSON.stringify(data)});
        },
        resetValidate(id){
            let data = this.address_book;
            if(data){
                data.forEach((val, idx)=>{
                    if(id == val.id){
                      this.addr = val;
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
            // let data =  JSON.parse(decodeURIComponent(escape(window.atob(localStorage.getItem('oncart')))));
            let data = this.forCheckout;
           
            this.to_order = this.addr
            this.to_order.checkout = data;
            this.to_order.request_detail = this.other_info.request_detail;
            this.to_order.delivery_option = this.other_info.delivery_option;
            this.to_order.account = this.user.first_name;
            this.to_order.total = this.totalPrice(data);
            this.to_order.grand_total = this.grandTotal();
            this.to_order.delivery_fee = this.deliveryCharges();
            let pur =[];
            this.other_info.purpose.forEach((val,indx)=>{
                if(val == true){
                    pur.push({'purpose_id':indx});
                }
            });
            this.to_order.purpose = pur;
            if(this.to_order.barangay != undefined){
                this.to_order.delivery_address = this.to_order.street + ', '+this.to_order.barangay+', '+this.to_order.city_or_municipality+', '+this.to_order.province;
            }
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.errors = [];
                this.$axios.post('api/order', this.to_order).then(res=>{
                    this.place_order = 'Place Order';
                    this.cartSave({'js_data': {}});
                    this.$emit('cartcount', []);
                    this.$router.push({name:'payment', params:{'order_id':res.data.id}});
                }).catch(err=>{
                    this.place_order = 'Place Order';
                    this.errors = err.response.data.errors;
                });
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
                    this.getauthBookAddress();
                    this.$emit('show',{'message':'Food Category Added Successfully!', 'status':4});
                }).catch(err=>{
                    this.add_address = 'Submit';
                    this.btn_add_address = false;
                    this.errors = err.response.data.errors;
                });
            })
           
        },
        // defaultAddress(){
        //     let data = this.user.address_book;
        //     if(data){
        //         data.forEach((val, idx)=>{
        //             if(val.selected == 1){
        //                this.to_order.address = val.id;
        //             }
        //         });
        //     }
        // },
        // defaultMobileNo(){
        //     let data = this.user.address_book;
        //     if(data){
        //         data.forEach((val, idx)=>{
        //             if(val.selected == 1){
        //                 this.mobile = val.mobile_number;
        //             }
        //         });
        //     }
        // },
        grandTotal(){
           let oncarts = this.forCheckout;
           let totalprice =  this.totalPrice(oncarts);
           let delivery = this.deliveryCharges();
           return Number(totalprice) + Number(delivery);
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

        },
        deliveryCharges(){
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
        getChargesPayment(id = 2){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.payment = res.data;
                });
            });
        },
        getChargesDelivery(id = 1){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/charges/get-charge/'+id).then(res=>{
                    this.delivery = res.data;
                });
            });
        },
        getauthBookAddress(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/address-book/auth').then(res=>{
                    this.address_book = res.data;
                }).catch(err=>{

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
        },
        listOfPurpose(){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.$axios.get('api/purpose/list').then(res=>{
                    this.purposes = res.data;
                });
            });
        }


    },
    mounted(){
      
        setTimeout(()=>{
            this.onCart();
            this.listItem();
            // this.defaultAddress();
            // this.defaultMobileNo(); 
            this.getChargesPayment();
            this.getChargesDelivery();
            this.getauthBookAddress();
            this.listOfPurpose();

        },1000);
       
        if(window.Laravel.isLoggedin){
            this.user = window.Laravel.user;
        }
    }
}
</script>
