<template>
    <div>
        <h1 v-if="user">
            <span>{{user.firstName}} {{user.lastName}}</span>
            <div class="btn dark tertiary sticky-right">
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </h1>
        <hr>

        <div v-if="cities">
            <h3>Найти билет</h3>
            <div class="input-composer">
                <select v-model="from">
                    <option v-for="city in cities" :value="city">{{city}}</option>
                </select>
                <select v-model="to">
                    <option v-for="city in cities" :value="city">{{city}}</option>
                </select>
                <input type="date" v-model="date">
                <div class="btn primary" @click="search">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <error-panel :error="errors"></error-panel>

            <div class="trains" v-if="trains">
                <div class="train" v-for="train in trains">
                    <div class="title">
                        <i class="fas fa-train"></i>
                        <div class="number">{{train.number}}</div>
                        <date-range
                            :from="train.departureDatetime"
                            :to="train.arrivalDatetime"
                        ></date-range>
                    </div>

                    <div class="cars">
                        <div class="car"
                             v-for="car in train.cars"
                             v-if="car.places.length>0"
                        >
                            <div class="title">
                                <b>{{car.number}}</b>
                                <span>{{car.type==1?'Плацкарт':'Купе'}}</span>
                            </div>
                            <div class="places">
                                <div class="btn xs dark outline"
                                     v-for="place in car.places"
                                     @click="order(train.number,car.number,place)"
                                >{{place}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div v-if="tickets">
            <h3>Мои билеты</h3>
            <div class="tickets">
                <div class="ticket" v-for="ticket in tickets.data">
                    <div class="title">
                        <i class="fas fa-train"></i>
                        <div class="number">{{ticket.train}}</div>
                        <span>{{ticket.departure_at | date(false)}}</span>
                    </div>
                    <div class="info">
                        <div class="attr">
                            <span>Отправление:</span><b>{{ticket.from}}</b>
                        </div>
                        <div class="attr">
                            <span>Прибытие:</span><b>{{ticket.to}}</b>
                        </div>
                        <div class="attr">
                            <span>Вагон</span><b>{{ticket.cart}}</b>
                        </div>
                        <div class="attr">
                            <span>Место</span><b>{{ticket.place}}</b>
                        </div>
                    </div>
                </div>
                <pagination v-model="page" :data="tickets.meta"></pagination>
            </div>
        </div>

    </div>
</template>

<script>
import ErrorPanel from "../elements/ErrorPanel";
import DateRange from "../elements/DateRange";
import Pagination from "../elements/Pagination";
export default {
    name: "home",
    components: {Pagination, DateRange, ErrorPanel},
    data(){
        return {
            tickets:null,
            user:null,
            cities:null,
            trains:null,
            errors:null,
            from:null,
            to:null,
            date:null,
            page:1
        }
    },
    mounted() {
        api.get('cities')
            .then(data=>this.cities=data)

        this.getUser()
        this.getTickets()
    },
    methods:{
        getUser(){
            this.dt = api.get('user')
                .then(data=>this.user=data.data)
        },
        search(){
            this.errors = null
            api.get('search',{
                depStationCode:this.from,
                arrStationCode:this.to,
                depDate:this.date
            })
                .then(data=>this.trains = data.trains)
                .catch(data=>this.errors = data)
        },
        getTickets(){
            api.get('tickets',{page:this.page})
                .then(data => this.tickets = data)
        },
        order(train,car,place){

            api.post('order',{
                "depStationCode": this.from,
                "arrStationCode": this.to,
                "depDate": this.date,
                "trainNumber": train,
                "carNumber": car,
                "placeNumber": place,
            })
                .then(data=>{
                    this.getTickets()
                    this.errors = null
                    // this.trains = null
                })
                .catch(data=>this.errors = data)
        }
    },
    watch:{
        page(val){
            this.getTickets()
        }
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
    }
}
</script>

<style scoped>

</style>
