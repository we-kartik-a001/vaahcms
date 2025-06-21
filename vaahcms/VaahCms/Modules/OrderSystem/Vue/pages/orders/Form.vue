<script setup>
import { onMounted, ref, watch, computed } from "vue";
import { useorderStore } from '../../stores/store-orders'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import { useRoute } from 'vue-router';


const store = useorderStore();
const route = useRoute();

onMounted(async () => {
    /**
     * Fetch the record from the database
     */
    if ((!store.item || Object.keys(store.item).length < 1)
        && route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    await store.getFormMenu();
});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

// For MultiSelect binding
const selectedProductIds = ref([]);

// Array to hold selected products with quantity
const productsWithQty = ref([]);

// Sync selectedProductIds with productsWithQty
watch(selectedProductIds, (newIds) => {
    // Add new selections with qty 1
    newIds.forEach(id => {
        if (!productsWithQty.value.find(p => p.id === id)) {
            productsWithQty.value.push({ id, qty: 1 });
        }
    });
    // Remove unselected
    productsWithQty.value = productsWithQty.value.filter(p => newIds.includes(p.id));
}, { immediate: true });

// Keep store.item.product_ids in sync with selectedProductIds
watch(productsWithQty, (val) => {
    store.item.products = val.map(prod => {
        const product = store.assets.products.find(p => p.id === prod.id);
        return {
            id: prod.id,
            qty: prod.qty,
            price: product ? Number(product.price) : 0
        };
    });
    store.item.product_ids = val.map(p => p.id);
    store.item.total_price = val.reduce((sum, prod) => {
        const product = store.assets.products.find(p => p.id === prod.id);
        const price = product ? Number(product.price) : 0;
        return sum + (Number(prod.qty) * price);
    }, 0);
}, { immediate: true, deep: true });

// Calculate total price
const totalPrice = computed(() => {
    return productsWithQty.value.reduce((sum, prod) => {
        const product = store.assets.products.find(p => p.id === prod.id);
        const price = product ? Number(product.price) : 0;
        return sum + (Number(prod.qty) * price);
    }, 0);
});

// Calculate total quantity
const totalQuantity = computed(() => {
    return productsWithQty.value.reduce((sum, prod) => sum + Number(prod.qty), 0);
});


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
                        data-testid="orders-save" @click="store.itemAction('save')" icon="pi pi-save" />

                    <Button label="Create & New" v-else @click="store.itemAction('create-and-new')" class="p-button-sm"
                        data-testid="orders-create-and-new" icon="pi pi-save" />


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
                            <Button label="Restore" class="p-button-sm" data-testid="articles-item-restore"
                                @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>


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


                <VhField label="Products">
                    <MultiSelect v-model="selectedProductIds" :options="store.assets.products" optionLabel="name"
                        optionValue="id" placeholder="Select Products" class="w-full md:w-19rem"
                        data-testid="orders-products" />
                    <div v-if="productsWithQty.length" class="mt-3 space-y-2">
                        <div v-for="prod in productsWithQty" :key="prod.id" class="flex items-center gap-4 p-2 rounded">
                            <span class="font-semibold">
                                {{store.assets.products.find(p => p.id === prod.id)?.name || prod.id}}
                            </span>
                            <!-- <span class="text-xs text-gray-500">
                                (Stock: {{ store.assets.products.find(p => p.id === prod.id)?.stock ?? 0 }})
                            </span>
                            <InputNumber v-model="prod.qty" :min="1"
                                :max="store.assets.products.find(p => p.id === prod.id)?.stock || 1" showButtons
                                buttonLayout="horizontal" :inputStyle="{ width: '3rem', textAlign: 'center' }" /> -->
                            <span class="ml-2 text-xs text-gray-700">
                                {{store.assets.products.find(p => p.id === prod.id)?.price ?? 0}}
                            </span>
                            <span class="ml-2 text-xs text-green-700 font-bold">
                                = ₹{{(Number(prod.qty) * Number(store.assets.products.find(p => p.id ===
                                    prod.id)?.price ??
                                0)).toFixed(2) }}
                            </span>
                        </div>
                        <div class="flex justify-end mt-2 font-bold text-xs">
                            Total: ₹{{ totalPrice.toFixed(2) }} (Qty: {{ totalQuantity }})
                        </div>
                    </div>
                </VhField>

                <VhField label="Slug">
                    <div class="p-inputgroup">
                        <InputText class="w-full" placeholder="Enter the slug" name="orders-slug"
                            data-testid="orders-slug" v-model="store.item.slug" required />
                        <div class="required-field hidden"></div>
                    </div>
                </VhField>

                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0" v-bind:true-value="1" class="p-inputswitch-sm"
                        name="orders-active" data-testid="orders-active" v-model="store.item.is_active" />
                </VhField>

            </div>
        </Panel>

    </div>

</template>
