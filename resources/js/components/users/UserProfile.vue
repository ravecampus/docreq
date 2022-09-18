<template>
    <div id="content" class="p-4 p-md-5 pt-5">
        <h4 class="mb-4">Profile</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6>Personal Infomation</h6>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>First Name</label>
                                <input type="text" v-model="post.first_name" class="form-control">
                                <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Middle Name</label>
                                <input type="text" v-model="post.middle_name" class="form-control">
                                <span class="errors-material" v-if="errors.middle_name">{{errors.middle_name[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Last Name</label>
                                <input type="text" v-model="post.last_name" class="form-control">
                                <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Gender</label>
                                <select v-model="post.gender" class="form-control">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                                <span class="errors-material" v-if="errors.gender">{{errors.gender[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input type="text" v-model="post.mobile" class="form-control">
                                <span class="errors-material" v-if="errors.mobile">{{errors.mobile[0]}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input type="text" v-model="post.address" class="form-control">
                                <span class="errors-material" v-if="errors.address">{{errors.address[0]}}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Birth Place</label>
                                <input type="text" v-model="post.address" class="form-control">
                                <span class="errors-material" v-if="errors.address">{{errors.address[0]}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Birth Date</label>
                                <Datepicker v-model="post.birth_date" :format="format"/>
                                <span class="errors-material" v-if="errors.birth_date">{{errors.birth_date[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Academic Program</label>
                                <input type="text" class="form-control" v-model="post.academic_program">
                                <span class="errors-material" v-if="errors.academic_program">{{errors.academic_program[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Current Enrolled</label>
                                <select class="form-control" v-model="post.current_enrolled">
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                                <span class="errors-material" v-if="errors.current_enrolled">{{errors.current_enrolled[0]}}</span>
                            </div>
                        </div>
                         <div class="row">
                            <div class="form-group col-md-4">
                                <label>Year Graduated</label>
                                <select v-model="post.year_graduated" class="form-control">
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <span class="errors-material" v-if="errors.year_graduated">{{errors.year_graduated[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Last School Year</label>
                                <select v-model="post.last_sy" class="form-control">
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <span class="errors-material" v-if="errors.last_sy">{{errors.last_sy[0]}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Father's Name</label>
                                <input type="text" class="form-control" v-model="post.fathers_name">
                                <span class="errors-material" v-if="errors.fathers_name">{{errors.fathers_name[0]}}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mother's Name</label>
                                <input type="text" class="form-control" v-model="post.mothers_name">
                                <span class="errors-material" v-if="errors.mothers_name">{{errors.mothers_name[0]}}</span>
                            </div>
                        </div>
                        <button type="button" @click="savePersonalInfo" class="btn btn-success mt-3">{{btn_a}}</button>
                    </div>
                   
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h6>Account Infomation</h6>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Email</label>
                                <input type="text" v-model="post.email" class="form-control">
                                <span class="errors-material" v-if="errors1.email">{{errors1.email[0]}}</span>
                            </div>
                        </div>
                        <button type="button" @click="saveEmail" class="btn btn-success mt-3">{{btn_b}}</button>
                    </div>
                </div>
                 <div class="card mt-3">
                    <div class="card-body">
                        <h6>Account Infomation</h6>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>New Password</label>
                                <input type="password" v-model="post.password" class="form-control">
                                <span class="errors-material" v-if="errors2.password">{{errors2.password[0]}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Confirm Password</label>
                                <input type="password" v-model="post.password_confirmation" class="form-control">
                                <span class="errors-material" v-if="errors2.password_confirmation">{{errors2.password_confirmation[0]}}</span>
                            </div>
                        </div>
                        <button type="button" @click="savePassword" class="btn btn-success mt-3">{{btn_c}}</button>
                    </div>
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
        return{
            post:{},
            btn_a:'Save',
            btn_b:'Save',
            btn_c:'Save',
            errors:[],
            errors1:[],
            errors2:[],
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
        savePersonalInfo(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_a = "Saving ..."
                this.$axios.post('api/user/fillup', this.post).then(res=>{
                    this.btn_a = "Save"
                    this.post = res.data
                    this.errors = [];
                }).catch(err=>{
                    this.btn_a = "Save"
                    this.errors = err.response.data.errors;
                });
            });
        },
        saveEmail(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_b = "Saving ..."
                this.$axios.post('api/user/email', this.post).then(res=>{
                    this.errors1 = [];
                    this.btn_b = "Save"
                    this.post = res.data
                }).catch(err=>{
                    this.btn_b = "Save"
                    this.errors1 = err.response.data.errors;
                });
            });
        },
        savePassword(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_c = "Saving ..."
                this.$axios.post('api/user/password', this.post).then(res=>{
                    this.btn_c = "Save"
                    this.post = res.data
                    this.errors2 = [];
                }).catch(err=>{
                    this.btn_c = "Save"
                    this.errors2 = err.response.data.errors;
                });
            });
        }
    },
    mounted(){
           if(window.Laravel.isLoggedin){
            let user = window.Laravel.user
            this.post = user;
           }
    }
}
</script>

<style>

</style>
