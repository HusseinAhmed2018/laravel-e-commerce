<template>
    <div>
        <a class="nav-link" href="/cart-details"><i class="fas fa-shopping-cart text-primary"></i> <span class="badge badge-danger">{{ items.count }}</span> Cart</a>
    </div>
</template>

<script>

    import {bus} from "../app";

    export default {
        name : "CartComponent",

        data(){
            return {
                items : {
                    count: 0
                },
            }
        },
        mounted() {
            console.log(this)
        },
        methods:{
            get_Cart()
            {
                var  vm = this;

                axios.get('/api/old_cart/').then(response => {

                    var totalQty = 0

                    if (response.data.cart != null)
                    {
                        var totalQty = response.data.cart.totalQty;
                    }
                    vm.items['count'] = totalQty;
                });
            }
        },
        created() {
            bus.$on('itemsCount', obj => {
                this.items['count'] = obj
            });

            this.get_Cart();
        },
    }
</script>
