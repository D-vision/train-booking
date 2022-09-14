<template>
    <span>
        <span v-if="from_date === to_date">
            <span class="text-dark">{{from_date}}</span> <b>[{{from | time}} - {{to | time}}]</b>
        </span>
        <span v-else class="text-dark">
            <span v-if="from">
                {{from | date}} <b>{{from | time}}</b>
            </span>
            <span v-if="from && to"> - </span>
            <span v-if="to">
                {{to | date}} <b>{{to | time}}</b>
            </span>
        </span>
    </span>
</template>

<script>
export default {
    name: "DateRange",
    props:['from','to'],
    computed:{
        from_date(){ return this.formatDate(this.from) },
        to_date(){ return this.formatDate(this.to) }
    },
    methods:{
        formatDate: function (timestamp, onlydate = true) {
            let dt = new Date(Date.parse((new Date(timestamp)).toString()))
            let year = dt.getFullYear()
            let month = dt.getMonth() + 1
            month = month.toString().padStart(2, '0')
            let date = dt.getDate().toString().padStart(2, '0')
            let hour = dt.getHours().toString().padStart(2, '0')
            let minute = dt.getMinutes().toString().padStart(2, '0')

            return `${year}-${month}-${date}` + (onlydate ? '' : ` ${hour}:${minute}`)
        },
    },
    filters:{
        date: function (timestamp, onlydate = true) {
            let dt = new Date(Date.parse((new Date(timestamp)).toString()))
            let year = dt.getFullYear()
            let month = dt.getMonth() + 1
            month = month.toString().padStart(2, '0')
            let date = dt.getDate().toString().padStart(2, '0')
            let hour = dt.getHours().toString().padStart(2, '0')
            let minute = dt.getMinutes().toString().padStart(2, '0')

            return `${year}-${month}-${date}` + (onlydate ? '' : ` ${hour}:${minute}`)
        },
        time: function (timestamp) {
            let dt = new Date(Date.parse((new Date(timestamp)).toString()))
            let year = dt.getFullYear()
            let month = dt.getMonth() + 1
            month = month.toString().padStart(2, '0')
            let date = dt.getDate().toString().padStart(2, '0')
            let hour = dt.getHours().toString().padStart(2, '0')
            let minute = dt.getMinutes().toString().padStart(2, '0')

            return `${hour}:${minute}`
        },
    }
}
</script>

<style scoped>

</style>
