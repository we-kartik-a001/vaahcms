<script setup>
import { onMounted, ref, watch } from "vue";
import { useorderStore } from '../../stores/store-orders'
import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import { useRoute } from 'vue-router';

const store = useorderStore();
const route = useRoute();

onMounted(async () => {
    if ((!store.item || Object.keys(store.item).length < 1)
        && route.params && route.params.id) {
        await store.getItem(route.params.id);
    }
    await store.getFormMenu();
});

const quantity = ref(0)
const prodObj = ref({})

watch(() => store.item && store.item.products, (newProducts) => {
     if (!Array.isArray(newProducts)) {
            quantity.value = 0
            return
        }
    quantity.value = newProducts.length
    // Add new products with default quantity 1
    newProducts.forEach(id => {
        if (!(id in prodObj.value)) {
            prodObj.value[id] = 1
        }
    })
    // Remove quantities for unselected products
    Object.keys(prodObj.value).forEach(id => {
        if (!newProducts.includes(Number(id))) {
            delete prodObj.value[id]
        }
    })

    console.log(prodObj.value)
})
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
function getTotalPrice() {
    return (store.item.products || []).reduce((sum, prodId) => {
        const product = store.assets.products.find(p => p.id === prodId);
        const quantity = prodObj.value[prodId] || 1;
        return sum + (product ? product.price * quantity : 0);
    }, 0);
}

function getOrderPayload() {
    return {
        ...store.item,
        total_price: getTotalPrice(),
        products: (store.item.products || []).map(product_id => ({
            id: product_id,
            quantity: prodObj.value[product_id] || 1
        }))
    }
}

async function saveOrder() {
    const payload = getOrderPayload();
    await store.itemAction('save', payload);
}

async function createAndNewOrder() {
    const payload = getOrderPayload();
    await store.itemAction('create-and-new', payload);
}
</script>

<template>
    <div class="col-6">
        <Panel class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">Update</span>
                        <span v-else>Create</span>
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">
                    <Button class="p-button-sm" v-tooltip.left="'View'" v-if="store.item && store.item.id"
                        data-testid="orders-view_item" @click="store.toView(store.item)" icon="pi pi-eye" />
                   <!-- filepath: d:\xampp\htdocs\vaahcms\vaahcms\VaahCms\Modules\OrderSystem\Vue\pages\orders\Form.vue -->
                    <Button label="Save" class="p-button-sm" v-if="store.item && store.item.id"
                        data-testid="orders-save" @click="saveOrder" icon="pi pi-save" />
                    <Button label="Create & New" v-else @click="createAndNewOrder" class="p-button-sm"
                        data-testid="orders-create-and-new" icon="pi pi-save" />
                    <Button type="button" @click="toggleFormMenu" class="p-button-sm" data-testid="orders-form-menu"
                        icon="pi pi-angle-down" aria-haspopup="true" />
                    <Menu ref="form_menu" :model="store.form_menu_list" :popup="true" />
                    <Button class="p-button-primary p-button-sm" icon="pi pi-times" data-testid="orders-to-list"
                        @click="store.toList()">
                    </Button>
                </div>
            </template>

            <div v-if="store.item" class="mt-2">
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
                {{ store.item.products }}
               
                <VhField label="Products">
                        <MultiSelect 
                            v-model="store.item.products" 
                            :options="store.assets.products" 
                            optionLabel="name" 
                            optionValue="id"
                            placeholder="Select Products"
                            class="w-full md:w-20rem"
                        />

                        <!-- For each selected product: render its quantity input -->
                        <div v-if="store.item.products" class="mt-3 space-y-2">
                            <div 
                                v-for="prod in store.product_ids" 
                                :key="prod" 
                                class="flex items-center gap-4 p-2 rounded border">

                                <!-- Product name -->
                                <span class="font-semibold">
                                    {{ store.assets.products.find(p => p.id === prod)?.name || 'Unknown Product' }}
                                </span>

                                <!-- Quantity input (for this product) -->
                                <InputNumber
                                    v-model="prodObj[prod]"
                                    :min="1"
                                    showButtons
                                    buttonLayout="horizontal"
                                    :inputStyle="{ width: '4rem', textAlign: 'center' }"
                                />
                            </div>
                        </div>
                        <!-- Show total price somewhere in your template -->
                        <div class="mt-4 font-bold">
                            Total Price: {{ getTotalPrice() }}
                        </div>
                 </VhField>


                quantity: {{ quantity }}

                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0" v-bind:true-value="1" class="p-inputswitch-sm"
                        name="orders-active" data-testid="orders-active" v-model="store.item.is_active" />
                </VhField>
            </div>
        </Panel>
    </div>
</template>