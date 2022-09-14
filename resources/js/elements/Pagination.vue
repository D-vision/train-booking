<template>
    <div class="pagination" v-if="data.last_page>1">
        <div v-if="needsArrows && !isFirst" @click="current--">
            <i class="fas fa-angle-left"></i>
        </div>
        <div :class="{current_page:isFirst}" @click="current = 1">1</div>
        <div v-if="current>range+2" class="divider">...</div>

        <div v-for="n in range*2+1"
             v-if="nearbyPage(n)"
             :key="nearbyPage(n)"
             :class="{current_page:isCurrent(n)}"
             @click="current = nearbyPage(n)"
        >{{ nearbyPage(n) }}</div>

        <div v-if="current<data.last_page - range - 1" class="divider">...</div>
        <div :class="{current_page:isLast}"  @click="current=data.last_page">{{ data.last_page }}</div>
        <div v-if="needsArrows && !isLast"  @click="current++">
            <i class="fas fa-angle-right"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Pagination",
        props:['data','value'],
        data(){
            return {
                current:this.value||1,
                range:3
            }
        },
        mounted() {

        },
        methods:{
            nearbyPage(n){
               let page = this.current + n - this.range -1
               return page>1 && page<this.data.last_page ? page : false;
            },
            isCurrent(n){ return n - this.range-1 === 0 },
            isVisibleRight(n) { return this.current + n < this.data.last_page },
            isVisibleLeft(n)  { return this.current - n > 1 }
        },
        computed:{
            isFirst() { return this.current === 1},
            isLast() { return this.current === this.data.last_page },
            needsArrows(){ return this.data.last_page > 2}
        },
        watch:{
            value(val){
                this.current = val
            },
            current(val) {
                this.$emit('pageChanged',val)
                this.$emit('input',val)
            }
        }
    }
</script>

<style scoped>
    .pagination{
        display: flex;
    }
    .pagination > div {
        padding:5px 10px;
        margin:3px;
        border:1px solid #c9c6c6;
        border-radius: 3px;
        cursor: pointer;
    }
    .pagination > div:hover{
        border-color:#3F5DE7;
    }

    .pagination > div.divider{
        border:none;
        cursor:default;
    }
    .pagination > div.current_page{
        font-weight:bold;
        border:none;
        cursor:default;
    }
</style>
