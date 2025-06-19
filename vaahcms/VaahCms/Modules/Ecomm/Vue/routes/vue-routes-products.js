let routes= [];
let routes_list= [];

import List from '../pages/products/List.vue'
import Form from '../pages/products/Form.vue'
import Item from '../pages/products/Item.vue'
import Filters from '../pages/products/Filters.vue'

routes_list = {

    path: '/products',
    name: 'products.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'products.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'products.view',
            component: Item,
            props: true,
        },
        {
            path: 'filters',
            name: 'products.filters',
            component: Filters,
            props: true,
        },

    ]
};

routes.push(routes_list);

export default routes;

