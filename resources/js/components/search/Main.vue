<template>
    <div class="input-group mb-3 child-content">
          
            <input type="text" v-model="search"
             @keyup="enterEvent"
             @click="showHistory()" 
           
             @blur="clearDropdown"
             class="form-control form-control-lg"  autocomplete="off" placeholder="Search..." aria-describedby="basic-addon2">
            <div class="input-group-append btn-head-search"  @click="searchGo(search)">
                <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
            </div>
           <!-- <div v-show="loading" class="loading-search"></div> -->
           <div class="auto-complete" v-show="visible">
                <div class="search-history" v-show="history">
                    <div class="caps">Search History</div>
                    <div class="clear">
                        <a href="#" @click="clearHistory()">CLEAR</a>
                    </div>
                </div>
                <li class="history-list" v-show="history" v-for="(hist_, idx) in history_data.slice(0, 5)" :key="idx+100"
                v-text="truncate(hist_.name, 20, '...' )"
                @click="setPage(hist_, hist_.name)"
                ></li>
                <li v-for="(match, index) in matches.slice(0, 10)" 
                :key="index" 
                v-html="highLight(truncate(match.name , 20, '...' ))"
                @click="setPage(match, match.name)"
                ></li>
           </div>
       
 
            <div class="cart">
                <a @click="linkCart()" href="#">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="badge badge-pill badge-warning"  v-if="cart_count > 0 || defaultCcart() > 0">{{ cart_count == null ? defaultCcart() : cart_count }}</span>
                    <!-- <span class="badge badge-pill badge-warning" >5</span> -->
                </a>
            </div> 
        </div> 
</template>

<script>
export default {
    name: "Main",
    props:['items', 'filterBy', 'cart_link', 'cart_count'],
    data(){
        return{
            search:'',
            cart_count_:0,
            visible:false,
            history: false,
            cartlen:0,
            search_history:[],
            historylist : [],
            result:[],
            sortKey: '',
            desc:true,
            loading: false,
        }
    },
    mounted(){
        this.search = this.$route.query.q;
    },
    methods:{
        setPage(data, filtered){
            this.search = filtered;
            setTimeout(()=>{
                this.visible = false;
            },500)
            this.setHistoryOnLocal();
            this.searchGo(filtered);
        }, 
        setOnList(data, filter){
            let ret =[];
           data.forEach((val)=>{
               ret.push({'name':val[filter],'asign':filter});
           });
           return ret;
        },
        enterEvent(e){
            if(e.key.toLowerCase() == 'enter'){  
                this.setHistoryOnLocal();
                this.searchGo(this.search);

            }
            if(this.search == '' && this.search_history != null){
                this.visible = true;
                this.history = true;
            }
        },
        setHistoryOnLocal(){
        
            let count = 1;
            let count_ = 0;
            let data = JSON.parse(localStorage.getItem('search_history'));
            let data_ = (data != null) ? data : [];
            if(data_.length > 0){
                
                // replace data
                let item = data.find(e =>e.name === this.search);
                if(item){
                    let idx = data.indexOf(item);
                    data.splice(idx,1); 
                }
               
                data_.forEach(val=>count_ = val.id);
                data_.push({'id':count+count_, 'name':this.search, 'sign':'history'});
            }else{
                data_.push({'id':1, 'name':this.search, 'sign':'history'});
            }
            if(this.search != ""){
                localStorage.setItem('search_history', JSON.stringify(data_));
            }
            this.getFromLocal();
        },
        showHistory(){
            if(this.search_history != null){
                if(this.search_history.length > 0){
                    this.history = true;
                    this.visible = true;
                }
            }
        },
        compareValues(key, order='asc') {
            return function(a, b) {
                if(!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
                    return 0; 
                }
                const varA = (typeof a[key] === 'string') ? 
                    a[key].toUpperCase() : a[key];
                const varB = (typeof b[key] === 'string') ? 
                    b[key].toUpperCase() : b[key];
                
                let comparison = 0;
                if (varA > varB) {
                    comparison = 1;
                } else if (varA < varB) {
                    comparison = -1;
                }
                return (
                (order == 'desc') ? (comparison * -1) : comparison
                );
            };
        },
        getFromLocal(){
            this.search_history = JSON.parse(localStorage.getItem('search_history'));
        },
        clearHistory(){
            localStorage.removeItem('search_history');
            this.getFromLocal();
        },
        clearDropdown(e){
            setTimeout(()=>{
                this.visible = false;
                this.history = false;
            },500);
        },
        searchGo(data){
            this.loading = true;
            if(data == ''){
                this.$router.push({name:'items'});
            }else{
                this.$router.push({name:'search', query:{q:data}});
            }
        },
        highLight(data){
            return data.replace(new RegExp(this.search, "gi"), match => {
                return '<strong>' + match + '</strong>';
            });
        },
        truncate(text, length, clamp){
            clamp = clamp || '...';
            var node = document.createElement('div');
            node.innerHTML = text;
            var content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        },
        defaultCcart(){
            let cc = 0;
            if(window.Laravel.isLoggedin){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.$axios.get('api/user-cart').then(res=>{
                        if(res.data != null){
                            let oncart = JSON.parse(res.data.js_data);
                            oncart.forEach(res => {
                                cc += res.quantity;
                            });
                        }
                    this.cartlen = cc;
                    });
                });
            }
            return this.cartlen;
        },
        linkCart(){
            if(window.Laravel.isLoggedin){
                this.$router.push({name:'cart'});
            }else{
                this.$router.push({name:'login', query:{redir:'/cart'}});
            }
        }
    },
    computed:{
        matches(){
            if(this.search == ''){
                return [];
                
            }
            if( this.search != "" && this.search != undefined){
                let search_ = this.search.toLowerCase();
                let partial_result_ = this.items.filter((item)=>{
        
                return (item[this.filterBy[0]].toLowerCase().includes(search_) 
                || item[this.filterBy[1]].toLowerCase().includes(search_));
                });

                // let partial_result = this.categories.filter((item)=>{ 
                //     return (item[this.filterBy[0]].toLowerCase().includes(search_));
                // });
                let item = this.setOnList(partial_result_, this.filterBy[0]);
                // let item2 = this.setOnList(partial_result_, this.filterBy[1]);
                // this.result = category.concat(item);
                // this.result = item.concat(item2);
                this.result = item;
            }
           
    
            
            return this.result;
        },
        history_data(){
            let res = []; 

            let search_ = this.search.toLowerCase();
                if(this.search_history != null){
                res = this.search_history.filter((hist)=>{
                    let data = hist.name.toLowerCase().includes(search_)
                    return data;
                });
            }
            
            if(this.search == ''){
                this.visible = false;    
            }else{
                if(this.result.length > 0){
                    this.visible = true;
                }
                if(res.length  >  0){
                    this.visible = true;
                    this.history = true;   
                }
                if(res.length <= 0){
                    this.history = false;
                }

                if(this.result.length <= 0 && res.length <= 0){
                    this.visible = false;
                }
            }
            return res.sort(this.compareValues('id', 'desc'));
        },
        

    },
    mounted(){
       this.getFromLocal();
    }
}
</script>


