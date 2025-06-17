let routes= [];
let routes_list= [];

import List from '../pages/items/List.vue'
import Form from '../pages/items/Form.vue'
import Item from '../pages/items/Item.vue'
import Filters from '../pages/items/Filters.vue'

routes_list = {

    path: '/items',
    name: 'items.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'items.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'items.view',
            component: Item,
            props: true,
        },
        {
            path: 'filters',
            name: 'items.filters',
            component: Filters,
            props: true,
        },

    ]
};

routes.push(routes_list);

export default routes;

