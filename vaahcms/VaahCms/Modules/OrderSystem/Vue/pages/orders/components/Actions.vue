<script  setup>
import {ref, reactive, watch, onMounted} from 'vue';
import {useRoute} from 'vue-router';

import { useorderStore } from '../../../stores/store-orders'

const store = useorderStore();
const route = useRoute();

onMounted(async () => {
    store.getListSelectedMenu();
    store.getListBulkMenu(); 
});

//--------selected_menu_state
const selected_menu_state = ref();
const toggleSelectedMenuState = (event) => {
    selected_menu_state.value.toggle(event);
};
//--------/selected_menu_state
watch(() => store.query.filter, () => {
    store.countFilters(store.query);
}, { deep: true });

//--------bulk_menu_state
const bulk_menu_state = ref();
const toggleBulkMenuState = (event) => {
    bulk_menu_state.value.toggle(event);
};
//--------/bulk_menu_state
</script>

<template>
    <div>

        <!--actions-->
        <div :class="{'flex justify-content-between': store.isViewLarge()}" class="mt-2 mb-2">

            <!--left-->
            <div v-if="store.view === 'large'">

                <!--selected_menu-->
                <Button class="p-button-sm"
                    type="button"
                    @click="toggleSelectedMenuState"
                    data-testid="orders-actions-menu"
                    aria-haspopup="true"
                    aria-controls="overlay_menu">
                    <i class="pi pi-angle-down"></i>
                    <Badge v-if="store.action.items.length > 0"
                           :value="store.action.items.length" />
                </Button>
                <Menu ref="selected_menu_state"
                      :model="store.list_selected_menu"
                      :popup="true" />
                
               <Button
                    type="button"
                    class="p-button-sm"
                    :disabled="Object.keys(route.params).length"
                    data-testid="orders-actions-show-filters"
                    @click="
                        store.show_advance_filter = !store.show_advance_filter;
                        store.show_filters = false;
                    ">
                    Advance Filter
                    <Badge v-if="store.advance_count_filter > 0" :value="store.advance_count_filter"></Badge>
                </Button>

                <!--/selected_menu-->

            </div>
            <!--/left-->

            <!--right-->
            <div >


                <div class="grid p-fluid">
                    <div class="col-12">
                        <div class="p-inputgroup ">

                            <InputText v-model="store.query.filter.q"
                                       @keyup.enter="store.delayedSearch()"
                                       class="p-inputtext-sm"
                                       @keyup.enter.native="store.delayedSearch()"
                                       @keyup.13="store.delayedSearch()"
                                       data-testid="orders-actions-search"
                                       placeholder="Search"/>
                            <Button @click="store.delayedSearch()"
                                    class="p-button-sm"
                                    data-testid="orders-actions-search-button"
                                    icon="pi pi-search"/>

                            <Button
                                type="button"
                                class="p-button-sm"
                                :disabled="Object.keys(route.params).length"
                                data-testid="orders-actions-show-filters"
                                @click="
                                    store.show_filters = !store.show_filters;
                                    store.show_advance_filter = false;
                                ">
                                Filters
                                <Badge v-if="store.count_filters > 0" :value="store.count_filters"></Badge>
                            </Button>

                            <Button
                                type="button"
                                icon="pi pi-filter-slash"
                                data-testid="orders-actions-reset-filters"
                                class="p-button-sm"
                                label="Reset"
                                @click="store.resetQuery()" />

                                <!--bulk_menu-->
                                <Button
                                    type="button"
                                    @click="toggleBulkMenuState"
                                    severity="danger" outlined
                                    data-testid="orders-actions-bulk-menu"
                                    aria-haspopup="true"
                                    aria-controls="bulk_menu_state"
                                    class="ml-1 p-button-sm">
                                    <i class="pi pi-ellipsis-v"></i>
                                </Button>
                                <Menu ref="bulk_menu_state"
                                      :model="store.list_bulk_menu"
                                      :popup="true" />
                                <!--/bulk_menu-->

                        </div>
                    </div>

                </div>

            </div>
            <!--/right-->

        </div>
        <!--/actions-->

    </div>
</template>
