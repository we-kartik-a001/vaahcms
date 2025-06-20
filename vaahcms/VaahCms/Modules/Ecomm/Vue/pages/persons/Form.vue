<script setup>
import { onMounted, ref, watch } from "vue";
import { useRootStore } from '@/stores/root'
import { usePersonStore } from '@/stores/store-persons'
import { useRoute } from 'vue-router';
import InputNumber from 'primevue/inputnumber';


const root = useRootStore();
const store = usePersonStore();
const selectedProductIds = ref([]);
const productsWithQty = ref([]);

// Sync selectedProductIds with productsWithQty
watch(selectedProductIds, (newIds) => {
    newIds.forEach(id => {
        if (!productsWithQty.value.find(p => p.id === id)) {
            productsWithQty.value.push({ id, qty: 1 });
        }
    });
    productsWithQty.value = productsWithQty.value.filter(p => newIds.includes(p.id));
}, { immediate: true });

// Sync productsWithQty to store.item.products for backend
watch(productsWithQty, (val) => {
    store.item.products = val;
}, { immediate: true, deep: true });


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

</script>
<template>


    <Panel :pt="root.panel_pt">

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
                    data-testid="persons-view_item" @click="store.toView(store.item)" icon="pi pi-eye" />

                <Button label="Save" class="p-button-sm" v-if="store.item && store.item.id" data-testid="persons-save"
                    @click="store.itemAction('save')" icon="pi pi-save" />

                <Button label="Create & New" v-else @click="store.itemAction('create-and-new')" class="p-button-sm"
                    data-testid="persons-create-and-new" icon="pi pi-save" />


                <!--form_menu-->
                <Button type="button" @click="toggleFormMenu" class="p-button-sm" data-testid="persons-form-menu"
                    icon="pi pi-angle-down" aria-haspopup="true" />

                <Menu ref="form_menu" :model="store.form_menu_list" :popup="true" />
                <!--/form_menu-->


                <Button class="p-button-primary p-button-sm" icon="pi pi-times" data-testid="persons-to-list"
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
                        <Button label="Restore" class="p-button-sm" data-testid="persons-item-restore"
                            @click="store.itemAction('restore')">
                        </Button>
                    </div>

                </div>

            </Message>


            <!-- Form Input Field:Start -->
            <FloatLabel class="my-3" :variant="store.float_label_variants">
                <InputText class="w-full" name="persons-name" data-testid="persons-name" id="persons-name"
                    @update:modelValue="store.watchItem" v-model="store.item.name" required />
                <label for="persons-name">Enter the name</label>
            </FloatLabel>


            <FloatLabel class="my-3" :variant="store.float_label_variants">
                <InputText class="w-full" name="persons-slug" data-testid="persons-slug" id="persons-slug"
                    v-model="store.item.slug" required />
                <label for="persons-slug">Enter the slug</label>
            </FloatLabel>

            <FloatLabel class="my-3" :variant="store.float_label_variants">
                <InputText class="w-full" name="persons-email" data-testid="persons-email" id="persons-email"
                    v-model="store.item.email" required />
                <label for="persons-email">Enter the Email</label>
            </FloatLabel>

            <!-- v-model="store.item.status" -->
            <div class="flex justify-between gap-2">
                <FloatLabel class="my-3" :variant="store.float_label_variants">
                    <MultiSelect v-model="selectedProductIds" :options="store.assets.products" optionLabel="name"
                        optionValue="id" placeholder="Select Products" class="w-full md:w-19rem" />
                </FloatLabel>

                <FloatLabel class="my-3" :variant="store.float_label_variants">
                    <Dropdown v-model="store.item.status" :options="store.assets.order_status" optionLabel="name"
                        optionValue="id" placeholder="Select Status" class="w-full md:w-19rem" />
                </FloatLabel>
            </div>

            <!-- <div class="flex flex-wrap gap-2 my-2 ">
                <span v-for="id in store.item.products" :key="id" class="p-tag rounded-md m-1 p-tag-info">
                    {{store.assets.products.find(p => p.id === id)?.name || id}}
                    <span v-if="store.assets.products.find(p => p.id === id)">
                        (Stock: {{store.assets.products.find(p => p.id === id).stock}})
                    </span>
                </span>
            </div> -->
           <FloatLabel class="my-3" :variant="store.float_label_variants">
    <div class="flex flex-wrap gap-4 my-4">
        <span v-for="prod in productsWithQty" :key="prod.id"
            class="flex flex-col p-4 bg-blue-50 rounded-xl shadow-sm border border-blue-200 w-60 space-y-3 transition-transform transform hover:scale-105">

            <!-- Product Name -->
            <div class="text-base font-semibold text-gray-800">
                {{ store.assets.products.find(p => p.id === prod.id)?.name || prod.id }}
            </div>

            <!-- Stock Info -->
            <div v-if="store.assets.products.find(p => p.id === prod.id)" class="text-sm text-gray-500">
                Stock: {{ store.assets.products.find(p => p.id === prod.id).stock }}
            </div>

            <!-- Quantity Input + Add Button -->
            <div class="flex items-center space-x-3">
                <InputNumber
                    v-model="prod.qty"
                    :min="1"
                    :max="store.assets.products.find(p => p.id === prod.id)?.stock || 1"
                    showButtons
                    buttonLayout="vertical"
                    style="width: 3rem"
                    :inputStyle="{ width: '3rem' }"
                >
                    <template #incrementbuttonicon>
                        <span class="pi pi-plus text-green-600" />
                    </template>
                    <template #decrementbuttonicon>
                        <span class="pi pi-minus text-red-600" />
                    </template>
                </InputNumber>

                <Button 
                    icon="pi pi-check" 
                    class="p-button-sm p-button-success shadow-md hover:shadow-lg transition duration-300" 
                    @click="confirmQty(prod)"
                    :disabled="prod.qty < 1 || prod.qty > (store.assets.products.find(p => p.id === prod.id)?.stock || 1)"
                    label="Add" 
                />
            </div>
        </span>
    </div>
</FloatLabel>

            <!-- Form Input Field:End -->



            <div class="flex items-center gap-2 my-3">
                <ToggleSwitch v-bind:false-value="0" v-bind:true-value="1" size="small" name="persons-active"
                    data-testid="persons-active" inputId="persons-active" v-model="store.item.is_active" />

                <label for="persons-active">Is Active</label>
            </div>


        </div>
    </Panel>


</template>
