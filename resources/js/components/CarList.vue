<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Cars</div>
                    <div class="card-body row">
                        <div v-for="car in cars" :key="car.id" class="card col-md-3">
                            <img src="https://via.placeholder.com/150" class="card-img-top">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ car.brand }} {{ car.model }}</h6>
                                <p class="card-text">
                                    Current Bid : {{ car.latest_bid_amount }}<br />
                                    ({{ car.bids.length }} bids placed by {{ uniqueDealers(car) }} dealers)
                                </p>
                                <button @click="bid(car.id)" class="btn btn-primary">BID</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Toasted from 'vue-toasted';

    export default {
        data() {
            return {
                cars: [],
            }
        },
        methods: {
            getCars() {
                axios.get('/api/cars').then(response => {
                    this.cars = response.data;
                });
            },
            bid(carId) {
                axios.post('/api/cars/' + carId + '/bid').then(() => {
                    this.getCars();
                }).catch((e) => {
                    Vue.toasted.show(e.response.data.message);
                });
            },
            uniqueDealers(car) {
                let dealers = car.bids.map(bid => bid.user_id);
                return [...new Set(dealers)].length;
            }
        },
        mounted() {
            let token = document.querySelector("meta[name='api-token']").getAttribute('content');
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`, 'Accept': 'application/json'}
            Vue.use(Toasted, {position: 'bottom-center', duration: 3000, keepOnHover: true});

            this.getCars();

            Echo.channel(`car-bid`)
                .listen('CarBid', (payload) => {
                    let index = this.cars.findIndex(car => {
                        return car.id === payload.car.id;
                    });
                    Vue.set(this.cars, index, payload.car);

                    let message = `${payload.bid.bidder.name} had placed a bid of ${payload.car.latest_bid_amount} on ${payload.car.brand} ${payload.car.model}`;
                    Vue.toasted.show(message);
                });
        }
    }
</script>
