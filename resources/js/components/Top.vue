<template>
    <div class="container mar-main mb-5">
        <div class="row">
             <div class="col-md-12">
                <h4 class="text-center">Top 10 Most Requested Documents</h4>
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
                                <!-- <div class="on-cart-ov">
                                    <button type="button" @click="addToCart(item)" class="btn btn-sm btn-on-cart"> Add to Cart <i class="fa fa-shopping-bag"></i></button>
                                </div> -->
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
    </div>
</template>

<script>
import PaginationVue from '../table/Pagination';

export default {
    components:{
        pagination:PaginationVue,
    },
    data() {
        return {
            loading_:true,
            mostrequest:[],
        }
    },
    computed : {
        getUniq() {
            let ret = [];
            ret =  this.mostrequest.reduce((seed, current) => {
                return Object.assign(seed, {
                [current.id]: current
                });
            }, {});
            return _.orderBy(ret, 'rate', 'desc');
        }
    },
    methods: {
        loadMostReq(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.loading_ = true;
                this.$axios.get('api/purpose/recommend').then(res=>{
                    this.loading_ = false;
                    this.mostrequest = res.data;
                });
            });
        },
 
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        truncate(text, length, clamp){
            clamp = clamp || '...';
            var node = document.createElement('div');
            node.innerHTML = text;
            var content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        },
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        
    },
    mounted() {
        this.loadMostReq();
    },
}
</script>

<style>

</style>
