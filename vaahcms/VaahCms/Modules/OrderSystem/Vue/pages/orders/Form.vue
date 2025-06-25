<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useorderStore } from '../../stores/store-orders'
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import { useRoute } from 'vue-router';

const store = useorderStore();
const route = useRoute();

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

const selectedProductIds = ref([])
const quantities = ref({})

onMounted(async () => {
    if ((!store.item || Object.keys(store.item).length < 1)
        && route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    await store.getFormMenu();

    // Set selected products and quantities on initial load (for edit)
    if (store.item && Array.isArray(store.item.products)) {
        selectedProductIds.value = store.item.products.map(p => p.id)
        store.item.products.forEach((product) => {
            quantities.value[product.id] = product.pivot?.quantity || product.quantity || 1
        })
    }
})

watch(() => route.params.id, async (newId) => {
    if (newId) {
        selectedProductIds.value = []
        quantities.value = {}
        await store.getItem(newId)

        if (store.item && Array.isArray(store.item.products)) {
            selectedProductIds.value = store.item.products.map(p => p.id)
            store.item.products.forEach((product) => {
                quantities.value[product.id] = product.pivot?.quantity || product.quantity || 0
            })
        }
    }
})

// Keep store.item.products in sync (do not modify pivot data directly)
watch(selectedProductIds, (val) => {
    // DO NOT assign raw IDs here because that would overwrite your full product objects
    // The correct format is set only in prepareOrderBeforeSave()
})

// Total per product
const productTotals = computed(() => {
    const totals = {}
    selectedProductIds.value.forEach((id) => {
        const product = store.assets.products.find(p => p.id === id)
        const qty = quantities.value[id] || 0
        totals[id] = qty * parseFloat(product?.price || 0)
    })
    return totals
})

// Grand total
const grandTotal = computed(() => {
    return Object.values(productTotals.value).reduce((sum, val) => sum + val, 0)
})

// Pivot data for backend
const pivotData = computed(() => {
    return selectedProductIds.value.map(id => {
        const quantity = quantities.value[id] || 0
        return {
            id: id,
            quantity: quantity
        }
    })
})

// Prepare final order data before saving
const prepareOrderBeforeSave = (action) => {
    store.item.total_price = grandTotal.value
    store.item.total_quantity = totalQuantity.value  
    store.item.products = pivotData.value

    if (action === 'create-and-new') {
        selectedProductIds.value = []
        quantities.value = {}
    }
}

const totalQuantity = computed(() => {
    return Object.values(quantities.value).reduce((sum, qty) => sum + Number(qty), 0)
})
</script>

<template>
    <div class="col-6">
        <Panel class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            Update
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <Button class="p-button-sm" v-tooltip.left="'View'" v-if="store.item && store.item.id"
                        data-testid="orders-view_item" @click="store.toView(store.item)" icon="pi pi-eye" />

                    <Button label="Save" class="p-button-sm" v-if="store.item && store.item.id"
                        data-testid="orders-save" @click="prepareOrderBeforeSave(); store.itemAction('save')"
                        icon="pi pi-save" />

                    <Button label="Create & New"
                        @click="prepareOrderBeforeSave('create-and-new'); store.itemAction('create-and-new')"
                        class="p-button-sm" data-testid="orders-create-and-new" icon="pi pi-save" />

                    <!--form_menu-->
                    <Button type="button" @click="toggleFormMenu" class="p-button-sm" data-testid="orders-form-menu"
                        icon="pi pi-angle-down" aria-haspopup="true" />

                    <Menu ref="form_menu" :model="store.form_menu_list" :popup="true" />
                    <!--/form_menu-->

                    <Button class="p-button-primary p-button-sm" icon="pi pi-times" data-testid="orders-to-list"
                        @click="store.toList()">
                    </Button>
                </div>
            </template>

            <div v-if="store.item" class="mt-2">
                <Message severity="error" class="p-container-message mb-3" :closable="false" icon="pi pi-trash"
                    v-if="store.item.deleted_at">
                    <div class="flex align-items-center justify-content-between">
                        <div class="">
                            Deleted {{ store.item.deleted_at }}
                        </div>
                        <div class="ml-3">
                            <Button label="Restore" class="p-button-sm" data-testid="orders-item-restore"
                                @click="store.itemAction('restore')">
                            </Button>
                        </div>
                    </div>
                </Message>

                <!-- Form: Start -->
                <VhField label="Name">
                    <div class="p-inputgroup">
                        <InputText class="w-full" placeholder="Enter the name" name="orders-name"
                            data-testid="orders-name" @update:modelValue="store.watchItem" v-model="store.item.name"
                            required />
                        <div class="required-field hidden"></div>
                    </div>
                </VhField>

                <VhField label="Customer">
                    <Dropdown v-model="store.item.customer_id" :options="store.assets.customers" optionLabel="name"
                        optionValue="id" placeholder="Select Customer" class="w-full md:w-19rem"
                        data-testid="orders-customer" />
                </VhField>

                <VhField label="Slug">
                    <div class="p-inputgroup">
                        <InputText class="w-full" placeholder="Enter the slug" name="orders-slug"
                            data-testid="orders-slug" v-model="store.item.slug" required />
                        <div class="required-field hidden"></div>
                    </div>
                </VhField>

                <VhField label="Products">
                    <MultiSelect v-model="selectedProductIds" :options="store.assets.products" optionLabel="name"
                        optionValue="id" filter placeholder="Select Products" :maxSelectedLabels="3"
                        class="w-full md:w-80" />

                    <!-- For each selected product -->
                    <div v-for="productId in selectedProductIds" :key="productId"
                        class="flex flex-col gap-3 py-3 items-center space-x-4">
                        <div class="w-48 font-medium flex pt-1">
                            {{store.assets.products.find(p => p.id === productId)?.name}}
                        </div>

                        <InputNumber v-model="quantities[productId]" :min="1" showButtons buttonLayout="horizontal"
                            :inputStyle="{ width: '4rem', textAlign: 'center' }" />

                        <div class="w-48 font-medium flex pt-1">
                            ₹ {{ productTotals[productId]?.toLocaleString() || '0' }}
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="w-full">
                        <div class="font-bold text-lg mt-4 flex  w-1/3">
                            Total: ₹ {{ grandTotal.toLocaleString() }}
                        </div>
                        <div class="font-bold text-md mt-1 text-gray-600">
                            Quantity: {{ totalQuantity }}
                        </div>
                    </div>
                </VhField>
                <!-- Form: End -->


                <VhField label="Status">
                    <Dropdown v-model="store.item.status_id" :options="store.assets.status" optionLabel="name"
                        optionValue="id" placeholder="Select a Status" class="w-full md:w-14rem" />
                </VhField>


                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0" v-bind:true-value="1" class="p-inputswitch-sm"
                        name="orders-active" data-testid="orders-active" v-model="store.item.is_active" />
                </VhField>
            </div>
        </Panel>
    </div>
</template>
