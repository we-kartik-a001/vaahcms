<script setup>

import { ref, watch } from 'vue';
import { useorderStore } from '../../../stores/store-orders'
import VhFieldVertical from './../../../vaahvue/vue-three/primeflex/VhFieldVertical.vue'


const store = useorderStore()

const price_range = ref([0, store.assets.max_price])

watch(price_range, (range) => {

    store.query.filter.price_min = range[0];
    store.query.filter.price_max = range[1];
})


</script>

<template>
    <div class="col-3" v-if="store.show_advance_filter">

        <Panel class="is-small">

            <template class="p-1" #header>

                <div class="flex flex-row">
                    <div>
                        <b class="mr-1">Advance Filters</b>
                    </div>

                </div>

            </template>

            <template #icons>

                <div class="p-inputgroup">

                    <Button data-testid="orders-hide-filter" class="p-button-sm"
                        @click="store.show_advance_filter = false">
                        <i class="pi pi-times"></i>
                    </Button>

                </div>

            </template>


            <VhFieldVertical>

                <p class="font-semibold">Filter Status</p>
                <Dropdown v-model="store.query.filter.status_id" :options="store.assets.status || []" optionLabel="name"
                    optionValue="id" placeholder="Select a Status" class="w-full" />

            </VhFieldVertical>


            <VhFieldVertical>
                <p class="font-semibold">Price Range</p>
                <!-- Optional: Label Underneath -->
                <div class="w-full text-xs text-gray-500 py-1">
                    Slide to filter orders by total price
                </div>

                <!-- Slider -->
                <div class="p-3">
                    <Slider v-model="price_range" range :min="0" :max="store.assets.max_price" :step="500" class="w-full " />
                </div>
                <!-- Price Range Display -->
                <div class="w-full text-center text-sm text-gray-700 font-medium py-1 space-y-1">
                    <div>
                        min: <span class="text-green-500">₹ {{ price_range[0].toLocaleString() }}</span>
                    </div>
                    <div>
                        max: <span class="text-green-500">₹ {{ price_range[1].toLocaleString() }}</span>
                    </div>
                </div>
            </VhFieldVertical>


            <VhFieldVertical>
                <template #label>
                    <b>Is Active:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="active-all" inputId="active-all" value="null"
                        data-testid="orders-filters-active-all" v-model="store.query.filter.is_active" />
                    <label for="active-all" class="cursor-pointer">All</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-true" inputId="active-true" data-testid="orders-filters-active-true"
                        value="true" v-model="store.query.filter.is_active" />
                    <label for="active-true" class="cursor-pointer">Only Active</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="active-false" inputId="active-false" data-testid="orders-filters-active-false"
                        value="false" v-model="store.query.filter.is_active" />
                    <label for="active-false" class="cursor-pointer">Only Inactive</label>
                </div>

            </VhFieldVertical>

            <Divider />

            <VhFieldVertical>
                <template #label>
                    <b>Trashed:</b>
                </template>

                <div class="field-radiobutton">
                    <RadioButton name="trashed-exclude" inputId="trashed-exclude"
                        data-testid="orders-filters-trashed-exclude" value="" v-model="store.query.filter.trashed" />
                    <label for="trashed-exclude" class="cursor-pointer">Exclude Trashed</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-include" inputId="trashed-include"
                        data-testid="orders-filters-trashed-include" value="include"
                        v-model="store.query.filter.trashed" />
                    <label for="trashed-include" class="cursor-pointer">Include Trashed</label>
                </div>
                <div class="field-radiobutton">
                    <RadioButton name="trashed-only" inputId="trashed-only" data-testid="orders-filters-trashed-only"
                        value="only" v-model="store.query.filter.trashed" />
                    <label for="trashed-only" class="cursor-pointer">Only Trashed</label>
                </div>

            </VhFieldVertical>


        </Panel>

    </div>
</template>
